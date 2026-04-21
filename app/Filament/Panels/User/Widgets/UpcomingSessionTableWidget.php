<?php

namespace App\Filament\Panels\User\Widgets;

use App\Domain\TrainingSession\Actions\GetSessionsAction;
use App\Support\Context\AuthContext;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class UpcomingSessionTableWidget extends TableWidget
{
    protected int|string|array $columnSpan = 'full';
    protected static ?int $sort = 3;

    public function table(Table $table): Table
    {
        $user = AuthContext::user();
        $hasSubscription = AuthContext::hasActiveSubscription();

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

            ->query(fn() => app(GetSessionsAction::class)
                ->upcomingUserSessions(
                    user: $user,
                    startDate: $startOfWeek->toDateString(),
                    endDate: $endOfWeek->toDateString(),
                ))

            /*
            |------------------------------------------------------------------
            | Columns
            |------------------------------------------------------------------
            */

            ->columns([
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
                    ->color(fn($record) => self::capacityColor($record))
                    ->formatStateUsing(
                        fn($record) => "Capacity {$record->getBooking()}/{$record->getCapacity()}"
                    ),

                TextColumn::make('session_date')
                    ->label('Date')
                    ->date()
                    ->badge()
                    ->icon(Heroicon::CalendarDays)
                    ->formatStateUsing(
                        fn($record) => $record->getSessionDate()?->format('M d, Y')
                    ),

                TextColumn::make('session_time')
                    ->label('Time')
                    ->badge()
                    ->icon(Heroicon::OutlinedClock)
                    ->formatStateUsing(
                        fn($record) => $record->getSessionDate()?->format('h:i A')
                    ),
            ])

            /*
            |------------------------------------------------------------------
            | Options
            |------------------------------------------------------------------
            */

            ->searchable(false)
            ->paginated(false);
    }

    /*
    |-------------------------------------------------------------------------
    | Helpers
    |-------------------------------------------------------------------------
    */

    private static function capacityColor($record): string
    {
        $capacity = max($record->getCapacity(), 1);
        $usage = $record->getBooking() / $capacity;

        return match (true) {
            $usage >= 0.9 => 'danger',
            $usage >= 0.6 => 'warning',
            default => 'success',
        };
    }
}
