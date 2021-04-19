<?php

namespace Drupal\wordproof_timestamp\Plugin\Condition;

use Drupal\Core\Condition\ConditionPluginBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\wordproof_timestamp\TimestampRepositoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


/**
 * Provides the 'Timestamp condition' condition.
 *
 * @Condition(
 *   id = "wordproof_timestamp_condition",
 *   label = @Translation("WordProof timestamp block condition"),
 *   context = {
 *     "node" = @ContextDefinition(
 *        "entity:node",
 *        required = TRUE,
 *        label = @Translation("entity")
 *     )
 *   }
 * )
 */
class TimestampCondition extends ConditionPluginBase implements ContainerFactoryPluginInterface {

  /**
   * @var \Drupal\wordproof_timestamp\TimestampRepositoryInterface
   */
  private $repository;

  public function __construct(array $configuration, $plugin_id, $plugin_definition, TimestampRepositoryInterface $repository) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->repository = $repository;
  }


  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('wordproof_timestamp.repository')
    );
  }

  public function evaluate() {
    $entity = $this->getContextValue('node');
    return $this->repository->isStamped($entity);
  }

  public function summary() {
    return t('Evaluate if entity had an available timestamp');
  }

}
