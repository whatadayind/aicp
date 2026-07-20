<?php

namespace App\Services\Contact;

use App\Models\Contact;
use App\Models\Organization;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;


class ContactService
{
    public function create(array $data, Organization $organization): Contact
    {
        return Contact::create([
            'organization_id' => $organization->id,
            'first_name'      => $data['first_name'],
            'last_name'       => $data['last_name'] ?? null,
            'email'           => $data['email'] ?? null,
            'phone'           => $data['phone'] ?? null,
            'company'         => $data['company'] ?? null,
            'job_title'       => $data['job_title'] ?? null,
            'status'          => $data['status'] ?? 'active',
        ]);
    }

    public function list(
        Organization $organization,
        ?string $search = null,
        int $perPage = 15
    ): LengthAwarePaginator {

        return Contact::query()
            ->where('organization_id', $organization->id)

            ->when($search, function ($query) use ($search) {

                $query->where(function ($query) use ($search) {

                    $query->where('first_name', 'ILIKE', "%{$search}%")
                        ->orWhere('last_name', 'ILIKE', "%{$search}%")
                        ->orWhere('email', 'ILIKE', "%{$search}%")
                        ->orWhere('phone', 'ILIKE', "%{$search}%")
                        ->orWhere('company', 'ILIKE', "%{$search}%");

                });

            })

            ->latest()

            ->paginate($perPage);
    }

    public function find(
    Organization $organization,
    int $id
    ): Contact {

        return Contact::query()
            ->where('organization_id', $organization->id)
            ->findOrFail($id);
    }

    public function update(Contact $contact, array $data): Contact
    {
        $contact->update($data);

        return $contact->fresh();
    }
    public function delete(Contact $contact): void
    {
        $contact->delete();
    }
}