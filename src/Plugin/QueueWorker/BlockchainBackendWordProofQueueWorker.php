<?php

namespace Drupal\wordproof_timestamp\Plugin\QueueWorker;

use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Queue\DelayedRequeueException;
use Drupal\Core\Queue\QueueWorkerBase;
use Drupal\Core\Queue\RequeueException;
use Drupal\wordproof_timestamp\TimestampRepositoryInterface;
use Drupal\wordproof_timestamp\WordProofAPIClientInterface;
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
   * @var \Drupal\wordproof_timestamp\WordProofAPIClientInterface
   */
  private $apiClient;

  const API_CHECK_DELAY = 60;

  /**
   * @var \Drupal\wordproof_timestamp\TimestampRepositoryInterface
   */
  private $timestampRepository;

  public function __construct(array $configuration, $plugin_id, $plugin_definition, WordProofAPIClientInterface $wordProofAPIClient, TimestampRepositoryInterface $timestampRepository) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);

    $this->apiClient = $wordProofAPIClient;
    $this->timestampRepository = $timestampRepository;
  }


  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('wordproof_timestamp.wordproof_api_client'),
      $container->get('wordproof_timestamp.repository')
    );
  }

  public function processItem($data) {
    \Drupal::logger('wordproof_timestamp')->debug('Queue worker starting.... :D');

    $response = $this->apiClient->get($data->id);
    \Drupal::logger('wordproof_timestamp')->debug('Queue response: ' . $response->getBody());

    $responseObject = json_decode($response->getBody());

    if (!isset($responseObject->transaction) && !isset($responseObject->transaction->transactionId)) {
      // @todo In Drupal 9.1 there is a DelayedRequeueException.
      throw new \Exception('Blockchain information not available yet.');
    }

    $this->timestampRepository->updateBlockchainInfo($responseObject->id, $responseObject->transaction->address, $responseObject->transaction->blockchain, $responseObject->transaction->transactionId, $responseObject->transaction->link);
  }

}
