<?php

namespace App\App\Web\Resources\NutrationPlans;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NutrationPlanResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->getId(),
            'uuid'      => $this->getUuid(),
            'meal'      => $this->getMeal(),
            'saturday'  => $this->getSaturday(),
            'sunday'    => $this->getSunday(),
            'monday'    => $this->getMonday(),
            'tuesday'   => $this->getTuesday(),
            'wednesday' => $this->getWednesday(),
            'thursday'  => $this->getThursday(),
            'friday'    => $this->getFriday(),
            'created_at'=> $this->getCreatedAt(),
        ];
    }
}