<?php

namespace Drupal\wordproof\Plugin;

use Drupal\Core\Entity\ContentEntityInterface;

/**
 * A stamper takes a content-entity and creates the Timestamp .
 *
 *  For example you could chose to use serialized data instead
 * of rendered HTML here, or
 *  if your entities need custom logic define that here.
 */
interface StamperInterface {

  /**
   * Stamp the entity.
   *
   * @param \Drupal\Core\Entity\ContentEntityInterface $entity
   *   The entity to stamp.
   *
   * @return \Drupal\wordproof\Timestamp\TimestampInterface
   *   return the timestamp
   */
  public function timestamp(ContentEntityInterface $entity);

}
