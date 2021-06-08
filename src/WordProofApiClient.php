<?php

namespace Drupal\wordproof;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\wordproof\Timestamp\TimestampInterface;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

/**
 * Client for the WordProof API.
 */
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

  /**
   * Builds the data needed for the API request.
   *
   * @param \Drupal\wordproof\Timestamp\TimestampInterface $timestamp
   *   The timestamp that needs stamping.
   *
   * @return array
   *   Array with the data that is expected by the API
   */
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

  /**
   * Post the timestamp to the API to save on the blockchain.
   *
   * @inheritdoc
   */
  public function post(TimestampInterface $timestamp): ResponseInterface {
    $timestampRequestData = $this->timestampRequestData($timestamp);
    $uri = $this->config->get('blockchain_backend_url') . '/timestamps';
    return $this->client->post($uri, $timestampRequestData);
  }

  /**
   * Get the status of an stamp request.
   *
   * @inheritdoc
   */
  public function get(int $id): ResponseInterface {
    $uri = $this->config->get('blockchain_backend_url') . '/timestamps/' . $id;
    return $this->client->get($uri, ['headers' => $this->headers()]);
  }

  /**
   * Send by bulk, slower but no rate limiting.
   *
   * @inheritdoc
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

  /**
   * Build the proper headers for the request.
   *
   * @return string[]
   *   The request headers for the API
   */
  private function headers(): array {
    return [
      "Accept" => "application/json",
      "Content-Type" => "application/json",
      "Authorization" => "Bearer " . $this->config->get('blockchain_backend_key'),
    ];
  }

}
