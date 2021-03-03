<?php

namespace Drupal\wordproof\Timestamp;


final class ArticleTimestamp extends TimestampBase implements TimestampInterface {

  protected $version;
  protected $author;
  protected $previousVersion;

  protected $properties = [
    'type',
    'version',
    'title',
    'content',
    'date',
  ];

  protected $attributes = [
    'author',
    'previousVersion',
    'url',
  ];

  /**
   * @return mixed
   */
  public function getVersion() {
    return $this->version;
  }

  /**
   * @param mixed $version
   */
  public function setVersion($version) {
    $this->version = $version;
  }

  /**
   * @return mixed
   */
  public function getAuthor() {
    return $this->author;
  }

  /**
   * @param mixed $author
   */
  public function setAuthor($author) {
    $this->author = $author;
  }

  /**
   * @return mixed
   */
  public function getPreviousVersion() {
    return $this->previousVersion;
  }

  /**
   * @param mixed $previousVersion
   */
  public function setPreviousVersion($previousVersion) {
    $this->previousVersion = $previousVersion;
  }

}
