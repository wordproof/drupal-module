<?php

namespace Drupal\wordproof\EventSubscriber;

use Drupal\Core\Entity\EntityTypeEvent;
use Drupal\Core\Entity\EntityTypeEventSubscriberTrait;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Psr\Log\LoggerInterface;
use \Symfony\Component\EventDispatcher\EventSubscriberInterface;

class EntityTypeSubscriber implements EventSubscriberInterface {

  use EntityTypeEventSubscriberTrait;

  /**
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  private $entityTypeManager;

  public function __construct(EntityTypeManagerInterface $entity_type_manager) {
    $this->entityTypeManager = $entity_type_manager;
  }

  public static function getSubscribedEvents() {
    $events = [];
    $events = static::getEntityTypeEvents();

    $events[\Drupal\Core\Entity\EntityTypeEvents::CREATE] = 'create';
    $events[\Drupal\Core\Entity\EntityTypeEvents::DELETE] = 'delete';
    $events[\Drupal\Core\Entity\EntityTypeEvents::UPDATE] = 'update';
    return $events;
  }


  public function create(EntityTypeEvent $event) {
    \Drupal::logger('wordproof')->debug('EntityTypeEvent create');
  }

  public function delete(EntityTypeEvent $event) {
    \Drupal::logger('wordproof')->debug('EntityTypeEvent delete');
  }

  public function update(EntityTypeEvent $event) {
    \Drupal::logger('wordproof')->debug('EntityTypeEvent update');
  }

  public function onEntityTypeEvent(EntityTypeEvent $event, $event_name) {
    \Drupal::logger('wordproof')->debug(__CLASS__ . '::' . __METHOD__);
  }

  public function onEntityTypeCreate(\Drupal\Core\Entity\EntityTypeInterface $entity_type) {
    \Drupal::logger('wordproof')->debug(__CLASS__ . '::' . __METHOD__);
  }

  public function onFieldableEntityTypeCreate(\Drupal\Core\Entity\EntityTypeInterface $entity_type, array $field_storage_definitions) {
    \Drupal::logger('wordproof')->debug(__CLASS__ . '::' . __METHOD__);
  }

  public function onEntityTypeUpdate(\Drupal\Core\Entity\EntityTypeInterface $entity_type, \Drupal\Core\Entity\EntityTypeInterface $original) {
    \Drupal::logger('wordproof')->debug(__CLASS__ . '::' . __METHOD__);
  }

  public function onFieldableEntityTypeUpdate(\Drupal\Core\Entity\EntityTypeInterface $entity_type, \Drupal\Core\Entity\EntityTypeInterface $original, array $field_storage_definitions, array $original_field_storage_definitions, array &$sandbox = NULL) {
    \Drupal::logger('wordproof')->debug(__CLASS__ . '::' . __METHOD__);
  }

  public function onEntityTypeDelete(\Drupal\Core\Entity\EntityTypeInterface $entity_type) {
    \Drupal::logger('wordproof')->debug(__CLASS__ . '::' . __METHOD__);
  }

}
