<?php

namespace App\Filament\Panels\Admin\Resources\Plans;

use App\Domain\Plan\Models\Plan;
use App\Filament\Panels\Admin\Resources\Plans\Pages\CreatePlan;
use App\Filament\Panels\Admin\Resources\Plans\Pages\EditPlan;
use App\Filament\Panels\Admin\Resources\Plans\Pages\ListPlans;
use App\Filament\Panels\Admin\Resources\Plans\Schemas\PlanForm;
use App\Filament\Panels\Admin\Resources\Plans\Schemas\PlanInfolist;
use App\Filament\Panels\Admin\Resources\Plans\Tables\PlansTable;
use App\Filament\Panels\Admin\Resources\Plans\Pages\ViewPlan;
use App\Filament\Panels\Admin\Resources\Plans\RelationManagers\SubscriptionsSessionRelationManager;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use BackedEnum;
use Illuminate\Database\Eloquent\Builder;

class PlanResource extends Resource
{
    /* 
    |---------------------------------
    | Resource Configuration
    |---------------------------------
    */

    protected static ?string $model = Plan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Bars3BottomLeft;

    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'name';

    /* 
    |---------------------------------
    | Navigation Labels
    |---------------------------------
    */

    public static function getNavigationLabel(): string
    {
        return 'Plans';
    }

    public static function getModelLabel(): string
    {
        return 'Plan';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Subscriptions Management';
    }

    /* 
    |---------------------------------
    | Eloquent Model
    |---------------------------------
    */

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery();
    }

    /* 
    |---------------------------------
    | Form & Infolist & Table
    |---------------------------------
    */

    public static function form(Schema $schema): Schema
    {
        return PlanForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PlanInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PlansTable::configure($table);
    }

    /* 
    |----------------------------------
    | Relations
    |----------------------------------
    */

    public static function getRelations(): array
    {
        return [
            SubscriptionsSessionRelationManager::class
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
            'index' => ListPlans::route('/'),
            'create' => CreatePlan::route('/create'),
            'view'   => ViewPlan::route('/{record}'),
            'edit' => EditPlan::route('/{record}/edit'),
        ];
    }
}
