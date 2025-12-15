{{-- Navigation Section --}}
<nav class="navbar glass-panel" id="navbar">
    <div class="nav-container">
        <a href="/" class="logo">
            <img src="{{ asset('/imgs/logo.png') }}" alt="VanStock">
            <span>VanStock</span>
        </a>

        <ul class="nav-links">
            <li><a href="#home">{{ __('landing.nav_home') }}</a></li>
            <li><a href="#features">{{ __('landing.nav_features') }}</a></li>
            <li><a href="#modules">{{ __('landing.nav_modules') }}</a></li>
            <li><a href="#about">{{ __('landing.nav_about') }}</a></li>
            <li><a href="#contact">{{ __('landing.nav_contact') }}</a></li>
        </ul>

        <div class="nav-actions">
            <a href="{{ url('locale/' . (app()->getLocale() == 'ar' ? 'en' : 'ar')) }}" class="lang-switch">
                {{ app()->getLocale() == 'ar' ? 'EN' : 'عربي' }}
            </a>
            @auth
            <a href="/admin" class="btn btn-primary">{{ __('landing.go_to_dashboard') }}</a>
            @else
            <a href="/admin/login" class="btn btn-primary">{{ __('landing.login') }}</a>
            @endauth
        </div>
    </div>
</nav>