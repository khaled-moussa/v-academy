<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('layouts.partials.head')

    <style>
        {!! file_get_contents(public_path('build/assets/app.css')) !!} 
        {!! file_get_contents(public_path('build/assets/_pdf.css')) !!}
    </style>
</head>

<body>

    {{-- Header --}}
    <x-template.pdf.header
        :subject="$subject"
        :description="$description"
    />

    {{-- Main Content --}}
    <main class="pdf-content">
        @yield('content')
    </main>

    {{-- Footer --}}
    <x-template.pdf.footer />

</body>

</html>
