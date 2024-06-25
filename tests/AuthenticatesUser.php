<?php

namespace Tests;

trait AuthenticatesUser
{

    protected string $token = "";

    public function registerUser($userData): Feature\AuthTest
    {
        $registerResponse = $this->postJson('/api/register', $userData);
        $registerResponse->assertStatus(200);

        return $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
        ]);
    }

    public function loginUser($credentials)
    {
        $loginResponse = $this->postJson('/api/login', $credentials);
        $loginResponse->assertStatus(200);

        $this->token = $loginResponse->json('access_token');

    }
}
