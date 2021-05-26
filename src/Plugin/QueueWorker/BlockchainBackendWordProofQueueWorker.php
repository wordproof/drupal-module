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
   * @var \Drupal\wordproof\WordProofApiClientInterface
   */
  private $apiClient;

  const API_CHECK_DELAY = 60;

  /**
   * @var \Drupal\wordproof\TimestampRepositoryInterface
   */
  private $timestampRepository;

  public function __construct(array $configuration, $plugin_id, $plugin_definition, WordProofApiClientInterface $wordProofAPIClient, TimestampRepositoryInterface $timestampRepository) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);

    $this->apiClient = $wordProofAPIClient;
    $this->timestampRepository = $timestampRepository;
  }

  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('wordproof.wordproof_api_client'),
      $container->get('wordproof.repository')
    );
  }

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
