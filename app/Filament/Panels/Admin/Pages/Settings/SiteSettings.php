<?php

namespace App\Filament\Panels\Admin\Pages\Settings;

use App\Domain\Setting\GeneralSetting\Actions\UpdateGeneralSettingAction;
use App\Domain\Setting\GeneralSetting\Dtos\GeneralSettingDto;
use App\Filament\Components\Notification\CustomNotification;
use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use BackedEnum;
use Filament\Forms\Components\Repeater;

class SiteSettings extends Page
{
    /*
    |-------------------------------
    | Resource Configuration
    |-------------------------------
    */
    protected string $view = 'filament.panels.admin.pages.settings.site-settings';
    protected static ?string $cluster = SettingsCluster::class;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedGlobeAmericas;
    protected static ?int $navigationSort = 2;

    /*
    |-------------------------------
    | State
    |-------------------------------
    */
    public ?string $site_name = null;
    public ?string  $description = null;
    public ?string $address = null;
    public ?string $location_url = null;
    public ?string $support_email = null;
    public ?array $phones = [];

    /*
    |-------------------------------
    | Navigation Labels
    |-------------------------------
    */
    public static function getNavigationLabel(): string
    {
        return 'Site Details';
    }

    /*
    |-------------------------------
    | Lifecycle
    |-------------------------------
    */
    public function mount(): void
    {
        $setting = app('generalSetting');

        $this->site_name     = $setting['site_name'] ?? null;
        $this->description   = $setting['description'] ?? null;
        $this->address       = $setting['address'] ?? null;
        $this->location_url  = $setting['location_url'] ?? null;
        $this->support_email = $setting['support_email'] ?? null;
        $this->phones        = $setting['phones'] ?? [];
    }

    /*
    |-------------------------------
    | Header Actions
    |-------------------------------
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
    |-------------------------------
    | Form
    |-------------------------------
    */
    public function form(Schema $schema): Schema
    {
        return $schema->components([

            Tabs::make('Settings Tabs')
                ->tabs([

                    /*
                    |-------------------------------
                    | Site Settings Tab
                    |-------------------------------
                    */
                    Tab::make('Site Settings')
                        ->icon(Heroicon::OutlinedGlobeAmericas)
                        ->schema([
                            Section::make()
                                ->schema([
                                    TextInput::make('site_name')
                                        ->label('Site Name')
                                        ->required()
                                        ->columnSpanFull(),

                                    Textarea::make('description')
                                        ->label('Description')
                                        ->rows(3)
                                        ->columnSpanFull(),
                                ])
                                ->columns(2)
                                ->contained(false),
                        ]),

                    /*
                    |-------------------------------
                    | Academy Contact Tab
                    |-------------------------------
                    */
                    Tab::make('Academy Contact')
                        ->icon(Heroicon::OutlinedPhone)
                        ->schema([
                            Section::make('Contact Details')
                                ->schema([
                                    TextInput::make('address')
                                        ->label('Address')
                                        ->columnSpanFull(),

                                    TextInput::make('location_url')
                                        ->label('Location URL')
                                        ->url()
                                        ->columnSpanFull(),

                                    TextInput::make('support_email')
                                        ->label('Support Email')
                                        ->email()
                                        ->columnSpanFull(),

                                    Repeater::make('phones')
                                        ->simple(
                                            TextInput::make('phone')
                                                ->label('Phones')
                                                ->tel()
                                                ->prefixIcon(Heroicon::Phone)
                                        )
                                        ->columnSpanFull()
                                ])
                                ->columns(2)
                                ->contained(false),
                        ]),
                ])
                ->columnSpanFull(),
        ]);
    }

    /*
    |-------------------------------
    | Actions
    |-------------------------------
    */
    public function save(): void
    {
        $dto = new GeneralSettingDto(
            siteName: $this->site_name,
            description: $this->description,
            address: $this->address,
            locationUrl: $this->location_url,
            supportEmail: $this->support_email,
            phones: $this->phones,
        );

        app(UpdateGeneralSettingAction::class)->execute($dto);

        CustomNotification::success(title: 'Settings updated successfully.');
    }
}
