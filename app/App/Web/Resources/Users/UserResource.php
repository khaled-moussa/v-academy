<?php

namespace App\App\Web\Resources\Users;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->getId(),
            'uuid'       => $this->getUuid(),

            'full_name'  => $this->getFullName(),
            'first_name' => $this->getFirstName(),
            'last_name'  => $this->getLastName(),
            'phone'      => $this->getPhone(),
            'email'      => $this->getEmail(),
            'position'   => $this->getPosition(),
            'panel'      => $this->getPanel(),

            'created_at' => $this->getCreatedAt(),
            // 'updated_at' => $this->getUpdatedAt(),
        ];
    }
}
