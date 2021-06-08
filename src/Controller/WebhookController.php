<?php

namespace Drupal\wordproof\Controller;

/**
 * Placeholder for possible webhook implementation which is supported by WordProof.com.
 */
class WebhookController {

  /**
   * Recieve and validate the incoming webhook.
   */
  public function receive() {
    /* By default, WordProof tries to send a webhook to the webhook_url defined in your account. The POST request contains a header called Signature which the receiving app can use to check the payload hasn't been tampered with. The secret is the sha256 hashed bearer token. Examples how to calculate the signature: $computedSignature = hash_hmac('sha256', $body, $hashedToken); */
  }

}
