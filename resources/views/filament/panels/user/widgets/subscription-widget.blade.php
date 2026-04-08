<x-filament-widgets::widget class="fi-account-widget">

    {{-- IS NOT Subscriped --}}
    @if (!$isSubscribed)
        <x-filament::empty-state icon="heroicon-o-information-circle">
            <x-slot name="heading">
                No Active Subscription
            </x-slot>

            <x-slot name="description">
                Subscribe to a plan to start using your available sessions and unlock all features.
            </x-slot>

            <x-slot name="footer">
                <x-filament::link icon="heroicon-m-arrow-top-right-on-square" :href="route('filament.user.pages.explore-plans')">
                    Browse Plans
                </x-filament::link>
            </x-slot>
        </x-filament::empty-state>

        {{-- IS PENDING --}}
    @elseif ($isSubscribedPending)
        <x-filament::section>
            <x-slot name="heading">
                Subscription Status
            </x-slot>

            <x-slot name="afterHeader">
                <x-filament::badge color="warning" icon="heroicon-o-clock">
                    Pending Approval
                </x-filament::badge>
            </x-slot>

            <p class="text-sm text-gray-600">
                Your subscription is currently under review. Once approved, your sessions will be activated and ready to
                use.
            </p>
        </x-filament::section>

        {{-- IS Subscriped --}}
    @else
        <x-filament::section>
            <x-slot name="heading">
                Your Plan
            </x-slot>

            <x-slot name="description">
                {{ $plan['name'] }}
            </x-slot>

            <x-slot name="afterHeader">
                <x-filament::badge color="warning">
                    {{ $subscription['used_sessions'] . ' / ' . $subscription['total_sessions'] }} Sessions
                </x-filament::badge>
            </x-slot>
        </x-filament::section>
    @endif

</x-filament-widgets::widget>
