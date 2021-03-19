<?php


namespace Drupal\wordproof\Plugin\wordproof\Stamper;

use Drupal\wordproof\Plugin\StamperInterface;

/**
 * Defines an Stamper implementation for Nodes
 *
 * @Stamper(
 *   id = "node_article_stamper",
 *   title = @Translation("Node ArticleTimestamp"),
 *   description = @Translation("Creates ArticleTimestamp from an Node"),
 *   entity_types = {"node:article"}
 * )
 */
class NodeArticleStamper extends NodeTypeStamper implements StamperInterface {

}
