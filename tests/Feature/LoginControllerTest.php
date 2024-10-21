<?php

use App\Models\User;

it('logs in with valid credentials', function () {
    // Create a test user
    $user = User::factory()->create([
        'email' => 'Oksana@drogas.com',
        'password' => 'asdasd123',
    ]);

    // Send POST request to the login route
    $response = $this->postJson('/api/login', [
        'email' => 'Oksana@drogas.com',
        'password' => 'asdasd123',
    ]);

    // Assert that the response is OK and contains a token
    $response->assertStatus(200);
    $response->assertJsonStructure(['token', 'user']);
});



