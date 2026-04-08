<?php

namespace App\Filament\Pages;

use App\Domain\Dashboard\Dtos\DashboardFilterDto;
use CodeWithKyrian\FilamentDateRange\Forms\Components\DateRangePicker;
use Filament\Actions\Action;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;

class CustomDashboard extends BaseDashboard
{
    use HasFiltersForm;

    /* 
    |-------------------------------
    | Header Actions
    |-------------------------------
    */

    /**
     * The filter Action lives here — not inside filtersForm().
     *
     * HasFiltersForm only supports form field components in its schema.
     * Placing an Action there causes Livewire to fail reconciling component
     * trees during re-renders (findCommitByComponent TypeError).
     */
    protected function getHeaderActions(): array
    {
        return [
            Action::make('filter')
                ->icon(Heroicon::Funnel)
                ->fillForm(fn(): array => $this->filters = DashboardFilterDto::fromFilters($this->filters)->toArray())
                ->schema([
                    DateRangePicker::make('daterange')
                        ->label('Select date')
                        ->startPlaceholder('e.g. Jan 01, 2020')
                        ->separator(['inline' => '→'])
                        ->singleField()
                        ->startPrefixIcon('heroicon-m-calendar-days')
                        ->columnSpanFull(),
                ])
                ->action(fn(array $data): array => $this->filters = DashboardFilterDto::fromFilters($data)->toArray())
                ->extraModalFooterActions([
                    Action::make('reset')
                        ->label('Reset')
                        ->icon(Heroicon::XMark)
                        ->color('gray')
                        ->action(function (): void {
                            $this->filters = [];
                        })
                        ->action(fn(): array => $this->filters = [])
                        ->cancelParentActions(),
                ])
                ->slideOver()
                ->modalWidth(Width::Large),
        ];
    }


    /* 
    |-------------------------------
    | Filters Form
    |-------------------------------
    */

    /**
     * Keep this schema empty (or add only real form fields here).
     *
     * The $this->filters property is still populated by the Action above, so
     * all widgets reading startDate / endDate will continue to work normally.
     */
    public function filtersForm(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public function persistsFiltersInSession(): bool
    {
        return false;
    }
}
