<?php

namespace Drupal\wordproof\Plugin\metatag;

use Drupal\Core\Render\BubbleableMetadata;
use Drupal\schema_metatag\Plugin\metatag\Tag\SchemaNameBase;

class SchemaTimestampBase extends SchemaNameBase {

  public function output() {
    $output = parent::output();

    if ($output['#attributes']['content'] === '') {
      return '';
    }

    return $output;
  }


  public function outputValue($input_value) {
    $values = explode(':', $input_value);
    list($entity_type, $entity_id) = $values;
    /** @var \Drupal\wordproof\Timestamp\TimestampInterface $timestamp */
    $timestamp = \Drupal::service('wordproof.repository')->find($entity_type, $entity_id);

    if (is_null($timestamp)) {
      return '';
    }

    $jsonLd = $timestamp->toJsonLdArray();
    if (count($jsonLd) === 0) {
      return '';
    }

    return $jsonLd;
  }

}
