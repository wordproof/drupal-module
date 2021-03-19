<?php

namespace Drupal\wordproof\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\wordproof\TimestampRepositoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'WordProofCertificateBlock' block.
 *
 * @Block(
 *  id = "wordproof_certificate_block",
 *  admin_label = @Translation("WordProof certificate block"),
 *  context = {
 *    "node" = @ContextDefinition("entity:node", label = @Translation("Node"))
 *  }
 * )
 */
class WordProofCertificateBlock extends BlockBase {

  /**
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * @var \Drupal\wordproof\TimestampRepositoryInterface
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
      $container->get('wordproof.repository')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $node = $this->getContextValue('node');
    /** @var \Drupal\wordproof\Timestamp\TimestampInterface $timestamp */
    $timestamp = $this->repository->get($node->id());

    if (!is_null($timestamp)) {
      return [
        '#theme' => 'wordproof_certificate',
        '#timestamp' => $timestamp,
        '#attached' => [
          '#library' => [
            'wordproof/certificate_module',
            'wordproof/certificate_nomodule',
          ]
        ]
      ];
    }
    return [];
  }

}
