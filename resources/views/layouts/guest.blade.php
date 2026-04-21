<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('layouts.partials.head')

<body>
    {{-- Main Content --}}
    @yield('content')
</body>

</html>
