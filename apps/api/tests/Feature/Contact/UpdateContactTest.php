<?php

namespace Tests\Feature\Contact;

use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateContactTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_update_contact(): void
    {
        [
            'organization' => $organization,
        ] = $this->actingAsOrganizationOwner();

        $contact = Contact::factory()->create([
            'organization_id' => $organization->id,
        ]);

        $response = $this->putJson(
            "/api/v1/contacts/{$contact->id}",
            [
                'first_name' => 'John Updated',
                'company' => 'OpenAI India',
                'job_title' => 'Senior Engineer',
            ]
        );

        $response
            ->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Contact updated successfully.',
            ]);

        $this->assertDatabaseHas('contacts', [
            'id' => $contact->id,
            'first_name' => 'John Updated',
            'company' => 'OpenAI India',
            'job_title' => 'Senior Engineer',
        ]);
    }
}