<?php


namespace Drupal\wordproof;


use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\wordproof\Timestamp\TimestampInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;

class WordProofAPIClient implements WordProofAPIClientInterface {

  /**
   * @var \GuzzleHttp\Client
   */
  private $client;

  /**
   * @var \Drupal\Core\Config\ImmutableConfig
   */
  private $config;

  /**
   * WordproofAPIClient constructor.
   */
  public function __construct(Client $client, ConfigFactoryInterface $configFactory) {
    $this->client = $client;
    $this->config = $configFactory->get('wordproof.settings');
  }

  private function timestampRequestData(TimestampInterface $timestamp): array {
    return [
      'headers' => $this->headers(),
      'body' => json_encode([
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
    $uri = $this->config->get('blockchain_backend_url') . '/timestamps';
    return $this->client->post($uri, $timestampRequestData);
  }

  public function get(TimestampInterface $timestamp){
    // @todo Send timestamp GET request
    // @todo Maybe eventually as extra backend? - This is only needed if you cannot receive Webhook
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
      $responses[] = $this->client->post($this->config->get('blockchain_backend_api') . '/timestamps/bulk', $timestampRequestData);
    }
    return $responses;
  }

  private function headers(): array {
    return [
      "Accept" => "application/json",
      "Content-Type" => "application/json",
      "Authentication" => "Bearer " . $this->config->get('blockchain_backend_key'),
    ];
  }

}
