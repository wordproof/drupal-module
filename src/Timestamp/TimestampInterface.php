<?php

namespace Drupal\wordproof\Timestamp;

interface TimestampInterface {
  public function getUid();
  public function getType();
  public function getTitle();
  public function getModified();
  public function getUrl();
  public function getContent();
}
