<?php

namespace App\Filament\Panels\User\Resources\Programs\Schemas;

use Filament\Actions\Action;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\SpatieMediaLibraryImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Joaopaulolndev\FilamentPdfViewer\Infolists\Components\PdfViewerEntry;

class ProgramInfolist
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
            self::programFileSection(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Program Information Section
    |--------------------------------------------------------------------------
    */

    private static function programInfoSection(): Section
    {
        return Section::make('Program Details')
            ->compact()
            ->secondary()
            ->columnSpanFull()
            ->schema([
                TextEntry::make('name')
                    ->label('Program Name')
                    ->color(Color::Gray)
                    ->placeholder('No program name'),

                TextEntry::make('description')
                    ->label('Description')
                    ->color(Color::Gray)
                    ->placeholder('No program description'),
            ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Program File Section
    |--------------------------------------------------------------------------
    */

    private static function programFileSection(): Section
    {
        return Section::make('Program File')
            ->secondary()
            ->columnSpanFull()
            ->headerActions([
                Action::make('preview')
                    ->label('Preview')
                    ->icon(Heroicon::OutlinedEye)
                    ->color('gray')
                    ->modalContent(fn($record) => view('filament.panels.user.pages.programs.pdf-preview', [
                        'url' => $record->getFirstMedia('programs')?->getUrl(),
                    ]))
                    ->modalHeading(fn($record) => $record->name)
                    ->modalWidth('7xl')
                    ->slideOver()
                    ->modalSubmitAction(false),
            ])
            ->schema([
                PdfViewerEntry::make('preview_file')
                    ->hiddenLabel()
                    ->minHeight('70svh'),
            ]);
    }
}
