<?php


namespace Drupal\wordproof\Plugin\wordproof\Stamper;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\RevisionableInterface;
use Drupal\wordproof\Plugin\StamperInterface;
use Drupal\wordproof\Timestamp\TimestampInterface;

/**
 * Defines an Stamper implementation for content entities
 *
 * @Stamper(
 *   id = "content_entity_stamper",
 *   title = @Translation("Content entity timestamp"),
 *   description = @Translation("Creates timestamp from an content entity")
 * )
 */
class ContentEntityStamper implements StamperInterface {

  public function timestamp(ContentEntityInterface $entity): TimestampInterface {
    /** @var \Drupal\wordproof\Timestamp\TimestampInterface $timestamp */
    $timestamp = \Drupal::entityTypeManager()->getStorage('timestamp')->create();

    $timestamp->setReferenceId($entity->id());
    $timestamp->setReferenceEntityType($entity->getEntityTypeId());

    $revisionId = 0;
    if ($entity instanceof RevisionableInterface) {
      $revisionId = $entity->getRevisionId() ?: 0;
    }
    $timestamp->setReferenceRevisionId($revisionId);

    $modified = time();
    if ($entity instanceof EntityChangedInterface) {
      $modified = $entity->getChangedTime();
    }
    $timestamp->setModified($modified);

    $view_builder = \Drupal::entityTypeManager()->getViewBuilder($entity->getEntityTypeId());
    $build = $view_builder->view($entity, 'wordproof_content');
    $timestamp->setContent(render($build));

    $timestamp->setTitle($entity->label());
    $timestamp->setUrl($entity->toUrl()->setAbsolute(TRUE)->toString());

    return $timestamp;
  }

}
