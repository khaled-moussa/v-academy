<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('layouts.partials.head')

</head>

<body class="loader">
    {{-- Navbar --}}
    @yield('navbar')

    {{-- Main Content --}}
    @yield('content')

    {{-- Footer --}}
    @yield('footer')

    @include('layouts.partials.scripts')
</body>

</html>
