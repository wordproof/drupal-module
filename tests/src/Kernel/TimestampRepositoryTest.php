<?php

namespace Drupal\Tests\wordproof\Kernel;

use Drupal\KernelTests\KernelTestBase;
use Drupal\node\Entity\Node;
use Drupal\node\Entity\NodeType;
use Drupal\wordproof\Entity\Timestamp;

/**
 * Class TimestampRepositoryTest.
 *
 * @coversDefaultClass \Drupal\wordproof\TimestampRepository
 * @covers \Drupal\wordproof\TimestampRepository
 * @group wordproof
 *
 * @internal
 */
class TimestampRepositoryTest extends KernelTestBase {

  public static $modules = [
    'system',
    'field',
    'user',
    'node',
    'wordproof',
  ];

  protected function setUp(): void {
    parent::setUp();

    $this->installEntitySchema('node');
    $this->installEntitySchema('user');
    $this->installEntitySchema('wordproof');

    $this->installSchema('system', ['sequences']);
    $this->installSchema('node', ['node_access']);
    $this->installSchema('user', ['users_data']);

    $this->nodeType = NodeType::create(
      [
        'type' => 'article',
      ]
    );
    $this->nodeType->save();

  }

  public function testGet() {
    $node = Node::create(
      [
        'title' => 'My node',
        'type' => 'article',
        'uid' => 1,
      ]
    );
    $node->save();
    $nodeStamped = Node::create(
      [
        'title' => 'My stamped node',
        'type' => 'article',
        'uid' => 2,
      ]
    );
    $nodeStamped->save();
    $timestamp = Timestamp::create(
      [
        'entity_id' => $nodeStamped->id(),
        'remote_id' => 1,
        'revision_id' => 1,
        'stamped_entity_type' => 'node',
      ]
    );
    $timestamp->save();

    /** @var \Drupal\wordproof\TimestampRepository $repository */
    $repository = $this->container->get('wordproof.repository');

    $this->assertEquals(NULL, $repository->get($node));
    $foundTimestamp = $repository->get($nodeStamped);

    $this->assertEquals($timestamp->toArray(), $foundTimestamp->toArray());
  }

  public function testIsStamped() {
    $node = Node::create(
      [
        'title' => 'My node',
        'type' => 'article',
        'uid' => 1,
      ]
    );
    $node->save();
    $nodeStamped = Node::create(
      [
        'title' => 'My stamped node',
        'type' => 'article',
        'uid' => 2,
      ]
    );
    $nodeStamped->save();
    $timestamp = Timestamp::create(
      [
        'entity_id' => $nodeStamped->id(),
        'remote_id' => 1,
        'revision_id' => 1,
        'stamped_entity_type' => 'node',
      ]
    );
    $timestamp->save();

    /** @var \Drupal\wordproof\TimestampRepository $repository */
    $repository = $this->container->get('wordproof.repository');

    $this->assertEquals(FALSE, $repository->isStamped($node));
    $this->assertEquals(TRUE, $repository->isStamped($nodeStamped));
  }

  public function testGetHashInput() {
    $timestamp = Timestamp::create(
      [
        'entity_id' => 1,
        'remote_id' => 1,
        'revision_id' => 1,
        'stamped_entity_type' => 'node',
        'hash_input' => 'hash_input_data',
      ]
    );
    $timestamp->save();

    /** @var \Drupal\wordproof\TimestampRepository $repository */
    $repository = $this->container->get('wordproof.repository');

    $this->assertEquals('hash_input_data', $repository->getHashInput($timestamp->id()));
  }

  public function testGetHashInputWithRevision() {
    $timestamp = Timestamp::create(
      [
        'entity_id' => 1,
        'revision_id' => 1,
        'remote_id' => 1,
        'url' => 'https://wordproof.dev/node/1',
        'content' => 'some content',
        'date_created' => 1617709090,
        'stamped_entity_type' => 'node',
      ]
    );
    $timestamp->save();

    $timestampRevision2 = Timestamp::create(
      [
        'entity_id' => 1,
        'revision_id' => 2,
        'remote_id' => 1,
        'url' => 'https://wordproof.dev/node/1',
        'content' => 'some contents',
        'date_created' => 1617709090 - 3600,
        'stamped_entity_type' => 'node',
      ]
    );
    $timestampRevision2->save();

    /** @var \Drupal\wordproof\TimestampRepository $repository */
    $repository = $this->container->get('wordproof.repository');
    $encoded = json_encode($repository->getHashInputRevisions($timestamp), JSON_UNESCAPED_SLASHES);
    $this->assertEquals('[{"@context":"https://schema.org","@type":"HashInput","dateCreated":"2021-04-06T20:38:10+10:00","isBasedOn":"https://wordproof.dev/node/1","text":"some contents"}]', $encoded);
  }

}
