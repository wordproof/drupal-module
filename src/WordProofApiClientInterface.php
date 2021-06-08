<?php

namespace Drupal\wordproof;

use Drupal\wordproof\Timestamp\TimestampInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Interface for the API client to WordProof.
 *
 * @package Drupal\wordproof
 */
interface WordProofApiClientInterface {

  /**
   * Post the timestamp to the API to save on the blockchain.
   *
   * @param \Drupal\wordproof\Timestamp\TimestampInterface $timestamp
   *   The timestamp entity to be stamped.
   *
   * @return \Psr\Http\Message\ResponseInterface
   *   API response
   */
  public function post(TimestampInterface $timestamp): ResponseInterface;

  /**
   * Get the status of an stamp request.
   *
   * @param int $id
   *   Remote ID of the timestamp.
   *
   * @return \Psr\Http\Message\ResponseInterface
   *   API response
   */
  public function get(int $id): ResponseInterface;

  /**
   * Send by bulk, slower but no rate limiting.
   *
   * @param \Drupal\wordproof\Timestamp\TimestampInterface[] $timestamps
   *   List of timestamps to be stamped.
   *
   * @return \Psr\Http\Message\ResponseInterface[]
   *   API response
   */
  public function bulk(array $timestamps): array;

}
