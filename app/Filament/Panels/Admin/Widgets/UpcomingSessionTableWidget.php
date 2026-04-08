<?php

namespace App\Filament\Panels\Admin\Widgets;

use App\Domain\Dashboard\Traits\HasFilterByDateTrait;
use App\Domain\TrainingSession\Actions\GetSessionsAction;
use App\Support\Context\UserContext;
use Carbon\Carbon;
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
    |-------------------------------
    | Layout & Sorting
    |------------------------------- 
    */
    protected int|string|array $columnSpan = 'full';
    protected static ?int $sort = 3;

    /* 
    |-------------------------------
    | Table Configuration
    |------------------------------- 
    */
    public function table(Table $table): Table
    {
        $this->getDateRange();

        $startOfWeek = $this->startDate
            ? Carbon::parse($this->startDate)->startOfWeek()->format('M d, Y')
            : Carbon::now()->startOfWeek()->format('M d, Y');

        $endOfWeek = $this->endDate
            ? Carbon::parse($this->endDate)->endOfWeek()->format('M d, Y')
            : Carbon::now()->endOfWeek()->format('M d, Y');

        return $table
            ->heading('Upcoming Sessions')
            ->description("This table shows upcoming sessions for this week: {$startOfWeek} - {$endOfWeek}")
            ->query(fn() => app(GetSessionsAction::class)->upcomingUserSessions(
                startDate: now()->startOfWeek(),
                endDate: now()->endOfWeek(),
            ))
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
                    ->color(fn($record) => self::determineColorForCapacity($record))
                    ->formatStateUsing(fn($record) => 'Capacity ' . $record->getBooking() . '/' . $record->getCapacity()),

                /* 
                |-------------------------------
                | Session Date
                |------------------------------- 
                */
                TextColumn::make('session_date')
                    ->label('Date')
                    ->date()
                    ->badge()
                    ->icon(Heroicon::CalendarDays)
                    ->formatStateUsing(fn($record) => $record->getCreatedAt()?->format('M d, Y')),

                /* 
                |-------------------------------
                | Session Time
                |------------------------------- 
                */
                TextColumn::make('session_time')
                    ->label('Time')
                    ->badge()
                    ->icon(Heroicon::OutlinedClock)
                    ->formatStateUsing(fn($record) => $record->getCreatedAt()?->format('h:i A')),
            ])
            ->searchable(false)
            ->paginated(false);
    }

    /* 
    |-------------------------------
    | Helpers
    |------------------------------- 
    */
    protected static function determineColorForCapacity($record): string
    {
        $usage = $record->getBooking() / max($record->getCapacity(), 1);

        return match (true) {
            $usage >= 0.9 => 'danger',
            $usage >= 0.6 => 'warning',
            default        => 'success',
        };
    }
}
