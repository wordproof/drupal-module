# Tasks

# Todo

* Allow choosing of version for WordProof certificate component
* WebHook endpoint: Receiving blockchain information.
* Nested backend Settings: form nested for backend (in config form, use #state and get form from the backend. See jsonapi)
* Possibly implement something like EntityReferenceSelection where you can set the valid entity types for a plugin. This makes installing a specific plugin for other modules easier.
* Create config for core.entity_view_mode.[ENTITY].wordproof_content.yml when timestamping is enabled.
  * See https://api.drupal.org/api/drupal/core!includes!entity.inc/function/entity_get_display/8.2.x for creating it in code.
* Tests? ;)
* Be explicit about ContentEntities only.
* Timestamp updates: optimize stamping through referenced entities
  * Cache?
  * Optimize which entities should be in the watchlist
* Use cache for invalidation/check if timestamp is needed? How do we check if a new timestamp is needed when a referenced entity is updatet. Perhaps local hashing? Perhaps using cache tags of the content (which would also invalidate on config changes).
* Make HashInputController a CacheableJsonReponse

## Done
* Timestamp updates: Challenge is to know when a entity is updated, since it can contain referenced entities it should also make sure it updates when references are updated. Possible solution:
  * Loop through all entity-type/entity-bundle where WordProof is activated.
  * Loop through the fields in the view mode (or default) and collect all reference fields.
  * Collect all possible types/bundles it can reference.
  * Save the references (referenced entity -> parent type->bundle and cache that result.
  * Use entity update hook to also check for existence in the array.

* Maybe make output value from the timestamp metatag field better cachable?
* Node type configuration: form for timestamp type vs node bundle.
* Move getJson to model since it's a representation of itself.
* id and type for schema_metatag field
* Fix cache tags for Timestamp (at least i think done)
* Repository getters the entity not the ID.
* Chainable setters yay.
* Should references in the Timestamp entity be true entity_reference fields? No.
* Wordproof -> WordProof
* Create and use view display `wordproof`: Can be enabled to define what content is rendered and hashed. Fallback to default.
* Data in Stampers: Add the node data to the output of the stampers.
* Render JSON-LD
* Create "timestamp" type for schema_metatag
  * First implementation is a full list of fields. Conclusion is that until the definition is final i implement is as a custom property.
* Timestamp storage: Store metadata for node/revision and hashinput
  * hook_schema() implementation done
  * Update: now using a custom entity as it should.
* Validate Timestamp data to make sure it contains the needed information?
* Render WordProof elements with the element by WordProof
  * See https://developers.wordproof.com/schema/#adding-a-timestamp
  * Block
    * Possibly block condition based on the fact there is a timestamp available.
    * Add js library for external module.
    * Theme (see [prelum-multisite:cusom_elearning/user](https://bitbucket.org/swisnl/prelum-multisite/src/3a0ab73cb24eb17777150f7b7cd054feb639f887/app/modules/custom/elearning/modules/user/src/Controller/UserController.php#UserController.php-17)) for rendering the element.
    * Eventually we will need a differently rendered element that is local to the installation.

# HashInput?
* For now we do not generate the HashInput locally, until we support custom blockchains.
