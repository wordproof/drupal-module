<?php

namespace Drupal\wordproof\Plugin;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;

/**
 * Plugin manager for Stampers.
 */
class StamperManager extends DefaultPluginManager {

  /**
   * @inheritdoc
   */
  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler) {
    parent::__construct(
      'Plugin/wordproof/Stamper',
      $namespaces,
      $module_handler,
      'Drupal\wordproof\Plugin\StamperInterface',
      'Drupal\wordproof\Annotation\Stamper'
    );
    $this->alterInfo('wordproof_info');
    $this->setCacheBackend($cache_backend, 'wordproof_info_stamper_plugins');
  }

  /**
   * {@inheritdoc}
   *
   * @return \Drupal\wordproof\Plugin\StamperInterface
   *   The stamper plugin
   */
  public function createInstance($plugin_id, array $configuration = []) {
    return parent::createInstance($plugin_id, $configuration);
  }

}
