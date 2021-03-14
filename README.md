# Todo

* Node type configuration: form for timestamp type vs node bundle.
* WebHook endpoint: Receiving blockchain information.
* Nested backend Settings: form nested for backend (in config form, use #state and get form from the backend. See jsonapi)
* Render JSON-LD
* Render WordProof elements with the element by WordProof
* Validate Timestamp data to make sure it contains the needed information?
* Possibly implement something like EntityReferenceSelection where you can set the valid entity types for a plugin. This makes installing a specific plugin for other modules easier.
* Timestamp updates: Challenge is to know when a entity is updated, since it can contain referenced entities it should also make sure it updates when references are updated. Possible solution:
  * Loop through all entity-type/entity-bundle where WordProof is activated.
  * Loop through the fields in the view mode (or default) and collect all reference fields.
  * Collect all possible types/bundles it can reference.
  * Save the references (referenced entity -> parent type->bundle and cache that result.
  * Use entity update hook to also check for existence in the array.
* Tests? ;)

* Create "timestamp" type for schema_metatag
  * First implementation is a full list of fields. Conclusion:
     * Until schema.org schema is defined:
        Create `SchemaXxxxxTimestamp.php` with a simple type (like text). Hint at the proper token ([node:wordproof-timestamp] or [entity:wordproof-timestamp]) and render the required json in the token hook based on the stored entity (remember cache tags ;)). This should be the most low tech solution for now.
```json
{
  "timestamp": {
    "@type": "BlockchainTransaction",
    "identifier": "bb93587586f089f83526eb90f93f3951c11b328bf81c492e18ba162a84cea1b0",
    "hash": "0d869841dccdabf8b25a727412023b3159c23c585e298b23317a0d05ad4164fa",
    "hashLink": "https://www.nrc.nl/api/wordproof/hashinput?id=4339608",
    "recordedIn": {
      "@type": "Blockchain",
      "name": "eosio_main"
    }
  }
}
```



* Wordproof -> WordProof

## Done
* Create and use view display `wordproof`: Can be enabled to define what content is rendered and hashed. Fallback to default.
* Data in Stampers: Add the node data to the output of the stampers.


# HashInput?
* Wel of niet genereren om HashInput misschien nu even niet.
*


# Done

* Timestamp storage: Store metadata for node/revision and hashinput?
  * hook_schema() - https://bitbucket.org/swisnl/fitpost/src/98f97d7bca2738b5ba25a711d77d8744426999ce/app/modules/custom/pm/custom_pm.install#custom_pm.install-2
