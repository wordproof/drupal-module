<?php

namespace Drupal\wordproof\Plugin\metatag\Tag;

use Drupal\schema_metatag\Plugin\metatag\Tag\SchemaNameBase;

/**
 * Provides a plugin for the 'schema_blockchain_transaction_hash' meta tag.
 *
 * - 'id' should be a globally unique id.
 * - 'name' should match the Schema.org element name.
 * - 'group' should match the id of the group that defines the Schema.org type.
 *
 * @MetatagTag(
 *   id = "schema_blockchain_transaction_hash",
 *   label = @Translation("hash"),
 *   description = @Translation("The hash of the timestamp."),
 *   name = "hash",
 *   group = "schema_blockchain_transaction",
 *   weight = 0,
 *   type = "string",
 *   secure = FALSE,
 *   multiple = FALSE,
 *   property_type = "text",
 *   tree_parent = {},
 *   tree_depth = -1,
 * )
 */
class SchemaBlockchainTransactionHash extends SchemaNameBase {

}
