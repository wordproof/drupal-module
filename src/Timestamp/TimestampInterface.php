<?php

namespace Drupal\wordproof\Timestamp;

interface TimestampInterface {

  public function id();

  public function getContent(): string;

  public function getReferenceId(): int;

  public function getHash(): string;

  public function getHashInput(): string;

  public function getModified(): int;

  public function getRemoteId(): string;

  public function getReferenceRevisionId(): int;

  public function getReferenceEntityType(): string;

  public function getTitle(): string;

  public function getTransactionBlockchain();

  public function getTransactionAddress();

  public function getTransactionId();

  public function getTransactionLink();

  public function getUrl(): string;

  public function setContent(string $content): TimestampInterface;

  public function setReferenceId(int $entity_id): TimestampInterface;

  public function setHash(string$hash): TimestampInterface;

  public function setHashInput(string$hash_input): TimestampInterface;

  public function setModified(int $date): TimestampInterface;

  public function setRemoteId(string $remote_id): TimestampInterface;

  public function setReferenceRevisionId(int $revision_id): TimestampInterface;

  public function setTitle(string $title): TimestampInterface;

  public function setUrl(string $url): TimestampInterface;

  public function setReferenceEntityType(string $entity_type): TimestampInterface;

  public function setTransactionBlockchain(string $transaction_blockchain): TimestampInterface;

  public function setTransactionAddress(string $transaction_address): TimestampInterface;

  public function setTransactionId(string $transaction_id): TimestampInterface;

  public function setTransactionLink(string $transaction_link): TimestampInterface;

}
