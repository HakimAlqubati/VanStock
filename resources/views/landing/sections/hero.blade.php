{{-- Hero Section --}}
<section class="hero" id="home">
    <div class="container">
        <div class="hero-content">
            <div class="hero-text reveal">
                <span class="hero-badge">✨ {{ __('landing.hero_subtitle') }}</span>
                <h1>{{ __('landing.hero_title') }}</h1>
                <h2>{{ __('landing.hero_subtitle') }}</h2>
                <p>{{ __('landing.hero_description') }}</p>
                <div class="hero-buttons">
                    @auth
                    <a href="/admin" class="btn btn-accent btn-large">{{ __('landing.go_to_dashboard') }}</a>
                    @else
                    <a href="/admin/login" class="btn btn-accent btn-large">{{ __('landing.hero_cta') }}</a>
                    @endauth
                    <a href="#features" class="btn btn-primary btn-large">{{ __('landing.hero_learn_more') }}</a>
                </div>
            </div>

            <div class="hero-visual floating reveal" style="transition-delay: 0.2s;">
                <div class="hero-mockup glass-panel" style="padding: 0; overflow: hidden;">
                    <img src="{{ asset('/imgs/dashboard-preview.png') }}" alt="VanStock Dashboard" style="width: 100%; height: auto; display: block; border-radius: 20px;">
                </div>
            </div>
        </div>
    </div>
</section>