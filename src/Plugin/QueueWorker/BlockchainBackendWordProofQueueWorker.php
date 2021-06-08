<?php

namespace Drupal\wordproof\Plugin\QueueWorker;

use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Queue\QueueWorkerBase;
use Drupal\wordproof\TimestampRepositoryInterface;
use Drupal\wordproof\WordProofApiClientInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Processes tasks for example module.
 *
 * @QueueWorker(
 *   id = "wordproof_blockchain_backend_wordproof_queue",
 *   title = @Translation("WordProof API queueworker"),
 *   cron = {"time" = 60}
 * )
 */
class BlockchainBackendWordProofQueueWorker extends QueueWorkerBase implements ContainerFactoryPluginInterface {

  /**
   * WordProof api client.
   *
   * @var \Drupal\wordproof\WordProofApiClientInterface
   */
  private $apiClient;

  /**
   * Timestamp repository.
   *
   * @var \Drupal\wordproof\TimestampRepositoryInterface
   */
  private $timestampRepository;

  /**
   * BlockchainBackendWordProofQueueWorker constructor.
   *
   * @param array $configuration
   *   Configuration.
   * @param string $plugin_id
   *   Plugin id.
   * @param mixed $plugin_definition
   *   Plugin definition.
   * @param \Drupal\wordproof\WordProofApiClientInterface $wordProofAPIClient
   *   API client.
   * @param \Drupal\wordproof\TimestampRepositoryInterface $timestampRepository
   *   Tiemstamp repository.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, WordProofApiClientInterface $wordProofAPIClient, TimestampRepositoryInterface $timestampRepository) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);

    $this->apiClient = $wordProofAPIClient;
    $this->timestampRepository = $timestampRepository;
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
   *   Plugin definition.
   *
   * @return \Drupal\wordproof\Plugin\QueueWorker\BlockchainBackendWordProofQueueWorker|static
   *   The queue worker.
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('wordproof.wordproof_api_client'),
      $container->get('wordproof.repository')
    );
  }

  /**
   * Process a queue item.
   *
   * @param mixed $data
   *   Data from the queue.
   *
   * @throws \Exception
   */
  public function processItem($data) {
    $response = $this->apiClient->get($data->id);
    $responseObject = json_decode($response->getBody());

    if (!isset($responseObject->transaction) && !isset($responseObject->transaction->transactionId)) {
      // @todo In Drupal 9.1 there is a DelayedRequeueException.
      throw new \Exception('Blockchain information not available yet.');
    }

    $this->timestampRepository->updateBlockchainInfo($responseObject->id, $responseObject->transaction->address, $responseObject->transaction->blockchain, $responseObject->transaction->transactionId, $responseObject->transaction->link);
  }

}
