<?php
namespace Drupal\wordproof\Entity;

/**
 * Defines the WordProof Config entity.
 *
 * @ConfigEntityType(
 *   id = "woordproof_timestamp_config",
 *   label = @Translation("WordProof field configuration"),
 *   label_collection = @Translation("WordProof field configurations"),
 *   label_singular = @Translation("WordProof field configuration"),
 *   label_plural = @Translation("WordProof field configurations"),
 *   label_count = @PluralTranslation(
 *     singular = "@count WordProof field configuration",
 *     plural = "@count WordProof field configurations",
 *   ),
 *   handlers = {
 *     "list_builder" = "Drupal\wordproof\TimestampConfigListBuilder",
 *     "form" = {
 *       "add" = "Drupal\wordproof\Form\WebTimestampConfigForm",
 *       "edit" = "Drupal\wordproof\Form\WebTimestampConfigForm",
 *       "delete" = "Drupal\wordproof\Form\WebTimestampConfigDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider"
 *     },
 *   },
 *   config_prefix = "woordproof_timestamp_config",
 *   admin_permission = "administer site configuration",
 *   static_cache = TRUE,
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   config_export = {
 *     "id",
 *     "enabled",
 *     "path",
 *     "resourceType",
 *     "resourceFields",
 *   },
 *   links = {
 *     "add-form" = "/admin/config/services/woordproof_timestamp/add/resource_types/{entity_type_id}/{bundle}",
 *     "edit-form" = "/admin/config/services/woordproof_timestamp/resource_types/{jsonapi_resource_config}/edit",
 *     "delete-form" = "/admin/config/services/woordproof_timestamp/resource_types/{jsonapi_resource_config}/delete",
 *     "collection" = "/admin/config/services/woordproof_timestamp/resource_types"
 *   }
 * )
 */
class WordProofTimestampConfig {

}
