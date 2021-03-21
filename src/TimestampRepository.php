<?php


namespace Drupal\wordproof;


use Drupal\Core\Database\Connection;
use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Url;
use Drupal\wordproof\Timestamp\TimestampInterface;

class TimestampRepository implements TimestampRepositoryInterface {

  /**
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  private $entityTypeManager;

  public function __construct(EntityTypeManagerInterface $entityTypeManager) {
    $this->entityTypeManager = $entityTypeManager;
  }

  public function isStamped(ContentEntityInterface $entity): bool {
    $entities = $this->entityTypeManager->getStorage('timestamp')->loadByProperties(['entity_id' => $entity->id(), 'stamped_entity_type' => $entity->getEntityTypeId()]);
    return (count($entities) > 0);
  }

  public function get(ContentEntityInterface $entity) {
    $entities = $this->entityTypeManager->getStorage('timestamp')->loadByProperties(['entity_id' => $entity->id(), 'stamped_entity_type' => $entity->getEntityTypeId()]);
    return array_pop($entities);
  }

  public function getHashInput($id) {
    /** @var \Drupal\wordproof\Entity\Timestamp $entity */
    $entity = $this->entityTypeManager->getStorage('timestamp')->load($id);
    return $entity->getHashInput();
  }

  public function find($entity_type, $entity_id) {
    $entities = $this->entityTypeManager->getStorage('timestamp')->loadByProperties(['entity_id' => $entity_id, 'stamped_entity_type' => $entity_type]);
    return array_pop($entities);
  }

  public function create(TimestampInterface $timestamp) {
    $entity = $this->entityTypeManager->getStorage('timestamp')->create(
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

  public function updateBlockchainInfo(string $remote_id, string $address, string $blockchain, string $transactionId, string $transactionLink) {
    /** @var \Drupal\wordproof\Entity\Timestamp $entity */
    $entities = $this->entityTypeManager->getStorage('timestamp')->loadByProperties(['remote_id' => (int) $remote_id]);
    $entity = array_shift($entities);
    $entity->setTransactionAddress($address);
    $entity->setTransactionBlockchain($blockchain);
    $entity->setTransactionId($transactionId);
    $entity->setTransactionLink($transactionLink);
    $entity->save();
  }

}
