<?php

namespace Tests\Feature\Contact;

use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListContactsTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_list_contacts(): void
    {
        [
            'organization' => $organization,
        ] = $this->actingAsOrganizationOwner();

        Contact::factory()
            ->count(3)
            ->create([
                'organization_id' => $organization->id,
            ]);

        $response = $this->getJson('/api/v1/contacts');

        $response
            ->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Contacts fetched successfully.',
            ]);

        $response->assertJsonStructure([
        'success',
        'message',
        'data' => [
            '*' => [
                'id',
                'uuid',
                'organization_id',
                'first_name',
                'last_name',
                'email',
                'phone',
                'company',
                'job_title',
                'status',
                'created_at',
            ],
        ],
    ]);

        $this->assertCount(
            3,
            $response->json('data')
        );
    }
}