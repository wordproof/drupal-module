<?php

namespace Drupal\wordproof_timestamp;

use Drupal\wordproof_timestamp\Timestamp\TimestampInterface;
use Psr\Http\Message\ResponseInterface;

interface WordProofApiClientInterface {

  public function post(TimestampInterface $timestamp): ResponseInterface;

  public function get(int $id): ResponseInterface;

  /**
   * @param \Drupal\wordproof_timestamp\Timestamp\TimestampInterface[] $timestamps
   *
   * @return \Psr\Http\Message\ResponseInterface[]
   */
  public function bulk(array $timestamps): array;

}
