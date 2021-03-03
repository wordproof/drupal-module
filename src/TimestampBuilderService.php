<?php

namespace Drupal\wordproof;

use Drupal\node\Entity\Node;
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

  public function __construct(StamperManager $stamperManager, BlockchainBackendManager $blockchainBackendManager) {
    $this->stamperManager = $stamperManager;
    $this->blockchainBackendManager = $blockchainBackendManager;
  }

  /**
   * @param $bundle
   *
   * @return \Drupal\wordproof\Plugin\StamperInterface
   * @throws \Drupal\Component\Plugin\Exception\PluginException
   * @todo This is configuration, what stamper to use for a node
   */
  private function getStamperPlugin($bundle): StamperInterface {
    switch ($bundle) {
      case 'article':
        return $this->stamperManager->createInstance('node_article_stamper');
      case 'page':
        return $this->stamperManager->createInstance('node_webpage_stamper');
    }
  }

  public function stamp(Node $node) {
    $bundle = $node->bundle();
    if ($bundle) {
      $plugin = $this->getStamperPlugin($bundle);

      $timestamp = $plugin->timestamp($node);
      \Drupal::logger('wordproof')->debug('Stamped ' . get_class($timestamp));

      $backendPlugin = $this->getBlockchainBackend();
      $backendPlugin->send($timestamp);
      \Drupal::logger('wordproof')->debug('Sent ' . get_class($timestamp));
    }
  }

  /**
   * @throws \Drupal\Component\Plugin\Exception\PluginException
   */
  public function getBlockchainBackend(): BlockchainBackendInterface {
    // @todo Get from configuration
    return $this->blockchainBackendManager->createInstance('wordproof_api_backend');
  }

}
