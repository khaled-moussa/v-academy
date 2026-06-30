<?php

namespace App\Filament\Panels\Admin\Resources\Programs\Schemas;

use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProgramForm
{
    /*
    |--------------------------------------------------------------------------
    | Configure
    |--------------------------------------------------------------------------
    */

    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            self::programInfoSection(),
            self::programMediaSection(),
            self::programStatusSection(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Program Infomration Section
    |--------------------------------------------------------------------------
    */

    private static function programInfoSection(): Section
    {
        return Section::make('Program Details')
            ->compact()
            ->secondary()
            ->columnSpanFull()
            ->schema([
                TextInput::make('name')
                    ->label('Program Name')
                    ->maxLength(255),

                Textarea::make('description')
                    ->label('Description')
                    ->nullable(),
            ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Program Media Section
    |--------------------------------------------------------------------------
    */

    private static function programMediaSection(): Section
    {
        return Section::make('Program File')
            ->compact()
            ->secondary()
            ->columnSpanFull()
            ->schema([
                self::programCoverSection(),
                self::programFileSection(),
            ]);
    }

    private static function programCoverSection(): Section
    {
        return Section::make('Program Cover')
            ->compact()
            ->secondary()
            ->columnSpanFull()
            ->schema([
                SpatieMediaLibraryFileUpload::make('program_cover')
                    ->hiddenLabel()
                    ->collection('cover')
                    ->required()
                    ->image(),
            ]);
    }

    private static function programFileSection(): Section
    {
        return Section::make('Program File')
            ->compact()
            ->secondary()
            ->columnSpanFull()
            ->schema([
                SpatieMediaLibraryFileUpload::make('program_file')
                    ->hiddenLabel()
                    ->collection('programs')
                    ->required(),
            ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Program Status Section
    |--------------------------------------------------------------------------
    */

    private static function programStatusSection(): Section
    {
        return Section::make('Status')
            ->columnSpanFull()
            ->schema([
                Toggle::make('is_active')
                    ->label('Active')
                    ->default(true),
            ]);
    }
}
