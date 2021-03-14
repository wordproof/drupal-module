<?php

namespace Drupal\wordproof\Plugin\metatag\Tag;

use Drupal\schema_metatag\Plugin\metatag\Tag\SchemaNameBase;

/**
 * Provides a plugin for the 'schema_blockchain_transaction_hash_link' meta tag.
 *
 * - 'id' should be a globally unique id.
 * - 'name' should match the Schema.org element name.
 * - 'group' should match the id of the group that defines the Schema.org type.
 *
 * @MetatagTag(
 *   id = "schema_blockchain_transaction_hash_link",
 *   label = @Translation("url"),
 *   description = @Translation("Absolute URL of the HashInput."),
 *   name = "hashLink",
 *   group = "schema_blockchain_transaction",
 *   weight = 0,
 *   type = "string",
 *   secure = FALSE,
 *   multiple = TRUE,
 *   property_type = "url",
 *   tree_parent = {},
 *   tree_depth = -1,
 * )
 */
class SchemaBlockchainTransactionHashLink extends SchemaNameBase {

}
