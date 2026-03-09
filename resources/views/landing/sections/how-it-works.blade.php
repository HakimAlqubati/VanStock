{{-- How It Works Section --}}
<section class="how-it-works section-padding" id="how-it-works">
    <div class="container">
        <div class="section-header reveal">
            <span class="section-badge">{{ __('landing.how_it_works_subtitle') }}</span>
            <h2>{{ __('landing.how_it_works_title') }}</h2>
        </div>

        <div class="timeline-carousel">
            <div class="timeline-track" id="timelineTrack">
                @php
                $steps = [
                ['icon' => '<i class="fa-solid fa-user-plus"></i>'],
                ['icon' => '<i class="fa-solid fa-store"></i>'],
                ['icon' => '<i class="fa-solid fa-box-open"></i>'],
                ['icon' => '<i class="fa-solid fa-truck"></i>'],
                ['icon' => '<i class="fa-solid fa-users"></i>'],
                ['icon' => '<i class="fa-solid fa-file-invoice-dollar"></i>'],
                ['icon' => '<i class="fa-solid fa-chart-line"></i>'],
                ['icon' => '<i class="fa-solid fa-shield-check"></i>'],
                ['icon' => '<i class="fa-solid fa-bullseye"></i>'],
                ['icon' => '<i class="fa-solid fa-trophy"></i>']
                ];
                @endphp

                @foreach($steps as $index => $step)
                <div class="timeline-step {{ $index == 1 ? 'active' : '' }}" data-index="{{ $index }}">
                    <div class="timeline-icon-wrapper reveal">
                        <div class="timeline-number">
                            {{ $index + 1 }}
                        </div>
                    </div>
                    <div class="timeline-content reveal">
                        <h3>
                            {!! $step['icon'] !!}
                            {{ __('landing.step_' . ($index+1) . '_title') }}
                        </h3>
                        <p>{{ __('landing.step_' . ($index+1) . '_desc') }}</p>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="slider-dots" id="sliderDots">
                @foreach($steps as $index => $step)
                <div class="slider-dot {{ $index == 0 ? 'active' : '' }}" onclick="goToSlide({{ $index }})"></div>
                @endforeach
            </div>
        </div>
    </div>
</section>