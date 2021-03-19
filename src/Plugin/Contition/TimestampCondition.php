<?php

namespace Drupal\wordproof\Plugin\Condition;

use Drupal\Core\Condition\ConditionPluginBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\wordproof\TimestampRepositoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


/**
 * Provides the 'Timestamp condition' condition.
 *
 * @Condition(
 *   id = "wordproof_timestamp_condition",
 *   label = @Translation("WordProof timestamp block condition"),
 *   context = {
 *     "entity" = @ContextDefinition(
 *        "entity",
 *        required = TRUE ,
 *        label = @Translation("entity")
 *     )
 *   }
 * )
 */
class TimestampCondition extends ConditionPluginBase implements ContainerFactoryPluginInterface {

  /**
   * @var \Drupal\wordproof\TimestampRepositoryInterface
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
      $container->get('wordproof.repository')
    );
  }

  public function evaluate() {
    $entity = $this->getContextValue('entity');
    return $this->repository->isStamped($entity);
  }

  public function summary() {
    return t('Evaluate if entity had an available timestamp');
  }

}
