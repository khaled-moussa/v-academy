<?php

namespace App\Filament\Panels\User\Resources\Sessions\Pages;

use App\Domain\TrainingSession\Actions\BookSessionAction;
use App\Filament\Panels\User\Resources\Sessions\SessionResource;
use App\Support\Context\AuthContext;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSessions extends ListRecords
{
    protected static string $resource = SessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->after(function ($record) {
                    app(BookSessionAction::class)->execute(AuthContext::user(), $record);
                })
                ->hidden(!AuthContext::hasActiveSubscription() || !app('generalSetting')['user_can_create_session']),
        ];
    }
}
