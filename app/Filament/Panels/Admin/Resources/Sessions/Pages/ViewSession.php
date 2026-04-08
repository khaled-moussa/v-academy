<?php

namespace App\Filament\Panels\Admin\Resources\Sessions\Pages;

use App\Filament\Panels\Admin\Resources\Sessions\SessionResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewSession extends ViewRecord
{
    protected static string $resource = SessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
