<?php

namespace App\Services\Organization;

use App\Models\Organization;
use App\Services\Common\SlugService;

class OrganizationService
{
    public function __construct(
            private readonly SlugService $slugService
        ) {
        }    

    public function create(array $data): Organization
    {
        return Organization::create([
            'name'      => $data['name'],
            'slug' => $this->slugService->generate(
                Organization::class,
                $data['name']
            ),
            'timezone'  => $data['timezone'],
            'logo_url'  => $data['logo_url'] ?? null,
            'status'    => 'active',
        ]);
    }
}