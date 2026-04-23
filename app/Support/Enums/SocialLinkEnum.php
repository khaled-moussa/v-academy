<?php

namespace App\Support\Enums;

enum SocialLinkEnum: string
{
    case FACEBOOK = 'facebook';
    case INSTAGRAM = 'instagram';
    case YOUTUBE = 'youtube';
    case X = 'x';
    case WHATSAPP = 'whatsapp';
    case TIKTOK = 'tiktok';

    /*
    |--------------------------------------------------------------------------
    | Label
    |--------------------------------------------------------------------------
    */

    public function label(): string
    {
        return match ($this) {
            self::FACEBOOK  => 'Facebook',
            self::INSTAGRAM => 'Instagram',
            self::YOUTUBE   => 'YouTube',
            self::X         => 'X',
            self::WHATSAPP  => 'WhatsApp',
            self::TIKTOK    => 'TikTok',
        };
    }

    /*
    |--------------------------------------------------------------------------
    | Icon (Lucide / Heroicon / custom class)
    |--------------------------------------------------------------------------
    */

    public function icon(): string
    {
        return match ($this) {
            self::FACEBOOK  => 'facebook',
            self::INSTAGRAM => 'instagram',
            self::YOUTUBE   => 'youtube',
            self::X         => 'x',
            self::WHATSAPP  => 'whatsapp',
            self::TIKTOK    => 'tiktok',
        };
    }

    /*
    |--------------------------------------------------------------------------
    | Options (for Select fields)
    |--------------------------------------------------------------------------
    */
    
    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn(self $case) => [
                $case->value => $case->label(),
            ])
            ->toArray();
    }
}
