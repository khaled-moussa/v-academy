<?php

namespace App\Filament\Panels\User\Resources\Programs\Pages;

use App\Filament\Panels\User\Resources\Programs\ProgramResource;
use Filament\Resources\Pages\ViewRecord;

class ViewProgram extends ViewRecord
{
    protected static string $resource = ProgramResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
