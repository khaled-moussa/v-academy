@props(['layout' => 'stacked'])

<dl {{ $attributes->class(['card-items', "card-items--{$layout}"]) }}>
    {{ $slot }}
</dl>
