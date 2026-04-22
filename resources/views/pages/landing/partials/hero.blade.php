<section id="hero" class="hero">

    <div class="hero__container">

        {{-- Navbar --}}
        @include('pages.landing.partials.navbar')

        {{-- Hero Content --}}
        <div class="hero__content">

            {{-- Copy --}}
            <div class="hero__intro">

                <p class="hero__slugon">
                    {{ $generalSetting['slugon'] }}
                </p>

                <h1 class="hero__description">
                    {{ $generalSetting['description'] }}
                </h1>

                <p class="hero__subtitle">
                    Personalized training and nutrition tailored to your goals, lifestyle, and schedule.
                </p>

                {{-- Actions --}}
                <div class="hero__actions">
                    <a href="#contact" class="btn btn--primary">
                        Start Coaching
                    </a>

                    <a href="#plans" class="btn btn--ghost">
                        Explore Programs
                    </a>
                </div>

                {{-- Badges --}}
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

                    <x-asset.img class="hero__image" folder="branding" img="logo-dark.png"
                        alt="Fitness coaching in action" />

                </div>

            </div>

        </div>

    </div>

</section>