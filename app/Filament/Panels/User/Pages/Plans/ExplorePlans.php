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
use App\Support\Context\AuthContext;
use Filament\Actions\Action;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Infolists\Components\TextEntry;
use Filament\Pages\Page;
use Filament\Schemas\Components\EmptyState;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Flex;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Filament\Support\RawJs;
use Livewire\Attributes\On;
use BackedEnum;

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
        $this->loadPlans();
    }

    private function loadPlans(): void
    {
        $this->plans = app(GetPlansAction::class)
            ->execute()
            ->toResourceCollection()
            ->resolve();
    }

    /*
    |--------------------------------------------------------------------------
    | UI
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
                ->map(fn($plan) => $this->planSection($plan))
                ->toArray()
        );
    }

    private function planSection(array $plan): Section
    {
        return Section::make($plan['name'] ?? 'Plan')
            ->afterHeader([
                $this->discountBadge($plan),
            ])

            ->footer([
                $this->subscribeAction($plan),
                $this->subscriptionStateEntry($plan)
            ])
         
            ->schema([
                $this->priceBlock($plan),
                $this->includesBlock($plan),
            ])
            
            ->columns(1);
    }

    private function priceBlock(array $plan): Section
    {
        return Section::make()
            ->schema([
                TextEntry::make("price_{$plan['uuid']}")
                    ->label('Price')
                    ->state(fn() => $this->formatPrice($plan))
                    ->money('EGP', locale: 'nl')
                    ->html(),

                TextEntry::make("sessions_{$plan['uuid']}")
                    ->label('Sessions')
                    ->badge()
                    ->default($plan['no_of_sessions'] ?? 0),
            ])
            ->columns(2)
            ->columnSpanFull()
            ->secondary();
    }

    private function includesBlock(array $plan): Fieldset
    {
        return Fieldset::make('Includes')
            ->schema([
                TextEntry::make("includes_{$plan['uuid']}")
                    ->hiddenLabel()
                    ->formatStateUsing(
                        fn($state) =>
                        is_array($state) ? implode(', ', $state) : $state
                    )
                    ->default($plan['includes'] ?? [])
                    ->hidden(fn() => empty($plan['includes']))
                    ->bulleted(),
            ])
            ->columnSpanFull();
    }

    /*
    |--------------------------------------------------------------------------
    | Badges
    |--------------------------------------------------------------------------
    */

    private function subscriptionStateEntry(array $plan): TextEntry
    {
        return TextEntry::make("state_{$plan['uuid']}")
            ->hiddenLabel()
            ->state(fn() => $this->subscriptionState($plan['id']))
            ->badge()
            ->color(fn($state) => $state?->filamentColor())
            ->formatStateUsing(fn($state) => $state?->label())
            ->hidden(fn($state) => is_null($state));
    }

    private function discountBadge(array $plan): TextEntry
    {
        return TextEntry::make("discount_{$plan['uuid']}")
            ->hiddenLabel()
            ->badge()
            ->color(Color::Rose)
            ->state($plan['discount'] ?? 0)
            ->formatStateUsing(fn($state) => "Sale {$state}%")
            ->hidden(fn($state) => (int) $state === 0);
    }

    /*
    |--------------------------------------------------------------------------
    | Actions
    |--------------------------------------------------------------------------
    */

    private function subscribeAction(array $plan): Action
    {
        return Action::make("subscribe_{$plan['uuid']}")
            ->label('Subscribe')
            ->schema($this->subscriptionModal($plan))
            ->action(fn(array $data) => $this->subscribeToPlan($data, $plan))
            ->hidden(fn() => $this->isSubscribed());
    }

    private function subscriptionModal(array $plan): array
    {
        return [
            Section::make()
                ->schema([
                    Flex::make([
                        TextEntry::make('plan_name')
                            ->label('Plan')
                            ->state($plan['name'])
                            ->badge(),

                        TextEntry::make('plan_price')
                            ->label('Price')
                            ->state(fn() => $this->formatPrice($plan))
                            ->money('EGP', locale: 'nl')
                            ->html(),
                    ]),

                    SpatieMediaLibraryFileUpload::make('payment_proof')
                        ->collection('payment_proofs')
                        ->required()
                        ->image()
                        ->maxSize(2048)
                        ->responsiveImages()
                        ->dehydrated(),

                    TextInput::make('amount')
                        ->required()
                        ->numeric()
                        ->mask(RawJs::make('$money($input)'))
                        ->stripCharacters(',')
                        ->minValue($plan['price_discount'])
                        ->maxValue($plan['price_discount'])
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
    | Handler
    |--------------------------------------------------------------------------
    */

    private function subscribeToPlan(array $data, array $planData): void
    {
        $plan = app(GetPlanByIdAction::class)
            ->execute($planData['id']);

        $subscription = app(SubscribeToPlanAction::class)
            ->execute(new SubscriptionDto(
                amount: $plan->getPrice(),
                paymentMethod: $data['payment_method'],
                totalSessions: $plan['no_of_sessions'],
                planId: $plan->getId(),
                userId: AuthContext::id(),
            ));

        if (! empty($data['payment_proof'])) {
            $subscription
                ->addMedia($data['payment_proof'])
                ->toMediaCollection('payment_proofs');
        }

        CustomNotification::success('Plan subscribed successfully.');

        $this->dispatch('subscribe');
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    private function formatPrice(array $plan): string
    {
        $price = $plan['price'] ?? 0;
        $priceDiscount = $plan['price_discount'] ?? 0;
        $discount = $plan['discount'] ?? 0;

        if ($discount > 0) {
            return "
            <div class='flex flex-col'>
                <span style='text-decoration-line: line-through'>
                    {$price} EGP
                </span>

                <span class='font-bold'>
                    {$priceDiscount} EGP
                </span>
            </div>
        ";
        }

        return "<span class='font-bold'>{$price} EGP</span>";
    }

    private function isSubscribed(): bool
    {
        return app(GetCurrentUserSubscriptionAction::class)
            ->exists(AuthContext::user());
    }

    private function subscriptionState(int $planId): mixed
    {
        $subscription = app(GetCurrentUserSubscriptionAction::class)
            ->execute(AuthContext::user());

        if (! $subscription || $subscription->getPlanId() !== $planId) {
            return null;
        }

        return $subscription->isActive()
            ? new SubscriptionActiveState($subscription)
            : $subscription->getSubscriptionState();
    }

    /*
    |--------------------------------------------------------------------------
    | Events
    |--------------------------------------------------------------------------
    */

    #[On('subscribe')]
    public function refreshPlan(): void
    {
        $this->reset();
        $this->loadPlans();
    }
}
