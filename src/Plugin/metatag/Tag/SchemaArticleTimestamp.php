<?php

namespace Drupal\wordproof\Plugin\metatag\Tag;

use Drupal\schema_metatag\Plugin\metatag\Tag\SchemaNameBase;

/**
 * Provides a plugin for the 'schema_article_timestamp' meta tag.
 *
 * - 'id' should be a globally unique id.
 * - 'name' should match the Schema.org element name.
 * - 'group' should match the id of the group that defines the Schema.org type.
 *
 * @MetatagTag(
 *   id = "schema_article_timestamp",
 *   label = @Translation("timestamp"),
 *   description = @Translation("The timestamp of this article."),
 *   name = "timestamp",
 *   group = "schema_article",
 *   weight = 10,
 *   type = "blockchain_transaction",
 *   secure = FALSE,
 *   multiple = FALSE,
 *   property_type = "blockchain_transaction",
 *   tree_parent = {
 *     "BlockchainTransaction"
 *   },
 *   tree_depth = -1,
 * )
 */
class SchemaArticleTimestamp extends SchemaNameBase {

}
