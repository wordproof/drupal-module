# Todo

* Should references in the Timestamp entity be true entity_reference fields?
* Node type configuration: form for timestamp type vs node bundle.
* WebHook endpoint: Receiving blockchain information.
* Nested backend Settings: form nested for backend (in config form, use #state and get form from the backend. See jsonapi)
* Render WordProof elements with the element by WordProof
  * See https://developers.wordproof.com/schema/#adding-a-timestamp
  * Block
    * Possibly block condition based on the fact there is a timestamp available.
    * Add js library for external module.
    * Theme (see [prelum-multisite:cusom_elearning/user](https://bitbucket.org/swisnl/prelum-multisite/src/3a0ab73cb24eb17777150f7b7cd054feb639f887/app/modules/custom/elearning/modules/user/src/Controller/UserController.php#UserController.php-17)) for rendering the element.
    * Eventually we will need a differently rendered element that is local to the installation.
* Possibly implement something like EntityReferenceSelection where you can set the valid entity types for a plugin. This makes installing a specific plugin for other modules easier.
* Timestamp updates: Challenge is to know when a entity is updated, since it can contain referenced entities it should also make sure it updates when references are updated. Possible solution:
  * Loop through all entity-type/entity-bundle where WordProof is activated.
  * Loop through the fields in the view mode (or default) and collect all reference fields.
  * Collect all possible types/bundles it can reference.
  * Save the references (referenced entity -> parent type->bundle and cache that result.
  * Use entity update hook to also check for existence in the array.
* Tests? ;)

* Be explicit about ContentEntities only.
* Chainable setters yay.
* Repository getters the entity not the ID.
* Move getJson to model since its a representation of itself.
* Fix cache tags for Timestamp
* id and type for schema_metatag field
* Maybe cachebablebububle ding @ outputValue


## Done
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


# HashInput?
* For now we do not generate the hashinput locally.

# Done
