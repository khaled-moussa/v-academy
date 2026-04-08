@props([
    'name'  => null,
    'size'  => 'w-[18px] h-[18px]',
    'color' => 'text-gray-900',
])

@if($name)
    <div class="card-icon">
        <i {{ $attributes->class(['fi', "{$name}", $size, $color]) }}></i>
    </div>
@endif