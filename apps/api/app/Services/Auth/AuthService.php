<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Services\Organization\OrganizationService;
use App\Services\User\UserService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function __construct(
        private readonly UserService $userService,
        private readonly OrganizationService $organizationService,
    ) {
    }

   public function register(array $data)
    {
        return DB::transaction(function () use ($data) {

            $user = $this->userService->create($data);

            $organization = $this->organizationService->create([
                'name' => "{$user->name}'s Workspace",
                'timezone' => 'UTC',
            ]);

            $organization->users()->attach($user->id, [
                'role' => 'owner',
                'joined_at' => now(),
            ]);

            $token = $user->createToken('api')->plainTextToken;

            return [
                    'user' => $user,
                    'organization' => $organization,
                    'token' => $token,
                ];
        });
    }
    public function login(array $data): array
    {
        $user = User::where('email', $data['email'])->first();

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('api')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }
}