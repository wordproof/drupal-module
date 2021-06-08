<?php

namespace Drupal\wordproof\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\wordproof\TimestampRepositoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Controller for displaying HasInput data which is used to validate timestamps and populate the certificate.
 */
class HashInputController extends ControllerBase {

  /**
   * @var \Drupal\wordproof\TimestampRepositoryInterface
   */
  private $repository;

  public function __construct(TimestampRepositoryInterface $repository) {
    $this->repository = $repository;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    $repository = $container->get('wordproof.repository');
    return new static($repository);
  }

  /**
   * @param mixed $id
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   */
  public function get($id) {
    $hashInput = $this->repository->getHashInput($id);
    return new JsonResponse($hashInput, 200, ['Content-Type' => 'application/json; charset=utf-8'], TRUE);
  }

}
