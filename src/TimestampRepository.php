<?php

namespace Drupal\wordproof;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\wordproof\Timestamp\TimestampInterface;

class TimestampRepository implements TimestampRepositoryInterface {

  /**
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  private $entityTypeManager;

  public function __construct(EntityTypeManagerInterface $entityTypeManager) {
    $this->entityTypeManager = $entityTypeManager;
  }

  /**
   * Check if the entity is stamped already.
   *
   * @inheritdoc
   */
  public function isStamped(ContentEntityInterface $entity): bool {
    $entityStorage = $this->entityTypeManager->getStorage('wordproof_timestamp');
    $entities = $entityStorage->loadByProperties([
      'entity_id' => $entity->id(),
      'stamped_entity_type' => $entity->getEntityTypeId(),
    ]);
    return (count($entities) > 0);
  }

  /**
   * Get a timestamp by entity.
   *
   * @inheritdoc
   */
  public function get(ContentEntityInterface $entity) {
    return $this->find($entity->getEntityTypeId(), $entity->id());
  }

  /**
   * Get the HashInput by id.
   *
   * @param string|int $id
   *   Id of the timestamp.
   *
   * @return string
   *   HashInput json as string.
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  public function getHashInput($id) {
    /** @var \Drupal\wordproof\Entity\Timestamp $entity */
    $entity = $this->entityTypeManager->getStorage('wordproof_timestamp')->load($id);

    return $entity->getHashInput();
  }

  /**
   * Get the revision information for the timestamp to enable showing revisions.
   *
   * @inheritdoc
   */
  public function getHashInputRevisions(TimestampInterface $timestamp): array {
    $query = $this->entityTypeManager->getStorage('wordproof_timestamp')->getQuery()
      ->condition('entity_id', $timestamp->getReferenceId())
      ->condition('date_created', $timestamp->getModified(), '<')
      ->sort('date_created', 'DESC');

    $ids = $query->execute();
    if (count($ids) <= 0) {
      return [];
    }

    /** @var \Drupal\wordproof\Entity\Timestamp[] $timestampRevisions */
    $timestampRevisions = $this->entityTypeManager->getStorage('wordproof_timestamp')->loadMultiple($ids);
    $revisions = [];
    foreach ($timestampRevisions as $revision) {
      $revisions[] = $revision->toJsonLdArray();
    }

    return $revisions;
  }

  /**
   * Find an timestamp by entity type and id.
   *
   * @param string $entity_type
   *   Entity type.
   * @param mixed $entity_id
   *   Entity id.
   *
   * @return \Drupal\Core\Entity\EntityInterface|null
   *   Returns if found
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  public function find($entity_type, $entity_id) {
    $entityStorage = $this->entityTypeManager->getStorage('wordproof_timestamp');
    $entities = $entityStorage->loadByProperties([
      'entity_id' => $entity_id,
      'stamped_entity_type' => $entity_type,
    ]);
    return array_pop($entities);
  }

  /**
   * Create the timestamp entity.
   *
   * @inheritdoc
   */
  public function create(TimestampInterface $timestamp) {
    $entity = $this->entityTypeManager->getStorage('wordproof_timestamp')->create(
      [
        'entity_id' => $timestamp->getReferenceId(),
        'stamped_entity_type' => $timestamp->getReferenceEntityType(),
        'revision_id' => $timestamp->getReferenceRevisionId(),
        'remote_id' => $timestamp->getRemoteId(),
        'hash' => $timestamp->getHash(),
        'hash_input' => $timestamp->getHashInput(),
        'date_created' => $timestamp->getModified(),
      ]
    );
    $entity->save();
  }

  /**
   * Update blockchain information of the timestamp.
   *
   * @inheritdoc
   */
  public function updateBlockchainInfo(string $remote_id, string $address, string $blockchain, string $transactionId, string $transactionLink) {
    /** @var \Drupal\wordproof\Entity\Timestamp $entity */
    $entities = $this->entityTypeManager->getStorage('wordproof_timestamp')->loadByProperties(['remote_id' => (int) $remote_id]);
    $entity = array_shift($entities);
    $entity->setTransactionAddress($address);
    $entity->setTransactionBlockchain($blockchain);
    $entity->setTransactionId($transactionId);
    $entity->setTransactionLink($transactionLink);
    $entity->save();
  }

}
