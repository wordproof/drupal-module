<?php

namespace Drupal\wordproof;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityPublishedInterface;
use Drupal\field\Entity\FieldStorageConfig;
use Drupal\wordproof\Exception\InvalidEntityException;
use Drupal\wordproof\Plugin\BlockchainBackendInterface;
use Drupal\wordproof\Plugin\BlockchainBackendManager;
use Drupal\wordproof\Plugin\StamperInterface;
use Drupal\wordproof\Plugin\StamperManager;

class TimestampBuilderService {

  /**
   * @var \Drupal\wordproof\Plugin\StamperManager
   */
  private $stamperManager;

  /**
   * @var \Drupal\wordproof\Plugin\BlockchainBackendManager
   */
  private $blockchainBackendManager;

  /**
   * @var \Drupal\wordproof\TimestampRepositoryInterface
   */
  private $timestampRepository;

  /**
   * @var \Drupal\Core\Config\ImmutableConfig
   */
  private $config;

  /**
   * @var array
   */
  private $watchList;


  public function __construct(StamperManager $stamperManager, BlockchainBackendManager $blockchainBackendManager, TimestampRepositoryInterface $timestampRepository, ConfigFactoryInterface $configFactory) {
    $this->timestampRepository = $timestampRepository;
    $this->stamperManager = $stamperManager;
    $this->blockchainBackendManager = $blockchainBackendManager;

    $this->config = $configFactory->get('wordproof.settings');
  }

  /**
   * @param \Drupal\Core\Entity\ContentEntityInterface $entity
   *
   * @return \Drupal\wordproof\Plugin\StamperInterface
   * @throws \Drupal\Component\Plugin\Exception\PluginException
   */
  private function getStamperPlugin(ContentEntityInterface $entity): StamperInterface {
    $pluginId = $this->config->get('stamper.' . $entity->getEntityTypeId() . '-' . $entity->bundle() . '.plugin_id');
    return $this->stamperManager->createInstance($pluginId);
  }

  /**
   * @param \Drupal\Core\Entity\ContentEntityInterface $entity
   *
   * @return bool
   * @throws \Drupal\Component\Plugin\Exception\PluginException
   */
  public function stamp(ContentEntityInterface $entity) {
    if ($entity instanceof EntityPublishedInterface && $entity->isPublished() === FALSE) {
      return FALSE;
    }
    if ($this->config->get('blockchain_backend_id') === '') {
      return FALSE;
    }

    if (!$this->isStampable($entity)) {
      return FALSE;
    }

    $plugin = $this->getStamperPlugin($entity);
    try {
      $timestamp = $plugin->timestamp($entity);
    } catch (InvalidEntityException $e) {
      return FALSE;
    }

    $timestamp->save();

    $backendPlugin = $this->getBlockchainBackend();
    $timestamp = $backendPlugin->send($timestamp);
    $timestamp->save();

    return TRUE;
  }

  /**
   * @return \Drupal\wordproof\Plugin\BlockchainBackendInterface
   * @throws \Drupal\Component\Plugin\Exception\PluginException
   */
  public function getBlockchainBackend(): BlockchainBackendInterface {
    return $this->blockchainBackendManager->createInstance($this->config->get('blockchain_backend_id'));
  }

  private function isStampable(ContentEntityInterface $entity): bool {
    $isEnabled = $this->config->get('stamper.' . $entity->getEntityTypeId() . '-' . $entity->bundle() . '.enabled');
    return $isEnabled === '1';
  }


  private function buildWatchList(): array {
    if (isset($this->watchList)) {
      return $this->watchList;
    }

    /** @var FieldStorageConfig[] $entityReferenceFields */
    $entityReferenceFields = \Drupal::service('entity_type.manager')
      ->getStorage('field_storage_config')
      ->loadByProperties(['type' => 'entity_reference']);
    $watchList = [];
    foreach ($entityReferenceFields as $field) {
      $target_type = $field->getSetting('target_type');
      if (!isset($watchList[$target_type])) {
        $watchList[$target_type] = [];
      }
      $targetEntityTypeId = $field->getTargetEntityTypeId();
      if (!isset($watchList[$target_type])) {
        $watchList[$target_type][$targetEntityTypeId] = [];
      }

      $watchList[$target_type][$targetEntityTypeId][] = $field->getName();
    }
    return $this->watchList = $watchList;
  }

  public function stampWatchedEntities(ContentEntityInterface $entity) {
    $watchList = $this->buildWatchList();
    $entityTypeId = $entity->getEntityTypeId();

    if (isset($watchList[$entityTypeId])) {
      foreach ($watchList[$entityTypeId] as $targetEntityTypeId => $fields) {
        $query = \Drupal::entityQuery($targetEntityTypeId, 'OR');
        foreach ($fields as $field_name) {
          $query->condition($field_name, $entity->id(), 'IN');
        }
        $result = $query->execute();

        if (count($result) > 0) {
          $entitiesWithReference = \Drupal::entityTypeManager()->getStorage($targetEntityTypeId)->loadMultiple($result);
          foreach ($entitiesWithReference as $entityWithReference) {
            if ($entityWithReference instanceof ContentEntityInterface) {
              $this->stamp($entityWithReference);
            }
          }
        }
      }
    }
  }

}
