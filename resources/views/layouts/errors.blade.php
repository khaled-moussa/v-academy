@include('layouts.partials.head')

<head>
    @vite(['resources/css/pages/errors/_errors.css'])
</head>

<body>

    {{-- Page Wrapper --}}
    <div class="under-dev-page">

        {{-- Content --}}
        <div class="under-dev-content">

            {{-- Pulse (Optional) --}}
            @hasSection('pulse')
                <span class="under-dev-pulse">
                    <span class="dot"></span>
                    <span class="dot-shadow"></span>
                </span>
            @endif

            {{-- Header --}}
            <div class="under-dev-header">
                <h1 class="under-dev-code">
                    @yield('code')
                </h1>

                <h1 class="under-dev-title">
                    @yield('title')
                </h1>
            </div>

            {{-- Message --}}
            <p class="under-dev-subtitle">
                @yield('message')
            </p>

            {{-- Button (Optional) --}}
            @hasSection('button')
                <p class="under-dev-button">
                    <x-button.link class="outline-btn" label="Go Home" :path="url('redirect')" />
                </p>
            @endif

        </div>
    </div>
</body>