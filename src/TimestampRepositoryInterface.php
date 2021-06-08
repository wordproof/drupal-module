<?php

namespace Drupal\wordproof;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\wordproof\Timestamp\TimestampInterface;

/**
 * Interface for a TimestampRepository.
 *
 * @package Drupal\wordproof
 */
interface TimestampRepositoryInterface {

  /**
   * Create the timestamp entity.
   *
   * @param \Drupal\wordproof\Timestamp\TimestampInterface $timestamp
   *   The timestamp to save.
   */
  public function create(TimestampInterface $timestamp);

  /**
   * Check if the entity is stamped already.
   *
   * @param \Drupal\Core\Entity\ContentEntityInterface $entity
   *   The entity to check.
   *
   * @return bool
   *   Is the entity stamped?
   */
  public function isStamped(ContentEntityInterface $entity): bool;

  /**
   * Get the timestamp by entity.
   *
   * @param \Drupal\Core\Entity\ContentEntityInterface $entity
   *   The entity to search by.
   *
   * @return mixed
   *   The timestamp of null of not found
   */
  public function get(ContentEntityInterface $entity);

  /**
   * Update blockchain information of the timestamp.
   *
   * @param string $remote_id
   *   Remote in the api.
   * @param string $address
   *   Address which contains the timestamp.
   * @param string $blockchain
   *   The blockchain on which the timestamp resides.
   * @param string $transactionId
   *   The transaction id.
   * @param string $transactionLink
   *   A link to the transaction.
   */
  public function updateBlockchainInfo(string $remote_id, string $address, string $blockchain, string $transactionId, string $transactionLink);

  /**
   * Get the revision information for the timestamp to enable showing revisions.
   *
   * @param \Drupal\wordproof\Timestamp\TimestampInterface $timestamp
   *   The most current timestamp.
   *
   * @return array
   *   Array of json-ld data.
   */
  public function getHashInputRevisions(TimestampInterface $timestamp): array;

}
