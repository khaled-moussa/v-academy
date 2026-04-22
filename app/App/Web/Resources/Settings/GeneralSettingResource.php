<?php

namespace App\App\Web\Resources\Settings;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GeneralSettingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                  => $this->getId(),
            'uuid'                => $this->getUuid(),

            'site_name'           => $this->getSiteName(),
            'tagline'             => $this->getTagline(),
            'slugon'              => $this->getSlugon(),
            'description'         => $this->getDescription(),

            'youtube_links'       => $this->getYoutubeLinks(),

            'address'             => $this->getAddress(),
            'location_url'        => $this->getLocationUrl(),
            'support_email'       => $this->getSupportEmail(),
            'phones'              => $this->getPhones(),

            'max_capacity'        => $this->getMaxCapacity(),
            'user_can_create_session' => $this->canUserCreateSession(),

            'created_at'          => $this->getCreatedAt(),
            'updated_at'          => $this->getUpdatedAt(),
        ];
    }
}
