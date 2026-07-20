<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Services\Auth\AuthService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Resources\OrganizationResource;
use App\Http\Controllers\Api\BaseApiController;

class AuthController extends BaseApiController
{
    public function __construct(
        private readonly AuthService $authService
    ) {
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $result = $this->authService->register(
            $request->validated()
        );

        return $this->success(
            [
                'user' => UserResource::make($result['user']),
                'organization' => OrganizationResource::make($result['organization']),
                'token' => $result['token'],
            ],
            'Registration successful.',
            201
        );
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $result = $this->authService->login(
            $request->validated()
        );

        return $this->success(
            [
                'user' => UserResource::make($result['user']),
                'token' => $result['token'],
            ],
            'Login successful.'
        );
    }

    public function me(Request $request): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Current user fetched successfully.',
            'data' => [
                'user' => $request->user(),
                'organizations' => $request->user()->organizations,
            ],
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return $this->success(
            null,
            'Logout successful.'
        );
    }
}