<?php

namespace Drupal\wordproof_timestamp\Plugin;


use Drupal\wordproof_timestamp\Timestamp\TimestampInterface;

interface BlockchainBackendInterface {

  public function send(TimestampInterface $timestamp): TimestampInterface;

}
