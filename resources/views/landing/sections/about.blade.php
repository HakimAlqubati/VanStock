{{-- About Section --}}
<section class="about" id="about">
    <div class="container">
        <div class="about-content">
            <div class="about-text reveal">
                <span class="section-badge">{{ __('landing.nav_about') }}</span>
                <h2>{{ __('landing.about_title') }}</h2>
                <p>{{ __('landing.about_description') }}</p>
                <ul class="about-points">
                    <li>{{ __('landing.about_point_1') }}</li>
                    <li>{{ __('landing.about_point_2') }}</li>
                    <li>{{ __('landing.about_point_3') }}</li>
                    <li>{{ __('landing.about_point_4') }}</li>
                    <li>{{ __('landing.about_point_5') }}</li>
                    <li>{{ __('landing.about_point_6') }}</li>
                </ul>
            </div>

            <div class="about-visual reveal" style="transition-delay: 0.2s;">
                <div class="about-stat">
                    <div class="about-stat-icon"><i class="fa-solid fa-boxes-stacked"></i></div>
                    <div class="about-stat-text">
                        <h4>{{ __('landing.feature_inventory_title') }}</h4>
                        <p>{{ __('landing.feature_inventory_desc') }}</p>
                    </div>
                </div>
                <div class="about-stat">
                    <div class="about-stat-icon"><i class="fa-solid fa-coins"></i></div>
                    <div class="about-stat-text">
                        <h4>{{ __('landing.feature_sales_title') }}</h4>
                        <p>{{ __('landing.feature_sales_desc') }}</p>
                    </div>
                </div>
                <div class="about-stat">
                    <div class="about-stat-icon"><i class="fa-solid fa-chart-pie"></i></div>
                    <div class="about-stat-text">
                        <h4>{{ __('landing.feature_reports_title') }}</h4>
                        <p>{{ __('landing.feature_reports_desc') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>