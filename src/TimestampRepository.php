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

  /**
   * @param $entity_id
   *
   * @return array
   */
  public function get($entity_id) {
    return [];
  }

  public function create(TimestampInterface $timestamp) {
    $id = $this->connection->insert('wordproof_node_timestamp')
      ->fields(
        [
          'nid' => $timestamp->getId(),
          'vid' => $timestamp->getVid(),
          'remote_id' => $timestamp->getRemoteId(),
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
          'remote_id' => $timestamp->getRemoteId(),
          'hash' => $timestamp->getHash(),
          'hash_input' => $timestamp->getHashInput(),
          'date_created' => $timestamp->getModified(),
        ]
      )
      ->where('nid = :nid', $timestamp->getId())
      ->where('vid = :vid', $timestamp->getVid())
      ->execute();
  }

  public function updateBlockchainInfo(string $remote_id, string $address, string $blockchain, string $transactionId, string $transactionLink) {

    var_dump([
      'blockchain' => $blockchain,
      'transaction_address' => $address,
      'transaction_id' => $transactionId,
      'transaction_link' => $transactionLink,
      'remote_id' => $remote_id,
    ]);

    $this->connection->update('wordproof_node_timestamp')
      ->fields(
        [
          'transaction_blockchain' => $blockchain,
          'transaction_address' => $address,
          'transaction_id' => $transactionId,
          'transaction_link' => $transactionLink,
        ]
      )
      ->where('remote_id = :remote_id', ['remote_id' => (int) $remote_id])
      ->execute();
  }

}
