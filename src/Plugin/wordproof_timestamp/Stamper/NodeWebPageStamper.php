<?php

namespace Drupal\wordproof\Plugin\wordproof\Stamper;

use Drupal\wordproof\Plugin\StamperInterface;

/**
 * Defines an Stamper implementation for Nodes.
 *
 * @Stamper(
 *   id = "node_webpage_stamper",
 *   title = @Translation("Node WebPageTimestamp"),
 *   description = @Translation("Creates WebPageTimestamp from an Node"),
 *   entity_types = {"node:page"}
 * )
 */
class NodeWebPageStamper extends ContentEntityStamper implements StamperInterface {

}
