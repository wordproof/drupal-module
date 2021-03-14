<?php

namespace Drupal\wordproof\Plugin\schema_metatag\PropertyType;

use Drupal\schema_metatag\Plugin\schema_metatag\PropertyTypeBase;

/**
 * Provides a plugin for the 'Review' Schema.org property type.
 *
 * @SchemaPropertyType(
 *   id = "blockchain_transaction",
 *   label = @Translation("BlockchainTransaction"),
 *   tree_parent = {
 *     "BlockchainTransaction"
 *   },
 *   tree_depth = 0,
 *   property_type = "BlockchainTransaction",
 *   sub_properties = {
 *     "@type" = {
 *       "id" = "type",
 *       "label" = @Translation("@type"),
 *       "description" = "",
 *     },
 *     "identifier" = {
 *       "id" = "text",
 *       "label" = @Translation("identifier"),
 *       "description" = @Translation("The identifierof the transaction."),
 *     },
 *     "hash" = {
 *       "id" = "text",
 *       "label" = @Translation("hash"),
 *       "description" = @Translation("The hash of the content at the moment of recording."),
 *     },
 *     "hashLink" = {
 *       "id" = "url",
 *       "label" = @Translation("hashLink"),
 *       "description" = @Translation("The link to the HashInput representing the data that was recorded."), *
 *     },
 *     "recordedIn" = {
 *       "id" = "blockchain",
 *       "label" = @Translation("recordedIn"),
 *       "description" = @Translation("The reference to the blockchain that recorded the content."),
 *       "tree_parent" = {
 *         "Blockchain",
 *       },
 *       "tree_depth" = 0,
 *     },
 *   },
 * )
 */
class BlockchainTransaction extends PropertyTypeBase {

}
