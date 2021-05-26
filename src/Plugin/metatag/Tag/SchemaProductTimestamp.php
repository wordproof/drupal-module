<?php

namespace Drupal\wordproof\Plugin\metatag\Tag;

use Drupal\wordproof\Plugin\metatag\SchemaTimestampBase;

/**
 * Provides a plugin for the 'schema_product_timestamp' meta tag.
 *
 * - 'id' should be a globally unique id.
 * - 'name' should match the Schema.org element name.
 * - 'group' should match the id of the group that defines the Schema.org type.
 *
 * @MetatagTag(
 *   id = "schema_product_timestamp",
 *   label = @Translation("timestamp"),
 *   description = @Translation("The timestamp of this product. Format: [entity-type:wordproof-timestamp]. For example: [commerce_product:wordproof-timestamp]"),
 *   name = "timestamp",
 *   group = "schema_product",
 *   provider = "schema_product",
 *   weight = 10,
 *   type = "string",
 *   secure = FALSE,
 *   multiple = FALSE,
 *   property_type = "text",
 * )
 */
class SchemaProductTimestamp extends SchemaTimestampBase {

}
