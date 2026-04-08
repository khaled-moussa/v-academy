@props(['color' => 'gray'])

<span {{ $attributes->class(['badge', $color]) }}>
    {{ $slot }}
</span>
