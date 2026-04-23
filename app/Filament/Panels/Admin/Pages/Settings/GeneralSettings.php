<?php

namespace App\Filament\Panels\Admin\Pages\Settings;

use App\Domain\Setting\GeneralSetting\Actions\UpdateGeneralSettingAction;
use App\Domain\Setting\GeneralSetting\Dtos\GeneralSettingDto;
use App\Support\Enums\ThemeEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Livewire\Attributes\On;
use BackedEnum;

class GeneralSettings extends Page
{
    protected string $view = 'filament.panels.admin.pages.settings.general-settings';
    protected static ?string $cluster = SettingsCluster::class;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::AdjustmentsHorizontal;
    protected static ?int $navigationSort = 1;

    /*
    |-----------------------------------------------------------------------
    | State
    |-----------------------------------------------------------------------
    */
    public string $themeMode;
    public bool $userCanCreateSession;
    public int $maxCapacity;

    /* 
    |-------------------------------
    | Navigation Labels
    |-------------------------------
    */
    public static function getNavigationLabel(): string
    {
        return 'General';
    }

    /*
    |-----------------------------------------------------------------------
    | Lifecycle
    |-----------------------------------------------------------------------
    */
    public function mount(): void
    {
        $setting = app('generalSetting');

        $this->themeMode            = filament()->getDefaultThemeMode()->value;
        $this->userCanCreateSession = $setting['user_can_create_session'];
        $this->maxCapacity          = $setting['max_capacity'];
    }

    /*
    |-----------------------------------------------------------------------
    | Header Actions
    |-----------------------------------------------------------------------
    */
    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->label('Save')
                ->requiresConfirmation()
                ->action(fn() => $this->save())
                ->button(),
        ];
    }

    /*
    |-----------------------------------------------------------------------
    | Form
    |-----------------------------------------------------------------------
    */
    public function form(Schema $schema): Schema
    {
        return $schema->components([

            /*
            |-------------------------------
            | Appearance Tab
            |-------------------------------
            */
            Section::make('Appearance')
                ->schema([
                    Select::make('themeMode')
                        ->label('Theme Mode')
                        ->options(ThemeEnum::options())
                        ->native(false)
                        ->prefixIcon(Heroicon::OutlinedSun)
                        ->columnSpanFull(),
                ])
                ->columns(2)
                ->compact(),

            /*
            |-------------------------------
            | Sessions Tab
            |-------------------------------
            */
            Section::make('Sessions')
                ->description('Manage session settings for users.')
                ->schema([
                    Section::make('Can User Create Session')
                        ->description('')
                        ->afterHeader([
                            Toggle::make('userCanCreateSession')->hiddenLabel(),
                        ])
                        ->compact()
                        ->secondary(),

                    Section::make('Max Capacity')
                        ->schema([
                            TextInput::make('maxCapacity')
                                ->hiddenLabel()
                                ->belowContent('Determine the default max capacity when users create a session.')
                                ->required()
                                ->numeric()
                                ->minValue(1),
                        ])
                        ->compact()
                        ->secondary(),
                ])
                ->columnSpanFull()
                ->compact(),
        ]);
    }

    /*
    |-----------------------------------------------------------------------
    | Actions
    |-----------------------------------------------------------------------
    */
    public function save(): void
    {
        $this->js("
            \$dispatch('theme-changed', '{$this->themeMode}');
            localStorage.setItem('theme', '{$this->themeMode}');
        ");

        $this->dispatch('settings-changed', $this->themeMode);

        $generalSettingDto = new GeneralSettingDto(
            userCanCreateSession: $this->userCanCreateSession,
            maxCapacity: $this->maxCapacity,
        );

        app(UpdateGeneralSettingAction::class)->execute($generalSettingDto);
    }

    #[On('settings-changed')]
    public function refreshSettings(): void {}
}
