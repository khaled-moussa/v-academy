<?php

namespace App\Filament\Panels\Admin\Resources\Sessions\Pages;

use App\Domain\TrainingSession\Models\TrainingSession;
use App\Filament\Panels\Admin\Resources\Sessions\SessionResource;
use Filament\Actions\CreateAction;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListSessions extends ListRecords
{
    protected static string $resource = SessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'upcoming' => Tab::make('Upcoming')
                ->badge(TrainingSession::query()->upcomming()->count())
                ->modifyQueryUsing(fn(Builder $query) => $query->upcomming())
                ->excludeQueryWhenResolvingRecord(),

            'past' => Tab::make('Past')
                ->badge(TrainingSession::query()->past()->count())
                ->modifyQueryUsing(fn(Builder $query) => $query->past())
                ->excludeQueryWhenResolvingRecord(),
        ];
    }
}
