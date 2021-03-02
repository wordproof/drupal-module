<?php

use Drupal\Core\Entity\EntityTypeEvent;
use \Symfony\Component\EventDispatcher\EventSubscriberInterface;

class HashSubscriber implements EventSubscriberInterface {

  public static function getSubscribedEvents() {
    $events = [];
    $events[\Drupal\Core\Entity\EntityTypeEvents::CREATE] = 'create';
    $events[\Drupal\Core\Entity\EntityTypeEvents::DELETE] = 'delete';
    $events[\Drupal\Core\Entity\EntityTypeEvents::UPDATE] = 'update';
    return $events;
  }


  public function create(EntityTypeEvent $event) {

  }

  public function delete(EntityTypeEvent $event) {

  }

  public function update(EntityTypeEvent $event) {

  }

}
