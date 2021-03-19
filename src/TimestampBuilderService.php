<?php

namespace Drupal\wordproof;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Entity\ContentEntityInterface;
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
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  private $configFactory;

  /**
   * @var \Drupal\Core\Config\ImmutableConfig
   */
  private $config;


  public function __construct(StamperManager $stamperManager, BlockchainBackendManager $blockchainBackendManager, TimestampRepositoryInterface $timestampRepository, ConfigFactoryInterface $configFactory) {
    $this->timestampRepository = $timestampRepository;
    $this->stamperManager = $stamperManager;
    $this->configFactory = $configFactory;
    $this->blockchainBackendManager = $blockchainBackendManager;

    $this->config = $configFactory->get('wordproof.settings');
  }

  /**
   * @param $bundle
   *
   * @return \Drupal\wordproof\Plugin\StamperInterface
   * @throws \Drupal\Component\Plugin\Exception\PluginException
   * @todo This is configuration, what stamper to use for an entity
   */
  private function getStamperPlugin(ContentEntityInterface $entity): StamperInterface {
    if ($entity->getEntityTypeId() == 'node') {
      switch ($entity->bundle()) {
        case 'article':
          return $this->stamperManager->createInstance('node_article_stamper');
        case 'page':
          return $this->stamperManager->createInstance('node_webpage_stamper');
      }
    }
    return $this->stamperManager->createInstance('content_entity_stamper');
  }

  public function stamp(ContentEntityInterface $entity) {
    if (method_exists($entity, 'isPublished') && $entity->isPublished() === FALSE) {
      return FALSE;
    }
    if ($this->config->get('blockchain_backend_id') === '') {
      return FALSE;
    }

    // Check if stampable from config normally.
    $allowed = ['node'];
    if (!in_array($entity->getEntityTypeId(), $allowed)) {
      return;
    }

    $bundle = $entity->bundle();
    if ($bundle) {
      $plugin = $this->getStamperPlugin($entity);
      try {
        $timestamp = $plugin->timestamp($entity);
      } catch (InvalidEntityException $e) {
        return FALSE;
      }
      $timestamp->save();

      \Drupal::logger('wordproof')->debug('Stamped ' . get_class($timestamp));

      $backendPlugin = $this->getBlockchainBackend();
      $timestamp = $backendPlugin->send($timestamp);
      \Drupal::logger('wordproof')->debug('Sent ' . get_class($timestamp));


      // $this->timestampRepository->create($timestamp);
      $timestamp->save();
      \Drupal::logger('wordproof')->debug('Saved ' . get_class($timestamp));
    }
  }

  /**
   * @throws \Drupal\Component\Plugin\Exception\PluginException
   */
  public function getBlockchainBackend(): BlockchainBackendInterface {
    return $this->blockchainBackendManager->createInstance($this->config->get('blockchain_backend_id'));
  }

}
