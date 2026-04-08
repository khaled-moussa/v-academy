@props([
    'title'       => null,
    'subtitle'    => null,
    'description' => null,
])

<div class="card-body">

    {{ $before ?? '' }}

    @if($title)
        <p class="card-title">{{ $title }}</p>
    @endif

    @if($subtitle)
        <p class="card-subtitle">{{ $subtitle }}</p>
    @endif

    @if($description)
        <p class="card-description">{{ $description }}</p>
    @endif

    {{ $slot }}

</div>