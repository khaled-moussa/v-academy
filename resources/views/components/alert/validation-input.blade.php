@props([
    'error' => null,
])

@error($error)
    <span class="validation-msg"> {{ $message }} </span>
@enderror
