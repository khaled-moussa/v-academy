@props([
    'label' => '',
    'value' => null,
    'variant' => 'default',
    'color' => 'gray',
    'initials' => null,
    'href' => null,
])

<div class="card-item">

    <dt class="card-item-label">{{ $label }}</dt>

    <dd class="card-item-value">
        @switch($variant)
            @case('badge')
                <x-common.badge :color="$color">{{ $value ?? $slot }}</x-common.badge>
            @break

            @case('avatar')
                <x-common.avatar :initials="$initials" />
            @break

            @case('link')
                <a
                    href="{{ $href ?? '#' }}"
                    class="card-item-link"
                >{{ $value ?? $slot }}</a>
            @break

            @case('mono')
                <span class="card-item-mono">{{ $value ?? $slot }}</span>
            @break

            @case('description')
                <span class="card-item-description">{{ $value ?? $slot }}</span>
            @break

            @default
                {{ $value ?? $slot }}
        @endswitch
    </dd>

</div>
