<?php

namespace App\Filament\Panels\User\Widgets;

use App\Support\Context\AuthContext;
use Filament\Widgets\Widget;

class NutrationPlanWidget extends Widget
{
    /* 
    |-------------------------------
    | Configuration
    |------------------------------- 
    */

    protected string $view = 'filament.panels.user.widgets.nutration-plan-widget';

    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 1;

    private const DAYS = [
        'saturday',
        'sunday',
        'monday',
        'tuesday',
        'wednesday',
        'thursday',
        'friday',
    ];

    /* 
    |-------------------------------
    | Data
    |------------------------------- 
    */

    public function getViewData(): array
    {
        $plans = AuthContext::user()
            ?->nutrationPlans
            ?->toResourceCollection()
            ?->resolve() ?? [];

        return [
            'nutrations' => $plans,
            'days'       => self::DAYS,
        ];
    }
}
