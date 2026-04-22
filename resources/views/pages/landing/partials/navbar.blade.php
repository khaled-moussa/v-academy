<header class="nav nav--hero">
    <input type="checkbox" id="nav-toggle" class="nav__checkbox" aria-hidden="true">

    {{-- Brand --}}
    <a class="nav__brand" href="#hero">
        <span class="brand-mark">
            <x-asset.img folder="branding" img="logo-transparent.png" />
        </span>

        <span class="brand-name">
            {{ $generalSetting['site_name']  }}
        </span>
    </a>

    {{-- Navigation --}}
    <nav class="nav__menu" aria-label="Primary" id="nav-menu">
        <a href="#plans" class="nav__link">Plans</a>
        <a href="#about" class="nav__link">About</a>
        <a href="#testimonials" class="nav__link">Results</a>
        <a href="#contact" class="nav__link">Contact</a>
        <a href="{{ route('filament.auth.auth.login') }}" class="nav__cta">Sign In</a>
    </nav>

    {{-- Mobile Toggle --}}
    <label class="nav__toggle" for="nav-toggle" aria-label="Toggle navigation" aria-controls="nav-menu"
        aria-expanded="false">
        <span></span>
        <span></span>
        <span></span>
    </label>
</header>