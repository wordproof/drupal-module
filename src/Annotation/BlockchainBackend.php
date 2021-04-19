<?php

namespace Drupal\wordproof_timestamp\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines an blockchain backend for the Hashes.
 *
 * Plugin Namespace: Plugin\wordproof_timestamp\BlockchainBackend
 *
 * For a working example, see \Drupal\wordproof_timestamp\Plugin\wordproof_timestamp\BlockchainBackend\WordProof
 *
 * @see \Drupal\wordproof_timestamp\Plugin\BlockchainBackendManager
 * @see \Drupal\wordproof_timestamp\Plugin\BlockchainBackendInterface
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
