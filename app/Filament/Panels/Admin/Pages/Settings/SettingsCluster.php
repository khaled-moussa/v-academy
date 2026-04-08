<?php

namespace App\Filament\Panels\Admin\Pages\Settings;

use BackedEnum;
use Filament\Actions\Action;
use Filament\Clusters\Cluster;
use Filament\Pages\Enums\SubNavigationPosition;
use Filament\Support\Icons\Heroicon;

class SettingsCluster extends Cluster
{
    /* 
    |-------------------------------
    | Resource Configuration
    |-------------------------------
    */

    protected static ?SubNavigationPosition $subNavigationPosition = SubNavigationPosition::End;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::AdjustmentsHorizontal;

    protected static ?int $navigationSort = 6;

    /* 
    |-------------------------------
    | Navigation Labels
    |-------------------------------
    */

    public static function getNavigationLabel(): string
    {
        return 'Settings';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Settings';
    }
}
