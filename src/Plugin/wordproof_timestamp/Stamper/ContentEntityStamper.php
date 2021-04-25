<?php


namespace Drupal\wordproof_timestamp\Plugin\wordproof_timestamp\Stamper;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\RevisionableInterface;
use Drupal\wordproof_timestamp\Plugin\StamperInterface;
use Drupal\wordproof_timestamp\Timestamp\TimestampInterface;

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
    /** @var \Drupal\wordproof_timestamp\Timestamp\TimestampInterface $timestamp */
    $timestamp = \Drupal::entityTypeManager()->getStorage('wordproof_timestamp')->create();

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
    $build = $view_builder->view($entity, 'wordproof_timestamp_content');
    /** @var \Drupal\Core\Render\Renderer $service */
    $service = \Drupal::service('renderer');
    $content = $service->renderPlain($build);
    $timestamp->setContent($content);

    $timestamp->setTitle($entity->label());
    $timestamp->setUrl($entity->toUrl()->setAbsolute(TRUE)->toString());

    return $timestamp;
  }

}
