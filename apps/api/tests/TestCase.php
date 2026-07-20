<?php

namespace Tests;
use App\Models\Organization;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
        protected function actingAsOrganizationOwner(): array
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

            return [
                'user' => $user,
                'organization' => $organization,
            ];
        }
}
