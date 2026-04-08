<?php

namespace App\Filament\Panels\Admin\Resources\Sessions\Tables;

use App\Domain\TrainingSession\Models\SessionStates\SessionAvailableState;
use App\Domain\TrainingSession\Models\SessionStates\SessionFullState;
use App\Domain\TrainingSession\Models\TrainingSession;
use App\Filament\Components\Filter\DateRangeFilter;
use Filament\Actions\ActionGroup;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;

class SessionsTable
{
    public static function configure(Table $table): Table
    {
        return $table

            /*
            |------------------------------------------------------------------
            | Header
            |------------------------------------------------------------------
            */

            ->heading('Training Sessions')
            ->description('Join or create training sessions here.')

            /*
            |------------------------------------------------------------------
            | Columns
            |------------------------------------------------------------------
            */

            ->columns([
                Split::make([

                    /*
                    |-----------------------------
                    | Left: Session Info
                    |-----------------------------
                    */

                    Stack::make([
                        TextColumn::make('name')
                            ->label('Session Name')
                            ->weight(FontWeight::Bold)
                            ->searchable(),
                    ]),

                    /*
                    |-----------------------------
                    | Right: Session State
                    |-----------------------------
                    */

                    TextColumn::make('session_state')
                        ->label('State')
                        ->badge()
                        ->color(fn($state) => $state->filamentColor())
                        ->formatStateUsing(fn($state) => $state->label()),
                ]),

                /*
                |-----------------------------
                | Secondary Info
                |-----------------------------
                */

                Stack::make([
                    TextColumn::make('user.full_name')
                        ->label('Created By')
                        ->color(Color::Gray)
                        ->searchable(),

                    TextColumn::make('capacity')
                        ->label('Capacity')
                        ->badge()
                        ->color(fn($record) => self::DetrmineColorForCapacity($record))
                        ->formatStateUsing(fn($record) => 'Capacity ' . $record->getBooking() . '/' . $record->getCapacity()),

                    TextColumn::make('session_date')
                        ->label('Date')
                        ->date()
                        ->badge()
                        ->icon(Heroicon::CalendarDays)
                        ->formatStateUsing(fn($record) => $record->getSessionDate()?->format('M d, Y')),

                    TextColumn::make('session_time')
                        ->label('Time')
                        ->badge()
                        ->icon(Heroicon::OutlinedClock)
                        ->formatStateUsing(fn($record) => $record->getSessionTime()),
                ])->space(3),

                /*
                |-----------------------------
                | Collapsible Details
                |-----------------------------
                */

                Panel::make([
                    TextColumn::make('user.full_name')
                        ->badge(),
                ])->collapsible(),
            ])

            /*
            |------------------------------------------------------------------
            | Layout
            |------------------------------------------------------------------
            */

            ->contentGrid([
                'md' => 2,
                'xl' => 3,
            ])

            /*
            |------------------------------------------------------------------
            | Table Options
            |------------------------------------------------------------------
            */

            ->deferLoading()
            ->searchable(false)

            /*
            |------------------------------------------------------------------
            | Grouping
            |------------------------------------------------------------------
            */

            ->groups([
                Group::make('is_active')
                    ->label('Active Status')
                    ->titlePrefixedWithLabel(false)
                    ->getTitleFromRecordUsing(
                        fn($state) => $state ? 'Active' : 'Inactive'
                    ),

                Group::make('session_state')
                    ->label('Session State')
                    ->titlePrefixedWithLabel(false),

                Group::make('created_at')
                    ->date(),
            ])
            ->collapsedGroupsByDefault()

            /*
            |------------------------------------------------------------------
            | Filters
            |------------------------------------------------------------------
            */

            ->filters([
                DateRangeFilter::make('session_date')
                    ->label('Session Date Range'),
            ])
            ->filtersFormWidth(Width::Large)

            /*
            |------------------------------------------------------------------
            | Actions
            |------------------------------------------------------------------
            */

            ->recordActions([
                ActionGroup::make([

                    /*
                    |-----------------------------
                    | Book Session
                    |-----------------------------
                    */

                    EditAction::make('edit_session')
                        ->label('Edit Session')
                        ->icon(Heroicon::PencilSquare)
                        ->button(),

                    /*
                    |-----------------------------
                    | View Details
                    |-----------------------------
                    */

                    ViewAction::make('view_session')
                        ->label('Details')
                        ->icon(Heroicon::OutlinedEye)
                        ->outlined(),
                ])
                    ->buttonGroup(),
            ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    private static function DetrmineColorForCapacity(TrainingSession $session): array
    {
        if ($session->getCapacity() === $session->getBooking()) {
            return SessionFullState::filamentColor();
        }

        return SessionAvailableState::filamentColor();
    }
}
