<?php

namespace Drupal\wordproof_timestamp\Plugin\metatag\Tag;

use Drupal\wordproof_timestamp\Plugin\metatag\SchemaTimestampBase;

/**
 * Provides a plugin for the 'schema_event_timestamp' meta tag.
 *
 * - 'id' should be a globally unique id.
 * - 'name' should match the Schema.org element name.
 * - 'group' should match the id of the group that defines the Schema.org type.
 *
 * @MetatagTag(
 *   id = "schema_event_timestamp",
 *   label = @Translation("timestamp"),
 *   description = @Translation("The timestamp of this event. Format: [entity-type:wordproof-timestamp]. For example: [event:wordproof-timestamp]"),
 *   name = "timestamp",
 *   group = "schema_event",
 *   provider = "schema_event",
 *   weight = 10,
 *   type = "string",
 *   secure = FALSE,
 *   multiple = FALSE,
 *   property_type = "text",
 * )
 */
class SchemaEventTimestamp extends SchemaTimestampBase {

}
