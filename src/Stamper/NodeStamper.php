<?php


namespace Drupal\wordproof\Stamper;

use Drupal\node\Entity\Node;
use Drupal\wordproof\Timestamp\TimestampInterface;

class NodeStamper {

  private $availableOutputs = [];

  public function stamp(Node $node) : TimestampInterface {

  }
}
