<section id="hero" class="hero">

    <div class="custom-container">

        {{-- Navbar --}}
        @include('pages.landing.partials.navbar')

        {{-- Hero Content --}}
        <div class="hero__content">

            {{-- Copy --}}
            <div class="hero__copy">

                <div class="hero__eyebrow">
                    1:1 Sessions & In-Person Coaching
                </div>

                <h1 class="hero__title">
                    {{ $generalSetting['slugon'] }}
                </h1>

                <p class="hero__subtitle">
                    {{ $generalSetting['description'] }}
                </p>

                <div class="hero__actions">
                    <a href="#contact" class="btn btn--primary">
                        Start Coaching
                    </a>

                    <a href="#plans" class="btn btn--ghost">
                        Explore Programs
                    </a>
                </div>

                <ul class="hero__badges">
                    <li>Custom Plans</li>
                    <li>Weekly Check-ins</li>
                    <li>Results-Driven</li>
                </ul>

            </div>

            {{-- Visual --}}
            <div class="hero__visual">
                <div class="hero__image-stack">
                    <div class="hero__glow"></div>

                    <x-asset.img class="hero__image" folder="branding" img="logo-dark.png" alt="Fitness coaching in action" />
                </div>
            </div>

        </div>
    </div>
</section>