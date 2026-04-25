<?php

namespace App\Filament\Panels\Admin\Resources\Users\Tables;

use App\Domain\Plan\Actions\GetPlanByIdAction;
use App\Domain\Plan\Actions\GetPlansAction;
use App\Domain\Subscription\Actions\SubscribeToPlanAction;
use App\Domain\Subscription\Actions\UpdateSubscriptionStateAction;
use App\Domain\Subscription\Dtos\SubscriptionDto;
use App\Domain\Subscription\Enums\PaymentMethodEnum;
use App\Domain\Subscription\Models\States\SubscriptionStates\SubscriptionApprovedState;
use App\Domain\User\Models\User;
use App\Filament\Components\Button\GroupedActionsButton;
use App\Filament\Components\Filter\DateRangeFilter;
use App\Filament\Components\Notification\CustomNotification;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Section;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table

            /*
            |------------------------------------------------------------------
            | Header
            |------------------------------------------------------------------
            */

            ->heading('Users')
            ->description('Manage your users here.')

            /*
            |------------------------------------------------------------------
            | Columns
            |------------------------------------------------------------------
            */

            ->columns(self::columns())

            /*
            |------------------------------------------------------------------
            | Table Options
            |------------------------------------------------------------------
            */

            ->deferLoading()
            ->stackedOnMobile()
            ->searchPlaceholder('Search (Full Name, Email, Phone)')

            /*
            |------------------------------------------------------------------
            | Grouping
            |------------------------------------------------------------------
            */

            ->groups(self::groups())
            ->collapsedGroupsByDefault()

            /*
            |------------------------------------------------------------------
            | Filters
            |------------------------------------------------------------------
            */

            ->filters([DateRangeFilter::make()])
            ->filtersFormWidth(Width::Large)

            /*
            |------------------------------------------------------------------
            | Record Actions
            |------------------------------------------------------------------
            */

            ->recordActions(GroupedActionsButton::actions(extraActions: [self::addUserSubscription()]))

            /*
            |------------------------------------------------------------------
            | Toolbar Actions
            |------------------------------------------------------------------
            */

            ->toolbarActions([
                BulkActionGroup::make([DeleteBulkAction::make()]),
            ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Columns
    |--------------------------------------------------------------------------
    */

    private static function columns(): array
    {
        return [

            TextColumn::make('full_name')
                ->label('Name')
                ->description(fn($record) => $record->getEmail())
                ->weight(FontWeight::Bold)
                ->searchable(['first_name', 'last_name', 'email']),

            TextColumn::make('phone')
                ->label('Phone')
                ->placeholder('No phone')
                ->searchable(),

            TextColumn::make('age')
                ->label('Age')
                ->badge()
                ->color(Color::Gray)
                ->placeholder('N/A'),

            TextColumn::make('gender')
                ->label('Gender')
                ->badge()
                ->color(fn($state) => $state->filamentColor())
                ->formatStateUsing(fn($state) => $state->label())
                ->placeholder('N/A'),

            TextColumn::make('activeSubscription.plan.name')
                ->label('Current Plan')
                ->color(Color::Gray)
                ->placeholder('No active plan'),

            IconColumn::make('is_email_verified')
                ->label('Email Verified')
                ->trueIcon(Heroicon::OutlinedCheckCircle)
                ->falseIcon(Heroicon::OutlinedXCircle)
                ->toggleable()
                ->toggledHiddenByDefault(),

            TextColumn::make('created_at_formatted')
                ->label('Created At')
                ->badge()
                ->color(Color::Gray)
                ->toggleable()
                ->toggledHiddenByDefault(),

            ToggleColumn::make('is_active')
                ->label('Active')
                ->toggleable()
                ->toggledHiddenByDefault(),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Groups
    |--------------------------------------------------------------------------
    */

    private static function groups(): array
    {
        return [
            Group::make('is_active')
                ->label('Active')
                ->titlePrefixedWithLabel(false)
                ->getTitleFromRecordUsing(fn($record) => $record->isActive() ? 'Active' : 'Inactive'),

            Group::make('email_verified_at')
                ->label('Email Verified')
                ->titlePrefixedWithLabel(false)
                ->getTitleFromRecordUsing(fn($record) => $record->hasVerifiedEmail() ? 'Verified' : 'Not Verified'),

            Group::make('created_at')
                ->label('Created At')
                ->date(),

            Group::make('gender')
                ->getTitleFromRecordUsing(fn($record) => $record->getGender()->label()),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Add subscription to user action
    |--------------------------------------------------------------------------
    */

    private static function addUserSubscription(): Action
    {
        return Action::make('add_user_subscription')
            ->label('Add Subscription')
            ->icon(Heroicon::OutlinedClock)
            ->hidden(fn(User $record) => $record->hasActiveSubscription())

            /*
            |------------------------------------------------------------------
            | Default Form Data
            |------------------------------------------------------------------
            */

            ->fillForm(fn(User $record): array => [
                'user_name' => $record->getFullName(),
            ])

            /*
            |------------------------------------------------------------------
            | Form Schema
            |------------------------------------------------------------------
            */

            ->schema([
                Section::make()
                    ->schema([

                        TextInput::make('user_name')
                            ->label('User')
                            ->disabled()
                            ->dehydrated(false),


                        Select::make('plan_id')
                            ->label('Plan')
                            ->options(app(GetPlansAction::class)->options())
                            ->required()
                            ->native(false),

                        TextInput::make('used_sessions')
                            ->label('Used Sessions')
                            ->numeric()
                            ->required()
                            ->default(0),

                        FileUpload::make('payment_proof')
                            ->label('Payment Proof')
                            ->nullable()
                            ->image()
                            ->maxSize(2048)
                            ->disk('public')
                            ->directory('payment-proofs')
                            ->visibility('public'),

                        TextInput::make('amount')
                            ->label('Amount')
                            ->numeric()
                            ->required()
                            ->suffix('EGP'),

                        ToggleButtons::make('payment_method')
                            ->label('Payment Method')
                            ->required()
                            ->options(PaymentMethodEnum::options())
                            ->colors(PaymentMethodEnum::colorOptions())
                            ->inline(),

                        DatePicker::make('expire_at')
                            ->label('Expire Date')
                            ->required()
                            ->displayFormat('M d, Y')
                            ->placeholder('Select expire date')
                            ->native(false),
                    ])
                    ->columns(1)
                    ->contained(false),
            ])

            /*
            |------------------------------------------------------------------
            | Submit Action
            |------------------------------------------------------------------
            */

            ->action(fn(User $record, array $data) => self::handleAddSubscription($record, $data))
            ->modalSubmitActionLabel('Submit');
    }

    /*
    |--------------------------------------------------------------------------
    | Handlers
    |--------------------------------------------------------------------------
    */

    private static function handleAddSubscription(User $record, array $data): void
    {
        if ($record->hasActiveSubscription()) {
            CustomNotification::warning(
                title: 'Action cannot be completed',
                description: 'User already has an active subscription.',
            );
            return;
        }

        $plan = app(GetPlanByIdAction::class)->execute($data['plan_id']);

        $subscription = app(SubscribeToPlanAction::class)->execute(
            new SubscriptionDto(
                amount: $data['amount'],
                paymentMethod: $data['payment_method'],
                totalSessions: $plan->getNoOfSession(),
                usedSessions: $data['used_sessions'],
                nextRenewalDate: Carbon::parse($data['expire_at'])->addDay(),
                expireDate: $data['expire_at'],
                imagePath: $data['payment_proof'],
                isAdminCreated: true,
                planId: $plan->getId(),
                userId: $record->getId(),
            )
        );

        app(UpdateSubscriptionStateAction::class)
            ->execute($subscription, SubscriptionApprovedState::value());

        /*
        |-----------------------------------
        | Success Notification
        |-----------------------------------
        */

        CustomNotification::success(
            title: "Subscription added successfully to {$record->getFullName()}.",
        );
    }
}
