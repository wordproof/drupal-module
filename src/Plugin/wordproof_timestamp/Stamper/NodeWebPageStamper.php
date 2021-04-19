<?php


namespace Drupal\wordproof_timestamp\Plugin\wordproof_timestamp\Stamper;


use Drupal\wordproof_timestamp\Plugin\StamperInterface;

/**
 * Defines an Stamper implementation for Nodes
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
