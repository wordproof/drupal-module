<?php

namespace Drupal\wordproof\Plugin;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;

class BlockchainBackendManager extends DefaultPluginManager {

  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler) {
    parent::__construct(
      'Plugin/wordproof/BlockchainBackend',
      $namespaces,
      $module_handler,
      'Drupal\wordproof\Plugin\BlockchainBackendInterface',
      'Drupal\wordproof\Annotation\BlockchainBackend'
    );
    $this->alterInfo('wordproof_info');
    $this->setCacheBackend($cache_backend, 'wordproof_info_blockchain_backend_plugins');
  }

}
