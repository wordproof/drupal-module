<?php

namespace Drupal\Tests\wordproof\Kernel;

use Drupal\Tests\token\Kernel\KernelTestBase;

/**
 * Test the EntityWatchListService.
 *
 * @group wordproof
 * @coversDefaultClass \Drupal\wordproof\EntityWatchListService
 * @covers \Drupal\wordproof\EntityWatchListService
 *
 * @internal
 * @package Drupal\Tests\wordproof\Kernel
 */
class EntityWatchListServiceTest extends KernelTestBase {

  public static $modules = [
    'wordproof',
    'node',
    'field',
    'system',
    'user',
  ];

  /**
   * @covers \Drupal\wordproof\EntityWatchListService::getWatchList
   */
  public function testGetWatchList() {
    /** @var \Drupal\wordproof\EntityWatchListService $watchListService */
    $watchListService = $this->container->get('wordproof.entity_watch_list');
    $result = $watchListService->getWatchList();

    $this->assertEquals([
      "user_role" => [
        "user" => ["roles"],
      ],
      "node_type" => [
        "node" => ['type'],
      ],
      "user" => [
        "node" => ["revision_uid", "uid"],
      ],
    ],
      $result
    );
  }

}
