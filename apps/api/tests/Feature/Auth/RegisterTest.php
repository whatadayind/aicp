<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register(): void
    {
        $response = $this->postJson('/api/v1/auth/register', [
            'name' => 'Dhaval Test',
            'email' => 'dhaval.test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response
            ->assertCreated()
            ->assertJson([
                'success' => true,
                'message' => 'Registration successful.',
            ]);

        $this->assertDatabaseHas('users', [
            'email' => 'dhaval.test@example.com',
        ]);

        $this->assertDatabaseHas('organizations', [
            'name' => "Dhaval Test's Workspace",
        ]);

        $this->assertDatabaseHas('organization_users', [
            'role' => 'owner',
        ]);
    }
}