<?php

namespace Drupal\wordproof\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Url;
use Drupal\wordproof\Timestamp\TimestampInterface;

/**
 * Defines the Timestamp entity.
 *
 * @ingroup timestamp
 *
 * @ContentEntityType(
 *   id = "wordproof_timestamp",
 *   label = @Translation("WordProof Timestamp"),
 *   base_table = "wordproof_timestamp",
 *   handlers = {
 *    "storage_schema" = "Drupal\wordproof\Entity\TimestampStorageSchema"
 *   },
 *   entity_keys = {
 *     "id" = "id",
 *     "date_created" = "date_created",
 *   }
 * )
 */
class Timestamp extends ContentEntityBase implements ContentEntityInterface, TimestampInterface {

  /**
   * @inheritdoc
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {

    // Standard field, used as unique if primary index.
    $fields['id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('ID'))
      ->setDescription(t('The ID of the Advertiser entity.'))
      ->setReadOnly(TRUE);

    // Standard field, unique outside of the scope of the current project.
    $fields['entity_id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('The entity id'))
      ->setDescription(t('The referred entity id for the timestamp.'));

    // @todo fix this all the way to the back?
    $fields['stamped_entity_type'] = BaseFieldDefinition::create('string')
      ->setLabel(t('The stamped entity type'))
      ->setSettings(
        [
          'length' => 128,
        ]
      )
      ->setDescription(t('Hash of the HashInput of this content.'));

    // Standard field, unique outside of the scope of the current project.
    $fields['revision_id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('The revision id'))
      ->setDescription(t('The referred revision id for the referred entity.'));

    $fields['remote_id'] = BaseFieldDefinition::create('string')
      ->setLabel(t('The remote id'))
      ->setDefaultValue('')
      ->setSettings(
        [
          'length' => 128,
        ]
      )
      ->setDescription(t('The ID in the remote if needed.'));

    $fields['hash'] = BaseFieldDefinition::create('string')
      ->setLabel(t('The revision id'))
      ->setSettings(
        [
          'length' => 64,
        ]
      )
      ->setDescription(t('Hash of the HashInput of this content.'));

    $fields['title'] = BaseFieldDefinition::create('string')
      ->setLabel(t('The content title'))
      ->setSettings(
        [
          'length' => 128,
        ]
      )
      ->setDescription(t('Hash of the HashInput of this content.'));

    $fields['url'] = BaseFieldDefinition::create('uri')
      ->setLabel(t('The content url'))
      ->setDescription(t('The url of the references content.'));

    // Standard field, unique outside of the scope of the current project.
    $fields['transaction_blockchain'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Blockchain used'))
      ->setSettings(
        [
          'length' => 128,
        ]
      )
      ->setDefaultValue('')
      ->setDescription(t('Blockchain used to record the content.'));

    $fields['transaction_address'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Blockchain address info'))
      ->setSettings(
        [
          'length' => 128,
        ]
      )
      ->setDefaultValue('')
      ->setDescription(t('Blockchain address info.'));

    $fields['transaction_id'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Blockchain transaction id'))
      ->setSettings(
        [
          'length' => 128,
        ]
      )
      ->setDefaultValue('')
      ->setDescription(t('Blockchain transaction to record the content.'));

    $fields['transaction_link'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Blockchain transaction link'))
      ->setSettings(
        [
          'length' => 128,
        ]
      )
      ->setDefaultValue('')
      ->setDescription(t('Link to blockchain transaction.'));

    $fields['hash_input'] = BaseFieldDefinition::create('string_long')
      ->setLabel(t('HashInput'))
      ->setSettings(
        [
          'size' => 'medium',
        ]
      )
      ->setDefaultValue('')
      ->setDescription(t('The HashInput on which the hash is based.'));

    $fields['content'] = BaseFieldDefinition::create('string_long')
      ->setLabel(t('Content'))
      ->setSettings(
        [
          'size' => 'medium',
        ]
      )
      ->setDescription(t('The HashInput on which the hash is based.'));

    // Standard field, unique outside of the scope of the current project.
    $fields['date_created'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Unix timestamp'))
      ->setDefaultValue(0)
      ->setDescription(t('The HashInput on which the hash is based.'));

    // Standard field, unique outside of the scope of the current project.
    $fields['created'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Unix timestamp'))
      ->setDefaultValue(0)
      ->setDescription(t('The date on which the timestamp is created.'));

    return $fields;
  }

  /**
   * @inheritdoc
   */
  public function toJsonLdArray(): array {
    if ($this->getTransactionBlockchain() === NULL) {
      return [];
    }

    $url = Url::fromRoute('wordproof.hashinput', ['id' => $this->id()])->setAbsolute()->toString();
    return [
      "@type" => "BlockchainTransaction",
      "identifier" => $this->getTransactionId(),
      "hash" => $this->getHash(),
      "hashLink" => $url,
      "recordedIn" => [
        "@type" => "Blockchain",
        "name" => $this->getTransactionBlockchain(),
      ],
    ];
  }

