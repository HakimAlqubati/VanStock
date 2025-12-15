{{-- Modules Section --}}
<section class="modules" id="modules">
    <div class="container">
        <div class="section-header reveal">
            <span class="section-badge">{{ __('landing.nav_modules') }}</span>
            <h2>{{ __('landing.modules_title') }}</h2>
            <p>{{ __('landing.modules_subtitle') }}</p>
        </div>

        <div class="modules-grid">
            <div class="module-card reveal">
                <div class="module-header">
                    <div class="module-icon"><i class="fa-solid fa-boxes-stacked"></i></div>
                    <h3>{{ __('landing.module_inventory_title') }}</h3>
                </div>
                <div class="module-features">
                    @foreach(explode('|', __('landing.module_inventory_features')) as $feature)
                    <div class="module-feature">{{ $feature }}</div>
                    @endforeach
                </div>
            </div>

            <div class="module-card reveal" style="transition-delay: 0.1s;">
                <div class="module-header">
                    <div class="module-icon"><i class="fa-solid fa-coins"></i></div>
                    <h3>{{ __('landing.module_sales_title') }}</h3>
                </div>
                <div class="module-features">
                    @foreach(explode('|', __('landing.module_sales_features')) as $feature)
                    <div class="module-feature">{{ $feature }}</div>
                    @endforeach
                </div>
            </div>

            <div class="module-card reveal" style="transition-delay: 0.2s;">
                <div class="module-header">
                    <div class="module-icon"><i class="fa-solid fa-users-gear"></i></div>
                    <h3>{{ __('landing.module_crm_title') }}</h3>
                </div>
                <div class="module-features">
                    @foreach(explode('|', __('landing.module_crm_features')) as $feature)
                    <div class="module-feature">{{ $feature }}</div>
                    @endforeach
                </div>
            </div>

            <div class="module-card reveal" style="transition-delay: 0.3s;">
                <div class="module-header">
                    <div class="module-icon"><i class="fa-solid fa-truck-fast"></i></div>
                    <h3>{{ __('landing.module_hr_title') }}</h3>
                </div>
                <div class="module-features">
                    @foreach(explode('|', __('landing.module_hr_features')) as $feature)
                    <div class="module-feature">{{ $feature }}</div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>