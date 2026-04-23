<section id="hero" class="hero">

    <div class="hero__container">

        {{-- Navbar --}}
        @include('pages.landing.partials.navbar')

        {{-- Hero Content --}}
        <div class="hero__content">

            {{-- Copy --}}
            <div class="hero__intro">

                <p class="hero__tagline">
                    {{ $settings->tagline }}
                </p>

                <h1 class="hero__slugon">
                    {{ $settings->slugon }}
                </h1>

                <p class="hero__description">
                    {{ $settings->description }}
                </p>

                {{-- Actions --}}
                <div class="hero__actions">
                    <x-button.link class="primary-btn" label="Start Coaching" path="#contact" />
                    <x-button.link class="outline-btn" label="Explore Programs" path="#plans" />
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