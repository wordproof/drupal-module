<?php

namespace Drupal\wordproof\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines an blockchain backend for the Hashes.
 *
 * Plugin Namespace: Plugin\BlockchainBackend
 *
 * For a working example, see \Drupal\wordproof\Plugin\wordproof\BlockchainBackend\Wordproof
 *
 * @see \Drupal\wordproof\HashInputManager
 * @see \Drupal\wordproof\HashInput\StamperInterface
 * @see plugin_api
 *
 * @todo Do we use hooks?
 *
 * @Annotation
 */
class BlockchainBackend extends Plugin {

  /**
   * The HashInput plugin ID.
   *
   * @var string
   */
  public $id;

  /**
   * The human-readable name of the HashInput plugin.
   *
   * @ingroup plugin_translatable
   *
   * @var \Drupal\Core\Annotation\Translation
   */
  public $title;

  /**
   * The description of the HashInput plugin.
   *
   * @ingroup plugin_translatable
   *
   * @var \Drupal\Core\Annotation\Translation
   */
  public $description;

}
