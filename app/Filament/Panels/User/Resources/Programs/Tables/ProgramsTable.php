<?php

namespace App\Filament\Panels\User\Resources\Programs\Tables;

use App\Support\Context\AuthContext;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProgramsTable
{
    public static function configure(Table $table): Table
    {
        return $table

            /*
            |------------------------------------------------------------------
            | Header
            |------------------------------------------------------------------
            */

            ->heading('Programs')
            ->description('Manage programs here.')

            /*
            |------------------------------------------------------------------
            | Columns
            |------------------------------------------------------------------
            */

            ->columns(self::columns())

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
            ->searchPlaceholder('Search by title')

            /*
            |------------------------------------------------------------------
            | Record Actions
            |------------------------------------------------------------------
            */

            ->recordActions(self::actions());
    }

    /*
    |--------------------------------------------------------------------------
    | Columns
    |--------------------------------------------------------------------------
    */

    private static function columns(): array
    {
        return [
            Split::make([

                Stack::make([
                    TextColumn::make('name')
                        ->label('Program Name')
                        ->weight(FontWeight::Bold)
                        ->searchable()
                        ->placeholder('No program name'),
                ]),
            ]),

            Stack::make([
                ImageColumn::make('cover')
                    ->size(300)
                    ->extraAttributes(['class' => 'mt-3']),
            ]),

            Panel::make([
                TextColumn::make('description')
                    ->placeholder('No description'),
            ])->collapsible(),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Actions
    |--------------------------------------------------------------------------
    */

    private static function actions(): array
    {
        return [
            ActionGroup::make([

                Action::make('subscribe')
                    ->label('Subscribe Now')
                    ->icon(Heroicon::OutlinedCreditCard)
                    ->visible(fn() => self::shouldShowSubscribe())
                    ->url(route('filament.user.pages.explore-plans'))
                    ->outlined(),

                ViewAction::make('view')
                    ->label('View')
                    ->icon(Heroicon::OutlinedEye)
                    ->outlined()
                    ->hidden(fn() => self::shouldShowSubscribe()),
            ])->buttonGroup(),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Visibility Helpers
    |--------------------------------------------------------------------------
    */

    private static function shouldShowSubscribe(): bool
    {
        return ! AuthContext::hasActiveSubscription();
    }
}
