@props([
    'title' => '',
    'meta' => null,
])

<div class="table-container-header">
    <div>
        <p class="table-container-title">{{ $title }}</p>

        @if ($meta)
            <p class="table-container-meta">{{ $meta }}</p>
        @endif
    </div>
</div>
