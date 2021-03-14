<?php

namespace Drupal\wordproof\Plugin\schema_metatag\PropertyType;

use Drupal\schema_metatag\Plugin\schema_metatag\PropertyTypeBase;

/**
 * Provides a plugin for the 'Review' Schema.org property type.
 *
 * @SchemaPropertyType(
 *   id = "blockchain",
 *   label = @Translation("Blockchain"),
 *   tree_parent = {
 *      "Blockchain",
 *   },
 *   tree_depth = 0,
 *   property_type = "Blockchain",
 *   sub_properties = {
 *     "@type" = {
 *       "id" = "type",
 *       "label" = @Translation("@type"),
 *       "description" = "",
 *     },
 *     "text" = {
 *       "id" = "text",
 *       "label" = @Translation("name"),
 *       "description" = @Translation("The name of the blockchain."),
 *     },
 *   },
 * )
 */
class Blockchain extends PropertyTypeBase {

}
