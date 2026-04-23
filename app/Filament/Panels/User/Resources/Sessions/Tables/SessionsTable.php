<?php

namespace App\Filament\Panels\User\Resources\Sessions\Tables;

use App\Domain\TrainingSession\Actions\BookSessionAction;
use App\Domain\TrainingSession\Actions\CancelSessionAction;
use App\Domain\TrainingSession\Actions\CheckIsUserBookedSession;
use App\Domain\TrainingSession\Models\SessionStates\SessionAvailableState;
use App\Domain\TrainingSession\Models\SessionStates\SessionCanceledState;
use App\Domain\TrainingSession\Models\SessionStates\SessionFullState;
use App\Domain\TrainingSession\Models\SessionStates\SessionScheduledState;
use App\Domain\TrainingSession\Models\SessionStates\SessionStates;
use App\Domain\TrainingSession\Models\TrainingSession;
use App\Filament\Components\Filter\DateRangeFilter;
use App\Filament\Components\Notification\CustomNotification;
use App\Support\Context\AuthContext;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
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
            |-----------------------------------------------------------------
            | Columns
            |-----------------------------------------------------------------
            */

            ->columns([
                Split::make([

                    /* 
                    |-------------------------------
                    | Left: Session Info
                    |-------------------------------
                    */
                    Stack::make([
                        TextColumn::make('name')
                            ->label('Session Name')
                            ->weight(FontWeight::Bold)
                            ->searchable(),
                    ]),

                    /* 
                    |-------------------------------
                    | Right: Session State
                    |-------------------------------
                    */

                    TextColumn::make('session_state')
                        ->label('State')
                        ->badge()
                        ->color(fn($state) => $state->filamentColor())
                        ->formatStateUsing(fn($state) => $state->label()),
                ]),

                /* 
                |-------------------------------
                | Secondary Info
                |-------------------------------
                */

                Stack::make([
                    TextColumn::make('user.full_name')
                        ->label('Created By')
                        ->color(Color::Gray)
                        ->searchable(),

                    TextColumn::make('capacity')
                        ->label('Capacity')
                        ->badge()
                        ->color(fn($record) => self::determineCapacityColor($record))
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
                        ->time()
                        ->badge()
                        ->icon(Heroicon::OutlinedClock),
                ])->space(3),

                /* 
                |-------------------------------
                | Collapsible Details
                |-------------------------------
                */

                Panel::make([
                    TextColumn::make('user.full_name')->badge(),
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
            |-----------------------------------------------------------------
            | Table Options
            |-----------------------------------------------------------------
            */

            ->deferLoading()
            ->stackedOnMobile()
            ->searchable(false)

            /*
            |------------------------------------------------------------------
            | Groupping
            |------------------------------------------------------------------
            */

            ->groups([
                Group::make('is_active')
                    ->label('Active Status')
                    ->titlePrefixedWithLabel(false)
                    ->getTitleFromRecordUsing(fn($state) => $state ? 'Active' : 'Inactive'),

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
                    |-------------------------------
                    | Subscribe
                    |-------------------------------
                    */

                    Action::make('subscribe')
                        ->label('Subscribe Now')
                        ->icon(Heroicon::OutlinedCreditCard)
                        ->visible(fn() => self::shouldShowSubscribe())
                        ->url(route('filament.user.pages.explore-plans'))
                        ->button(),

                    /* 
                    |-------------------------------
                    | Book Session
                    |-------------------------------
                    */

                    Action::make('book_session')
                        ->label('Book Session')
                        ->icon(Heroicon::Plus)
                        ->button()
                        ->hidden(fn($record) => self::shouldHideBook($record))
                        ->action(fn($record) => self::handleBookingSession($record))
                        ->rateLimit(3),

                    /* 
                    |-------------------------------
                    | Cancel Session
                    |-------------------------------
                    */

                    Action::make('cancel_session')
                        ->label('Cancel Session')
                        ->icon(Heroicon::XMark)
                        ->color(Color::Rose)
                        ->button()
                        ->hidden(fn($record) => self::shouldHideCancel($record))
                        ->action(fn($record) => self::handleCanceledSession($record))
                        ->rateLimit(3),

                    /* 
                    |-------------------------------
                    | View Details
                    |-------------------------------
                    */

                    ViewAction::make('details')
                        ->label('Details')
                        ->icon(Heroicon::OutlinedEye)
                        ->outlined()
                        ->hidden(fn() => self::shouldShowSubscribe()),
                ])->buttonGroup(),
            ]);
    }

    /* 
    |-------------------------------------------------------------------------
    | Action Visibility Helpers
    |-------------------------------------------------------------------------
    */

    private static function shouldShowSubscribe(): bool
    {
        return ! AuthContext::hasActiveSubscription();
    }

    private static function shouldHideBook(TrainingSession $session): bool
    {
        return
            self::shouldShowSubscribe() ||
            self::isUserBookedThisSession($session) ||
            self::isSessionLocked($session);
    }

    private static function shouldHideCancel(TrainingSession $session): bool
    {
        return
            self::shouldShowSubscribe() ||
            !self::isUserBookedThisSession($session) ||
            self::isSessionLocked($session);
    }

    /* 
    |-------------------------------------------------------------------------
    | Action Handlers
    |-------------------------------------------------------------------------
    */

    private static function handleBookingSession(TrainingSession $session): void
    {
        app(BookSessionAction::class)->execute(
            AuthContext::user(),
            $session
        );

        CustomNotification::success(title: 'Session booked successfully');
    }

    private static function handleCanceledSession(TrainingSession $session): void
    {
        app(CancelSessionAction::class)->execute(
            AuthContext::user(),
            $session
        );

        CustomNotification::success(title: 'Your session is canceled');
    }

    /* 
    |-------------------------------------------------------------------------
    | Helpers
    |-------------------------------------------------------------------------
    */

    private static function isSessionLocked(TrainingSession $session): bool
    {
        $state = $session->getSessionState()::class;

        return in_array($state, [
            SessionScheduledState::class,
            SessionCanceledState::class,
        ]);
    }

    private static function isUserBookedThisSession(TrainingSession $session): bool
    {
        return app(CheckIsUserBookedSession::class)
            ->execute(AuthContext::user(), $session);
    }

    private static function determineCapacityColor(TrainingSession $session): array
    {
        if ($session->getCapacity() === $session->getBooking()) {
            return SessionFullState::filamentColor();
        }

        return SessionAvailableState::filamentColor();
    }
}
