<?php

namespace Drupal\wordproof\HashInput;


use Drupal\Core\Entity\ContentEntityBase;

interface HashInputInterface {

  public static function data(ContentEntityBase $entity) : string;

  public static function hash(ContentEntityBase $entity) : string;

}
