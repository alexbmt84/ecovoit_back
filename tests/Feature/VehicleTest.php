<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\AuthenticatesUser;


class VehicleTest extends TestCase
{
    use AuthenticatesUser;

    /** @test */
    public function user_can()
    {

        // Check protected route access
        $protectedResponse = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/trips');

        $protectedResponse->assertStatus(200);

    }
}
