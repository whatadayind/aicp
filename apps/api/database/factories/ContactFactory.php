<?php

namespace Database\Factories;

use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Contact;

class ContactFactory extends Factory
{
    protected $model = Contact::class;
    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),

            'uuid' => fake()->uuid(),

            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),

            'email' => fake()->unique()->safeEmail(),

            'phone' => fake()->phoneNumber(),

            'company' => fake()->company(),

            'job_title' => fake()->jobTitle(),

            'status' => 'active',
        ];
    }
}