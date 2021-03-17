<?php

namespace Drupal\wordproof;

use Drupal\wordproof\Timestamp\TimestampInterface;

interface TimestampRepositoryInterface {

  public function create(TimestampInterface $timestamp);

  public function update(TimestampInterface $timestamp);

  public function updateBlockchainInfo(string $hash, string $blockchain, string $address, string $transactionId, string $transactionLink);

}
