<?php

namespace App\Filament\Panels\Admin\Widgets;

use App\Domain\Dashboard\Traits\HasFilterByDateTrait;
use App\Domain\Subscription\Actions\GetSubscriptionsAction;
use App\Domain\Subscription\Models\States\SubscriptionStates\SubscriptionPendingState;
use App\Domain\TrainingSession\Actions\GetSessionsAction;
use App\Domain\User\Actions\GetUsersAction;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseStatsOverviewWidget;

class StatsOverviewWidget extends BaseStatsOverviewWidget
{
    use InteractsWithPageFilters;
    use HasFilterByDateTrait;

    /* 
    |-------------------------------
    | Widget Configuration
    |-------------------------------
    */
    protected ?string $pollingInterval = null;
    protected int|string|array $columnSpan = 'full';

    protected function getColumns(): int
    {
        return 3;
    }

    /* 
    |-------------------------------
    | Stats
    |-------------------------------
    */
    protected function getStats(): array
    {
        $this->getDateRange();

        return [

            /* 
            |-----------------------------
            | Users
            |-----------------------------
            */
            Stat::make('Users', app(GetUsersAction::class)->count($this->startDate, $this->endDate))
                ->description('Total registered users')
                ->icon(Heroicon::OutlinedUsers)
                ->url(route('filament.admin.resources.users.index')),

            /* 
            |-----------------------------
            | Sessions
            |-----------------------------
            */
            Stat::make('Sessions', app(GetSessionsAction::class)->count($this->startDate, $this->endDate))
                ->description('Total training sessions')
                ->icon(Heroicon::OutlinedCalendar)
                ->url(route('filament.admin.resources.sessions.index')),

            /* 
            |-----------------------------
            | Subscriptions
            |-----------------------------
            */
            Stat::make('Pending Subscriptions', app(GetSubscriptionsAction::class)->count($this->startDate, $this->endDate, SubscriptionPendingState::value()))
                ->description('Total pending subscriptions')
                ->icon(Heroicon::OutlinedClock)
                ->url(route('filament.admin.resources.subscriptions.index')),
        ];
    }
}
