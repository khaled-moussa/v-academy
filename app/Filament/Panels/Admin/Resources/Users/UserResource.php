<?php

namespace App\Filament\Panels\Admin\Resources\Users;

use App\Domain\User\Models\User;
use App\Filament\Panels\Admin\Resources\Users\Pages\CreateUser;
use App\Filament\Panels\Admin\Resources\Users\Pages\EditUser;
use App\Filament\Panels\Admin\Resources\Users\Pages\ListUsers;
use App\Filament\Panels\Admin\Resources\Users\Schemas\UserForm;
use App\Filament\Panels\Admin\Resources\Users\Schemas\UserInfolist;
use App\Filament\Panels\Admin\Resources\Users\Tables\UsersTable;
use App\Filament\Panels\Admin\Resources\Users\Pages\ViewUser;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use BackedEnum;

class UserResource extends Resource
{
    /* 
    |---------------------------------
    | Resource Configuration
    |---------------------------------
    */

    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'name';

    /* 
    |---------------------------------
    | Eloquent Query 
    |---------------------------------
    */

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereUserPanel()
            ->latest();
    }

    /* 
    |---------------------------------
    | Navigation Labels
    |---------------------------------
    */

    public static function getNavigationLabel(): string
    {
        return 'Users';
    }

    public static function getModelLabel(): string
    {
        return 'User';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Users Managament';
    }

    /* 
    |---------------------------------
    | Form & Infolist & Table
    |---------------------------------
    */

    public static function form(Schema $schema): Schema
    {
        return UserForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return UserInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UsersTable::configure($table);
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
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'view'   => ViewUser::route('/{record}'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }
}
