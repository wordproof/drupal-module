<?php

use Drupal\Core\Queue\QueueWorkerBase;
use Drupal\Core\Queue\RequeueException;
use Drupal\wordproof\TimestampRepositoryInterface;
use Drupal\wordproof\WordProofAPIClientInterface;

/**
 * Processes tasks for example module.
 *
 * @QueueWorker(
 *   id = "wordproof_blockchain_backend_wordproof_queue",
 *   title = @Translation("Wordproof API queueworker"),
 *   cron = {"time" = 90}
 * )
 */
class BlockchainBackendWordproofQueueWorker extends QueueWorkerBase {

  /**
   * @var \Drupal\wordproof\WordProofAPIClientInterface
   */
  private $apiClient;

  /**
   * @var \Drupal\wordproof\TimestampRepositoryInterface
   */
  private $timestampRepository;

  public function __construct(array $configuration, $plugin_id, $plugin_definition, WordProofAPIClientInterface $wordProofAPIClient, TimestampRepositoryInterface $timestampRepository) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);

    $this->apiClient = $wordProofAPIClient;
    $this->timestampRepository = $timestampRepository;
  }


  public function processItem($data) {
    $response = $this->apiClient->get($data->id);
    \Drupal::logger('wordproof')->debug('Queue response: ' . $response->getBody());

    $responseObject = json_decode($response->getBody()->getContents());
    if (!isset($responseObject->transaction) && !isset($responseObject->trnasaction->transactionId)) {
      throw new RequeueException('Blockchain information not available yet.');
    }

    $this->timestampRepository->updateBlockchainInfo($responseObject->hash, $responseObject->transaction->blockchain, $responseObject->transaction->transactionId, $responseObject->transaction->link);
  }

}
