<?php

namespace Drupal\wordproof_timestamp\Plugin\wordproof_timestamp\BlockchainBackend;

use Drupal\wordproof_timestamp\Plugin\BlockchainBackendInterface;
use Drupal\wordproof_timestamp\Timestamp\TimestampInterface;

/**
 * Defines an blockchain backend implementation for WordProof.
 *
 * @BlockchainBackend(
 *   id = "wordproof_test_backend",
 *   title = @Translation("WordProof API Queued Blockchain backend"),
 *   description = @Translation("Blockchain backend for WordProof API create hashes on a blockchain. Uses the queued checks to call the API for blockchain info instead of a WebHook")
 * )
 */
class TestBackend implements BlockchainBackendInterface {

  public function send(TimestampInterface $timestamp): TimestampInterface {
    $timestamp->setHashInput('hashinput');
    $timestamp->setHash(hash('sha256', $timestamp->getContent()));
    $timestamp->setRemoteId($timestamp->id());
    $timestamp->setTransactionAddress(md5($timestamp->id()));
    $timestamp->setTransactionBlockchain('eos');
    $timestamp->setTransactionId(md5($timestamp->id()));
    $timestamp->setTransactionLink('https://testlink.com');
    return $timestamp;
  }

}
