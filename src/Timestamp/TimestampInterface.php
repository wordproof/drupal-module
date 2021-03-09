<?php

namespace Drupal\wordproof\Timestamp;

interface TimestampInterface {
  public function getId();
  public function getTitle();
  public function getModified(): int;
  public function getUrl();
  public function getContent();
  public function getVid();
}
