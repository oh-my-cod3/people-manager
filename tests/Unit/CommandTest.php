<?php

namespace OhMyCod3\PeopleManager\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use OhMyCod3\PeopleManager\Models\People;
use OhMyCod3\PeopleManager\Models\Planet;
use OhMyCod3\PeopleManager\Tests\TestCase;

class ExampleTest extends TestCase
{

    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_application_returns_a_successful_response()
    {
        Artisan::call('pm:import');

        $this->assertTrue(People::count() > 0);
        $this->assertTrue(Planet::count() > 0);
    }
}
