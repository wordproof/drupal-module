<?php

namespace Drupal\wordproof\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines an hash input annotation object.
 *
 * Plugin Namespace: Plugin\wordproof\Stamper.
 *
 * For a working example, see \Drupal\wordproof\Plugin\wordproof\Stamper\ContentEntityStamper
 *
 * @see \Drupal\wordproof\Plugin\StamperManager
 * @see \Drupal\wordproof\Plugin\StamperInterface
 * @see plugin_api
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
   * @var \Drupal\Core\Annotation\Translation
   *
   * @ingroup plugin_translatable
   */
  public $title;

  /**
   * The description of the plugin.
   *
   * @var \Drupal\Core\Annotation\Translation
   *
   * @ingroup plugin_translatable
   */
  public $description;

  /**
   * An array of entity types that can be referenced by this plugin. Defaults to all entity types.
   *
   * @var array
   *
   * @todo Implement filtering on entity types
   */
  public $entity_types = [];

}
