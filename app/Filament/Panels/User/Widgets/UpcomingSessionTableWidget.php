<?php

namespace App\Filament\Panels\User\Widgets;

use App\Domain\TrainingSession\Actions\GetSessionsAction;
use App\Support\Context\UserContext;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget;
use Filament\Tables\Table;

class UpcomingSessionTableWidget extends TableWidget
{
    protected int|string|array $columnSpan = 'full';
    protected static ?int $sort = 3;

    public function table(Table $table): Table
    {
        $user = UserContext::user();
        $isSubscribed = $user->hasActiveSubscription();

        $startOfWeek = now()->startOfWeek()->format('M d, Y');
        $endOfWeek = now()->endOfWeek()->format('M d, Y');

        return $table
            ->heading('Upcoming Sessions')
            ->description($isSubscribed ? "This table shows upcoming sessions for this week: {$startOfWeek} - {$endOfWeek}" : null)
            ->query(fn() => app(GetSessionsAction::class)->upcomingUserSessions(
                user: $user,
                startDate: now()->startOfWeek(),
                endDate: now()->endOfWeek(),
            ))
            ->columns([
                TextColumn::make('name')
                    ->label('Session Name')
                    ->weight(FontWeight::Bold)
                    ->searchable()
                    ->hidden(!$isSubscribed),

                TextColumn::make('session_state')
                    ->label('State')
                    ->badge()
                    ->color(fn($state) => $state->filamentColor())
                    ->formatStateUsing(fn($state) => $state->label())
                    ->hidden(!$isSubscribed),

                TextColumn::make('capacity')
                    ->label('Capacity')
                    ->badge()
                    ->color(fn($record) => self::determineColorForCapacity($record))
                    ->formatStateUsing(fn($record) => 'Capacity ' . $record->getBooking() . '/' . $record->getCapacity())
                    ->hidden(!$isSubscribed),

                TextColumn::make('session_date')
                    ->label('Date')
                    ->date()
                    ->badge()
                    ->icon(Heroicon::CalendarDays)
                    ->formatStateUsing(fn($record) => $record->getCreatedAt()?->format('M d, Y'))
                    ->hidden(!$isSubscribed),

                TextColumn::make('session_time')
                    ->label('Time')
                    ->badge()
                    ->icon(Heroicon::OutlinedClock)
                    ->formatStateUsing(fn($record) => $record->getCreatedAt()?->format('h:i A'))
                    ->hidden(!$isSubscribed),
            ])
            ->searchable(false)
            ->paginated(false);
    }

    /**
     * Determine the color for the capacity column based on usage.
     */
    protected static function determineColorForCapacity($record): string
    {
        $usage = $record->getBooking() / max($record->getCapacity(), 1);

        return match (true) {
            $usage >= 0.9 => 'danger',
            $usage >= 0.6 => 'warning',
            default => 'success',
        };
    }
}
