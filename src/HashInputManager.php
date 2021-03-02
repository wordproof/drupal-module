<?php
namespace Drupal\wordproof;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;

class HashInputManager extends DefaultPluginManager {

  public function __construct( \Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler) {
    parent::__construct(
      'Plugin/HashInput',
      $namespaces,
      $module_handler,
      'Drupal\wordproof\HashInput\HashInputInterface',
      'Drupal\wordproof\HashInput\Annotation\HashInput'
    );
    $this->alterInfo('wordproof_info');
    $this->setCacheBackend($cache_backend, 'wordproof_info_plugins');
  }

}
