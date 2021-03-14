<?php

namespace Drupal\wordproof\Plugin\metatag\Group;

use Drupal\schema_metatag\Plugin\metatag\Group\SchemaGroupBase;

/**
 * Provides a plugin for the 'Blockchain' meta tag group.
 *
 * @MetatagGroup(
 *   id = "schema_blockchain",
 *   label = @Translation("Schema.org: Blockchain"),
 *   description = @Translation("See Schema.org definitions for this Schema type at <a href="":url"">:url</a>.", arguments = { ":url" = "https://schema.org/Blockchain"}),
 *   weight = 10,
 * )
 */
class SchemaBlockchain extends SchemaGroupBase {
  // Nothing here yet. Just a placeholder class for a plugin.
}
