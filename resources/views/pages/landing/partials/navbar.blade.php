<header class="nav nav--hero">

    <input type="checkbox" id="nav-toggle" class="nav__checkbox" aria-hidden="true">

    {{-- Brand --}}
    <a class="brand" href="#hero">

        <span class="brand-mark">
            <x-asset.img folder="branding" img="logo-transparent.png" />
        </span>

        <span class="brand-name">
            {{ $settings->site_name }}
        </span>

    </a>

    {{-- Navigation --}}
    <nav class="nav__menu" aria-label="Primary" id="nav-menu">

        <a href="#plans" class="nav__link">Plans</a>
        <a href="#about" class="nav__link">About</a>
        <a href="#testimonials" class="nav__link">Results</a>
        <a href="#contact" class="nav__link">Contact</a>

        @guest
            <x-button.link class="outline-btn outline-btn--bg" label="Sign In" :path="route('filament.auth.auth.login')" />
        @endguest

        @auth
            <x-button.link class="outline-btn outline-btn--bg" :label="$user->full_name" :path="route('filament.auth.auth.login')" />
        @endauth
    </nav>

    {{-- Toggle --}}
    <label class="nav__toggle" for="nav-toggle" aria-label="Toggle navigation" aria-controls="nav-menu"
        aria-expanded="false">
        <span></span>
        <span></span>
        <span></span>
    </label>

</header>