<section id="testimonials" class="testimonials section">

    <div class="testimonials__container">

        {{-- Header --}}
        <div class="testimonials__header">
            <h2 class="section__title">
                Results & Testimonials
            </h2>

            <p class="lead">
                Real athletes. Real progress. A glimpse into the journey and outcomes from Variables Academy coaching.
            </p>
        </div>


        {{-- Grid --}}
        <div class="testimonials__grid">
            @foreach ($settings->youtube_links as $youtube)
                {{-- Card --}}
                <div class="video-card">
                    <div class="video-wrap">
                        <iframe class="video" src="{{ $youtube['embed'] }}" title={{ $youtube['title'] }}
                            allowfullscreen></iframe>
                    </div>

                    <div class="video-meta">
                        {{ $youtube['title']  }}
                    </div>
                </div>
            @endforeach
        </div>

        {{-- CTA --}}
        <div class="testimonials__footer">
            <a href="https://www.youtube.com/@" target="_blank" class="btn btn--ghost testimonials__more">
                View more
            </a>
        </div>
</section>