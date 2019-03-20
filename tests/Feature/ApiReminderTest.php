<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Controllers\ApiController;

class ApiReminderTest extends TestCase
{
    /**
     *
     * @return void
     */
    public function testValidEmail()
    {
        $customer = ApiController::exampleCustomer();

        $response = $this->json('POST', '/api/module_reminder_assigner', ['email' => $customer->email])
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Course Tag added successfully.'
            ]);
    }

    /**
     *
     * @return void
     */
    public function testUnregisteredInfusionSoftEmail()
    {
        $response = $this->json('POST', '/api/module_reminder_assigner', ['email' => 'test@test.com'])
            ->assertStatus(422)
            ->assertJson([
                'success' => false
            ]);
    }

    /**
     *
     * @return void
     */
    public function testInvalidEmail()
    {
        $response = $this->json('POST', '/api/module_reminder_assigner', ['email' => 'fake-email'])
            ->assertStatus(422)
            ->assertJson([
                'success' => false
            ]);
    }

    /**
     *
     * @return void
     */
    public function testEmptyEmail()
    {
        $response = $this->json('POST', '/api/module_reminder_assigner')
            ->assertStatus(422)
            ->assertJson([
                'success' => false
            ]);
    }
}
