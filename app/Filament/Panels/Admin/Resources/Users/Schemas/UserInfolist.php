<?php

namespace App\Filament\Panels\Admin\Resources\Users\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\RepeatableEntry\TableColumn;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Icons\Heroicon;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Tabs::make('User Overview')
                ->tabs([
                    self::userInfoTab(),
                    self::nutrationPlanTab(),
                    self::subscriptionTab(),
                ])
                ->columnSpanFull(),
        ]);
    }

    /*
    |------------------------------------------------------------------
    | User Info Tab
    |------------------------------------------------------------------
    */

    private static function userInfoTab(): Tab
    {
        return Tab::make('User Info')
            ->icon(Heroicon::OutlinedUser)
            ->schema([

                /* 
                |-------------------------------
                | Header
                |------------------------------- 
                */

                Section::make()
                    ->schema([
                        TextEntry::make('uuid')
                            ->label('Reference')
                            ->badge()
                            ->color(Color::Orange)
                            ->copyable(),

                        TextEntry::make('full_name')
                            ->label('Full Name')
                            ->weight(FontWeight::SemiBold),

                        TextEntry::make('age')
                            ->badge()
                            ->placeholder('N/A'),

                        TextEntry::make('gender')
                            ->badge()
                            ->formatStateUsing(fn($state) => $state->label())
                            ->color(fn($state) => $state->filamentColor()),

                        TextEntry::make('address')
                            ->icon(Heroicon::OutlinedMapPin)
                            ->placeholder('No address'),

                        TextEntry::make('created_at_formatted')
                            ->label('Member Since')
                            ->badge()
                            ->color(Color::Gray),
                    ])
                    ->columns(2)
                    ->secondary()
                    ->compact(),

                /* 
                |-------------------------------
                | Notes
                |------------------------------- 
                */

                Section::make('Notes')
                    ->schema([
                        TextEntry::make('notes')
                            ->hiddenLabel()
                            ->placeholder('No notes')
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull()
                    ->compact()
                    ->secondary(),

                /* 
                |-------------------------------
                | Contact
                |------------------------------- 
                */

                Section::make('Contact')
                    ->schema([
                        TextEntry::make('phone')
                            ->icon(Heroicon::OutlinedPhone)
                            ->copyable()
                            ->placeholder('No phone'),

                        TextEntry::make('email')
                            ->icon(Heroicon::OutlinedEnvelope)
                            ->copyable(),
                    ])
                    ->columns(2)
                    ->compact()
                    ->secondary(),

                /* 
                |-------------------------------
                | Status
                |------------------------------- 
                */

                Section::make('Status')
                    ->schema([
                        IconEntry::make('is_email_verified')
                            ->label('Email Verified')
                            ->boolean(),

                        IconEntry::make('is_active')
                            ->label('Active')
                            ->boolean(),
                    ])
                    ->columns(2)
                    ->compact()
                    ->secondary()
                    ->collapsible(),
            ]);
    }

    /*
    |------------------------------------------------------------------
    | Nutration Plan Tab
    |------------------------------------------------------------------
    */

    public static function nutrationPlanTab(): Tab

    {
        return Tab::make('Nutration Plan')
            ->icon(Heroicon::TableCells)
            ->schema([

                /* 
                |-------------------------------
                | Other Subscriptions
                |------------------------------- 
                */

                RepeatableEntry::make('nutrationPlans')
                    ->hiddenLabel()

                    ->schema([
                        Section::make(fn($record) => $record?->getMeal())
                            ->schema([
                                TextEntry::make('saturday')
                                    ->color(Color::Gray)
                                    ->label('Sat'),

                                TextEntry::make('sunday')
                                    ->color(Color::Gray)
                                    ->label('Sun'),

                                TextEntry::make('monday')
                                    ->color(Color::Gray)
                                    ->label('Mon'),

                                TextEntry::make('tuesday')
                                    ->color(Color::Gray)
                                    ->label('Tue'),

                                TextEntry::make('wednesday')
                                    ->color(Color::Gray)
                                    ->label('Wed'),

                                TextEntry::make('thursday')
                                    ->color(Color::Gray)
                                    ->label('Thu'),

                                TextEntry::make('friday')
                                    ->color(Color::Gray)
                                    ->label('Fri'),
                            ])
                            ->columns(2)
                            ->compact()
                            ->secondary()
                            ->collapsible(),

                    ])
                    ->placeholder('No nutration plan')
                    ->contained(false),
            ]);
    }

    /*
    |------------------------------------------------------------------
    | Subscription Tab
    |------------------------------------------------------------------
    */

    public static function subscriptionTab(): Tab
    {
        return Tab::make('Subscription')
            ->icon(Heroicon::OutlinedCreditCard)
            ->schema([

                /* 
                |-------------------------------
                | Active Subscription
                |------------------------------- 
                */

                Section::make('Active Subscription')
                    ->relationship('activeSubscription')
                    ->afterHeader([
                        TextEntry::make('active_subscription')
                            ->state('Active')
                            ->hiddenLabel()
                            ->badge()
                            ->color(Color::Green)
                            ->hidden(fn($record) => is_null($record)),
                    ])
                    ->schema(self::subscriptionSchema())
                    ->columns(2)
                    ->compact()
                    ->secondary(),

                /* 
                |-------------------------------
                | Other Subscriptions
                |------------------------------- 
                */

                RepeatableEntry::make('inActiveSubscriptions')
                    ->hiddenLabel()
                    ->schema([
                        Section::make('Subscription Details')
                            ->schema(self::subscriptionSchema())
                            ->columns(2)
                            ->compact()
                            ->secondary(),
                    ])
                    ->contained(false),
            ]);
    }

    /*
    |------------------------------------------------------------------
    | Shared Subscription Schema
    |------------------------------------------------------------------
    */

    private static function subscriptionSchema(): array
    {
        return [

            /* 
            |-------------------------------
            | Basic Info
            |------------------------------- 
            */

            TextEntry::make('uuid')
                ->label('Reference')
                ->badge()
                ->color(Color::Orange)
                ->copyable()
                ->placeholder('N/A'),

            TextEntry::make('amount')
                ->money('EGP', locale: 'nl')
                ->badge()
                ->placeholder('N/A'),

            TextEntry::make('payment_method')
                ->badge()
                ->color(fn($state) => $state->color())
                ->formatStateUsing(fn($state) => $state->label())
                ->placeholder('N/A'),

            TextEntry::make('subscription_state')
                ->label('Payment Status')
                ->badge()
                ->color(fn($state) => $state->filamentColor())
                ->formatStateUsing(fn($state) => $state->label())
                ->placeholder('N/A'),

            /* 
            |-------------------------------
            | Dates
            |------------------------------- 
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

                    TextEntry::make('created_at_formatted')
                        ->label('Subscribed At')
                        ->badge()
                        ->color(Color::Gray)
                        ->placeholder('N/A'),
                ])
                ->columns(3)
                ->columnSpanFull()
                ->compact()
                ->secondary(),
        ];
    }
}
