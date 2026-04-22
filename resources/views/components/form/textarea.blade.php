@props([
    'type' => 'text',
    'label' => null,
    'options' => [],
])

<div   
    @class([
        'input-field',
        $attributes->get('class'),
    ])>

    <div>
        {{-- Label --}}
        @if($label)
            <label for="{{ $attributes->get('id') }}">
                {{ $label }}
            </label>
        @endif

        {{-- Optional description --}}
        {{ $description ?? null }}
    </div>

    <div class="input-wrapper">
        <textarea
            id="{{ $attributes->get('id') }}"
            name="{{ $attributes->get('name') }}"
            {{ $attributes->whereStartsWith('value') }}
            {{ $attributes->whereStartsWith('wire') }}
            {{ $attributes->whereStartsWith('x-model') }}
        ></textarea>

        {{-- Slot element --}}
        {{ $slot }}
    </div>
</div>
