<?php

namespace Drupal\wordproof_timestamp\Plugin\wordproof_timestamp\Stamper;

use Drupal\wordproof_timestamp\Plugin\StamperInterface;

/**
 * Defines an Stamper implementation for Nodes.
 *
 * @Stamper(
 *   id = "node_article_stamper",
 *   title = @Translation("Node ArticleTimestamp"),
 *   description = @Translation("Creates ArticleTimestamp from an Node"),
 *   entity_types = {"node:article"}
 * )
 */
class NodeArticleStamper extends ContentEntityStamper implements StamperInterface {

}
