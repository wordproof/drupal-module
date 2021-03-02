<?php

namespace Drupal\wordproof\Plugin;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;

class StamperManager extends DefaultPluginManager {

  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler) {
    parent::__construct(
      'Plugin/wordproof/Stamper',
      $namespaces,
      $module_handler,
      'Drupal\wordproof\Plugin\StamperInterface',
      'Drupal\wordproof\Annotation\Stamper'
    );
    $this->alterInfo('wordproof_info');
    $this->setCacheBackend($cache_backend, 'wordproof_info_plugins');
  }

}
