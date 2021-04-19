<?php

namespace Drupal\wordproof_timestamp\Plugin;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;

class BlockchainBackendManager extends DefaultPluginManager {

  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler) {
    parent::__construct(
      'Plugin/wordproof_timestamp/BlockchainBackend',
      $namespaces,
      $module_handler,
      'Drupal\wordproof_timestamp\Plugin\BlockchainBackendInterface',
      'Drupal\wordproof_timestamp\Annotation\BlockchainBackend'
    );
    $this->alterInfo('wordproof_info');
    $this->setCacheBackend($cache_backend, 'wordproof_info_blockchain_backend_plugins');
  }

  /**
   * {@inheritdoc}
   *
   * @return \Drupal\wordproof_timestamp\Plugin\BlockchainBackendInterface
   */
  public function createInstance($plugin_id, array $configuration = []) {
    return parent::createInstance($plugin_id, $configuration);
  }
}
