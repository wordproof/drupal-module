<?php
namespace Drupal\wordproof\Plugin\wordproof\HashInput;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\wordproof\HashInput\HashInputInterface;

/**
 * Defines an HashInput implementation for ContentEntities
 *
 * @Serializer(
 *   id = "Serializer",
 *   title = @Translation("Serializer"),
 *   description = @Translation("Created HashInput by serializing an Entity")
 * )
 */
class Serializer implements HashInputInterface {

  public static function data(ContentEntityBase $entity): string {
    // @todo Serialze the entity to something we can hash.
  }

  public static function hash(ContentEntityBase $entity): string {
    // @todo Return the hash of the data
  }

}
