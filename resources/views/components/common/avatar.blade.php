@props([
    'initials' => '',
    'color' => 'gray',
])

<div {{ $attributes->class(['card-avatar', "card-avatar--{$color}"]) }}>
    {{ $initials ?: $slot }}
</div>
