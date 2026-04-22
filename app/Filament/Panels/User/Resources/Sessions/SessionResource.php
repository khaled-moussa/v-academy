<?php

namespace App\Filament\Panels\User\Resources\Sessions;

use App\Domain\TrainingSession\Models\SessionStates\SessionAvailableState;
use App\Domain\TrainingSession\Models\TrainingSession;
use App\Filament\Panels\User\Resources\Sessions\Pages\ListSessions;
use App\Filament\Panels\User\Resources\Sessions\Schemas\SessionForm;
use App\Filament\Panels\User\Resources\Sessions\Schemas\SessionInfolist;
use App\Filament\Panels\User\Resources\Sessions\Tables\SessionsTable;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use BackedEnum;
use Illuminate\Database\Eloquent\Builder;

class SessionResource extends Resource
{
    /* 
    |---------------------------------
    | Resource Configuration
    |---------------------------------
    */

    protected static ?string $model = TrainingSession::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendar;

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'name';

    /* 
    |---------------------------------
    | Eloquent Query 
    |---------------------------------
    */

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest();
    }

    /* 
    |---------------------------------
    | Navigation Labels
    |---------------------------------
    */

    public static function getNavigationLabel(): string
    {
        return 'Sessions';
    }

    public static function getModelLabel(): string
    {
        return 'Session';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Sessions';
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) self::$model::available()->count() . ' ' . SessionAvailableState::label();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return SessionAvailableState::filamentColorClass();
    }

    /* 
    |---------------------------------
    | Form & Infolist & Table
    |---------------------------------
    */

    public static function form(Schema $schema): Schema
    {
        return SessionForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return SessionInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SessionsTable::configure($table);
    }

    /* 
    |----------------------------------
    | Relations
    |----------------------------------
    */

    public static function getRelations(): array
    {
        return [];
    }

    /* 
    |---------------------------------
    | Pages
    |---------------------------------
    */

    public static function getPages(): array
    {
        return [
            'index' => ListSessions::route('/'),
        ];
    }
}
