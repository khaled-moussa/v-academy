<x-filament-widgets::widget>

    <x-filament::section icon="heroicon-o-user" icon-color="info" collapsible collapsed>
        <x-slot name="heading">
            Nutrition Plans
        </x-slot>

        <x-slot name="description">
            Weekly nutrition schedule for all meals
        </x-slot>

        @foreach ($nutrations as $nutration)
            <x-filament::section compact secondary collapsible collapsed>

                <x-slot name="heading">
                    {{ ucfirst($nutration['meal']) }}
                </x-slot>

                @foreach ($days as $day)
                    <x-filament::section compact secondary>
                        <x-slot name="heading">
                            {{ ucfirst($day) }}
                        </x-slot>

                        <x-slot name="description">
                            {{ $nutration[$day] ?: '—' }}
                        </x-slot>
                    </x-filament::section>

                    <br />
                @endforeach

            </x-filament::section>

            <br />
        @endforeach
    </x-filament::section>


</x-filament-widgets::widget>
