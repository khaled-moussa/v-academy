@props([
    'type' => 'button',
    'label' => null,
    'disabled' => false,
])

<button
	type="{{ $type }}"
	@if ($attributes->has('id')) id="{{ $attributes->get('id') }}" @endif
	@class(['outline-btn', $attributes->get('class')])
	{{ $attributes->whereStartsWith('data') }}
	{{ $attributes->whereStartsWith('wire') }}
	{{ $attributes->whereStartsWith('x-') }}
	{{ $attributes->whereStartsWith('@') }}
	@disabled($disabled)
>
	{{-- Label --}}
	@if ($label)
		<span>{{ $label }}</span>
	@endif

	{{-- Slot element --}}
	{{ $slot }}
</button>
