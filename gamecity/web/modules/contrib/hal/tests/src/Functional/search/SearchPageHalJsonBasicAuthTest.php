<?php

namespace Drupal\Tests\hal\Functional\search;

use Drupal\Tests\rest\Functional\BasicAuthResourceTestTrait;
use Drupal\Tests\search\Functional\Rest\SearchPageResourceTestBase;

/**
 * @group hal
 */
class SearchPageHalJsonBasicAuthTest extends SearchPageResourceTestBase {

  use BasicAuthResourceTestTrait;

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['hal', 'basic_auth'];

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * {@inheritdoc}
   */
  protected static $format = 'hal_json';

  /**
   * {@inheritdoc}
   */
  protected static $mimeType = 'application/hal+json';

  /**
   * {@inheritdoc}
   */
  protected static $auth = 'basic_auth';

}
