<?php

namespace App\Filament\Panels\Admin\Resources\Sessions\Tables;

use App\Domain\TrainingSession\Models\SessionStates\SessionAvailableState;
use App\Domain\TrainingSession\Models\SessionStates\SessionFullState;
use App\Domain\TrainingSession\Models\SessionStates\SessionStates;
use App\Domain\TrainingSession\Models\TrainingSession;
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
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Components\Filter\DateRangeFilter;
use Filament\Actions\DeleteAction;
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
            ->description('Manage training sessions here.')

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

                    TextColumn::make('session_date_formatted')
                        ->label('Date')
                        ->date()
                        ->badge()
                        ->icon(Heroicon::CalendarDays),

                    TextColumn::make('session_time_formatted')
                        ->label('Time')
                        ->badge()
                        ->icon(Heroicon::OutlinedClock),
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
            ->stackedOnMobile()
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

                Group::make('created_at_formatted')
                    ->label('Created At')
                    ->date(),
            ])
            ->collapsedGroupsByDefault()

            /*
            |------------------------------------------------------------------
            | Filters
            |------------------------------------------------------------------
            */

            ->filters([
                SelectFilter::make('session_state')
                    ->label('Session State')
                    ->options(SessionStates::options())
                    ->native(false),

                DateRangeFilter::make('session_date_formatted')
                    ->label('Session Date Range'),
            ])
            ->filtersFormWidth(Width::Large)

            /*
            |------------------------------------------------------------------
            | Record Actions
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
                        ->outlined(),

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

                /*
                |-----------------------------
                | Delete
                |-----------------------------
                */

                DeleteAction::make('delete')
                    ->color(Color::Rose)
                    ->icon(Heroicon::OutlinedTrash)
                    ->button(),
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
