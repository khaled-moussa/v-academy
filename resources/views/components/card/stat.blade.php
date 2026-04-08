@props([
    'label'   => '',
    'value'   => '',
    'change'  => null,
    'compare' => 'vs last month',
])

<x-card variant="stat">
    <x-card.body>
        <p class="card-stat-label">{{ $label }}</p>
        <p class="card-stat-value">{{ $value }}</p>

        @if($change)
            <div>
                <span class="card-stat-badge">{{ $change }}</span>
                <span class="card-stat-compare">{{ $compare }}</span>
            </div>
        @endif

        {{ $slot }}
    </x-card.body>
</x-card>