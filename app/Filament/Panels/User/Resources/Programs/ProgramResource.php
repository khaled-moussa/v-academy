<?php

namespace App\Filament\Panels\User\Resources\Programs;

use App\Domain\Program\Models\Program;
use App\Filament\Panels\User\Resources\Programs\Pages\ListPrograms;
use App\Filament\Panels\User\Resources\Programs\Schemas\ProgramInfolist;
use App\Filament\Panels\User\Resources\Programs\Tables\ProgramsTable;
use App\Filament\Panels\User\Resources\Programs\Pages\ViewProgram;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use BackedEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class ProgramResource extends Resource
{
    /* 
    |---------------------------------
    | Resource Configuration
    |---------------------------------
    */

    protected static ?string $model = Program::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

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
        return 'Programs';
    }

    public static function getModelLabel(): string
    {
        return 'Program';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Sessions & Programs';
    }

    public static function getNavigationBadge(): ?string
    {
        $expiresAt = Carbon::create(now()->year, 7, 5, 23, 59, 59);
        return now()->lessThanOrEqualTo($expiresAt) ? 'New' : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'indigo';
    }

    /* 
    |---------------------------------
    | Form & Infolist & Table
    |---------------------------------
    */

    public static function infolist(Schema $schema): Schema
    {
        return ProgramInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProgramsTable::configure($table);
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
            'index' => ListPrograms::route('/'),
            'view'   => ViewProgram::route('/{record}'),
        ];
    }
}
