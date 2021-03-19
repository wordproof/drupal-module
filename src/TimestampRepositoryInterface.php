<?php

namespace Drupal\wordproof;

use Drupal\wordproof\Timestamp\TimestampInterface;

interface TimestampRepositoryInterface {

  public function create(TimestampInterface $timestamp);

  public function isStamped($entity_id): bool;

  public function get($entity_id);

  public function updateBlockchainInfo(string $remote_id, string $address, string $blockchain, string $transactionId, string $transactionLink);

}
