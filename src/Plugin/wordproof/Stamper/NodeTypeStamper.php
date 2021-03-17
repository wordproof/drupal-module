<?php


namespace Drupal\wordproof\Plugin\wordproof\Stamper;

use Drupal\node\Entity\Node;
use Drupal\wordproof\Plugin\StamperInterface;
use Drupal\wordproof\Timestamp\TimestampInterface;

/**
 * Defines an Stamper implementation for Nodes
 *
 * @Stamper(
 *   id = "node_type_stamper",
 *   title = @Translation("Node ArticleTimestamp"),
 *   description = @Translation("Creates ArticleTimestamp from an Node")
 * )
 */
class NodeTypeStamper implements StamperInterface {

  public function timestamp(Node $node): TimestampInterface {
    /** @var \Drupal\wordproof\Entity\Timestamp $timestamp */
    $timestamp = \Drupal::entityTypeManager()->getStorage('timestamp')->create();

    $view_builder = \Drupal::entityTypeManager()->getViewBuilder('node');
    $build = $view_builder->view($node, 'wordproof_content');

    $timestamp->setReferenceId($node->id());
    $timestamp->setReferenceRevisionId($node->getRevisionId());
    $timestamp->setContent(render($build));
    $timestamp->setModified($node->getChangedTime());
    $timestamp->setTitle($node->label());
    $timestamp->setUrl($node->toUrl()->setAbsolute(true)->toString());

    return $timestamp;
  }

}
