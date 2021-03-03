<?php

namespace Drupal\wordproof\Timestamp;


final class WebPageTimestamp extends TimestampBase implements TimestampInterface {

  protected $version;
  protected $name;
  protected $previousVersion;

  protected $properties = [
    'type',
    'version',
    'name',
    'date',
  ];

  protected $attributes = [
    'previousVersion',
    'url',
    'content', // This is not in the timestamp standard field but is in the text?
  ];

  public function getVersion() {
    return $this->version;
  }

  public function setVersion($version) {
    $this->version = $version;
  }

  public function getName() {
    return $this->name;
  }

  public function setName($name) {
    $this->name = $name;
  }

  public function getPreviousVersion() {
    return $this->previousVersion;
  }

  public function setPreviousVersion($previousVersion) {
    $this->previousVersion = $previousVersion;
  }

}
