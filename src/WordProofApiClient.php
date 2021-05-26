<?php

namespace Drupal\wordproof;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\wordproof\Timestamp\TimestampInterface;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class WordProofApiClient implements WordProofApiClientInterface {

  /**
   * @var \GuzzleHttp\Client
   */
  private $client;

  /**
   * @var \Drupal\Core\Config\ImmutableConfig
   */
  private $config;

  /**
   * WordProofApiClient constructor.
   */
  public function __construct(Client $client, ConfigFactoryInterface $configFactory) {
    $this->client = $client;
    $this->config = $configFactory->get('wordproof.settings');
  }

  private function timestampRequestData(TimestampInterface $timestamp): array {
    $time = new \DateTime();
    $time->setTimestamp($timestamp->getModified());

    // @todo uid is unique id of referenced entity officially, but cannot do that since entities can live in different tables.
    return [
      'headers' => $this->headers(),
      'body' => json_encode([
        'uid' => (int) $timestamp->id(),
        'date_modified' => $time->format('c'),
        'meta_title' => $timestamp->getTitle(),
        'url' => $timestamp->getUrl(),
        'content' => $timestamp->getContent(),
      ]),
    ];
  }

  public function post(TimestampInterface $timestamp): ResponseInterface {
    $timestampRequestData = $this->timestampRequestData($timestamp);
    $uri = $this->config->get('blockchain_backend_url') . '/timestamps';
    return $this->client->post($uri, $timestampRequestData);
  }

  public function get(int $id): ResponseInterface {
    $uri = $this->config->get('blockchain_backend_url') . '/timestamps/' . $id;
    return $this->client->get($uri, ['headers' => $this->headers()]);
  }

  /**
   * @param \Drupal\wordproof\Timestamp\TimestampInterface[] $timestamps
   *
   * @return \Psr\Http\Message\ResponseInterface[]
   */
  public function bulk(array $timestamps): array {
    // @todo Send bulk timestamps, @see self::get() but slower responses
    $responses = [];
    foreach ($timestamps as $timestamp) {
      $timestampRequestData = $this->timestampRequestData($timestamp);
      $responses[] = $this->client->post($this->config->get('blockchain_backend_api') . '/timestamps/bulk', $timestampRequestData);
    }
    return $responses;
  }

  private function headers(): array {
    return [
      "Accept" => "application/json",
      "Content-Type" => "application/json",
      "Authorization" => "Bearer " . $this->config->get('blockchain_backend_key'),
    ];
  }

}
