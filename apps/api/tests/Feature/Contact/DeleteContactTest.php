<?php

namespace Tests\Feature\Contact;

use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteContactTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_delete_contact(): void
    {
        [
            'organization' => $organization,
        ] = $this->actingAsOrganizationOwner();

        $contact = Contact::factory()->create([
            'organization_id' => $organization->id,
        ]);

        $response = $this->deleteJson(
            "/api/v1/contacts/{$contact->id}"
        );

        $response
            ->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Contact deleted successfully.',
            ]);

        $this->assertDatabaseMissing('contacts', [
            'id' => $contact->id,
        ]);
    }
}