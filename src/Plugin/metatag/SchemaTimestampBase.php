<?php

namespace Drupal\wordproof\Plugin\metatag;

use Drupal\schema_metatag\Plugin\metatag\Tag\SchemaNameBase;

class SchemaTimestampBase extends SchemaNameBase {

  public function outputValue($input_value) {
    return [
      "@type" => "BlockchainTransaction",
      "identifier" => "bb93587586f089f83526eb90f93f3951c11b328bf81c492e18ba162a84cea1b0",
      "hash" => "0d869841dccdabf8b25a727412023b3159c23c585e298b23317a0d05ad4164fa",
      "hashLink" => "https =>//www.nrc.nl/api/wordproof/hashinput?id=4339608",
      "recordedIn" => [
        "@type" => "Blockchain",
        "name" => "eosio_main"
      ]
    ];
  }

}
