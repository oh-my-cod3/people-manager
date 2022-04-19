<?php

namespace OhMyCod3\PeopleManager\Tests;

use OhMyCod3\PeopleManager\PeopleManagerServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
  public function setUp(): void
  {
    parent::setUp();
    // additional setup
  }

  protected function getPackageProviders($app)
  {
    return [
        PeopleManagerServiceProvider::class,
    ];
  }

  protected function getEnvironmentSetUp($app)
  {
    // perform environment setup
  }
}
