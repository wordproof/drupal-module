<?php

namespace Drupal\wordproof\Timestamp;

interface TimestampInterface {

  public function getContent(): string;

  public function getReferenceId(): int;

  public function getHash(): string;

  public function getHashInput(): string;

  public function getModified(): int;

  public function getRemoteId(): string;

  public function getReferenceRevisionId(): int;

  public function getTitle(): string;

  public function getTransactionBlockchain();

  public function getTransactionAddress();

  public function getTransactionId();

  public function getTransactionLink();

  public function getUrl(): string;

  public function setContent(string $content) : TimestampInterface;

  public function setReferenceId(int $entity_id);

  public function setHash(string$hash);

  public function setHashInput(string$hash_input);

  public function setModified(int $date);

  public function setRemoteId(string $remote_id);

  public function setReferenceRevisionId(int $revision_id);

  public function setTitle(string $title);

  public function setUrl(string $url);

  public function setTransactionBlockchain(string $transaction_blockchain);

  public function setTransactionAddress(string $transaction_address);

  public function setTransactionId(string $transaction_id);

  public function setTransactionLink(string $transaction_link);

}
