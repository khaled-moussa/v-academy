<?php

namespace App\Filament\Panels\Admin\Resources\Programs\Pages;

use App\Filament\Panels\Admin\Resources\Programs\ProgramResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditProgram extends EditRecord
{
    protected static string $resource = ProgramResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
