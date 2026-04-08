@props([
    'icon' => null,
    'message' => 'No data available.',
])

<div class="empty">

    @if ($icon)
        <x-icon :name="$icon" />
    @endif

    <p class="empty-message">{{ $message }}</p>
</div>
