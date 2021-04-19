<?php

namespace Drupal\wordproof_timestamp\Plugin\metatag\Tag;

use Drupal\wordproof_timestamp\Plugin\metatag\SchemaTimestampBase;

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
 *   description = @Translation("The timestamp of this article. Format: [entity-type:wordproof-timestamp]. For example: [node:wordproof-timestamp]"),
 *   name = "timestamp",
 *   group = "schema_article",
 *   provider = "schema_article",
 *   weight = 10,
 *   type = "string",
 *   secure = FALSE,
 *   multiple = FALSE,
 *   property_type = "text",
 * )
 */
class SchemaArticleTimestamp extends SchemaTimestampBase {

}
