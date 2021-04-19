<?php

namespace Drupal\wordproof_timestamp\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines an hash input annotation object.
 *
 * Plugin Namespace: Plugin\wordproof_timestamp\Stamper
 *
 * For a working example, see \Drupal\wordproof_timestamp\Plugin\wordproof_timestamp\Stamper\ContentEntityStamper
 *
 * @see \Drupal\wordproof_timestamp\Plugin\StamperManager
 * @see \Drupal\wordproof_timestamp\Plugin\StamperInterface
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

  /**
   * An array of entity types that can be referenced by this plugin. Defaults to
   * all entity types.
   *
   * @var array (optional)
   */
  public $entity_types = [];

}
