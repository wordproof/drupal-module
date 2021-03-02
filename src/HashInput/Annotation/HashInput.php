<?php

namespace Drupal\wordproof\HashInput\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines an hash input annotation object.
 *
 * Plugin Namespace: Plugin\HashInput
 *
 * For a working example, see \Drupal\wordproof\Plugin\wordproof\HashInput\Serializer
 *
 * @see \Drupal\wordproof\HashInputManager
 * @see \Drupal\wordproof\HashInput\HashInputInterface
 * @see plugin_api
 *
 * @todo Do we use hooks?
 *
 * @Annotation
 */
class HashInput extends Plugin {

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
