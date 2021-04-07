<?php


namespace Drupal\wordproof;


use Drupal\Core\Entity\ContentEntityTypeInterface;
use Drupal\Core\Entity\EntityFieldManagerInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Entity\FieldableEntityInterface;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\field\Entity\FieldStorageConfig;

class EntityWatchListService {

  /**
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  private $entityTypeManager;

  /**
   * @var \Drupal\Core\Entity\EntityFieldManagerInterface
   */
  private $entityFieldManager;

  /**
   * @var array
   */
  private $watchList;

  /**
   * EntityWatchListService constructor.
   */
  public function __construct(EntityTypeManagerInterface $entityTypeManager, EntityFieldManagerInterface $entityFieldManager) {
    $this->entityTypeManager = $entityTypeManager;
    $this->entityFieldManager = $entityFieldManager;
  }

  public function getWatchList(): array {
    if (isset($this->watchList)) {
      return $this->watchList;
    }

    $this->fromFieldStorageConfig();
    $this->fromBaseFields();

    return $this->watchList;
  }

  private function fromFieldStorageConfig() {
    /** @var FieldStorageDefinitionInterface[] $entityReferenceFields */
    $entityReferenceFields = $this->entityTypeManager
      ->getStorage('field_storage_config')
      ->loadByProperties(['type' => ['entity_reference', 'entity_reference_revision']]);

    foreach ($entityReferenceFields as $field) {
      $this->addField($field);
    }
  }

  private function fromBaseFields() {
    $entityTypeDefinitions = $this->entityTypeManager->getDefinitions();
    /** @var ContentEntityTypeInterface[] $fieldableEntityTypeDefinitions */
    $fieldableEntityTypeDefinitions = array_filter(
      $entityTypeDefinitions,
      function ($definition, $key) {
        $isContentEntity = $definition instanceof ContentEntityTypeInterface;
        $isNoTimestamp = $key !== 'timestamp';
        $isFieldable = $definition->entityClassImplements(FieldableEntityInterface::class);
        return $isContentEntity && $isNoTimestamp && $isFieldable;
      },
      ARRAY_FILTER_USE_BOTH
    );

    foreach ($fieldableEntityTypeDefinitions as $entityType) {
      /** @var \Drupal\Core\Field\BaseFieldDefinition[] $base_fields */
      $base_fields = $this->entityFieldManager->getBaseFieldDefinitions($entityType->id());
      foreach ($base_fields as $field) {
        if ($field->getType() === 'entity_reference') {
          $this->addField($field);
        }
      }
    }
  }

  private function addField(FieldStorageDefinitionInterface $field) {
    $target_type = $field->getSetting('target_type');
    if (!isset($this->watchList[$target_type])) {
      $this->watchList[$target_type] = [];
    }
    $targetEntityTypeId = $field->getTargetEntityTypeId();
    if (!isset($this->watchList[$target_type])) {
      $this->watchList[$target_type][$targetEntityTypeId] = [];
    }

    $field_name = $field->getName();
    $this->watchList[$target_type][$targetEntityTypeId][] = $field_name;
  }

}
