<?php
namespace Drupal\wordproof\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

class HashInputController {
  public function get($id) {
    $hashInput = \Drupal::service('wordproof.repository')->getHashInput($id, TRUE);
    return new JsonResponse($hashInput, 200, [], true);
  }
}
