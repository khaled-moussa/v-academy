{{-- Meta --}}
<meta charset="utf-8">
<meta
    name="viewport"
    content="width=device-width, initial-scale=1, maximum-scale=1"
>

{{-- Title --}}
<title>
    @yield('title', config('app.name'))
</title>

{{-- Favicon --}}
<link rel="icon" href="{{ asset('favicon.ico') }}">

{{-- App Assets --}}
{{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}

{{-- Extra Head --}}
@stack('head')
