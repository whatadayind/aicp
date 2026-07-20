<?php

namespace Tests\Feature\Contact;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CreateContactTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_create_contact(): void
    {
        $user = User::factory()->create();

        $organization = Organization::factory()->create();

        $user->organizations()->attach(
            $organization->id,
            [
                'role' => 'owner',
                'joined_at' => now(),
            ]
        );

        Sanctum::actingAs($user);

        $response = $this->postJson('/api/v1/contacts', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'phone' => '+919999999999',
            'company' => 'OpenAI',
            'job_title' => 'Engineer',
            'status' => 'active',
        ]);

        $response
            ->assertCreated()
            ->assertJson([
                'success' => true,
            ]);

        $this->assertDatabaseHas('contacts', [
            'email' => 'john@example.com',
        ]);
    }
}