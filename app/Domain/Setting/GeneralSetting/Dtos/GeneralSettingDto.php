<?php

namespace App\Domain\Setting\GeneralSetting\Dtos;

class GeneralSettingDto
{
    public function __construct(
        public readonly ?string $siteName = null,
        public readonly ?string $slugon = null,
        public readonly ?string $description = null,
        public readonly ?string $address = null,
        public readonly ?string $locationUrl = null,
        public readonly ?string $supportEmail = null,
        public readonly ?array $phones = [],
        public readonly ?int   $maxCapacity = null,
        public readonly ?bool  $userCanCreateSession = null,
    ) {}

    /*
    |-----------------------------------------------------------------------
    | Export — To Array
    |-----------------------------------------------------------------------
    */
    public function toArray(): array
    {
        return array_filter([
            'site_name'                => $this->siteName,
            'slugon'                   => $this->slugon,
            'description'              => $this->description,
            'address'                  => $this->address,
            'location_url'             => $this->locationUrl,
            'support_email'            => $this->supportEmail,
            'phones'                   => $this->phones,
            'max_capacity'             => $this->maxCapacity,
            'user_can_create_session'  => $this->userCanCreateSession,
        ], fn($value) => ! is_null($value));
    }
}
