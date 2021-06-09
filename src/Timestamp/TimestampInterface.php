<?php

namespace Drupal\wordproof\Timestamp;

/**
 * Interface that should be used for timestamps.
 */
interface TimestampInterface {

  /**
   * Array with HashInput data. Encoding note: json_encode([], JSON_FORCE_OBJECT + JSON_UNESCAPED_SLASHES).
   *
   * @return object
   *   Object containing HashInput information
   */
  public function getHashInputObject();

  /**
   * Return id of the timestamp.
   *
   * @return mixed
   *   The id
   */
  public function id();

  /**
   * Save the record.
   *
   * @return mixed
   *   Status
   */
  public function save();

  /**
   * Return JSON-LD array of the timestamp.
   *
   * @return array
   *   JSON-LD array
   */
  public function toJsonLdArray(): array;

  /**
   * Get contents on which the timestamp is based.
   *
   * @return string
   *   Timestamp contents
   */
  public function getContent(): string;

  /**
   * Return the id of the references entity.
   *
   * @return int
   *   Referened entity id
   */
  public function getReferenceId(): int;

  /**
   * Return the hash of the timestamp.
   *
   * @return string
   *   Hash of the timestamp
   */
  public function getHash(): string;

  /**
   * Return the HashInput json as string.
   *
   * @return string
   *   HashInput json as string
   */
  public function getHashInput(): string;

  /**
   * Return the modified time of the referenced entity.
   *
   * @return int
   *   Modified time of the referenced entity
   */
  public function getModified(): int;

  /**
   * Get the remote ID, used for BlockChainBackends.
   *
   * @return string
   *   The remote ID, used for BlockChainBackends
   */
  public function getRemoteId(): string;

  /**
   * Return the revision of the references entity if applicable.
   *
   * @return int
   *   Revision of the references entity if applicable
   */
  public function getReferenceRevisionId(): int;

  /**
   * Return referenced entity type.
   *
   * @return string
   *   Referenced entity type
   */
  public function getReferenceEntityType(): string;

  /**
   * Return the title of the references entity.
   *
   * @return string
   *   Title of the references entity
   */
  public function getTitle(): string;

  /**
   * Return the blockchain name that contains the hash.
   *
   * @return mixed
   *   Blockchain name that contains the hash
   */
  public function getTransactionBlockchain();

  /**
   * Return the transaction address on the blockchain.
   *
   * @return mixed
   *   Transaction address on the blockchain
   */
  public function getTransactionAddress();

  /**
   * Return the transaction id on the blockchain.
   *
   * @return mixed
   *   Transaction id on the blockchain
   */
  public function getTransactionId();

  /**
   * Return a link to the blockchain transaction.
   *
   * @return mixed
   *   Link to the blockchain transaction
   */
  public function getTransactionLink();

  /**
   * Return the url of the referenced entity.
   *
   * @return string
   *   Url of the referenced entity
   */
  public function getUrl(): string;

  /**
   * Return when the timestamp was created.
   *
   * @return string
   *   Created unix timestamp
   */
  public function getCreated(): string;

  /**
   * Set when the timestamp was created.
   *
   * @param int $created
   *   The unix timestamp.
   *
   * @return \Drupal\wordproof\Timestamp\TimestampInterface
   *   Return the timestamp
   */
  public function setCreated(int $created): TimestampInterface;

  /**
   * Set the content.
   *
   * @param string $content
   *   The content.
   *
   * @return \Drupal\wordproof\Timestamp\TimestampInterface
   *   Return the timestamp
   */
  public function setContent(string $content): TimestampInterface;

  /**
   * Set the referenced entity id.
   *
   * @param int $entity_id
   *   Referenced entity id.
   *
   * @return \Drupal\wordproof\Timestamp\TimestampInterface
   *   Return the timestamp
   */
  public function setReferenceId(int $entity_id): TimestampInterface;

  /**
   * Set the hash of the timestamp.
   *
   * @param string $hash
   *   Hash of the timestamp.
   *
   * @return \Drupal\wordproof\Timestamp\TimestampInterface
   *   Return the timestamp
   */
  public function setHash(string $hash): TimestampInterface;

  /**
   * Set the string HashInput of the timestamp.
   *
   * @param string $hash_input
   *   String HashInput of the timestamp.
   *
   * @return \Drupal\wordproof\Timestamp\TimestampInterface
   *   Return the timestamp
   */
  public function setHashInput(string $hash_input): TimestampInterface;

  /**
   * Set the modified date of the referenced entity.
   *
   * @param int $date
   *   Modified date of the referenced entity.
   *
   * @return \Drupal\wordproof\Timestamp\TimestampInterface
   *   Return the timestamp
   */
  public function setModified(int $date): TimestampInterface;

  /**
   * Set the remote id for thebclockchain backend.
   *
   * @param string $remote_id
   *   Remote id for thebclockchain backend.
   *
   * @return \Drupal\wordproof\Timestamp\TimestampInterface
   *   Return the timestamp
   */
  public function setRemoteId(string $remote_id): TimestampInterface;

  /**
   * Set the revision id of the referenced entity.
   *
   * @param int $revision_id
   *   Revision id of the referenced entity.
   *
   * @return \Drupal\wordproof\Timestamp\TimestampInterface
   *   Return the timestamp
   */
  public function setReferenceRevisionId(int $revision_id): TimestampInterface;

  /**
   * Set the title of the referenced entity.
   *
   * @param string $title
   *   Title of the referenced entity.
   *
   * @return \Drupal\wordproof\Timestamp\TimestampInterface
   *   Return the timestamp
   */
  public function setTitle(string $title): TimestampInterface;

  /**
   * Set the url to the referenced entity.
   *
   * @param string $url
   *   Url to the referenced entity.
   *
   * @return \Drupal\wordproof\Timestamp\TimestampInterface
   *   Return the timestamp
   */
  public function setUrl(string $url): TimestampInterface;

  /**
   * Set the referenced entity type.
   *
   * @param string $entity_type
   *   Referenced entity type.
   *
   * @return \Drupal\wordproof\Timestamp\TimestampInterface
   *   Return the timestamp
   */
  public function setReferenceEntityType(string $entity_type): TimestampInterface;

  /**
   * Set the blockchain transaction id.
   *
   * @param string $transaction_blockchain
   *   Blockchain transaction id.
   *
   * @return \Drupal\wordproof\Timestamp\TimestampInterface
   *   Return the timestamp
   */
  public function setTransactionBlockchain(string $transaction_blockchain): TimestampInterface;

  /**
   * Set the blockchain transaction address.
   *
   * @param string $transaction_address
   *   Blockchain transaction address.
   *
   * @return \Drupal\wordproof\Timestamp\TimestampInterface
   *   Return the timestamp
   */
  public function setTransactionAddress(string $transaction_address): TimestampInterface;

  /**
   * Set the blockchain transaction id.
   *
   * @param string $transaction_id
   *   Blockchain transaction id.
   *
   * @return \Drupal\wordproof\Timestamp\TimestampInterface
   *   Return the timestamp
   */
  public function setTransactionId(string $transaction_id): TimestampInterface;

  /**
   * Set the link to the blockchain transaction.
   *
   * @param string $transaction_link
   *   To the blockchain transaction.
   *
   * @return \Drupal\wordproof\Timestamp\TimestampInterface
   *   Return the timestamp
   */
  public function setTransactionLink(string $transaction_link): TimestampInterface;

}
