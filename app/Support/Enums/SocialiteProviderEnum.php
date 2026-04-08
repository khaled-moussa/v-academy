<?php

namespace App\Support\Enums;

enum SocialiteProviderEnum: string
{
    case GOOGLE = 'google';
    case GITHUB = 'github';


    /*
    |-----------------------------
    | Label
    |-----------------------------
    */
    public function label(): string
    {
        return match ($this) {
            self::GOOGLE => "Google",
            self::GITHUB => "Github",
        };
    }

    /*
    |-----------------------------
    | Icon
    |-----------------------------
    */
    public function icon(): string
    {
        return match ($this) {
            self::GOOGLE => "",
        };
    }

    /*
    |-----------------------------
    | Options
    |-----------------------------
    */
    public static function options(): array
    {
        return array_combine(
            array_column(self::cases(), 'value'),
            array_map(fn($case) => $case->label(), self::cases())
        );
    }
}
