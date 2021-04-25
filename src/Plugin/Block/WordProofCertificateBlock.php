<?php

namespace Drupal\wordproof_timestamp\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\wordproof_timestamp\TimestampRepositoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'WordProofCertificateBlock' block.
 *
 * @Block(
 *  id = "wordproof_certificate_block",
 *  admin_label = @Translation("WordProof certificate block"),
 *  context_definitions = {
 *    "entity" = @ContextDefinition("entity"),
 *    "wordproof_timestamp" = @ContextDefinition("entity:wordproof_timestamp", required = FALSE)
 *  }
 * )
 */
class WordProofCertificateBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * @var \Drupal\wordproof_timestamp\TimestampRepositoryInterface
   */
  private $repository;

  public function __construct(array $configuration, $plugin_id, $plugin_definition, EntityTypeManagerInterface $entity_type_manager, TimestampRepositoryInterface $repository) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->entityTypeManager = $entity_type_manager;
    $this->repository = $repository;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity_type.manager'),
      $container->get('wordproof_timestamp.repository')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    /** @var \Drupal\Core\Entity\ContentEntityInterface $entity */
    $entity = $this->getContextValue('entity');
    /** @var \Drupal\wordproof_timestamp\Timestamp\TimestampInterface $timestamp */
    $timestamp = $this->repository->get($entity);

    if (!is_null($timestamp)) {
      $this->setContextValue('wordproof_timestamp', $timestamp);

      return [
        '#theme' => 'wordproof_certificate',
        '#timestamp' => $timestamp,
        '#attached' => [
          'library' => [
            'wordproof_timestamp/certificate_module',
            'wordproof_timestamp/certificate_nomodule',
          ],
        ],
      ];
    }
    return [];
  }

}
