<?php
namespace Drupal\wordproof_timestamp\Entity;

use Drupal\Core\Entity\Sql\SqlContentEntityStorageSchema;
use Drupal\Core\Field\FieldStorageDefinitionInterface;

class TimestampStorageSchema extends SqlContentEntityStorageSchema {

  /**
   * {@inheritdoc}
   */
  protected function getSharedTableFieldSchema(FieldStorageDefinitionInterface $storage_definition, $table_name, array $column_mapping) {
    $schema = parent::getSharedTableFieldSchema($storage_definition, $table_name, $column_mapping);
    $field_name = $storage_definition->getName();

    switch ($field_name) {
      case 'entity_id':
      case 'stamped_entity_type':
      case 'revision_id':
      case 'date_created':
        $this->addSharedTableFieldIndex($storage_definition, $schema, TRUE);
        break;
      case 'remote_id':
        $this->addSharedTableFieldIndex($storage_definition, $schema, FALSE);
    }

    return $schema;
  }

}
