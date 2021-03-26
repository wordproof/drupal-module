<?php


namespace Drupal\wordproof\Plugin\wordproof\Stamper;

use Drupal\node\Entity\Node;
use Drupal\wordproof\Plugin\StamperInterface;
use Drupal\wordproof\Timestamp\TimestampInterface;
use Drupal\wordproof\Timestamp\WebPageTimestamp;

/**
 * Defines an Stamper implementation for Nodes
 *
 * @Stamper(
 *   id = "node_webpage_stamper",
 *   title = @Translation("Node WebPageTimestamp"),
 *   description = @Translation("Creates WebPageTimestamp from an Node")
 * )
 */
class NodeWebPageStamper implements StamperInterface {

  public function timestamp(Node $node): TimestampInterface {
    return new WebPageTimestamp();
  }

}
