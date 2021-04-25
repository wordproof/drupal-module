<?php

namespace Drupal\wordproof_timestamp\Plugin;

use Drupal\Core\Entity\ContentEntityInterface;

interface StamperInterface {

  public function timestamp(ContentEntityInterface $entity);

}
