<?php

namespace App\Filament\Panels\Admin\Resources\Subscriptions\Schemas;

use App\Domain\Subscription\Actions\UpdateSubscriptionStateAction;
use App\Domain\Subscription\Models\States\SubscriptionStates\SubscriptionApprovedState;
use App\Domain\Subscription\Models\States\SubscriptionStates\SubscriptionRejectedState;
use App\Domain\Subscription\Models\Subscription;
use App\Filament\Components\Notification\CustomNotification;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\SpatieMediaLibraryImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;

class SubscriptionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Tabs::make('Subscription')
                ->tabs([
                    self::subscriptionTab(),
                    self::planTab(),
                ])
                ->columnSpanFull(),
        ]);
    }

    /*
    |------------------------------------------------------------------
    | Subscription Info
    |------------------------------------------------------------------
    */
    private static function subscriptionTab(): Tab
    {
        return Tab::make('Subscription')
            ->icon(Heroicon::OutlinedCreditCard)
            ->schema([

                Section::make('Subscription Details')
                    ->footerActions(self::paymentProofsAction())
                    ->schema([

                        /*
                        |-----------------------------
                        | Basic Info
                        |-----------------------------
                        */

                        ImageEntry::make('image')
                            ->label('Payment Proof')
                            ->belowLabel('Click on image to view on new tab')
                            ->imageSize(200)
                            ->url(fn($state) => $state, true)
                            ->columnSpanFull(),

                        TextEntry::make('uuid')
                            ->label('Reference')
                            ->badge()
                            ->color(Color::Orange)
                            ->copyable(),

                        TextEntry::make('amount')
                            ->money('EGP')
                            ->badge(),

                        TextEntry::make('payment_method')
                            ->badge()
                            ->color(fn($state) => $state->color())
                            ->formatStateUsing(fn($state) => $state->label()),

                        TextEntry::make('subscription_state')
                            ->label('Payment Status')
                            ->badge()
                            ->color(fn($state) => $state->filamentColor())
                            ->formatStateUsing(fn($state) => $state->label()),

                        /*
                        |-----------------------------
                        | Dates
                        |-----------------------------
                        */

                        Section::make()
                            ->schema([
                                TextEntry::make('next_renewal_at')
                                    ->label('Next Renewal At')
                                    ->badge()
                                    ->color(Color::Gray)
                                    ->formatStateUsing(fn($state) => $state?->format('d M Y, h:i A'))
                                    ->placeholder('N/A'),

                                TextEntry::make('expire_at')
                                    ->label('Expired At')
                                    ->badge()
                                    ->color(Color::Gray)
                                    ->formatStateUsing(fn($state) => $state?->format('d M Y, h:i A'))
                                    ->placeholder('N/A'),

                                TextEntry::make('created_at')
                                    ->label('Subscribed At')
                                    ->badge()
                                    ->color(Color::Gray)
                                    ->formatStateUsing(fn($state) => $state?->format('d M Y, h:i A')),
                            ])
                            ->columnSpanFull()
                            ->columns(3)
                            ->compact()
                            ->secondary(),

                    ])
                    ->columns(2)
                    ->compact()
                    ->secondary(),
            ]);
    }

    /*
    |------------------------------------------------------------------
    | Plan Info
    |------------------------------------------------------------------
    */
    private static function planTab(): Tab
    {
        return Tab::make('Plan')
            ->icon(Heroicon::Bars3BottomLeft)
            ->schema([
                Section::make()
                    ->relationship('plan')
                    ->schema([

                        /*
                        |-----------------------------
                        | Plan Information
                        |-----------------------------
                        */

                        Section::make('Plan Information')
                            ->schema([
                                TextEntry::make('name')
                                    ->label('Plan Name')
                                    ->weight('bold'),

                                Section::make('Description')
                                    ->schema([
                                        TextEntry::make('description')
                                            ->hiddenLabel()
                                            ->placeholder('No description'),
                                    ])
                                    ->columnSpanFull()
                                    ->compact()
                                    ->secondary(),

                                TextEntry::make('no_of_sessions')
                                    ->label('Number of Sessions')
                                    ->badge(),

                                TextEntry::make('price')
                                    ->label('Price')
                                    ->badge()
                                    ->money('EGP', locale: 'ln'),
                            ])
                            ->columns(2)
                            ->compact()
                            ->secondary(),

                        /*
                        |-----------------------------
                        | Plan Includes
                        |-----------------------------
                        */

                        Section::make('Plan Includes')
                            ->schema([
                                TextEntry::make('includes')
                                    ->hiddenLabel()
                                    ->formatStateUsing(
                                        fn($state) => is_array($state)
                                            ? implode(', ', $state)
                                            : $state
                                    )
                                    ->bulleted(),
                            ])
                            ->compact()
                            ->secondary()
                            ->collapsible(),
                    ])
                    ->columnSpanFull()
                    ->contained(false),
            ]);
    }

    /*
    |------------------------------------------------------------------
    | Actions 
    |------------------------------------------------------------------
    */

    private static function paymentProofsAction(): array
    {
        return [
            /*
            |-----------------------------
            | Accept Payment
            |-----------------------------
            */
            Action::make('accept_payment')
                ->label('Accept')
                ->visible(fn($record) => $record->isPending())
                ->requiresConfirmation()
                ->action(fn($record) => self::handleUpdatePayment(
                    $record,
                    SubscriptionApprovedState::value()
                )),

            /*
            |-----------------------------
            | Reject Payment
            |-----------------------------
            */
            Action::make('reject_payment')
                ->label('Reject')
                ->color(Color::Rose)
                ->visible(fn($record) => $record->isPending())
                ->requiresConfirmation()
                ->action(fn($record) => self::handleUpdatePayment(
                    $record,
                    SubscriptionRejectedState::value()
                )),
        ];
    }

    /*
    |------------------------------------------------------------------
    | Actions Handlers
    |------------------------------------------------------------------
    */
    private static function handleUpdatePayment(Subscription $subscription, string $state): void
    {
        app(UpdateSubscriptionStateAction::class)->execute($subscription, $state);

        $stateLabel = match ($state) {
            SubscriptionApprovedState::value() => SubscriptionApprovedState::label(),
            SubscriptionRejectedState::value() => SubscriptionRejectedState::label(),
            default => 'Updated',
        };

        CustomNotification::success(
            title: "Subscription {$stateLabel} successfully"
        );
    }
}
