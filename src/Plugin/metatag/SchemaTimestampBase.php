<?php

namespace Drupal\wordproof\Plugin\metatag;

use Drupal\schema_metatag\Plugin\metatag\Tag\SchemaNameBase;

/**
 * Base for timestamp schemas.
 */
class SchemaTimestampBase extends SchemaNameBase {

  /**
   * Output the schema.
   *
   * @return string
   *   Return the content
   */
  public function output() {
    $output = parent::output();

    if (isset($output['#attributes']['content']) && $output['#attributes']['content'] === '') {
      return '';
    }

    return $output;
  }

  /**
   * Input for the schema.
   *
   * @param string $input_value
   *   Value that is input.
   *
   * @return mixed|string
   *   JSON JD data
   */
  public function outputValue($input_value) {
    $jsonLd = json_decode($input_value, TRUE);

    if (!is_null($jsonLd)) {
      return $jsonLd;
    }

    return '';
  }

}
