@props([
    'label' => '',
    'align' => 'left',
    'type' => null,
    'status' => null,
    'color' => 'gray',
])

<td
    data-label="{{ $label }}"
    {{ $attributes->class([
        'text-right' => $align === 'right',
        'text-center' => $align === 'center',
    ]) }}
>
    @switch($type)
        @case('id')
            <span class="table-cell-id">{{ $slot }}</span>
        @break

        @case('title')
            <p class="table-cell-title">{{ $slot }}</p>
            @if (isset($sub))
                <p class="table-cell-label">{{ $sub }}</p>
            @endif
        @break

        @case('date')
            <span class="table-cell-date">{{ $slot }}</span>
        @break

        @case('assignee')
            <div class="table-cell-assignee">
                <x-common.avatar :initials="$initials" />
                <span>{{ $value ?? $slot }}</span>
            </div>
        @break

        @case('badge')
            <span class="table-badge table-badge--{{ $status }}">{{ $slot }}</span>
        @break

        @case('action')
            <button class="table-row-action">{{ $slot ?? '···' }}</button>
        @break

        @default
            {{ $slot }}
    @endswitch

</td>
