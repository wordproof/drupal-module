<?php

namespace Drupal\wordproof\Plugin\wordproof\BlockchainBackend;

use Drupal\wordproof\Plugin\BlockchainBackendInterface;
use Drupal\wordproof\Timestamp\TimestampInterface;

/**
 * Defines an blockchain backend implementation for WordProof.
 *
 * @BlockchainBackend(
 *   id = "wordproof_test_backend",
 *   title = @Translation("WordProof API Queued Blockchain backend"),
 *   description = @Translation("Blockchain backend for WordProof API create hashes on a blockchain. Uses the queued checks to call the API for blockchain info instead of a WebHook")
 * )
 */
class TestBackend implements BlockchainBackendInterface {

  /**
   * Send the timestamp.
   *
   * @param \Drupal\wordproof\Timestamp\TimestampInterface $timestamp
   *   The timestamp.
   *
   * @return \Drupal\wordproof\Timestamp\TimestampInterface
   *   The enriched timestamp
   */
  public function send(TimestampInterface $timestamp): TimestampInterface {
    $timestamp->setHashInput('{"@context":"https://schema.org","@type":"HashInput","dateCreated":"2021-04-30T14:43:15+00:00","isBasedOn":"https://swisnl-drupal.dev.swis.nl/blog/dfsaadfs","text":"<article role=\"article\" class=\"contextual-region node node--type-article node--promoted node--view-mode-wordproof-timestamp-content\">\n\n  \n      <h2>\n      <a href=\"/blog/dfsaadfs\" rel=\"bookmark\"><span class=\"field field--name-title field--type-string field--label-hidden\">dfsaadfssdaadsdsa</span>\n</a>\n    </h2>\n    <div data-contextual-id=\"node:node=182:changed=1619793795&amp;langcode=nl\" data-contextual-token=\"BI5YpnDyURc98JoBAqUBkpe9TrH6PW9m7RQMOlaxqJE\"></div>\n\n  \n  <div class=\"node__content\">\n    \n      <div class=\"field field--name-article__body field--type-entity-reference-revisions field--label-hidden field__items\">\n              <div class=\"field__item\">  <div class=\"paragraph paragraph--type--text paragraph--view-mode--lane\">\n          \n            <div class=\"clearfix text-formatted field field--name-body field--type-text-with-summary field--label-hidden field__item\"><p>fadsfadsfadsfdas</p></div>\n      \n      </div>\n</div>\n          </div>\n  \n  <div class=\"field field--name-article__author field--type-entity-reference field--label-above\">\n    <div class=\"field__label\">Auteur</div>\n              <div class=\"field__item\"><a href=\"/node/75\" hreflang=\"nl\">Björn Brala </a></div>\n          </div>\n\n  </div>\n\n</article>"}');
    $timestamp->setHash('8418d48191e2402b25dadad3f26490296e96b27cc95650373249f45e7576017a');
    $timestamp->setRemoteId('3465774');
    $timestamp->setTransactionAddress('itswordproof');
    $timestamp->setTransactionBlockchain('eos_main');
    $timestamp->setTransactionId('194b339b5c1b7bba70d0becb3a8524c3bf3bfe6a4fc0b72d1e0a5ea5c02e194b');
    $timestamp->setTransactionLink('https://bloks.io/transaction/194b339b5c1b7bba70d0becb3a8524c3bf3bfe6a4fc0b72d1e0a5ea5c02e194b');
    return $timestamp;
  }

}
