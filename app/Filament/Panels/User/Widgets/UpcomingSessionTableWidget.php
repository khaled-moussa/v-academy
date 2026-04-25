<?php

namespace App\Filament\Panels\User\Widgets;

use App\Domain\TrainingSession\Actions\GetSessionsAction;
use App\Domain\TrainingSession\Models\SessionStates\SessionAvailableState;
use App\Domain\TrainingSession\Models\SessionStates\SessionFullState;
use App\Domain\TrainingSession\Models\TrainingSession;
use App\Support\Context\AuthContext;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class UpcomingSessionTableWidget extends TableWidget
{
    /*
    |--------------------------------------------------------------------------
    | Layout & Sorting
    |--------------------------------------------------------------------------
    */

    protected int|string|array $columnSpan = 'full';
    protected static ?int $sort = 3;

    /*
    |--------------------------------------------------------------------------
    | Table Configuration
    |--------------------------------------------------------------------------
    */

    public function table(Table $table): Table
    {
        return $table

            /*
            |--------------------------------------------------------------------------
            | Header
            |--------------------------------------------------------------------------
            */

            ->heading('Upcoming Sessions')
            ->description($this->getWeekDescription())

            /*
            |--------------------------------------------------------------------------
            | Query
            |--------------------------------------------------------------------------
            */

            ->query(fn() => $this->getQuery())

            /*
            |--------------------------------------------------------------------------
            | Columns
            |--------------------------------------------------------------------------
            */

            ->columns($this->columns())

            /*
            |--------------------------------------------------------------------------
            | Table Options
            |--------------------------------------------------------------------------
            */

            ->deferLoading()
            ->stackedOnMobile()
            ->searchable(false)
            ->paginated(false);
    }

    /*
    |--------------------------------------------------------------------------
    | Columns
    |--------------------------------------------------------------------------
    */

    private function columns(): array
    {
        return [

            TextColumn::make('name')
                ->label('Session Name')
                ->weight(FontWeight::Bold)
                ->searchable(),

            TextColumn::make('session_state')
                ->label('State')
                ->badge()
                ->color(fn($state) => $state?->filamentColor())
                ->formatStateUsing(fn($state) => $state?->label()),

            TextColumn::make('capacity')
                ->label('Capacity')
                ->badge()
                ->color(fn($record) => $this->determineCapacityColor($record))
                ->formatStateUsing(
                    fn($record) => 'Capacity ' . $record->getBooking() . '/' . $record->getCapacity()
                ),

            TextColumn::make('session_date_formatted')
                ->label('Date')
                ->date()
                ->badge()
                ->icon(Heroicon::CalendarDays),

            TextColumn::make('session_time_formatted')
                ->label('Time')
                ->badge()
                ->icon(Heroicon::OutlinedClock),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Query
    |--------------------------------------------------------------------------
    */

    private function getQuery()
    {
        $user = AuthContext::user();

        return app(GetSessionsAction::class)->upcomingUserSessions(
            user: $user,
            startDate: now()->startOfWeek()->toDateString(),
            endDate: now()->endOfWeek()->toDateString(),
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    private function getWeekDescription(): string
    {
        $start = now()->startOfWeek()->format('M d');
        $end = now()->endOfWeek()->format('M d, Y');

        return "This week: {$start} - {$end}";
    }

    private function determineCapacityColor(TrainingSession $session): array
    {
        if ($session->getCapacity() === $session->getBooking()) {
            return SessionFullState::filamentColor();
        }

        return SessionAvailableState::filamentColor();
    }
}
