<?php

namespace App\Filament\Panels\Admin\Resources\Subscriptions\Schemas;

use App\Domain\Plan\Actions\GetPlansAction;
use App\Domain\Subscription\Enums\PaymentMethodEnum;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ToggleButtons;
use Filament\Infolists\Components\TextEntry;
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

            Section::make()
                ->schema([

                    TextEntry::make('user.full_name')
                        ->label('Username')
                        ->badge(),

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

                    SpatieMediaLibraryFileUpload::make('payment_proof')
                        ->label('Payment Proof')
                        ->collection('payment_proofs')
                        ->nullable()
                        ->image()
                        ->maxSize(2048),

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
                ->columnSpanFull()
                ->secondary()
                ->contained(false),
        ]);
    }
}
