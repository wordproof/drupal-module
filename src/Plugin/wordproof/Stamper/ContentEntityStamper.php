<?php

namespace Drupal\wordproof\Plugin\wordproof\Stamper;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\RevisionableInterface;
use Drupal\wordproof\Plugin\StamperInterface;
use Drupal\wordproof\Timestamp\TimestampInterface;

/**
 * Defines an Stamper implementation for content entities.
 *
 * @Stamper(
 *   id = "content_entity_stamper",
 *   title = @Translation("Content entity timestamp"),
 *   description = @Translation("Creates timestamp from an content entity")
 * )
 */
class ContentEntityStamper implements StamperInterface {

  /**
   * Stamp the entity.
   *
   * @param \Drupal\Core\Entity\ContentEntityInterface $entity
   *   The entity to stamp.
   *
   * @return \Drupal\wordproof\Timestamp\TimestampInterface
   *   The created timestamp
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   * @throws \Drupal\Core\Entity\EntityMalformedException
   */
  public function timestamp(ContentEntityInterface $entity): TimestampInterface {
    $entityTypeManager = \Drupal::entityTypeManager();

    /** @var \Drupal\wordproof\Timestamp\TimestampInterface $timestamp */
    $timestamp = $entityTypeManager->getStorage('wordproof_timestamp')->create();

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

    $view_builder = $entityTypeManager->getViewBuilder($entity->getEntityTypeId());
    $build = $view_builder->view($entity, 'wordproof_content');
    /** @var \Drupal\Core\Render\Renderer $renderer */
    $renderer = \Drupal::service('renderer');
    $content = $renderer->renderPlain($build);
    $timestamp->setContent($content);

    $timestamp->setTitle($entity->label());
    $timestamp->setUrl($entity->toUrl()->setAbsolute(TRUE)->toString());

    return $timestamp;
  }

}
