<?php

namespace App\App\Web\Resources\Plans;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlanResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->getId(),
            'uuid'            => $this->getUuid(),

            'name'            => $this->getName(),
            'description'     => $this->getDescription(),

            'no_of_sessions'  => $this->getNoOfSession(),
            'price'           => $this->getPrice(),

            'includes'        => $this->getIncludes(),
            'is_active'       => $this->isActive(),

            'created_at'      => $this->getCreatedAt(),
        ];
    }
}
