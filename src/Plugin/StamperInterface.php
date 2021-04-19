<?php

namespace Drupal\wordproof_timestamp\Plugin;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\wordproof_timestamp\Timestamp\TimestampInterface;

interface StamperInterface {
  public function timestamp(ContentEntityInterface $entity);
}