  /**
   * Array with HashInput data. Encoding note: json_encode([], JSON_FORCE_OBJECT + JSON_UNESCAPED_SLASHES).
   *
   * @return object
   *   Object containing HashInput information
   */
  public function getHashInputObject() {
    return (object) [
      "@context"    => "https://schema.org",
      "@type"       => "HashInput",
      "dateCreated" => date('c', $this->getCreated()),
      "isBasedOn"   => $this->getUrl(),
      "text"        => trim($this->getContent()),
    ];
  }

  /**
   * @inheritdoc
   */
  public function getCacheTagsToInvalidate() {
    $cacheTagsToInvalidate = parent::getCacheTagsToInvalidate();
    $cacheTagsToInvalidate[] = $this->getReferenceEntityType() . ':' . $this->getReferenceId();
    if ($this->isNew()) {
      return $cacheTagsToInvalidate;
    }
    $cacheTagsToInvalidate[] = $this->entityTypeId . ':' . $this->id();
    return $cacheTagsToInvalidate;
  }

  /**
   * @inheritdoc
   */
  public function getHash(): string {
    return $this->get('hash')->value;
  }

  /**
   * @inheritdoc
   */
  public function getContent(): string {
    return $this->get('content')->value;
  }

  public function getCreated(): string {
    return $this->get('created')->value;
  }

  /**
   * @inheritdoc
   */
  public function getModified(): int {
    return $this->get('date_created')->value;
  }

  /**
   * @inheritdoc
   */
  public function getUrl(): string {
    return $this->get('url')->value;
  }

  /**
   * @inheritdoc
   */
  public function getTitle(): string {
    return $this->get('title')->value;
  }

  /**
   * @inheritdoc
   */
  public function getReferenceId(): int {
    return $this->get('entity_id')->value;
  }

  /**
   * @inheritdoc
   */
  public function getHashInput(): string {
    return $this->get('hash_input')->value;
  }

  /**
   * @inheritdoc
   */
  public function getReferenceRevisionId(): int {
    return $this->get('revision_id')->value;
  }

  /**
   * @inheritdoc
   */
  public function getRemoteId(): string {
    return $this->get('remote_id')->value;
  }

  /**
   * @inheritdoc
   */
  public function getTransactionBlockchain() {
    return $this->get('transaction_blockchain')->value;
  }

  /**
   * @inheritdoc
   */
  public function getTransactionAddress() {
    return $this->get('transaction_address')->value;
  }

  /**
   * @inheritdoc
   */
  public function getTransactionId() {
    return $this->get('transaction_id')->value;
  }

  /**
   * @inheritdoc
   */
  public function getTransactionLink() {
    return $this->get('transaction_link')->value;
  }

  /**
   * @inheritdoc
   */
  public function getReferenceEntityType(): string {
    return $this->get('stamped_entity_type')->value;
  }

  /**
   * @inheritdoc
   */
  public function setModified(int $date): TimestampInterface {
    return $this->set('date_created', $date);
  }

  public function setCreated(int $created): TimestampInterface {
    return $this->set('created', $created);
  }

  /**
   * @inheritdoc
   */
  public function setTitle(string $title): TimestampInterface {
    return $this->set('title', $title);
  }

  /**
   * @inheritdoc
   */
  public function setReferenceId(int $entity_id): TimestampInterface {
    return $this->set('entity_id', $entity_id);
  }

  /**
   * @inheritdoc
   */
  public function setUrl(string $url): TimestampInterface {
    return $this->set('url', $url);
  }

  /**
   * @inheritdoc
   */
  public function setHash(string $hash): TimestampInterface {
    return $this->set('hash', $hash);
  }

  /**
   * @inheritdoc
   */
  public function setContent(string $content): TimestampInterface {
    return $this->set('content', $content);
  }

  /**
   * @inheritdoc
   */
  public function setReferenceRevisionId(int $revision_id): TimestampInterface {
    return $this->set('revision_id', $revision_id);
  }

  /**
   * @inheritdoc
   */
  public function setHashInput(string $hash_input): TimestampInterface {
    return $this->set('hash_input', $hash_input);
  }

  /**
   * @inheritdoc
   */
  public function setRemoteId(string $remote_id): TimestampInterface {
    return $this->set('remote_id', $remote_id);
  }

  /**
   * @inheritdoc
   */
  public function setTransactionBlockchain(string $transaction_blockchain): TimestampInterface {
    return $this->set('transaction_blockchain', $transaction_blockchain);
  }

  /**
   * @inheritdoc
   */
  public function setTransactionAddress(string $transaction_address): TimestampInterface {
    return $this->set('transaction_address', $transaction_address);
  }

  /**
   * @inheritdoc
   */
  public function setTransactionId(string $transaction_id): TimestampInterface {
    return $this->set('transaction_id', $transaction_id);
  }

  /**
   * @inheritdoc
   */
  public function setTransactionLink(string $transaction_link): TimestampInterface {
    return $this->set('transaction_link', $transaction_link);
  }

  /**
   * @inheritdoc
   */
  public function setReferenceEntityType(string $entity_type): TimestampInterface {
    return $this->set('stamped_entity_type', $entity_type);
  }

}
