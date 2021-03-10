<?php


namespace Drupal\wordproof\Plugin\wordproof\BlockchainBackend;

use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\wordproof\Annotation\BlockchainBackend;
use Drupal\wordproof\Plugin\BlockchainBackendInterface;
use Drupal\wordproof\Timestamp\TimestampInterface;
use Drupal\wordproof\WordProofAPIClientInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Defines an blockchain backend implementation for Wordproof
 *
 * @BlockchainBackend(
 *   id = "wordproof_api_backend_queued",
 *   title = @Translation("Blockchain backend for Wordproof API"),
 *   description = @Translation("Blockchain backend for Wordproof API create hashes on a blockchain. Uses the queued checks to call the API for blockchain info instead of a WebHook")
 * )
 */
class WordproofQueued implements ContainerFactoryPluginInterface, BlockchainBackendInterface {

  /**
   * @var \Drupal\wordproof\WordProofAPIClientInterface
   */
  private $client;

  public function __construct(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition, WordProofAPIClientInterface $wordproofAPIClient) {
    $this->client = $wordproofAPIClient;
  }

  public function send(TimestampInterface $timestamp): TimestampInterface {
    $response = $this->client->post($timestamp);

    if ($response->getStatusCode() >= 200 && $response->getStatusCode() <= 299) {
      $response = json_decode($response->getBody());
      $timestamp->setHashInput($response->hash_input);
      $timestamp->setHash($response->hash);

      $this->queueBlockchainInfoCron($response);

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

  private function queueBlockchainInfoCron($response) {
    $queue = \Drupal::queue('wordproof_blockchain_backend_wordproof_queue');
    $queue->createItem($response);
  }

}
