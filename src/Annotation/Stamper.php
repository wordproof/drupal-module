<?php

namespace Drupal\wordproof\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines an hash input annotation object.
 *
 * Plugin Namespace: Plugin\wordproof\Stamper
 *
 * For a working example, see \Drupal\wordproof\Plugin\wordproof\Stamper\NodeStamper
 *
 * @see \Drupal\wordproof\Plugin\StamperManager
 * @see \Drupal\wordproof\Plugin\StamperInterface
 * @see plugin_api
 *
 * @todo Do we use hooks?
 *
 * @Annotation
 */
class Stamper extends Plugin {

  /**
   * The HashInput plugin ID.
   *
   * @var string
   */
  public $id;

  /**
   * The human-readable name of the plugin.
   *
   * @ingroup plugin_translatable
   *
   * @var \Drupal\Core\Annotation\Translation
   */
  public $title;

  /**
   * The description of the plugin.
   *
   * @ingroup plugin_translatable
   *
   * @var \Drupal\Core\Annotation\Translation
   */
  public $description;

}
