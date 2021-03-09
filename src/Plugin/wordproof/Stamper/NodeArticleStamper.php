<?php


namespace Drupal\wordproof\Plugin\wordproof\Stamper;

use Drupal\node\Entity\Node;
use Drupal\wordproof\Plugin\StamperInterface;
use Drupal\wordproof\Timestamp\ArticleTimestamp;
use Drupal\wordproof\Timestamp\Timestamp;
use Drupal\wordproof\Timestamp\TimestampInterface;

/**
 * Defines an Stamper implementation for Nodes
 *
 * @Stamper(
 *   id = "node_article_stamper",
 *   title = @Translation("Node ArticleTimestamp"),
 *   description = @Translation("Creates ArticleTimestamp from an Node")
 *   entity_types = ['article']
 * )
 */
class NodeArticleStamper extends NodeTypeStamper implements StamperInterface {

}
