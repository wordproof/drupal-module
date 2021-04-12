<?php
namespace Drupal\wordproof\Entity;

use Drupal\Core\Entity\Sql\SqlContentEntityStorageSchema;
use Drupal\Core\Field\FieldStorageDefinitionInterface;

/**
 * Defines the node schema handler.
 */
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
      case 'remote_id':
      case 'date_created':
        $this->addSharedTableFieldIndex($storage_definition, $schema, TRUE);
        break;
    }

    return $schema;
  }

}
