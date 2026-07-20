<?php

namespace Tests\Feature\Contact;

use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowContactTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_contact(): void
    {
        [
            'organization' => $organization,
        ] = $this->actingAsOrganizationOwner();

        $contact = Contact::factory()->create([
            'organization_id' => $organization->id,
        ]);

        $response = $this->getJson(
            "/api/v1/contacts/{$contact->id}"
        );

        $response
            ->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Contact fetched successfully.',
            ]);

        $response->assertJsonPath(
            'data.id',
            $contact->id
        );

        $response->assertJsonPath(
            'data.email',
            $contact->email
        );
    }
}