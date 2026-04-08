@props([
    'label' => '',
    'align' => 'left',
])

<th
    {{ $attributes->class([
        'text-right' => $align === 'right',
        'text-center' => $align === 'center',
    ]) }}>

    {{ $label }}

    {{ $slot }}
</th>
