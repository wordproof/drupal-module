<?php

namespace Drupal\wordproof\Plugin\metatag\Group;

use Drupal\schema_metatag\Plugin\metatag\Group\SchemaGroupBase;

/**
 * Provides a plugin for the 'BlockchainTransaction' meta tag group.
 *
 * @MetatagGroup(
 *   id = "schema_blockchain_transaction",
 *   label = @Translation("Schema.org: BlockchainTransaction"),
 *   description = @Translation("See Schema.org definitions for this Schema type at <a href="":url"">:url</a>.", arguments = { ":url" = "https://schema.org/BlockchainTransaction"}),
 *   weight = 10,
 * )
 */
class SchemaBlockchainTransaction extends SchemaGroupBase {
  // Nothing here yet. Just a placeholder class for a plugin.
}
