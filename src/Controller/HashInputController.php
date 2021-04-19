<?php
namespace Drupal\wordproof_timestamp\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

class HashInputController {
  public function get($id) {
    $hashInput = \Drupal::service('wordproof_timestamp.repository')->getHashInput($id, TRUE);
    return new JsonResponse($hashInput, 200, [], true);
  }
}
