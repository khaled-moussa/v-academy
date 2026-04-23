@props([
    'type' => 'submit',
    'label' => null,
    'disabled' => false,
])

<button
	type="{{ $type }}"
	id="{{ $attributes->get('id') }}"
	@class(['primary-btn', $attributes->get('class')])
	{{ $attributes->whereStartsWith('data') }}
	{{ $attributes->whereStartsWith('wire') }}
	{{ $attributes->whereStartsWith('x-') }}
	{{ $attributes->whereStartsWith('@click') }}
	@disabled($disabled)
>
	{{-- Label --}}
	@if ($label)
		{{ $label }}
	@endif

	{{-- Slot for icons or extra content --}}
	{{ $slot }}
</button>
