{{-- Hero Section --}}
<section class="hero section-padding" id="home">
    <div class="container">
        <div class="hero-content">
            <div class="hero-text reveal">
                <span class="hero-badge"><i class="fa-solid fa-sparkles"></i> {{ __('landing.hero_subtitle') }}</span>
                <h1>{{ __('landing.hero_title') }}</h1>
                <p>{{ __('landing.hero_description') }}</p>
                <div class="hero-buttons">
                    @auth
                    <a href="/admin" class="btn btn-accent btn-large">{{ __('landing.go_to_dashboard') }}</a>
                    @else
                    <a href="/admin/login" class="btn btn-primary btn-large">{{ __('landing.hero_cta') }}</a>
                    @endauth
                    <a href="#features" class="btn btn-secondary btn-large">{{ __('landing.hero_learn_more') }}</a>
                </div>
            </div>

            <div class="hero-visual reveal">
                <div class="hero-mockup">
                    <img src="{{ asset('/imgs/dashboard-preview.png') }}" alt="VanStock Dashboard">
                </div>
            </div>
        </div>
    </div>
</section>