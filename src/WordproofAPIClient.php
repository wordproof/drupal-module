<?php


namespace Drupal\wordproof;


use Drupal\wordproof\Timestamp\TimestampInterface;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;

class WordproofAPIClient implements WordproofAPIClientInterface {

  const API_URL = 'https://api.wordproof.com';

  /**
   * WordproofAPIClient constructor.
   */
  public function __construct() {
    // @todo Load configuration/settings. Load HttpClient
  }

  private function timestampRequestData(TimestampInterface $timestamp): array {
    return [
      'headers' => $this->headers(),
      'body' => http_build_query([
        'uid' => $timestamp->getUid(),
        'date_modified' => $timestamp->getModified(),
        'title' => $timestamp->getTitle(),
        'url' => $timestamp->getUrl(),
        'content' => $timestamp->getContent(),
      ]),
    ];
  }

  public function post(TimestampInterface $timestamp): ResponseInterface {
    $timestampRequestData = $this->timestampRequestData($timestamp);
    return \Drupal::httpClient()->post(self::API_URL . '/timestamps', $timestampRequestData);
  }

  public function get(TimestampInterface $timestamp){
    // @todo Send timestamp GET request
  }

  /**
   * @param TimestampInterface[] $timestamps
   *
   * @return ResponseInterface[]
   */
  public function bulk(array $timestamps): array {
    // @todo Send bulk timestamps, @see self::get() but slower responses
    $responses = [];
    foreach($timestamps as $timestamp){
      $timestampRequestData = $this->timestampRequestData($timestamp);
      $responses[] = \Drupal::httpClient()->post(self::API_URL . '/timestamps/bulk', $timestampRequestData);
    }
    return $responses;
  }

  private function headers(): array {
    return [
      "Accept" => "application/json",
      "Content-Type" => "application/json",
      "Authentication" => "Bearer {token}",
    ];
  }

}
