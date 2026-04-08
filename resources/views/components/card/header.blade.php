@props([
    'icon' => null,
    'badge' => null,
    'color' => null,
])

<div class="card-header">

    @if ($icon)
        <x-common.icon :name="$icon" />
    @elseif(isset($iconSlot))
        <div class="card-icon">{{ $iconSlot }}</div>
    @endif

    @if ($badge)
        <x-common.badge :color="$color">{{ $badge }}</x-common.badge>
    @elseif(isset($badgeSlot))
        {{ $badgeSlot }}
    @endif

</div>
