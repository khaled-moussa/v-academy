<?php

namespace App\Filament\Panels\User\Pages\Plans;

use App\Domain\Plan\Actions\GetPlanByIdAction;
use App\Domain\Plan\Actions\GetPlansAction;
use App\Domain\Subscription\Actions\GetCurrentUserSubscriptionAction;
use App\Domain\Subscription\Actions\SubscribeToPlanAction;
use App\Domain\Subscription\Dtos\SubscriptionDto;
use App\Domain\Subscription\Enums\PaymentMethodEnum;
use App\Domain\Subscription\Models\States\SubscriptionStates\SubscriptionActiveState;
use App\Filament\Components\Notification\CustomNotification;
use App\Support\Context\UserContext;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Infolists\Components\TextEntry;
use Filament\Pages\Page;
use Filament\Schemas\Components\EmptyState;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Filament\Support\RawJs;
use Livewire\Attributes\On;

class ExplorePlans extends Page
{
    protected string $view = 'filament.panels.user.pages.plans.explore-plans';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::Bars3BottomLeft;
    protected static ?int $navigationSort = 3;

    /*
    |--------------------------------------------------------------------------
    | Navigation
    |--------------------------------------------------------------------------
    */

    public static function getNavigationLabel(): string
    {
        return 'Plans';
    }
    public static function getNavigationGroup(): ?string
    {
        return 'Subscriptions';
    }

    /*
    |--------------------------------------------------------------------------
    | State
    |--------------------------------------------------------------------------
    */

    public array $plans = [];

    /*
    |--------------------------------------------------------------------------
    | Lifecycle
    |--------------------------------------------------------------------------
    */

    public function mount(): void
    {
        $this->plans = app(GetPlansAction::class)->execute()->toArray();
    }

    /*
    |--------------------------------------------------------------------------
    | Infolist
    |--------------------------------------------------------------------------
    */

    public function infolist(Schema $schema): Schema
    {
        if (empty($this->plans)) {
            return $schema->components([
                EmptyState::make('No plans available')
                    ->description('There are no available plans yet.')
                    ->icon(Heroicon::Bars3BottomLeft),
            ]);
        }

        return $schema->components(
            collect($this->plans)
                ->map(fn(array $plan) => $this->buildPlanSection($plan))
                ->values()
                ->toArray()
        );
    }

    private function buildPlanSection(array $plan): Section
    {
        $state = $this->subscriptionState($plan['id']);

        return Section::make($plan['name'] ?? 'Plan')
            ->afterHeader([
                Action::make("subscribe_{$plan['uuid']}")
                    ->label('Subscribe')
                    ->schema($this->subscriptionModal($plan))
                    ->action(fn(array $data) => $this->subscribeToPlan($data, $plan))
                    ->hidden($this->isSubscribed()),

                TextEntry::make("state_{$plan['uuid']}")
                    ->hiddenLabel()
                    ->state(fn() => $state)
                    ->badge()
                    ->color(fn($state) => $state->filamentColor())
                    ->formatStateUsing(fn($state) => $state->label())
                    ->hidden(fn() => is_null($state)),
            ])
            ->schema([
                Section::make()
                    ->schema([
                        TextEntry::make("price_{$plan['uuid']}")
                            ->label('Price')
                            ->badge()
                            ->color(Color::Orange)
                            ->money('EGP', locale: 'nl')
                            ->default($plan['price'] ?? 'N/A'),

                        TextEntry::make("sessions_{$plan['uuid']}")
                            ->label('Sessions')
                            ->badge()
                            ->default($plan['no_of_sessions'] ?? 0),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),

                Section::make()
                    ->schema([
                        TextEntry::make("description_{$plan['uuid']}")
                            ->hiddenLabel()
                            ->placeholder('No description')
                            ->default($plan['description'] ?? null)
                            ->columnSpanFull(),

                        TextEntry::make("includes_{$plan['uuid']}")
                            ->label('Includes')
                            ->formatStateUsing(
                                fn($state) => is_array($state)
                                    ? implode(', ', $state)
                                    : $state
                            )
                            ->default($plan['includes'] ?? [])
                            ->hidden(empty($plan['includes']))
                            ->bulleted(),
                    ])
                    ->columnSpanFull(),
            ])
            ->columns(1);
    }

    private function subscriptionModal(array $plan): array
    {
        return [
            Section::make()
                ->schema([
                    Section::make()
                        ->schema([
                            TextEntry::make('plan_name')
                                ->label('Plan')
                                ->state($plan['name'])
                                ->badge(),

                            TextEntry::make('plan_price')
                                ->label('Price')
                                ->state($plan['price'])
                                ->badge()
                                ->color(Color::Orange)
                                ->money('EGP', locale: 'nl'),
                        ])
                        ->columns(2),

                    TextInput::make('amount')
                        ->required()
                        ->numeric()
                        ->mask(RawJs::make('$money($input)'))
                        ->stripCharacters(',')
                        ->minValue($plan['price'])
                        ->maxValue($plan['price'])
                        ->suffix('EGP'),

                    ToggleButtons::make('payment_method')
                        ->required()
                        ->options(PaymentMethodEnum::options())
                        ->colors(PaymentMethodEnum::colorOptions())
                        ->inline(),
                ])
                ->contained(false),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Handlers
    |--------------------------------------------------------------------------
    */

    private function subscribeToPlan(array $data, array $planData): void
    {
        $plan = app(GetPlanByIdAction::class)->execute($planData['id']);

        $dto = new SubscriptionDto(
            amount: $plan->getPrice(),
            paymentMethod: $data['payment_method'],
            totalSessions: $plan['no_of_sessions'],
            planId: $plan->getId(),
            userId: UserContext::id(),
        );

        app(SubscribeToPlanAction::class)->execute($dto);

        CustomNotification::success(title: 'Plan subscribed successfully.');

        $this->dispatch('subscribe');
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    private function isSubscribed(): bool
    {
        return app(GetCurrentUserSubscriptionAction::class)->exists(UserContext::user());
    }

    private function subscriptionState(int $planId): mixed
    {
        $subscription = app(GetCurrentUserSubscriptionAction::class)
            ->execute(UserContext::user());

        if (! $subscription || $subscription->getPlanId() !== $planId) {
            return null;
        }

        if ($subscription && $subscription->isActive()) {
            return new SubscriptionActiveState($subscription);
        }

        return $subscription->getSubscriptionState();
    }

    /**
     * Listens for the 'unlink' Livewire event dispatched by handleProviderAction().
     *
     * An empty public method body is sufficient — Livewire re-renders the entire
     * component on every public method call, which causes getSocialiteProviderComponent()
     * to rebuild the provider rows with the fresh linked/unlinked state.
     */
    #[On('subscribe')]
    public function refreshPlan(): void {}
}
