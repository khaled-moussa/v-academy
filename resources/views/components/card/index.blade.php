@props(['variant' => 'default'])

<div {{ $attributes->class(['card', "card--{$variant}" => $variant !== 'default']) }}>
    {{ $slot }}
</div>
