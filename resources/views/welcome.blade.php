<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ __('landing.hero_description') }}">
    <meta name="keywords" content="VanStock, inventory, sales, distribution, مخزون, مبيعات, توزيع">
    <title> {{ __('landing.hero_title') }}</title>
    <link rel="icon" href="{{ asset('/imgs/logo.png') }}" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&family=Almarai:wght@300;400;700;800&family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('css/landing/style.css') }}">
</head>

<body>
    <div class="universe-bg"></div>

    {{-- Navigation --}}
    @include('landing.sections.navigation')

    {{-- Hero Section --}}
    @include('landing.sections.hero')

    {{-- Features Section --}}
    @include('landing.sections.features')

    {{-- How It Works Section --}}
    @include('landing.sections.how-it-works')

    {{-- Stats Section --}}
    @include('landing.sections.stats')

    {{-- Modules Section --}}
    @include('landing.sections.modules')

    {{-- Why VanStock Section --}}
    @include('landing.sections.why')

    {{-- FAQ Section --}}
    @include('landing.sections.faq')

    {{-- About Section --}}
    @include('landing.sections.about')

    {{-- CTA Section --}}
    @include('landing.sections.cta')

    {{-- Contact Section --}}
    @include('landing.sections.contact')

    {{-- Footer --}}
    @include('landing.sections.footer')

    {{-- Floating Buttons --}}
    @include('landing.sections.floating-buttons')

    <script src="{{ asset('js/landing/script.js') }}"></script>
</body>

</html>