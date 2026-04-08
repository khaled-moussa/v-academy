<?php

namespace App\Filament\Panels\User\Resources\Subscriptions\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Fieldset;
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
    |-----------------------------------
    | Subscription Info
    |-----------------------------------
    */

    private static function subscriptionTab(): Tab
    {
        return Tab::make('Subscription')
            ->icon(Heroicon::OutlinedCreditCard)
            ->schema([
                Section::make('Subscription Details')
                    ->schema([

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
                            ->label('State')
                            ->badge()
                            ->color(fn($state) => $state->filamentColor())
                            ->formatStateUsing(fn($state) => $state->label()),

                        TextEntry::make('created_at')
                            ->label('Subscribed At')
                            ->dateTime()
                            ->color(Color::Gray),

                    ])
                    ->columns(2)
                    ->compact()
                    ->secondary(),
            ]);
    }

    /*
    |-----------------------------------
    | Plan Info
    |-----------------------------------
    */

    private static function planTab(): Tab
    {
        return Tab::make('Plan')
            ->icon(Heroicon::OutlinedClipboardDocumentList)
            ->schema([
                Section::make('Plan Details')
                    ->relationship('plan')
                    ->schema([

                        TextEntry::make('name')
                            ->label('Plan Name')
                            ->badge(),

                        TextEntry::make('price')
                            ->money('EGP')
                            ->badge()
                            ->color(Color::Orange),

                        TextEntry::make('no_of_sessions')
                            ->label('Sessions')
                            ->badge(),

                        Fieldset::make()
                            ->label('Description')
                            ->schema([
                                TextEntry::make('description')
                                    ->hiddenLabel()
                                    ->placeholder('No description')
                                    ->columnSpanFull(),
                            ])
                            ->columnSpanFull(),

                        TextEntry::make('includes')
                            ->formatStateUsing(
                                fn($state) => is_array($state)
                                    ? implode(', ', $state)
                                    : $state
                            )
                            ->bulleted()
                            ->hidden(fn($state) => empty($state))
                            ->columnSpanFull(),

                    ])
                    ->columns(2)
                    ->compact()
                    ->secondary(),
            ]);
    }
}
