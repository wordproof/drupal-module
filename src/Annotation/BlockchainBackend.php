<?php

namespace Drupal\wordproof\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines an blockchain backend for the Hashes.
 *
 * Plugin Namespace: Plugin\wordproof\BlockchainBackend
 *
 * For a working example, see \Drupal\wordproof\Plugin\wordproof\BlockchainBackend\Wordproof
 *
 * @see \Drupal\wordproof\Plugin\BlockchainBackendManager
 * @see \Drupal\wordproof\Plugin\BlockchainBackendInterface
 * @see plugin_api
 *
 * @Annotation
 */
class BlockchainBackend extends Plugin {

  /**
   * The BlockchainBackend plugin ID.
   *
   * @var string
   */
  public $id;

  /**
   * The human-readable name of the BlockchainBackend plugin.
   *
   * @ingroup plugin_translatable
   *
   * @var \Drupal\Core\Annotation\Translation
   */
  public $title;

  /**
   * The description of the BlockchainBackend plugin.
   *
   * @ingroup plugin_translatable
   *
   * @var \Drupal\Core\Annotation\Translation
   */
  public $description;

}
