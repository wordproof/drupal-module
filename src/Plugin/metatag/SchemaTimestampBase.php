<?php

namespace Drupal\wordproof\Plugin\metatag;

use Drupal\schema_metatag\Plugin\metatag\Tag\SchemaNameBase;

class SchemaTimestampBase extends SchemaNameBase {

  public function output() {
    $output =  parent::output();

    if($output['#attributes']['content'] === ''){
      return '';
    }

    return $output;
  }


  public function outputValue($input_value) {
    $timestamp = \Drupal::service('wordproof.repository')->getJson($input_value);
    return $timestamp;
  }

}
