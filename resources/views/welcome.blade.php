<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VanStock - {{ __('landing.hero_title') }}</title>
    <link rel="icon" href="{{ asset('/imgs/logo.png') }}" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Tajawal:wght@300;400;500;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #00172c;
            --primary-light: #002744;
            --secondary: #0ea5e9;
            --accent: #06b6d4;
            --text: #1e293b;
            --text-light: #64748b;
            --white: #ffffff;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gradient-primary: linear-gradient(135deg, #00172c 0%, #003366 100%);
            --gradient-accent: linear-gradient(135deg, #0ea5e9 0%, #06b6d4 100%);
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: {
                    {
                    app()->getLocale()=='ar' ? "'Tajawal', sans-serif": "'Inter', sans-serif"
                }
            }

            ;
            color: var(--text);
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* Container */
        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        /* Navigation */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--gray-200);
            transition: all 0.3s ease;
        }

        .navbar.scrolled {
            box-shadow: var(--shadow);
        }

        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 2rem;
            max-width: 1280px;
            margin: 0 auto;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 800;
            font-size: 1.5rem;
            color: var(--primary);
            text-decoration: none;
        }

        .logo img {
            height: 40px;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 2.5rem;
            list-style: none;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--text);
            font-weight: 500;
            transition: color 0.3s ease;
            position: relative;
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--secondary);
            transition: width 0.3s ease;
        }

        .nav-links a:hover {
            color: var(--secondary);
        }

        .nav-links a:hover::after {
            width: 100%;
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .lang-switch {
            padding: 0.5rem 1rem;
            background: var(--gray-100);
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            color: var(--text);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .lang-switch:hover {
            background: var(--gray-200);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            gap: 0.5rem;
        }

        .btn-primary {
            background: var(--gradient-primary);
            color: var(--white);
            box-shadow: var(--shadow);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .btn-secondary {
            background: var(--white);
            color: var(--primary);
            border: 2px solid var(--gray-200);
        }

        .btn-secondary:hover {
            border-color: var(--secondary);
            color: var(--secondary);
        }

        .btn-accent {
            background: var(--gradient-accent);
            color: var(--white);
            padding: 1rem 2rem;
            font-size: 1.1rem;
        }

        /* Hero Section */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            background: var(--gradient-primary);
            position: relative;
            overflow: hidden;
            padding-top: 80px;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.5;
        }

        .hero-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
            position: relative;
            z-index: 1;
        }

        .hero-text {
            color: var(--white);
        }

        .hero-badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.875rem;
            margin-bottom: 1.5rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 1.5rem;
        }

        .hero h2 {
            font-size: 1.5rem;
            font-weight: 400;
            opacity: 0.9;
            margin-bottom: 1rem;
        }

        .hero p {
            font-size: 1.1rem;
            opacity: 0.8;
            margin-bottom: 2rem;
            line-height: 1.8;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .hero-visual {
            position: relative;
        }

        .hero-mockup {
            background: var(--white);
            border-radius: 20px;
            padding: 1rem;
            box-shadow: var(--shadow-xl);
            transform: perspective(1000px) rotateY(-5deg) rotateX(5deg);
            transition: transform 0.5s ease;
        }

        .hero-mockup:hover {
            transform: perspective(1000px) rotateY(0) rotateX(0);
        }

        .mockup-header {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .mockup-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
        }

        .mockup-dot.red {
            background: #ef4444;
        }

        .mockup-dot.yellow {
            background: #eab308;
        }

        .mockup-dot.green {
            background: #22c55e;
        }

        .mockup-content {
            background: var(--gray-100);
            border-radius: 12px;
            padding: 2rem;
            min-height: 400px;
        }

        .mockup-nav {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .mockup-nav-item {
            height: 10px;
            background: var(--gray-200);
            border-radius: 5px;
        }

        .mockup-cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .mockup-card {
            background: var(--white);
            padding: 1rem;
            border-radius: 10px;
            box-shadow: var(--shadow-sm);
        }

        .mockup-card-icon {
            width: 30px;
            height: 30px;
            background: var(--gradient-accent);
            border-radius: 8px;
            margin-bottom: 0.75rem;
        }

        .mockup-card-text {
            height: 8px;
            background: var(--gray-200);
            border-radius: 4px;
            margin-bottom: 0.5rem;
        }

        .mockup-card-text.short {
            width: 60%;
        }

        .mockup-table {
            background: var(--white);
            border-radius: 10px;
            padding: 1rem;
            box-shadow: var(--shadow-sm);
        }

        .mockup-table-row {
            display: flex;
            gap: 1rem;
            padding: 0.75rem 0;
            border-bottom: 1px solid var(--gray-100);
        }

        .mockup-table-cell {
            height: 8px;
            background: var(--gray-200);
            border-radius: 4px;
            flex: 1;
        }

        /* Features Section */
        .features {
            padding: 6rem 0;
            background: var(--white);
        }

        .section-header {
            text-align: center;
            max-width: 600px;
            margin: 0 auto 4rem;
        }

        .section-header h2 {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--primary);
            margin-bottom: 1rem;
        }

        .section-header p {
            font-size: 1.1rem;
            color: var(--text-light);
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
        }

        .feature-card {
            background: var(--white);
            padding: 2rem;
            border-radius: 16px;
            border: 1px solid var(--gray-200);
            transition: all 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-xl);
            border-color: transparent;
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            background: var(--gradient-accent);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
        }

        .feature-card h3 {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 0.75rem;
        }

        .feature-card p {
            color: var(--text-light);
            line-height: 1.7;
        }

        /* Stats Section */
        .stats {
            padding: 5rem 0;
            background: var(--gradient-primary);
            color: var(--white);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 2rem;
            text-align: center;
        }

        .stat-item {
            padding: 2rem;
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            background: var(--gradient-accent);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .stat-label {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        /* Screenshots Section */
        .screenshots {
            padding: 6rem 0;
            background: var(--gray-100);
        }

        .screenshots-tabs {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 3rem;
            flex-wrap: wrap;
        }

        .tab-btn {
            padding: 1rem 2rem;
            background: var(--white);
            border: 2px solid var(--gray-200);
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .tab-btn.active,
        .tab-btn:hover {
            background: var(--primary);
            color: var(--white);
            border-color: var(--primary);
        }

        .screenshot-display {
            background: var(--white);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: var(--shadow-xl);
            max-width: 1000px;
            margin: 0 auto;
        }

        .screenshot-placeholder {
            background: linear-gradient(135deg, var(--gray-100) 0%, var(--gray-200) 100%);
            border-radius: 12px;
            min-height: 500px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 1rem;
        }

        .screenshot-placeholder svg {
            width: 80px;
            height: 80px;
            opacity: 0.3;
        }

        .screenshot-placeholder span {
            color: var(--text-light);
            font-size: 1.2rem;
        }

        /* About Section */
        .about {
            padding: 6rem 0;
            background: var(--white);
        }

        .about-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }

        .about-text h2 {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--primary);
            margin-bottom: 1.5rem;
        }

        .about-text p {
            font-size: 1.1rem;
            color: var(--text-light);
            margin-bottom: 2rem;
            line-height: 1.8;
        }

        .about-points {
            list-style: none;
        }

        .about-points li {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem 0;
            border-bottom: 1px solid var(--gray-100);
        }

        .about-points li:last-child {
            border-bottom: none;
        }

        .check-icon {
            width: 28px;
            height: 28px;
            background: var(--gradient-accent);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            flex-shrink: 0;
        }

        .about-visual {
            position: relative;
        }

        .about-image {
            background: var(--gradient-primary);
            border-radius: 20px;
            padding: 3rem;
            color: var(--white);
            position: relative;
            overflow: hidden;
        }

        .about-image::before {
            content: '';
            position: absolute;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            top: -50px;
            right: -50px;
        }

        .about-logo {
            width: 120px;
            margin-bottom: 2rem;
            filter: brightness(0) invert(1);
        }

        .about-stats {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }

        .about-stat {
            background: rgba(255, 255, 255, 0.1);
            padding: 1.5rem;
            border-radius: 12px;
        }

        .about-stat-number {
            font-size: 2rem;
            font-weight: 800;
        }

        .about-stat-label {
            opacity: 0.8;
        }

        /* Contact Section */
        .contact {
            padding: 6rem 0;
            background: var(--gray-100);
        }

        .contact-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            max-width: 900px;
            margin: 0 auto;
        }

        .contact-card {
            background: var(--white);
            padding: 2rem;
            border-radius: 16px;
            text-align: center;
            box-shadow: var(--shadow);
            transition: all 0.3s ease;
        }

        .contact-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-xl);
        }

        .contact-icon {
            width: 60px;
            height: 60px;
            background: var(--gradient-accent);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 1.5rem;
        }

        .contact-card h3 {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-light);
            margin-bottom: 0.5rem;
        }

        .contact-card p {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--primary);
        }

        /* Footer */
        .footer {
            background: var(--primary);
            color: var(--white);
            padding: 3rem 0;
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .footer-logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 700;
            font-size: 1.25rem;
        }

        .footer-logo img {
            height: 35px;
            filter: brightness(0) invert(1);
        }

        .footer-text {
            opacity: 0.8;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .hero-content {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .hero-buttons {
                justify-content: center;
            }

            .hero-visual {
                display: none;
            }

            .features-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .about-content {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }

            .hero h1 {
                font-size: 2.5rem;
            }

            .features-grid {
                grid-template-columns: 1fr;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .contact-grid {
                grid-template-columns: 1fr;
            }

            .footer-content {
                flex-direction: column;
                text-align: center;
            }
        }

        /* Animations */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        .floating {
            animation: float 6s ease-in-out infinite;
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar" id="navbar">
        <div class="nav-container">
            <a href="/" class="logo">
                <img src="{{ asset('/imgs/logo.png') }}" alt="VanStock">
                <span>VanStock</span>
            </a>

            <ul class="nav-links">
                <li><a href="#home">{{ __('landing.nav_home') }}</a></li>
                <li><a href="#features">{{ __('landing.nav_features') }}</a></li>
                <li><a href="#about">{{ __('landing.nav_about') }}</a></li>
                <li><a href="#contact">{{ __('landing.nav_contact') }}</a></li>
            </ul>

            <div class="nav-actions">
                <a href="{{ url('locale/' . (app()->getLocale() == 'ar' ? 'en' : 'ar')) }}" class="lang-switch">
                    {{ __('landing.language') }}
                </a>
                @auth
                <a href="/admin" class="btn btn-primary">
                    {{ __('landing.go_to_dashboard') }}
                </a>
                @else
                <a href="/admin/login" class="btn btn-primary">
                    {{ __('landing.login') }}
                </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="container">
            <div class="hero-content">
                <div class="hero-text">
                    <span class="hero-badge">✨ {{ __('landing.hero_subtitle') }}</span>
                    <h1>{{ __('landing.hero_title') }}</h1>
                    <h2>{{ __('landing.hero_subtitle') }}</h2>
                    <p>{{ __('landing.hero_description') }}</p>
                    <div class="hero-buttons">
                        @auth
                        <a href="/admin" class="btn btn-accent">{{ __('landing.go_to_dashboard') }}</a>
                        @else
                        <a href="/admin/login" class="btn btn-accent">{{ __('landing.hero_cta') }}</a>
                        @endauth
                        <a href="#features" class="btn btn-secondary" style="background: rgba(255,255,255,0.1); color: white; border-color: rgba(255,255,255,0.3);">
                            {{ __('landing.hero_learn_more') }}
                        </a>
                    </div>
                </div>

                <div class="hero-visual floating">
                    <div class="hero-mockup">
                        <div class="mockup-header">
                            <div class="mockup-dot red"></div>
                            <div class="mockup-dot yellow"></div>
                            <div class="mockup-dot green"></div>
                        </div>
                        <div class="mockup-content">
                            <div class="mockup-nav">
                                <div class="mockup-nav-item" style="width: 60px;"></div>
                                <div class="mockup-nav-item" style="width: 80px;"></div>
                                <div class="mockup-nav-item" style="width: 70px;"></div>
                                <div class="mockup-nav-item" style="width: 90px;"></div>
                            </div>
                            <div class="mockup-cards">
                                <div class="mockup-card">
                                    <div class="mockup-card-icon"></div>
                                    <div class="mockup-card-text"></div>
                                    <div class="mockup-card-text short"></div>
                                </div>
                                <div class="mockup-card">
                                    <div class="mockup-card-icon"></div>
                                    <div class="mockup-card-text"></div>
                                    <div class="mockup-card-text short"></div>
                                </div>
                                <div class="mockup-card">
                                    <div class="mockup-card-icon"></div>
                                    <div class="mockup-card-text"></div>
                                    <div class="mockup-card-text short"></div>
                                </div>
                            </div>
                            <div class="mockup-table">
                                <div class="mockup-table-row">
                                    <div class="mockup-table-cell"></div>
                                    <div class="mockup-table-cell"></div>
                                    <div class="mockup-table-cell"></div>
                                </div>
                                <div class="mockup-table-row">
                                    <div class="mockup-table-cell"></div>
                                    <div class="mockup-table-cell"></div>
                                    <div class="mockup-table-cell"></div>
                                </div>
                                <div class="mockup-table-row">
                                    <div class="mockup-table-cell"></div>
                                    <div class="mockup-table-cell"></div>
                                    <div class="mockup-table-cell"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="container">
            <div class="section-header">
                <h2>{{ __('landing.features_title') }}</h2>
                <p>{{ __('landing.features_subtitle') }}</p>
            </div>

            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">📦</div>
                    <h3>{{ __('landing.feature_inventory_title') }}</h3>
                    <p>{{ __('landing.feature_inventory_desc') }}</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">💰</div>
                    <h3>{{ __('landing.feature_sales_title') }}</h3>
                    <p>{{ __('landing.feature_sales_desc') }}</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">👥</div>
                    <h3>{{ __('landing.feature_reps_title') }}</h3>
                    <p>{{ __('landing.feature_reps_desc') }}</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">🏢</div>
                    <h3>{{ __('landing.feature_customers_title') }}</h3>
                    <p>{{ __('landing.feature_customers_desc') }}</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">📊</div>
                    <h3>{{ __('landing.feature_reports_title') }}</h3>
                    <p>{{ __('landing.feature_reports_desc') }}</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">🏪</div>
                    <h3>{{ __('landing.feature_multi_store_title') }}</h3>
                    <p>{{ __('landing.feature_multi_store_desc') }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats">
        <div class="container">
            <div class="section-header" style="color: white;">
                <h2 style="color: white;">{{ __('landing.stats_title') }}</h2>
            </div>
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-number">1000+</div>
                    <div class="stat-label">{{ __('landing.stats_products') }}</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">500+</div>
                    <div class="stat-label">{{ __('landing.stats_transactions') }}</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">10+</div>
                    <div class="stat-label">{{ __('landing.stats_stores') }}</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">50+</div>
                    <div class="stat-label">{{ __('landing.stats_reps') }}</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Screenshots Section -->
    <section class="screenshots" id="screenshots">
        <div class="container">
            <div class="section-header">
                <h2>{{ __('landing.screenshots_title') }}</h2>
                <p>{{ __('landing.screenshots_subtitle') }}</p>
            </div>

            <div class="screenshots-tabs">
                <button class="tab-btn active">{{ __('landing.screen_dashboard') }}</button>
                <button class="tab-btn">{{ __('landing.screen_inventory') }}</button>
                <button class="tab-btn">{{ __('landing.screen_sales') }}</button>
                <button class="tab-btn">{{ __('landing.screen_reports') }}</button>
            </div>

            <div class="screenshot-display">
                <div class="screenshot-placeholder">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <span>{{ __('landing.screen_dashboard') }}</span>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about" id="about">
        <div class="container">
            <div class="about-content">
                <div class="about-text">
                    <h2>{{ __('landing.about_title') }}</h2>
                    <p>{{ __('landing.about_description') }}</p>

                    <ul class="about-points">
                        <li>
                            <span class="check-icon">✓</span>
                            <span>{{ __('landing.about_point_1') }}</span>
                        </li>
                        <li>
                            <span class="check-icon">✓</span>
                            <span>{{ __('landing.about_point_2') }}</span>
                        </li>
                        <li>
                            <span class="check-icon">✓</span>
                            <span>{{ __('landing.about_point_3') }}</span>
                        </li>
                        <li>
                            <span class="check-icon">✓</span>
                            <span>{{ __('landing.about_point_4') }}</span>
                        </li>
                    </ul>
                </div>

                <div class="about-visual">
                    <div class="about-image">
                        <img src="{{ asset('/imgs/logo.png') }}" alt="VanStock" class="about-logo">
                        <div class="about-stats">
                            <div class="about-stat">
                                <div class="about-stat-number">24/7</div>
                                <div class="about-stat-label">{{ __('landing.nav_features') }}</div>
                            </div>
                            <div class="about-stat">
                                <div class="about-stat-number">100%</div>
                                <div class="about-stat-label">{{ __('landing.about_point_4') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact" id="contact">
        <div class="container">
            <div class="section-header">
                <h2>{{ __('landing.contact_title') }}</h2>
                <p>{{ __('landing.contact_subtitle') }}</p>
            </div>

            <div class="contact-grid">
                <div class="contact-card">
                    <div class="contact-icon">📧</div>
                    <h3>{{ __('landing.contact_email') }}</h3>
                    <p>info@vanstock.com</p>
                </div>

                <div class="contact-card">
                    <div class="contact-icon">📞</div>
                    <h3>{{ __('landing.contact_phone') }}</h3>
                    <p dir="ltr">+967 123 456 789</p>
                </div>

                <div class="contact-card">
                    <div class="contact-icon">📍</div>
                    <h3>{{ __('landing.contact_address') }}</h3>
                    <p>{{ __('landing.contact_address_value') }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-logo">
                    <img src="{{ asset('/imgs/logo.png') }}" alt="VanStock">
                    <span>VanStock</span>
                </div>

                <div class="footer-text">
                    © {{ date('Y') }} VanStock. {{ __('landing.footer_rights') }}
                </div>

                <div class="footer-text">
                    {{ __('landing.footer_powered_by') }} VanStock Team
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Tab switching for screenshots
        document.querySelectorAll('.tab-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.tab-btn').forEach(function(b) {
                    b.classList.remove('active');
                });
                this.classList.add('active');
            });
        });
    </script>
</body>

</html>