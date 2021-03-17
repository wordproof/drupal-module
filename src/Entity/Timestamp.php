<?php

namespace Drupal\wordproof\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;

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
 *     "uuid" = "uuid",
 *     "entity_id" = "entity_id",
 *     "revision_id" = "revision_id",
 *     "remote_id" = "remote_id",
 *     "hash" = "hash",
 *     "transaction_blockchain" = "transaction_blockchain",
 *     "transaction_address" = "transaction_address",
 *     "transaction_id" = "transaction_id",
 *     "transaction_link" = "transaction_link",
 *     "hash_input" = "hash_input",
 *     "date_created" = "date_created",
 *   }
 * )
 */
class Timestamp extends ContentEntityBase implements ContentEntityInterface {

  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {

    // Standard field, used as unique if primary index.
    $fields['id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('ID'))
      ->setDescription(t('The ID of the Advertiser entity.'))
      ->setReadOnly(TRUE);

    // Standard field, unique outside of the scope of the current project.
    $fields['uuid'] = BaseFieldDefinition::create('uuid')
      ->setLabel(t('UUID'))
      ->setDescription(t('The UUID of the Advertiser entity.'))
      ->setReadOnly(TRUE);

    // Standard field, unique outside of the scope of the current project.
    $fields['entity_id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('The entity id'))
      ->setDescription(t('The referred entity id for the timestamp.'));

    // Standard field, unique outside of the scope of the current project.
    $fields['revision_id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('The revision id'))
      ->setDescription(t('The referred revision id for the referred entity.'));

    // Standard field, unique outside of the scope of the current project.
    $fields['remote_id'] = BaseFieldDefinition::create('string')
      ->setLabel(t('The remote id'))
      ->setDefaultValue('')
      ->setSettings(
        [
          'length' => 128,
        ]
      )
      ->setDescription(t('The ID in the remote if needed.'));

    // Standard field, unique outside of the scope of the current project.
    $fields['hash'] = BaseFieldDefinition::create('string')
      ->setLabel(t('The revision id'))
      ->setSettings(
        [
          'length' => 64,
        ]
      )
      ->setDescription(t('Hash of the HashInput of this content.'));

    // Standard field, unique outside of the scope of the current project.
    $fields['transaction_blockchain'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Blockchain used'))
      ->setSettings(
        [
          'length' => 128,
        ]
      )
      ->setDescription(t('Blockchain used to record the content.'));

    // Standard field, unique outside of the scope of the current project.
    $fields['transaction_address'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Blockchain address info'))
      ->setSettings(
        [
          'length' => 128,
        ]
      )
      ->setDescription(t('Blockchain address info.'));

    // Standard field, unique outside of the scope of the current project.
    $fields['transaction_id'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Blockchain transaction id'))
      ->setSettings(
        [
          'length' => 128,
        ]
      )
      ->setDescription(t('Blockchain transaction to record the content.'));

    // Standard field, unique outside of the scope of the current project.
    $fields['transaction_link'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Blockchain transaction link'))
      ->setSettings(
        [
          'length' => 128,
        ]
      )
      ->setDescription(t('Link to blockchain transaction.'));

    // Standard field, unique outside of the scope of the current project.
    $fields['hash_input'] = BaseFieldDefinition::create('string_long')
      ->setLabel(t('HashInput'))
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

}
