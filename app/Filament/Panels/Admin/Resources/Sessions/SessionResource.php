<?php

namespace App\Filament\Panels\Admin\Resources\Sessions;

use App\Domain\TrainingSession\Models\TrainingSession;
use App\Filament\Panels\Admin\Resources\Sessions\Pages\ListSessions;
use App\Filament\Panels\Admin\Resources\Sessions\Schemas\SessionForm;
use App\Filament\Panels\Admin\Resources\Sessions\Schemas\SessionInfolist;
use App\Filament\Panels\Admin\Resources\Sessions\Tables\SessionsTable;
use App\Filament\Panels\Admin\Resources\Sessions\Pages\ViewSession;
use App\Filament\Panels\Admin\Resources\Sessions\RelationManagers\UserBookingSessionRelationManager;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use BackedEnum;

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
        return 'Sessions Management';
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
        return [
            UserBookingSessionRelationManager::class
        ];
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
            'view'   => ViewSession::route('/{record}'),
        ];
    }
}
