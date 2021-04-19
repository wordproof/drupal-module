<?php

namespace Drupal\wordproof_timestamp\Plugin\metatag\Tag;

use Drupal\wordproof_timestamp\Plugin\metatag\SchemaTimestampBase;

/**
 * Provides a plugin for the 'schema_how_to_timestamp' meta tag.
 *
 * - 'id' should be a globally unique id.
 * - 'name' should match the Schema.org element name.
 * - 'group' should match the id of the group that defines the Schema.org type.
 *
 * @MetatagTag(
 *   id = "schema_how_to_timestamp",
 *   label = @Translation("timestamp"),
 *   description = @Translation("The timestamp of this how_to. Format: [entity-type:wordproof-timestamp]. For example: [howto:wordproof-timestamp]"),
 *   name = "timestamp",
 *   group = "schema_how_to",
 *   provider = "schema_how_to",
 *   weight = 10,
 *   type = "string",
 *   secure = FALSE,
 *   multiple = FALSE,
 *   property_type = "text",
 * )
 */
class SchemaHowToTimestamp extends SchemaTimestampBase {

}
