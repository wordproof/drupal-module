<?php

namespace Drupal\wordproof;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\wordproof\Timestamp\TimestampInterface;

interface TimestampRepositoryInterface {

  public function create(TimestampInterface $timestamp);

  public function isStamped(ContentEntityInterface $entity): bool;

  public function get(ContentEntityInterface $entity);

  public function updateBlockchainInfo(string $remote_id, string $address, string $blockchain, string $transactionId, string $transactionLink);

  public function getHashInputRevisions(TimestampInterface $timestamp): array;

}
