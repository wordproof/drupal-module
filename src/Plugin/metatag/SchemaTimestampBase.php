<?php

namespace Drupal\wordproof_timestamp\Plugin\metatag;

use Drupal\schema_metatag\Plugin\metatag\Tag\SchemaNameBase;

class SchemaTimestampBase extends SchemaNameBase {

  public function output() {
    $output = parent::output();

    if (isset($output['#attributes']['content']) && $output['#attributes']['content'] === '') {
      return '';
    }

    return $output;
  }

  public function outputValue($input_value) {
    $jsonLd = json_decode($input_value, TRUE);

    if (!is_null($jsonLd)) {
      return $jsonLd;
    }

    return '';
  }

}
