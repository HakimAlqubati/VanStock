{{-- FAQ Section --}}
<section class="faq section-padding" id="faq">
    <div class="container">
        <div class="section-header reveal">
            <span class="section-badge"><i class="fas fa-question-circle"></i> FAQ</span>
            <h2>{{ __('landing.faq_title') }}</h2>
            <p>{{ __('landing.faq_subtitle') }}</p>
        </div>

        <div class="faq-container">
            <div class="faq-accordion">
                @php
                $faqs = [
                ['q' => __('landing.faq_1_q'), 'a' => __('landing.faq_1_a')],
                ['q' => __('landing.faq_2_q'), 'a' => __('landing.faq_2_a')],
                ['q' => __('landing.faq_3_q'), 'a' => __('landing.faq_3_a')],
                ['q' => __('landing.faq_4_q'), 'a' => __('landing.faq_4_a')],
                ['q' => __('landing.faq_5_q'), 'a' => __('landing.faq_5_a')],
                ];
                @endphp

                @foreach($faqs as $index => $faq)
                <div class="faq-item reveal" data-index="{{ $index }}">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <div style="display: flex; align-items: center; width: 100%;">
                            <span class="faq-number">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                            <span class="faq-text">{{ $faq['q'] }}</span>
                        </div>
                        <span class="faq-icon">
                            <i class="fas fa-chevron-down"></i>
                        </span>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-answer-content">
                            <i class="fas fa-lightbulb faq-answer-icon"></i>
                            <p>{{ $faq['a'] }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>