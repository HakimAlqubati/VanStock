{{-- Footer Section --}}
<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-brand">
                <a href="/" class="logo">
                    <img src="{{ asset('/imgs/logo.png') }}" alt="VanStock">
                    <span>VanStock</span>
                </a>
                <p>{{ __('landing.footer_description') }}</p>
            </div>

            <div class="footer-links">
                <h4>{{ __('landing.footer_links_title') }}</h4>
                <ul>
                    <li><a href="#home">{{ __('landing.nav_home') }}</a></li>
                    <li><a href="#features">{{ __('landing.nav_features') }}</a></li>
                    <li><a href="#modules">{{ __('landing.nav_modules') }}</a></li>
                    <li><a href="#about">{{ __('landing.nav_about') }}</a></li>
                    <li><a href="#faq">FAQ</a></li>
                </ul>
            </div>

            <div class="footer-contact">
                <h4>{{ __('landing.footer_contact_title') }}</h4>
                {{-- <p>📧 hakimahmed123321@gmail.com</p> --}}
                <p dir="ltr">📞 +967 0000000</p>
                <p>📍 {{ __('landing.contact_address_value') }}</p>
            </div>
        </div>

        <div class="footer-bottom">
            <div>© {{ date('Y') }} VanStock. {{ __('landing.footer_rights') }}</div>
            <div>{{ __('landing.footer_powered_by') . ' VanStock Team' }} </div>
        </div>
    </div>
</footer>