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
 *   id = "test_backend",
 *   title = @Translation("Test backend for Wordproof API to check selections"),
 *   description = @Translation("Test backend for Wordproof API create hashes on a blockchain")
 * )
 */
class Test implements ContainerFactoryPluginInterface, BlockchainBackendInterface {

  /**
   * @var \Drupal\wordproof\WordProofAPIClientInterface
   */
  private $client;

  public function __construct(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition, WordProofAPIClientInterface $wordproofAPIClient) {
    $this->client = $wordproofAPIClient;
  }

  public function send(TimestampInterface $timestamp) {
    $response = $this->client->post($timestamp);

    if ($response->getStatusCode() >= 200 && $response->getStatusCode() <= 299) {
      // @todo Save HashInput? Save Referred ID?
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
