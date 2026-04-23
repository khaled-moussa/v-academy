<?php

namespace App\Filament\Panels\Admin\Widgets;

use App\Domain\Dashboard\Traits\HasFilterByDateTrait;
use App\Domain\TrainingSession\Actions\GetSessionsAction;
use App\Domain\TrainingSession\Models\SessionStates\SessionAvailableState;
use App\Domain\TrainingSession\Models\SessionStates\SessionFullState;
use App\Domain\TrainingSession\Models\TrainingSession;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget;
use Filament\Tables\Table;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class UpcomingSessionTableWidget extends TableWidget
{
    use InteractsWithPageFilters;
    use HasFilterByDateTrait;

    /*
    |------------------------------------------------------------------
    | Layout & Sorting
    |------------------------------------------------------------------
    */

    protected int|string|array $columnSpan = 'full';
    protected static ?int $sort = 3;

    /*
    |------------------------------------------------------------------
    | Table Configuration
    |------------------------------------------------------------------
    */

    public function table(Table $table): Table
    {
        $this->getDateRange();

        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();

        return $table

            /*
            |------------------------------------------------------------------
            | Header
            |------------------------------------------------------------------
            */

            ->heading('Upcoming Sessions')
            ->description("This week: {$startOfWeek->format('M d')} - {$endOfWeek->format('M d, Y')}")

            /*
            |------------------------------------------------------------------
            | Query
            |------------------------------------------------------------------
            */

            ->query(fn() => app(GetSessionsAction::class)->upcomingUserSessions(
                startDate: $startOfWeek->toDateString(),
                endDate: $endOfWeek->toDateString(),
            ))

            /* 
            |-----------------------------------------------------------------
            | Columns
            |-----------------------------------------------------------------
            */

            ->columns([

                /* 
                |-------------------------------
                | Session Name
                |------------------------------- 
                */

                TextColumn::make('name')
                    ->label('Session Name')
                    ->weight(FontWeight::Bold)
                    ->searchable(),

                /* 
                |-------------------------------
                | Session State
                |------------------------------- 
                */

                TextColumn::make('session_state')
                    ->label('State')
                    ->badge()
                    ->color(fn($state) => $state->filamentColor())
                    ->formatStateUsing(fn($state) => $state->label()),

                /* 
                |-------------------------------
                | Capacity
                |------------------------------- 
                */

                TextColumn::make('capacity')
                    ->label('Capacity')
                    ->badge()
                    ->color(fn($record) => self::determineCapacityColor($record))
                    ->formatStateUsing(fn($record) => 'Capacity ' . $record->getBooking() . '/' . $record->getCapacity()),

                /* 
                |-------------------------------
                | Session Date
                |------------------------------- 
                */

                TextColumn::make('session_date_formatted')
                    ->label('Date')
                    ->date()
                    ->badge()
                    ->icon(Heroicon::CalendarDays),

                /* 
                |-------------------------------
                | Session Time
                |------------------------------- 
                */

                TextColumn::make('session_time_formatted')
                    ->label('Time')
                    ->badge()
                    ->icon(Heroicon::OutlinedClock),
            ])

            /* 
            |-----------------------------------------------------------------
            | Table Options
            |-----------------------------------------------------------------
            */

            ->deferLoading()
            ->stackedOnMobile()
            ->searchable(false)
            ->paginated(false);
    }

    /* 
    |-------------------------------------------------------------------------
    | Helpers
    |-------------------------------------------------------------------------
    */

    private static function determineCapacityColor(TrainingSession $session): array
    {
        if ($session->getCapacity() === $session->getBooking()) {
            return SessionFullState::filamentColor();
        }

        return SessionAvailableState::filamentColor();
    }
}
