<?php

namespace App\Filament\Panels\Admin\Resources\Users\Tables;

use App\Filament\Components\Button\GroupedActionsButton;
use App\Filament\Components\Filter\DateRangeFilter;
use App\Support\Enums\GenderEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table

            /*
            |------------------------------------------------------------------
            | Header
            |------------------------------------------------------------------
            */

            ->heading('Users')
            ->description('Manage your users here.')

            /* 
            |-----------------------------------------------------------------
            | Columns
            |-----------------------------------------------------------------
            */

            ->columns([

                /*
                |-----------------------------------
                | User Identity
                |-----------------------------------
                */

                TextColumn::make('full_name')
                    ->label('Name')
                    ->description(fn($record) => $record->getEmail())
                    ->weight(FontWeight::Bold)
                    ->searchable(['first_name', 'last_name', 'email']),

                TextColumn::make('phone')
                    ->label('Phone')
                    ->placeholder('No phone')
                    ->searchable(),

                TextColumn::make('age')
                    ->label('Age')
                    ->badge()
                    ->color(Color::Gray)
                    ->placeholder('N/A'),

                TextColumn::make('gender')
                    ->label('Gender')
                    ->badge()
                    ->color(fn($state) => $state->filamentColor())
                    ->formatStateUsing(fn($state) => $state->label())
                    ->placeholder('N/A'),

                /*
                |-----------------------------------
                | Current Plan
                |-----------------------------------
                */

                TextColumn::make('activeSubscription.plan.name')
                    ->label('Current Plan')
                    ->color(Color::Gray)
                    ->placeholder('No active plan'),

                /*
                |-----------------------------------
                | States
                |-----------------------------------
                */

                IconColumn::make('is_email_verified')
                    ->label('Email verified')
                    ->trueIcon(Heroicon::OutlinedCheckCircle)
                    ->falseIcon(Heroicon::OutlinedXCircle)
                    ->toggleable()
                    ->toggledHiddenByDefault(),

                /*
                |-----------------------------------
                | Timestamp
                |-----------------------------------
                */

                TextColumn::make('created_at_formatted')
                    ->label('Created At')
                    ->badge()
                    ->color(Color::Gray)
                    ->toggleable()
                    ->toggledHiddenByDefault(),

                /*
                |-----------------------------------
                | Action
                |-----------------------------------
                */

                ToggleColumn::make('is_active')
                    ->label('Active')
                    ->toggleable()
                    ->toggledHiddenByDefault(),
            ])

            /* 
            |-----------------------------------------------------------------
            | Table Options
            |-----------------------------------------------------------------
            */

            ->deferLoading()
            ->stackedOnMobile()
            ->searchOnBlur()
            ->searchPlaceholder('Search (Full Name, Email, Phone)')


            /* 
            |-----------------------------------------------------------------
            | Grouping
            |-----------------------------------------------------------------
            */

            ->groups([
                Group::make('is_active')
                    ->label('Active')
                    ->titlePrefixedWithLabel(false)
                    ->getTitleFromRecordUsing(fn($state) => $state ? 'Active' : 'Not Active'),

                Group::make('email_verified_at')
                    ->label('Email Verified')
                    ->titlePrefixedWithLabel(false)
                    ->getTitleFromRecordUsing(fn($state) => !is_null($state) ? 'Verified' : 'Not Verified'),

                Group::make('created_at_formatted')
                    ->label('Created At')
                    ->date(),

                Group::make('gender')
                    ->getTitleFromRecordUsing(fn($record) => $record->getGender()->label()),
            ])
            ->collapsedGroupsByDefault()

            /* 
            |-----------------------------------------------------------------
            | Filters
            |-----------------------------------------------------------------
            */

            ->filters([
                DateRangeFilter::make(),
            ])
            ->filtersFormWidth(Width::Large)

            /* 
            |-----------------------------------------------------------------
            | Record Actions
            |-----------------------------------------------------------------
            */

            ->recordActions(GroupedActionsButton::actions())

            /* 
            |-------------------------------
            | Toolbar Actions
            |-------------------------------
            */

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
