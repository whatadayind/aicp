<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\User;

class Organization extends Model
{
    protected $fillable = [
        'uuid',
        'name',
        'slug',
        'logo_url',
        'timezone',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Organization $organization) {
            if (empty($organization->uuid)) {
                $organization->uuid = (string) Str::uuid();
            }
        });
    }

    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'organization_users'
        )
        ->withPivot('role', 'joined_at')
        ->withTimestamps();
    }
}