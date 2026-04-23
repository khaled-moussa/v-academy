<footer id="footer" class="footer">

    <div class="footer__container">

        {{-- Brand --}}
        <div class="footer__brand">

            <a href="#hero" class="footer__brand-wrapper">

                {{-- Brand Header --}}
                <div class="footer__brand-header">

                    <span class="brand-mark">
                        <x-asset.img folder="branding" img="logo-transparent.png" />
                    </span>

                    <span class="brand-name">
                        {{ $settings->site_name }}
                    </span>

                </div>

                {{-- Info --}}
                <div class="footer__info">

                    {{-- Address --}}
                    @if (!empty($settings->address))
                        <p class="footer__address">{{ $settings->address }}</p>
                    @endif

                    {{-- Email --}}
                    @if (!empty($settings->support_email))
                        <p class="footer__contact">{{ $settings->support_email }}</p>
                    @endif

                    {{-- Phones --}}
                    @if (!empty($settings->phones))
                        <ul class="footer__phones">
                            @foreach ($settings->phones as $phone)
                                <li>{{ $phone }}</li>
                            @endforeach
                        </ul>
                    @endif

                    {{-- Social --}}
                    @if (!empty($settings->social_links))
                        <ul class="footer__social">
                            @foreach ($settings->social_links as $social)
                                <li>
                                    <a href="{{ $social['link'] }}" target="_blank" class="footer__social-link">
                                        <i class="fi fi-brands-{{ $social['type'] }}"></i>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif

                </div>

            </a>

        </div>

        {{-- Links --}}
        <div class="footer__links">

            <h4>Explore</h4>

            <ul>
                <li><a href="#plans" class="nav__link">Plans</a></li>
                <li><a href="#about" class="nav__link">About</a></li>
                <li><a href="#testimonials" class="nav__link">Results</a></li>
                <li><a href="#testimonials" class="nav__link">Contact</a></li>
            </ul>

        </div>

    </div>

    {{-- Meta --}}
    <div class="footer__meta">
        <p>© 2025 Variables Academy. All rights reserved.</p>
    </div>

</footer>