<?php

namespace Drupal\wordproof\Plugin\wordproof\BlockchainBackend;

use Drupal\Component\Datetime\TimeInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Queue\QueueFactory;
use Drupal\wordproof\Plugin\BlockchainBackendInterface;
use Drupal\wordproof\Timestamp\TimestampInterface;
use Drupal\wordproof\WordProofApiClientInterface;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Defines an blockchain backend implementation for WordProof.
 *
 * @BlockchainBackend(
 *   id = "wordproof_api_backend_queued",
 *   title = @Translation("WordProof API Queued Blockchain backend"),
 *   description = @Translation("Blockchain backend for WordProof API create hashes on a blockchain. Uses the queued checks to call the API for blockchain info instead of a WebHook")
 * )
 */
class WordProofQueued implements ContainerFactoryPluginInterface, BlockchainBackendInterface {

  /**
   * @var \Drupal\wordproof\WordProofApiClientInterface
   */
  private $client;

  /**
   * @var \Drupal\Core\Queue\QueueFactory
   */
  private $queue;

  /**
   * @var \Drupal\Component\Datetime\TimeInterface
   */
  private $timeservice;

  /**
   * WordProofQueued constructor.
   *
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   *   Container.
   * @param array $configuration
   *   Config.
   * @param string $plugin_id
   *   Plugin id.
   * @param mixed $plugin_definition
   *   Definition.
   * @param \Drupal\wordproof\WordProofApiClientInterface $wordproofAPIClient
   *   API client.
   * @param \Drupal\Core\Queue\QueueFactory $queue
   *   Queue factory.
   *
   * @return void
   */
  public function __construct(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition, WordProofApiClientInterface $wordproofAPIClient, QueueFactory $queue, TimeInterface $timeservice) {
    $this->client = $wordproofAPIClient;
    $this->queue = $queue;
    $this->timeservice = $timeservice;
  }

  /**
   * Send the timestamp.
   *
   * @param \Drupal\wordproof\Timestamp\TimestampInterface $timestamp
   *   The timestamp data.
   *
   * @return \Drupal\wordproof\Timestamp\TimestampInterface
   *   Return the timestamp with the info from the API
   */
  public function send(TimestampInterface $timestamp): TimestampInterface {
    $response = $this->client->post($timestamp);

    if ($response->getStatusCode() >= 200 && $response->getStatusCode() <= 299) {
      $response = json_decode($response->getBody());
      $timestamp->setHashInput($response->hash_input);
      $timestamp->setHash($response->hash);
      $timestamp->setRemoteId($response->id);
      $timestamp->setCreated($this->timeservice->getCurrentTime());
      $this->queueBlockchainInfoCron($response);
    }

    return $timestamp;
  }

  /**
   * Create the plugin.
   *
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   *   Container.
   * @param array $configuration
   *   Config.
   * @param string $plugin_id
   *   Plugin id.
   * @param mixed $plugin_definition
   *   Definition.
   *
   * @return \Drupal\wordproof\Plugin\wordproof\BlockchainBackend\WordProofQueued|static
   *   The plugin instance
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $container,
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('wordproof.wordproof_api_client'),
      $container->get('queue'),
      $container->get('datetime.time')
    );
  }

  /**
   * Queue the blockchain info update check.
   *
   * @param \Psr\Http\Message\ResponseInterface $response
   *   The api response.
   */
  private function queueBlockchainInfoCron(ResponseInterface $response) {
    $queue = $this->queue->get('wordproof_blockchain_backend_wordproof_queue');
    $queue->createItem($response);
  }

}
