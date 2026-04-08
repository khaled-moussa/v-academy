<?php

namespace App\Filament\Panels\Admin\Resources\Plans\Pages;

use App\Filament\Panels\Admin\Resources\Plans\PlanResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPlan extends ViewRecord
{
    protected static string $resource = PlanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
