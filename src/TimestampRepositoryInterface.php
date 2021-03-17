<?php

namespace Drupal\wordproof;

use Drupal\wordproof\Timestamp\TimestampInterface;

interface TimestampRepositoryInterface {

  public function create(TimestampInterface $timestamp);

  public function updateBlockchainInfo(string $remote_id, string $address, string $blockchain, string $transactionId, string $transactionLink);

}
