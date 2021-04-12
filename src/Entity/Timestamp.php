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
 *   id = "timestamp",
 *   label = @Translation("Timestamp"),
 *   base_table = "timestamp",
 *   entity_keys = {
 *     "id" = "id",
 *     "date_created" = "date_created",
 *   }
 * )
 */
class Timestamp extends ContentEntityBase implements ContentEntityInterface, TimestampInterface {

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
      ->setLabel(t('Unix timestamp '))
      ->setDefaultValue(0)
      ->setDescription(t('The HashInput on which the hash is based.'));

    return $fields;
  }

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
   * Array with HashInput data. Encoding note: json_encode([], JSON_FORCE_OBJECT + JSON_UNESCAPED_SLASHES);
   *
   * @return object
   */
  public function getHashInputObject(){
    return (object) [
      "@context"    => "https://schema.org",
      "@type"       => "HashInput",
      "dateCreated" => date('c', $this->getModified()),
      "isBasedOn"   => $this->getUrl(),
      "text"        => trim($this->getContent()),
    ];
  }

  public function getCacheTagsToInvalidate() {
    $cacheTagsToInvalidate = parent::getCacheTagsToInvalidate();
    $cacheTagsToInvalidate[] = $this->getReferenceEntityType() . ':' . $this->getReferenceId();
    if ($this->isNew()) {
      return $cacheTagsToInvalidate;
    }
    $cacheTagsToInvalidate[] = $this->entityTypeId . ':' . $this->id();
    return $cacheTagsToInvalidate;
  }


  public function getHash(): string {
    return $this->get('hash')->value;
  }

  public function getContent(): string {
    return $this->get('content')->value;
  }

  public function getModified(): int {
    return $this->get('date_created')->value;
  }

  public function getUrl(): string {
    return $this->get('url')->value;
  }

  public function getTitle(): string {
    return $this->get('title')->value;
  }

  public function getReferenceId(): int {
    return $this->get('entity_id')->value;
  }

  public function getHashInput(): string {
    return $this->get('hash_input')->value;
  }

  public function getReferenceRevisionId(): int {
    return $this->get('revision_id')->value;
  }

  public function getRemoteId(): string {
    return $this->get('remote_id')->value;
  }

  public function getTransactionBlockchain() {
    return $this->get('transaction_blockchain')->value;
  }

  public function getTransactionAddress() {
    return $this->get('transaction_address')->value;
  }

  public function getTransactionId() {
    return $this->get('transaction_id')->value;
  }

  public function getTransactionLink() {
    return $this->get('transaction_link')->value;
  }

  public function getReferenceEntityType(): string {
    return $this->get('stamped_entity_type')->value;
  }

  public function setModified(int $date): TimestampInterface {
    return $this->set('date_created', $date);
  }

  public function setTitle(string $title): TimestampInterface {
    return $this->set('title', $title);
  }

  public function setReferenceId(int $entity_id): TimestampInterface {
    return $this->set('entity_id', $entity_id);
  }

  public function setUrl(string $url): TimestampInterface {
    return $this->set('url', $url);
  }

  public function setHash(string $hash): TimestampInterface {
    return $this->set('hash', $hash);
  }

  public function setContent(string $content): TimestampInterface {
    return $this->set('content', $content);
  }

  public function setReferenceRevisionId(int $revision_id): TimestampInterface {
    return $this->set('revision_id', $revision_id);
  }

  public function setHashInput(string $hash_input): TimestampInterface {
    return $this->set('hash_input', $hash_input);
  }

  public function setRemoteId(string $remote_id): TimestampInterface {
    return $this->set('remote_id', $remote_id);
  }

  public function setTransactionBlockchain(string $transaction_blockchain): TimestampInterface {
    return $this->set('transaction_blockchain', $transaction_blockchain);
  }

  public function setTransactionAddress(string $transaction_address): TimestampInterface {
    return $this->set('transaction_address', $transaction_address);
  }

  public function setTransactionId(string $transaction_id): TimestampInterface {
    return $this->set('transaction_id', $transaction_id);
  }

  public function setTransactionLink(string $transaction_link): TimestampInterface {
    return $this->set('transaction_link', $transaction_link);
  }

  public function setReferenceEntityType(string $entity_type): TimestampInterface {
    return $this->set('stamped_entity_type', $entity_type);
  }

}
