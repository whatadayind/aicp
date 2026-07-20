<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\StoreContactRequest;
use App\Http\Resources\ContactResource;
use App\Services\Contact\ContactService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Organization;
use App\Http\Requests\UpdateContactRequest;

class ContactController extends BaseApiController
{
    public function __construct(
        private readonly ContactService $contactService
    ) {
    }
    public function index(Request $request): JsonResponse
    {
        $organization = $request->user()
            ->organizations()
            ->firstOrFail();

        $contacts = $this->contactService->list(
            $organization,
            $request->query('search'),
            (int) $request->query('per_page', 15)
        );

        return $this->success(
            ContactResource::collection($contacts),
            'Contacts fetched successfully.'
        );
    }

    public function store(StoreContactRequest $request): JsonResponse
    {
        $organization = $request->user()
            ->organizations()
            ->firstOrFail();

        $contact = $this->contactService->create(
            $request->validated(),
            $organization
        );

        return $this->success(
            ContactResource::make($contact),
            'Contact created successfully.',
            201
        );
    }

    public function show(
    Request $request,
    int $id
    ): JsonResponse {

        $contact = $this->contactService->find(
            $this->currentOrganization($request),
            $id
        );

        return $this->success(
            ContactResource::make($contact),
            'Contact fetched successfully.'
        );
    }

    private function currentOrganization(Request $request): Organization
    {
        return $request->user()
            ->organizations()
            ->firstOrFail();
    }

    public function update(
    UpdateContactRequest $request,
    int $id
    ): JsonResponse {

        $contact = $this->contactService->find(
            $this->currentOrganization($request),
            $id
        );

        $contact = $this->contactService->update(
            $contact,
            $request->validated()
        );

        return $this->success(
            ContactResource::make($contact),
            'Contact updated successfully.'
        );
    }

    public function destroy(
    Request $request,
    int $id
    ): JsonResponse {

        $contact = $this->contactService->find(
            $this->currentOrganization($request),
            $id
        );

        $this->contactService->delete($contact);

        return $this->success(
            null,
            'Contact deleted successfully.'
        );
    }
}