<?php

namespace Drupal\wordproof\Plugin\wordproof\BlockchainBackend;

use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\wordproof\Plugin\BlockchainBackendInterface;
use Drupal\wordproof\Timestamp\TimestampInterface;
use Drupal\wordproof\WordProofApiClientInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Defines an blockchain backend implementation for WordProof.
 *
 * @BlockchainBackend(
 *   id = "wordproof_api_backend_webhook",
 *   title = @Translation("WordProof API Webhook Blockchain backend"),
 *   description = @Translation("Blockchain backend for WordProof API create hashes on a blockchain. Uses the queued checks to call the API for blockchain info instead of a WebHook")
 * )
 */
class WordProofWebhook implements ContainerFactoryPluginInterface, BlockchainBackendInterface {

  /**
   * @var \Drupal\wordproof\WordProofApiClientInterface
   */
  private $client;

  public function __construct(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition, WordProofApiClientInterface $wordproofAPIClient) {
    $this->client = $wordproofAPIClient;
  }

  public function send(TimestampInterface $timestamp): TimestampInterface {
    $response = $this->client->post($timestamp);

    if ($response->getStatusCode() >= 200 && $response->getStatusCode() <= 299) {
      $response = json_decode($response->getBody());
      $timestamp->setHashInput($response->hash_input);
      $timestamp->setHash($response->hash);
      $timestamp->setRemoteId($response->id);

      return $timestamp;
    }
  }

  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $container,
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('wordproof.wordproof_api_client')
    );
  }

}
