<section id="contact" class="contact">

    <div class="contact__container">

        {{-- Header --}}
        <div class="contact__header">
            <h2 class="section__title">
                Contact Us
            </h2>

            <p class="lead">
                Reach out and start your journey. Share your goals and we’ll help you build the right plan.
            </p>
        </div>


        {{-- Form --}}
        <form class="contact__form">

            {{-- Name --}}
            <x-form.input
                type="text"
                id="name"
                label="Full name"
                placeholder="Ex. John Doe"
                wire:model="name"
                :error="$errors->first('name')"
                required
            />


            {{-- Email --}}
            <x-form.input
                type="email"
                id="email"
                label="Email"
                placeholder="Ex. username@example.com"
                wire:model="email"
                :error="$errors->first('email')"
                required
            />


            {{-- Phone --}}
            <x-form.input
                type="tel"
                id="phone"
                label="Phone"
                placeholder="Ex. 01000xxxxxx"
                wire:model="phone"
                :error="$errors->first('phone')"
                required
            />


            {{-- Message --}}
            <x-form.textarea
                label="Message"
            />

        </form>

    </div>

</section>