<?php

namespace Drupal\wordproof_timestamp;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityPublishedInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\wordproof_timestamp\Exception\InvalidEntityException;
use Drupal\wordproof_timestamp\Plugin\BlockchainBackendInterface;
use Drupal\wordproof_timestamp\Plugin\BlockchainBackendManager;
use Drupal\wordproof_timestamp\Plugin\StamperInterface;
use Drupal\wordproof_timestamp\Plugin\StamperManager;

class TimestampBuilderService {

  /**
   * @var \Drupal\wordproof_timestamp\Plugin\StamperManager
   */
  private $stamperManager;

  /**
   * @var \Drupal\wordproof_timestamp\Plugin\BlockchainBackendManager
   */
  private $blockchainBackendManager;

  /**
   * @var \Drupal\wordproof_timestamp\TimestampRepositoryInterface
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

  /**
   * @var \Drupal\wordproof_timestamp\EntityWatchListService
   */
  private $entityWatchListService;
  /**
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  private $entityTypeManager;

  public function __construct(StamperManager $stamperManager, BlockchainBackendManager $blockchainBackendManager, TimestampRepositoryInterface $timestampRepository, ConfigFactoryInterface $configFactory, EntityWatchListService $entityWatchListService, EntityTypeManagerInterface $entityTypeManager) {
    $this->timestampRepository = $timestampRepository;
    $this->stamperManager = $stamperManager;
    $this->blockchainBackendManager = $blockchainBackendManager;

    $this->config = $configFactory->get('wordproof_timestamp.settings');
    $this->entityWatchListService = $entityWatchListService;
    $this->entityTypeManager = $entityTypeManager;
  }

  /**
   * @param \Drupal\Core\Entity\ContentEntityInterface $entity
   *
   * @return \Drupal\wordproof_timestamp\Plugin\StamperInterface
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
    }
    catch (InvalidEntityException $e) {
      return FALSE;
    }

    $timestamp->save();

    $backendPlugin = $this->getBlockchainBackend();
    $timestamp = $backendPlugin->send($timestamp);
    $timestamp->save();

    return TRUE;
  }

  /**
   * @return \Drupal\wordproof_timestamp\Plugin\BlockchainBackendInterface
   * @throws \Drupal\Component\Plugin\Exception\PluginException
   */
  public function getBlockchainBackend(): BlockchainBackendInterface {
    return $this->blockchainBackendManager->createInstance($this->config->get('blockchain_backend_id'));
  }

  private function isStampable(ContentEntityInterface $entity): bool {
    $isEnabled = $this->config->get('stamper.' . $entity->getEntityTypeId() . '-' . $entity->bundle() . '.enabled');
    return $isEnabled === '1';
  }

  public function stampWatchedEntities(ContentEntityInterface $entity) {
    $watchList = $this->entityWatchListService->getWatchList();
    $entityTypeId = $entity->getEntityTypeId();

    if (isset($watchList[$entityTypeId])) {
      foreach ($watchList[$entityTypeId] as $targetEntityTypeId => $fields) {
        $entityStorage = $this->entityTypeManager->getStorage($targetEntityTypeId);
        $query = $entityStorage->getQuery('OR');
        foreach ($fields as $field_name) {
          $query->condition($field_name, $entity->id(), 'IN');
        }
        $result = $query->execute();

        if (count($result) > 0) {
          $entitiesWithReference = $entityStorage->loadMultiple($result);
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
