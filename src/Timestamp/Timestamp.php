<?php


namespace Drupal\wordproof\Timestamp;


class Timestamp implements TimestampInterface {

  protected $date;

  protected $title;

  protected $uuid;

  protected $url;

  protected $hash;

  protected $content;

  public function getHash(): string {
    return $this->hash;
  }

  public function getContent() {
    return $this->content;
  }

  public function getModified() {
    return $this->date;
  }

  public function getUrl() {
    return $this->url;
  }

  public function getTitle() {
    return $this->title;
  }

  public function getUid() {
    return $this->uuid;
  }

  public function setDate($date) {
    $this->date = $date;
  }

  public function setTitle($title) {
    $this->title = $title;
  }

  public function setUuid($uuid) {
    $this->uuid = $uuid;
  }

  public function setUrl($url) {
    $this->url = $url;
  }

  public function setHash($hash) {
    $this->hash = $hash;
  }

  public function setContent($content) {
    $this->content = $content;
  }
}
