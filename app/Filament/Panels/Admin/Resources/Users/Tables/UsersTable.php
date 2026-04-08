<?php

namespace App\Filament\Panels\Admin\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Components\Button\GroupedActionsButton;
use App\Filament\Components\Filter\DateRangeFilter;
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
            ->heading('Users')
            ->description('Manage your users here.')
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

                TextColumn::make('email')
                    ->label('Email & Phone')
                    ->description(fn($record) => $record->getPhone())
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
                TextColumn::make('created_at')
                    ->badge()
                    ->color(Color::Gray)
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->formatStateUsing(fn($record) => $record->getCreatedAt()?->format('M d, Y h:i A')),

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
            |-------------------------------
            | Table Behavior
            |-------------------------------
            */
            ->deferLoading()
            ->stackedOnMobile()
            ->searchOnBlur()
            ->searchPlaceholder('Search (Full Name, Email, Phone)')

            /* 
            |-------------------------------
            | Groups
            |-------------------------------
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

                Group::make('created_at')
                    ->date(),
            ])
            ->collapsedGroupsByDefault()

            /* 
            |-------------------------------
            | Filters
            |-------------------------------
            */
            ->filters([
                DateRangeFilter::make(),
            ])->filtersFormWidth(Width::Large)

            /* 
            |-------------------------------
            | Record Actions
            |-------------------------------
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
