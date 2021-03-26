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
   * WordProofAPIClient constructor.
   */
  public function __construct(Client $client, ConfigFactoryInterface $configFactory) {
    $this->client = $client;
    $this->config = $configFactory->get('wordproof.settings');
  }

  private function timestampRequestData(TimestampInterface $timestamp): array {
    $time = new \DateTime();
    $time->setTimestamp($timestamp->getModified());

    return [
      'headers' => $this->headers(),
      'body' => json_encode([
        'uid' => $timestamp->getId(),
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
    return $this->client->get($uri);
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
      "Authorization" => "Bearer " . $this->config->get('blockchain_backend_key'),
    ];
  }

}
