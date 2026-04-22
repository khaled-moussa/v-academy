@props([
    'type' => 'button',
    'label' => null,
    'path' => '#',
])

<a
    id="{{ $attributes->get('id') }}"
    href="{{ $path }}"
    {{ $attributes->whereStartsWith('class') }}
    {{ $attributes->whereStartsWith('wire') }}
    {{ $attributes->whereStartsWith('x-model') }}
    {{ $attributes->whereStartsWith('@click') }}
>
    {{-- Icon --}}
    {{ $icon ?? null }}

    {{-- Label --}}
    @if ($label)
        <span>
            {{ $label }}
        </span>
    @endif

    {{-- Slot element --}}
    {{ $slot }}
</a>
