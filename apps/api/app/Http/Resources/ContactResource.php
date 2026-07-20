<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->id,
            'uuid'            => $this->uuid,
            'organization_id' => $this->organization_id,
            'first_name'      => $this->first_name,
            'last_name'       => $this->last_name,
            'email'           => $this->email,
            'phone'           => $this->phone,
            'company'         => $this->company,
            'job_title'       => $this->job_title,
            'status'          => $this->status,
            'created_at'      => $this->created_at,
        ];
    }
}