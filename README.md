# WordProof timestamp

This module aims at buildind the truster web. It enabled sites to timestamp content and expose that timestamp through JSON-LD. For more information on the trusted web visit [thetrustedweb.org](https://thetrustedweb.org/).

## Usage

Install using composer and enable the module. Currently only [wordproof.com](https://wordproof.com/) is supported for creating the timestamps. Register for an account there.

Go to `/admin/config/wordproof/settings` and setup your API key and endpoint. You can configure what content you'd like to timestamp.

Configure the JSON-LD data in the MetaTag module (`admin/config/search/metatag`) and make sure you fill the `timestamp` field.

After saving your entity the timestamp request will be submitten. The next cron run the blockchain information required is retrieved and the timestamp will be added to the page.

To show the certificate on the page enable the `Wordproof timestamp certificate` block on the relevant entities or pages.
