<?php

namespace App\Domain\Setting\GeneralSetting\Dtos;

use Illuminate\Support\Str;

class GeneralSettingDto
{
    public function __construct(
        public readonly ?string $siteName = null,
        public readonly ?string $tagline = null,
        public readonly ?string $slugon = null,
        public readonly ?string $description = null,
        public readonly ?array $youtubeLinks = [],
        public readonly ?string $address = null,
        public readonly ?string $locationUrl = null,
        public readonly ?string $supportEmail = null,
        public readonly ?array $socialLinks = [],
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
            'tagline'                  => $this->tagline,
            'slugon'                   => $this->slugon,
            'description'              => $this->description,
            'youtube_links'            => $this->resolveYoutubeLink($this->youtubeLinks),
            'address'                  => $this->address,
            'location_url'             => $this->locationUrl,
            'support_email'            => $this->supportEmail,
            'social_links'             => $this->resolveSocialLinks($this->socialLinks),
            'phones'                   => $this->resolvePhones($this->phones),
            'max_capacity'             => $this->maxCapacity,
            'user_can_create_session'  => $this->userCanCreateSession,
        ], fn($value) => ! is_null($value));
    }

    /*
    |-----------------------------------------------------------------------
    | Helpers
    |-----------------------------------------------------------------------
    */
    public function resolveYoutubeLink(array $youtubeLinks): array
    {
        return collect($youtubeLinks)
            ->map(function ($youtube) {

                $link = $youtube['link'] ?? null;

                if (! $link) {
                    return null;
                }

                // Extract video ID
                if (Str::contains($link, 'youtu.be/')) {
                    $videoId = Str::after($link, 'youtu.be/');
                } elseif (Str::contains($link, 'watch?v=')) {
                    $videoId = Str::after($link, 'watch?v=');
                } else {
                    return null;
                }

                return [
                    ...$youtube,
                    'embed' => "https://www.youtube.com/embed/{$videoId}",
                ];
            })
            ->filter() // remove nulls
            ->values()
            ->toArray();
    }

    public function resolvePhones(array $phones): array
    {
        return collect($phones)
            ->map(function ($phone) {

                if (is_array($phone)) {
                    return $phone['phone'] ?? null;
                }

                return is_string($phone) ? $phone : null;
            })
            ->filter()
            ->values()
            ->toArray();
    }

    public function resolveSocialLinks(array $socialLinks): array
    {
        return collect($socialLinks)
            ->map(function ($social) {

                if (empty($social)) {
                    return null;
                }

                // If already structured
                if (is_array($social)) {
                    $type = $social['type'] ?? null;
                    $link = $social['link'] ?? null;
                } else {
                    return null;
                }

                if (! $type || ! $link) {
                    return null;
                }

                return [
                    'type' => $type,
                    'link' => $link,
                ];
            })
            ->filter()
            ->values()
            ->toArray();
    }
}
