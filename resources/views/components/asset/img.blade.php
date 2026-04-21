@props([
	'id' => null,
	'folder' => null,
	'img' => null,
	'alt' => 'Variables Academy'
])

<img {{ $attributes->whereStartsWith('class') }}
	id="{{ $id }}"
	src="{{ Vite::image("{$folder}/{$img}") }}"
	alt="{{ $alt }}"
>
