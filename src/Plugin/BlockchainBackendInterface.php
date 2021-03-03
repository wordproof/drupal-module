<?php

namespace Drupal\wordproof\Plugin;


use Drupal\wordproof\Timestamp\TimestampInterface;

interface BlockchainBackendInterface {

  public function send(TimestampInterface $timestamp);

}
