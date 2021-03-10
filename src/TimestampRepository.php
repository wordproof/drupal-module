<?php


namespace Drupal\wordproof;


use Drupal\Core\Database\Connection;
use Drupal\wordproof\Timestamp\TimestampInterface;

class TimestampRepository implements TimestampRepositoryInterface {

  /**
   * @var \Drupal\Core\Database\Connection
   */
  private $connection;

  public function __construct(Connection $connection) {
    $this->connection = $connection;
  }

  public function create(TimestampInterface $timestamp) {
    $id = $this->connection->insert('wordproof_node_timestamp')
      ->fields(
        [
          'nid' => $timestamp->getId(),
          'vid' => $timestamp->getVid(),
          'hash' => $timestamp->getHash(),
          'hash_input' => $timestamp->getHashInput(),
          'date_created' => $timestamp->getModified(),
        ]
      )->execute();
  }

  public function update(TimestampInterface $timestamp) {
    $this->connection->update('wordproof_node_timestamp')
      ->fields(
        [
          'nid' => $timestamp->getId(),
          'vid' => $timestamp->getVid(),
          'hash' => $timestamp->getHash(),
          'hash_input' => $timestamp->getHashInput(),
          'date_created' => $timestamp->getModified(),
        ]
      )
      ->where('nid = :nid', $timestamp->getId())
      ->where('vid = :vid', $timestamp->getVid())
      ->execute();
  }

  public function updateBlockchainInfo(string $hash, string $blockchain, string $transactionId, string $transactionLink){
    $this->connection->update('wordproof_node_timestamp')
      ->fields(
        [
          'blockchain' => $blockchain,
          'transaction_id' => $transactionId,
          'transaction_link' => $transactionLink,
        ]
      )
      ->where('hash = :hash', $hash)
      ->execute();
  }
}
