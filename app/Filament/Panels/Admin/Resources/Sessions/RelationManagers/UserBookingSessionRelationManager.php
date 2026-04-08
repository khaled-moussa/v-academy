<?php

namespace App\Filament\Panels\Admin\Resources\Sessions\RelationManagers;

use App\Domain\Subscription\Actions\UpdateSubscriptionUsageSessionsAction;
use App\Domain\User\Models\User;
use App\Filament\Components\Button\GroupedActionsButton;
use App\Filament\Components\Notification\CustomNotification;
use App\Filament\Panels\Admin\Resources\Users\UserResource;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Table;

class UserBookingSessionRelationManager extends RelationManager
{
    protected static string $relationship = 'userBooking';

    protected static ?string $relatedResource = UserResource::class;

    public function infolist(Schema $schema): Schema
    {
        return UserResource::infolist($schema);
    }

    public function table(Table $table): Table
    {
        return UserResource::table($table)
            /* 
            |-------------------------------
            | Filters
            |-------------------------------
            */
            ->recordActionsAlignment('start')
            ->pushColumns([
                CheckboxColumn::make('attendance')
                    ->label('Attendance')
                    ->state(fn($record) => $record->pivot->getAttendance())
                    ->afterStateUpdated(fn($record, $state) => self::handleAttendedUser($record, $state)),
            ])

            /* 
            |-------------------------------
            | Filters
            |-------------------------------
            */
            ->filters([])

            /* 
            |-------------------------------
            | Record Actions
            |-------------------------------
            */
            ->recordActions(GroupedActionsButton::actions(
                canEdit: false,
                canDelete: false
            ));
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    private static function handleAttendedUser(User $user, bool $state): void
    {
        if (! $user->hasActiveSubscription()) {
            return;
        }

        app(UpdateSubscriptionUsageSessionsAction::class)
            ->execute($user->activeSubscription, $state);

        if ($state) {
            CustomNotification::success(title: "{$user->getFullName()} marked as attended successfully");

            return;
        }

        CustomNotification::warning(
            title: "{$user->getFullName()} attendance has been removed"
        );
    }
}
