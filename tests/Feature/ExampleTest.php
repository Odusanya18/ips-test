<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $customer = ApiController::exampleCustomer();
        $response = $this->post('/api/module_reminder_assigner');

        $response->assertStatus(200);
    }
}
