<?php

namespace Drupal\wordproof;

use Drupal\wordproof\Timestamp\TimestampInterface;
use Psr\Http\Message\ResponseInterface;

interface WordProofApiClientInterface {

  public function post(TimestampInterface $timestamp): ResponseInterface;

  public function get(int $id): ResponseInterface;

  /**
   * @param \Drupal\wordproof\Timestamp\TimestampInterface[] $timestamps
   *
   * @return \Psr\Http\Message\ResponseInterface[]
   */
  public function bulk(array $timestamps): array;

}
