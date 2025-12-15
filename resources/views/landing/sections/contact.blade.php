{{-- Contact Section --}}
<section class="contact" id="contact">
    <div class="container">
        <div class="section-header reveal">
            <span class="section-badge">{{ __('landing.nav_contact') }}</span>
            <h2>{{ __('landing.contact_title') }}</h2>
            <p>{{ __('landing.contact_subtitle') }}</p>
        </div>

        <div class="contact-grid">
            {{-- <div class="contact-card reveal">
                <div class="contact-icon"><i class="fa-solid fa-envelope"></i></div>
                <h3>{{ __('landing.contact_email') }}</h3>
            <p>hakimahmed123321@gmail.com</p>
        </div> --}}

        <div class="contact-card reveal" style="transition-delay: 0.1s;">
            <div class="contact-icon"><i class="fa-solid fa-phone"></i></div>
            <h3>{{ __('landing.contact_phone') }}</h3>
            <p dir="ltr">+967 0000000</p>
        </div>

        <div class="contact-card reveal" style="transition-delay: 0.2s;">
            <div class="contact-icon"><i class="fa-solid fa-location-dot"></i></div>
            <h3>{{ __('landing.contact_address') }}</h3>
            <p>{{ __('landing.contact_address_value') }}</p>
        </div>
    </div>
    </div>
</section>