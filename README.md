## WordProof: Timestamp your content on the blockchain

With WordProof, you can timestamp your content on any EOSIO blockchain from the comfort of your site. No prior blockchain experience necessary. After the set-up, everything is taken care of automatically!

## Why do i need to timestamp my content?

WordProof does everything in its power to bring the benefits of blockchain to your content. Here are some reasons why you should timestamp your content:

*   Copyright protection
*   Transparency: increase trust and claim authenticity
*   Next-generation SEO benefits
*   Proof of existence at certain moments in time
*   Prepare for upcoming EU regulations
*   Be your own notary

## Features

*   Automatically timestamp your content on the blockchain
*   Show the blockchain certificate pop-up on your website
*   Let your visitors verify when and how your content changed
*   Downloadable blockchain certificate as proof of existence

## How does it work?

Timestamping creates a unique and universal fingerprint (the ‘hash’) for all your posts, pages and media files. If the input changes, the hash becomes totally different.

This hash is added to the blockchain with a date and time. Because you (the website owner) have the input that results in this specific hash, you can prove that you published the content at that point in time.

## Read more

*   [YouTube explaination on timestamps](https://youtu.be/Jh7ufPyRIZY)
*   [Building the trusted Web together](https://thetrustedweb.org/)
*   [WordProof.com](https://wordproof.com/)

## Getting started

**under contruction**

1.  Install and enable the module.
2.  Sign up for an free account on WordProof.com
3.  Configure your API information
4.  Configure the `schema_metatag` module. Most importantly add the timestamp token. (for example for nodes: `node<span class="token punctuation">:</span>wordproof<span class="token operator">-</span>timestamp`).
5.  Enable timestamping for the proper entity type in the WordProof configuration.
6.  Place the `wordproof certificate block` on the proper pages. This displays the certificate though a webcomponent.
7.  Optional: Configure the `wordproof_content` viewmode. The module uses this view to generate a rendered representation of the content.

Thats all, after saving content the module queues a job to fetch the blockchain data from the WordProof API.

## Extending

The module uses plugins for stamping content and publishing on a blockchain.

`Plugin\<span class="token package">StamperInterface</span>`

Stampers receive a `ContentEntity` and create a `wordproof timestamp` entity. If you have custom conent entities where you need a different way to consolidate the content.

`Plugin\BlockchainBackendInterface`

This plugin sends the timestamp to the chosen backend for publication on a blockchain. The current module only supports WordProof as a backend, but this could be any API that published to a blockchain. The backend should enrich the timestamp entity with the proper blockchain information.

Supporting organizations:
[SWIS](https://swis.nl) - Development and maintenance
[WordProof](https://wordproof.com) - Development support
