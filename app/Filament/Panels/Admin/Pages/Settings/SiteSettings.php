<?php

namespace App\Filament\Panels\Admin\Pages\Settings;

use App\Domain\Setting\GeneralSetting\Actions\UpdateGeneralSettingAction;
use App\Domain\Setting\GeneralSetting\Dtos\GeneralSettingDto;
use App\Filament\Components\Notification\CustomNotification;
use App\Support\Context\GeneralSettingContext;
use App\Support\Enums\SocialLinkEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Forms\Components\Repeater;
use BackedEnum;
use Filament\Forms\Components\Select;

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
    public string $siteName;
    public string $tagline;
    public string $slugon;
    public string $description;
    public ?array $youtubeLinks = [];
    public ?string $address = null;
    public ?string $locationUrl = null;
    public ?string $supportEmail = null;
    public ?array $socialLinks = [];
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
        $setting = GeneralSettingContext::toArray();

        $this->siteName     = data_get($setting, 'site_name');
        $this->tagline      = data_get($setting, 'tagline');
        $this->slugon       = data_get($setting, 'slugon');
        $this->description  = data_get($setting, 'description');
        $this->youtubeLinks = data_get($setting, 'youtube_links');
        $this->address      = data_get($setting, 'address');
        $this->locationUrl  = data_get($setting, 'location_url');
        $this->supportEmail = data_get($setting, 'support_email');
        $this->socialLinks  = data_get($setting, 'social_links', []);
        $this->phones       = data_get($setting, 'phones', []);
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

                    Tab::make('Intro')
                        ->icon(Heroicon::OutlinedGlobeAmericas)
                        ->schema([
                            Section::make()
                                ->schema([
                                    TextInput::make('siteName')
                                        ->label('Site Name')
                                        ->required()
                                        ->columnSpanFull(),

                                    TextInput::make('tagline')
                                        ->label('Tagline')
                                        ->required()
                                        ->maxLength(150)
                                        ->rule('max:150')
                                        ->columnSpanFull(),

                                    Textarea::make('slugon')
                                        ->label('Slugon')
                                        ->required()
                                        ->maxLength(300)
                                        ->rule('max:300')
                                        ->rows(3)
                                        ->columnSpanFull(),

                                    Textarea::make('description')
                                        ->label('Description')
                                        ->required()
                                        ->maxLength(300)
                                        ->rule('max:300')
                                        ->rows(3)
                                        ->columnSpanFull(),
                                ])
                                ->columns(2)
                                ->contained(false),
                        ]),

                    /*
                    |-------------------------------
                    | Site Youtube Tab
                    |-------------------------------
                    */

                    Tab::make('Youtube')
                        ->icon(Heroicon::OutlinedLink)
                        ->schema([
                            Repeater::make('youtubeLinks')
                                ->schema([
                                    TextInput::make('title')
                                        ->label('Title')
                                        ->maxLength(300)
                                        ->rule('max:300')
                                        ->required(),

                                    TextInput::make('link')
                                        ->label('Link')
                                        ->required()
                                        ->url()
                                ])
                                ->columnSpanFull()
                                ->reorderable(false)
                                ->itemLabel(fn($state) => $state['title'] ?? 'New')
                        ]),


                    /*
                    |-------------------------------
                    | Academy Contact Tab
                    |-------------------------------
                    */

                    Tab::make('Contact')
                        ->icon(Heroicon::OutlinedPhone)
                        ->schema([
                            Section::make('Contact Details')
                                ->schema([
                                    TextInput::make('address')
                                        ->label('Address')
                                        ->columnSpanFull(),

                                    TextInput::make('locationUrl')
                                        ->label('Location URL')
                                        ->url()
                                        ->columnSpanFull(),

                                    TextInput::make('supportEmail')
                                        ->label('Support Email')
                                        ->email()
                                        ->columnSpanFull(),

                                    Section::make('Phones')
                                        ->schema([
                                            Repeater::make('phones')
                                                ->hiddenLabel()
                                                ->simple(
                                                    TextInput::make('')
                                                        ->label('Phone')
                                                        ->tel()
                                                        ->prefixIcon(Heroicon::Phone)
                                                )
                                                ->columnSpanFull()
                                                ->reorderable(false)
                                        ])
                                        ->columnSpanFull()
                                        ->compact()
                                        ->secondary()
                                        ->collapsible(),

                                    Section::make('Social Media')
                                        ->schema([
                                            Repeater::make('socialLinks')
                                                ->hiddenLabel()
                                                ->schema([
                                                    Select::make('type')
                                                        ->options(SocialLinkEnum::options())
                                                        ->native(false),

                                                    TextInput::make('link')
                                                        ->label('Link')
                                                        ->required()
                                                        ->url()
                                                ])
                                                ->columnSpanFull()
                                                ->reorderable(false)
                                                ->itemLabel(function ($state) {
                                                    $type = data_get($state, 'type');

                                                    if (! is_string($type) || ! SocialLinkEnum::tryFrom($type)) {
                                                        return 'New';
                                                    }

                                                    return SocialLinkEnum::from($type)->label();
                                                })
                                        ])
                                        ->columnSpanFull()
                                        ->compact()
                                        ->secondary()
                                        ->collapsible(),
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
        $this->validate();

        $dto = new GeneralSettingDto(
            siteName: $this->siteName,
            tagline: $this->tagline,
            slugon: $this->slugon,
            description: $this->description,
            youtubeLinks: $this->youtubeLinks,
            address: $this->address,
            locationUrl: $this->locationUrl,
            supportEmail: $this->supportEmail,
            socialLinks: $this->socialLinks,
            phones: $this->phones,
        );

        app(UpdateGeneralSettingAction::class)->execute($dto);

        CustomNotification::success(title: 'Settings updated successfully.');
    }
}
