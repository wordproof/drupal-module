# Todo

* Tests
* Configuration form for timestamp type vs node bundle.
* Module configuration settings
  * backend
  * api information
* Timestamp storage to store metadata for node/revision and hashinput?
    * hook_schema() - https://bitbucket.org/swisnl/fitpost/src/98f97d7bca2738b5ba25a711d77d8744426999ce/app/modules/custom/pm/custom_pm.install#custom_pm.install-2
* WebHook endpoint for receiving blockchain information.
* EntityTypeSubscriber is probably not needed.
* Build something to render on the frontend on the relevant nodes.
* Create a view display `wordproof` that can be enabled to define what content is rendered and hashed
* Add the node data to the output of the stampers
* Add other timestamp types.
* Validate Timestamp data to make sure it contains the needed information
* Possibly implement something like EntityReferenceSelection where you can set the valid entity types for a plugin. This makes installing a specific plugin for other modules easier.
