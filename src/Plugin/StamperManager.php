<?php

namespace Drupal\wordproof_timestamp\Plugin;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;

class StamperManager extends DefaultPluginManager {

  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler) {
    parent::__construct(
      'Plugin/wordproof_timestamp/Stamper',
      $namespaces,
      $module_handler,
      'Drupal\wordproof_timestamp\Plugin\StamperInterface',
      'Drupal\wordproof_timestamp\Annotation\Stamper'
    );
    $this->alterInfo('wordproof_info');
    $this->setCacheBackend($cache_backend, 'wordproof_info_stamper_plugins');
  }

  /**
   * {@inheritdoc}
   *
   * @return \Drupal\wordproof_timestamp\Plugin\StamperInterface
   */
  public function createInstance($plugin_id, array $configuration = []) {
    return parent::createInstance($plugin_id, $configuration);
  }

}
