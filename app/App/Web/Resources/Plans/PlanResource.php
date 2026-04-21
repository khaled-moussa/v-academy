<?php

namespace App\App\Web\Resources\Plans;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlanResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->getId(),
            'uuid'           => $this->getUuid(),

            'name'           => $this->getName(),
            'no_of_sessions' => $this->getNoOfSession(),

            'price'          => $this->getPrice(),
            'discount'       => $this->getDiscount(),
            'price_discount' => $this->getPriceDiscount(),


            'includes'       => $this->getIncludes(),

            'has_discount'   => $this->hasDiscount(),
            'is_popular'     => $this->isPopular(),
            'is_active'      => $this->isActive(),

            'created_at'     => $this->getCreatedAt(),
        ];
    }
}