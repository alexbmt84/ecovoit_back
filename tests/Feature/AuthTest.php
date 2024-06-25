<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use Tests\AuthenticatesUser;


class AuthTest extends TestCase
{
    use RefreshDatabase, AuthenticatesUser;

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('db:seed', ['--class' => 'DatabaseSeeder']);
    }

    /** @test */
    public function user_can_register_and_login_to_access_protected_routes()
    {
        // Check register function
        $this->registerUser([
            'first_name' => 'Test',
            'last_name' => 'Test',
            'email' => 'test@example.com',
            'password' => 'password',
            'phone_number' => "0102030405",
            'role_id' => 3,
            'establishment_id' => 1
        ]);

        // Check login function
        $this->loginUser([
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        // Check protected route access
        $protectedResponse = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token,
        ])->postJson('/api/me');

        $protectedResponse->assertStatus(200);

    }
}
