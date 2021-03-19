<?php

namespace Drupal\wordproof\Plugin;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\wordproof\Timestamp\TimestampInterface;

interface StamperInterface {
  public function timestamp(ContentEntityInterface $entity);
}
