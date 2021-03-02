<?php

namespace Drupal\wordproof\Timestamp;


final class WebPageTimestamp implements TimestampInterface {
  private $properties = [
    'type',
    'version',
    'name',
    'date',
  ];

  private $attributes = [
    'previousVersion',
    'url',
  ];
}
