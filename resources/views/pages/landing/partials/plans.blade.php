@props([
    'plans' => [],
])

<section id="plans" class="plan section">

    <div class="plan__container">

        {{-- Header --}}
        <header class="plan__header">
            <h2 class="section__title">
                Plan & Pricing
            </h2>

            <p class="lead">
                Choose a plan that fits your goals. Train 1-on-1 or in a small group, with optional nutrition planning.
            </p>
        </header>


        {{-- Plans --}}
        <div class="plan__grid">

            @foreach ($plans as $plan)

                {{-- Card --}}
                <div class="plan-card">

                    {{-- Head --}}
                    <div class="plan-card__head">
                        <h3 class="plan-card__title">
                            {{ $plan['name'] }}
                        </h3>

                        <span @class([
                            'plan-card__badge',
                            'hidden' => empty($plan['is_popular']),
                        ])>
                            Popular
                        </span>
                    </div>


                    {{-- List --}}
                    <ul class="plan-card__list">

                        {{-- Sessions --}}
                        <li class="plan-card__item">
                            <span>
                                {{ $plan['no_of_sessions'] }} Sessions
                            </span>
                        </li>


                        {{-- Price --}}
                        <li class="plan-card__price-wrapper">

                            {{-- Old / Base Price --}}
                            <span @class([
                                'plan-card__old-price' => $plan['has_discount'],
                                'plan-card__price' => !$plan['has_discount'],
                            ])>
                                {{ $plan['price'] }} EGP
                            </span>

                            {{-- Discount Price --}}
                            @if ($plan['has_discount'])
                                <span class="plan-card__price plan-card__price--discount">
                                    {{ $plan['price_discount'] }} EGP
                                </span>
                            @endif

                        </li>


                        <hr class="divider">

                        {{-- Includes --}}
                        @foreach ($plan['includes'] ?? [] as $include)
                            <li class="plan-card__item">
                                {{ $include }}
                            </li>
                        @endforeach
                    </ul>

                    {{-- CTA --}}
                    <x-button.link class="primary-btn primary-btn--center" label="Choose {{ $plan['name'] }}" :path="route('filament.auth.auth.register')"/>
                </div>
            @endforeach
        </div>
    </div>
</section>