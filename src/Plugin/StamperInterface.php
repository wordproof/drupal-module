<?php

namespace Drupal\wordproof\Plugin;

use Drupal\node\Entity\Node;
use Drupal\wordproof\Timestamp\TimestampInterface;

interface StamperInterface {
  public function timestamp(Node $node): TimestampInterface;
}
