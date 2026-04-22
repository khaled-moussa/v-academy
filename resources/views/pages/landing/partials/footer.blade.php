<footer id="footer" class="footer">

    <div class="footer__container">

        {{-- Brand --}}
        <div class="footer__grid footer__brand">

            <a href="#hero" class="footer__brand-wrapper">

                <div class="footer__brand-header">

                    <span class="brand-mark">
                        <x-asset.img folder="branding" img="logo-transparent.png" />
                    </span>

                    <span class="brand-name">
                        {{ $generalSetting['site_name'] }}
                    </span>

                </div>


                {{-- Info --}}
                <div class="footer__info">

                    {{-- Address --}}
                    @if (!empty($generalSetting['address']))
                        <p class="footer__address">
                            {{ $generalSetting['address'] }}
                        </p>
                    @endif

                    {{-- Email --}}
                    @if (!empty($generalSetting['support_email']))
                        <p class="footer__contact">
                            {{ $generalSetting['support_email'] }}
                        </p>
                    @endif

                    {{-- Phones --}}
                    @if (!empty($generalSetting['phones']))
                        <ul class="footer__phones">
                            @foreach ($generalSetting['phones'] as $phone)
                                <li>
                                    {{ $phone['phone'] }}
                                </li>
                            @endforeach
                        </ul>
                    @endif

                </div>

            </a>

        </div>


        {{-- Explore --}}
        <div class="custom-col-6 custom-col-md-3 footer__links">

            <h4>
                Explore
            </h4>

            <ul>
                <li>
                    <a href="#plans" class="nav__link">Plans</a>
                </li>
                <li>
                    <a href="#about" class="nav__link">About</a>
                </li>
                <li>
                    <a href="#testimonials" class="nav__link">Results</a>
                </li>
            </ul>

        </div>

    </div>


    {{-- Meta --}}
    <div class="footer__meta">
        <p>
            © 2025 Variables Academy. All rights reserved.
        </p>
    </div>

</footer>