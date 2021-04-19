<?php

namespace Drupal\Tests\wordproof_timestamp\Kernel;

use Drupal\Tests\token\Kernel\KernelTestBase;
use Drupal\wordproof_timestamp\EntityWatchListService;


/**
 * Class EntityWatchListServiceTest
 *
 * @group wordproof
 * @coversDefaultClass \Drupal\wordproof_timestamp\EntityWatchListService
 * @covers \Drupal\wordproof_timestamp\EntityWatchListService
 *
 * @internal
 * @package Drupal\Tests\wordproof_timestamp\Kernel
 */
class EntityWatchListServiceTest extends KernelTestBase {

  public static $modules = [
    'wordproof_timestamp',
    'node',
    'field',
    'system',
    'user',
  ];


  public function testGetWatchList() {
    /** @var \Drupal\wordproof_timestamp\EntityWatchListService $watchListService */
    $watchListService = $this->container->get('wordproof_timestamp.entity_watch_list');
    $result = $watchListService->getWatchList();

    $this->assertEquals([
        "user_role" => [
          "user" => ["roles"],
        ],
        "node_type" => [
          "node" => ['type'],
        ],
        "user" => [
          "node" => ["revision_uid", "uid"],
        ],
      ],
      $result
    );
  }

}
