<?php

namespace App\Filament\Panels\Admin\Resources\Subscriptions\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class SubscriptionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            /*
            |------------------------------------------------------------------
            | Edit Subscription
            |------------------------------------------------------------------
            */

            Section::make('Edit Subscription')
                ->schema([

                    DatePicker::make('expire_at')
                        ->label('Expire Date')
                        ->required()
                        ->displayFormat('M d, Y')
                        ->placeholder('Select expire date')
                        ->native(false),

                    DatePicker::make('next_renewal_at')
                        ->label('Next Renewal Date')
                        ->required()
                        ->displayFormat('M d, Y')
                        ->placeholder('Select renewal date')
                        ->native(false),

                    Toggle::make('is_active')
                        ->label('Active')
                        ->live()
                        ->afterStateUpdated(fn(bool $state, Set $set) => $set('is_current', $state)),

                    /*
                    |----------------------------------------------------------
                    | Hidden State
                    |----------------------------------------------------------
                    */

                    Hidden::make('is_current')
                        ->default(false)
                        ->dehydrated(),
                ])
                ->columns(2)
                ->compact()
                ->secondary()
                ->columnSpanFull(),
        ]);
    }
}
