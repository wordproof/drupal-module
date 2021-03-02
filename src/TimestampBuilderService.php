<?php

namespace Drupal\wordproof;

use Drupal\node\Entity\Node;
use Drupal\wordproof\Plugin\StamperInterface;
use Drupal\wordproof\Plugin\StamperManager;

class TimestampBuilderService {

  /**
   * @var \Drupal\wordproof\Plugin\StamperManager
   */
  private $stamperManager;

  public function __construct(StamperManager $stamperManager) {
    $this->stamperManager = $stamperManager;
  }

  /**
   * @todo This is configuration, what stamper to use for a node
   *
   * @param $bundle
   *
   * @return \Drupal\wordproof\Plugin\StamperInterface
   * @throws \Drupal\Component\Plugin\Exception\PluginException
   */
  private function getPlugin($bundle): StamperInterface {
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
      $plugin = $this->getPlugin($bundle);

      $timestamp = $plugin->timestamp($node);
      \Drupal::logger('wordproof')->debug('stamped ' . get_class($timestamp));

      // send TimestampInterface to BlockchainBackend
    }
  }

}
