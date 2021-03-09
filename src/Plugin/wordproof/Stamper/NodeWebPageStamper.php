<?php


namespace Drupal\wordproof\Plugin\wordproof\Stamper;

use Drupal\node\Entity\Node;
use Drupal\wordproof\Plugin\StamperInterface;
use Drupal\wordproof\Timestamp\Timestamp;
use Drupal\wordproof\Timestamp\TimestampInterface;
use Drupal\wordproof\Timestamp\WebPageTimestamp;

/**
 * Defines an Stamper implementation for Nodes
 *
 * @Stamper(
 *   id = "node_webpage_stamper",
 *   title = @Translation("Node WebPageTimestamp"),
 *   description = @Translation("Creates WebPageTimestamp from an Node")
 *   entity_types = ['page']
 * )
 */
class NodeWebPageStamper extends NodeTypeStamper implements StamperInterface {

}
