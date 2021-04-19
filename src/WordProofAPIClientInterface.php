<?php

namespace Drupal\wordproof_timestamp;

use Drupal\wordproof_timestamp\Timestamp\TimestampInterface;
use Psr\Http\Message\ResponseInterface;

interface WordProofAPIClientInterface {

  public function post(TimestampInterface $timestamp): ResponseInterface;

  public function get(int $id): ResponseInterface;

  /**
   * @param TimestampInterface[] $timestamps
   *
   * @return ResponseInterface[]
   */
  public function bulk(array $timestamps): array;

}
