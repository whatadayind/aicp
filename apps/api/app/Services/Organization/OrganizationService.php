<?php

namespace App\Services\Organization;

use App\Models\Organization;
use Illuminate\Support\Str;

class OrganizationService
{
    public function create(array $data): Organization
    {
        return Organization::create([
            'name'      => $data['name'],
            'slug'      => Str::slug($data['name']),
            'timezone'  => $data['timezone'],
            'logo_url'  => $data['logo_url'] ?? null,
            'status'    => 'active',
        ]);
    }
}