<?php

namespace Drupal\wordproof\Plugin;

use Drupal\Core\Entity\ContentEntityInterface;

interface StamperInterface {

  public function timestamp(ContentEntityInterface $entity);

}
