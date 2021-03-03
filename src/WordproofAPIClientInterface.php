<?php

namespace Drupal\wordproof;

use Drupal\wordproof\Timestamp\TimestampInterface;
use Psr\Http\Message\ResponseInterface;

interface WordproofAPIClientInterface {

  public function post(TimestampInterface $timestamp): ResponseInterface;

  public function get(TimestampInterface $timestamp);

  /**
   * @param TimestampInterface[] $timestamps
   *
   * @return ResponseInterface[]
   */
  public function bulk(array $timestamps): array;

}
