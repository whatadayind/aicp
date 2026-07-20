<?php

namespace Database\Factories;

use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrganizationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Organization::class;

    public function definition(): array
    {
        return [
            'uuid' => fake()->uuid(),
            'name' => fake()->company(),
            'slug' => fake()->unique()->slug(),
            'timezone' => 'UTC',
            'logo_url' => null,
            'status' => 'active',
        ];
    }
}