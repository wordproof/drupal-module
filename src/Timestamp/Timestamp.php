<?php


namespace Drupal\wordproof\Timestamp;


class Timestamp implements TimestampInterface {

  protected $date;

  protected $title;

  protected $id;

  protected $url;

  protected $hash = '';

  protected $content = '';

  protected $vid;

  protected $hash_input = '';

  public function getHash(): string {
    return $this->hash;
  }

  public function getContent() {
    return $this->content;
  }

  public function getModified(): int {
    return $this->date;
  }

  public function getUrl() {
    return $this->url;
  }

  public function getTitle() {
    return $this->title;
  }

  public function getId() {
    return $this->id;
  }

  public function setDate($date) {
    $this->date = $date;
  }

  public function setTitle($title) {
    $this->title = $title;
  }

  public function setId(int $id) {
    $this->id = $id;
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

  /**
   * @return mixed
   */
  public function getVid() {
    return $this->vid;
  }

  /**
   * @param mixed $vid
   */
  public function setVid($vid) {
    $this->vid = $vid;
  }

  /**
   * @return mixed
   */
  public function getHashInput() {
    return $this->hash_input;
  }

  /**
   * @param mixed $hash_input
   */
  public function setHashInput($hash_input) {
    $this->hash_input = $hash_input;
  }

}
