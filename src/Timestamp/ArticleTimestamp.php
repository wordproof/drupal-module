<?php

namespace Drupal\wordproof\Timestamp;


final class ArticleTimestamp implements TimestampInterface {
  private $properties = [
    'type',
    'version',
    'title',
    'content',
    'date',
  ];

  private $attributes = [
    'author',
    'previousVersion',
    'url',
  ];
}
