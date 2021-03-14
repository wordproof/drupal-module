<?php

namespace Drupal\wordproof\Plugin\metatag\Tag;

use Drupal\schema_metatag\Plugin\metatag\Tag\SchemaNameBase;

/**
 * Provides a plugin for the 'schema_blockchain_transaction_recorded_in' meta tag.
 *
 * - 'id' should be a globally unique id.
 * - 'name' should match the Schema.org element name.
 * - 'group' should match the id of the group that defines the Schema.org type.
 *
 * @MetatagTag(
 *   id = "schema_blockchain_transaction_recorded_in",
 *   label = @Translation("recordedIn"),
 *   description = @Translation("Recorded in."),
 *   name = "recodedIn",
 *   group = "schema_blockchain_transaction",
 *   weight = 11,
 *   type = "recordedIn",
 *   secure = FALSE,
 *   multiple = TRUE,
 *   property_type = "blockchain",
 *   tree_parent = {
 *     "Blockchain",
 *   },
 *   tree_depth = 0,
 * )
 */
class SchemaBlockchainTransactionRecordedIn extends SchemaNameBase {

}
