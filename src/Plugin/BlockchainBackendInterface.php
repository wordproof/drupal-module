<?php

namespace Drupal\wordproof\Plugin;

use Drupal\wordproof\Timestamp\TimestampInterface;

/**
 * Defines an blockchain backend implementation for WordProof.
 *
 * The backend is responsible for posting the hash of the timestamp
 * to the blockchain and updating thetimestamp with the
 * blockchain metadata.
 */
interface BlockchainBackendInterface {

  /**
   * Send the timetamp to the backend.
   *
   * @param \Drupal\wordproof\Timestamp\TimestampInterface $timestamp
   *   The timestamp.
   *
   * @return \Drupal\wordproof\Timestamp\TimestampInterface
   *   The updated timestamp
   */
  public function send(TimestampInterface $timestamp): TimestampInterface;

}
