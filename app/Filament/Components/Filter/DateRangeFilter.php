<?php

namespace App\Filament\Components\Filter;

use Carbon\Carbon;
use CodeWithKyrian\FilamentDateRange\Forms\Components\DateRangePicker;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class DateRangeFilter
{
    public static function make(string $column = 'created_at'): Filter
    {
        return Filter::make($column)
            ->schema([
                DateRangePicker::make('daterange')
                    ->label('Select date')
                    ->startPlaceholder('Ex. Jan 01, 2020')
                    ->separator(['inline' => '→'])
                    ->singleField()
                    ->dualCalendar(false)
                    ->startPrefixIcon('heroicon-m-calendar-days')
                    ->columnSpanFull(),
            ])
            ->query(function (Builder $query, array $data) use ($column): Builder {
                return $query
                    ->when(
                        $data['daterange']['start'] ?? null,
                        fn($q) => $q->whereDate($column, '>=', $data['daterange']['start'])
                    )
                    ->when(
                        $data['daterange']['end'] ?? null,
                        fn($q) => $q->whereDate($column, '<=', $data['daterange']['end'])
                    );
            })
            ->indicateUsing(function (array $data): array {
                $indicators = [];

                if (!empty($data['daterange']['start'])) {
                    $indicators[] = 'From: ' . Carbon::parse($data['daterange']['start'])->format('d M Y');
                }

                if (!empty($data['daterange']['end'])) {
                    $indicators[] = 'To: ' . Carbon::parse($data['daterange']['end'])->format('d M Y');
                }

                return $indicators;
            });
    }
}
