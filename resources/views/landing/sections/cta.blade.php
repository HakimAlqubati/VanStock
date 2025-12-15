{{-- CTA Section --}}
<section class="cta-section" id="cta">
    <div class="container">
        <div class="cta-content reveal">
            <h2>{{ __('landing.cta_title') }}</h2>
            <p>{{ __('landing.cta_subtitle') }}</p>
            @auth
            <a href="/admin" class="btn btn-accent btn-large">{{ __('landing.go_to_dashboard') }}</a>
            @else
            <a href="/admin/login" class="btn btn-accent btn-large">{{ __('landing.cta_button') }}</a>
            @endauth
            {{-- <p class="cta-note">{{ __('landing.cta_note') }}</p> --}}
        </div>
    </div>
</section>