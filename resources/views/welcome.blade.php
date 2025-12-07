<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VanStock - {{ __('landing.hero_title') }}</title>
    <link rel="icon" href="{{ asset('/imgs/logo.png') }}" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&family=Tajawal:wght@300;400;500;700;900&display=swap" rel="stylesheet">

    <style>
        :root {
            /* Palette Future 100k */
            --bg-deep: #030014;
            --bg-space: #0f0c29;
            --primary-glow: #00d2ff;
            --secondary-glow: #9d00ff;
            --accent-glow: #ff0055;

            --glass-bg: rgba(255, 255, 255, 0.03);
            --glass-border: rgba(255, 255, 255, 0.08);
            --glass-shine: rgba(255, 255, 255, 0.15);

            --text-main: #ffffff;
            --text-muted: #94a3b8;

            --font-ar: 'Tajawal', sans-serif;
            --font-en: 'Outfit', sans-serif;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            outline: none;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: {
                    {
                    app()->getLocale()=='ar' ? 'var(--font-ar)': 'var(--font-en)'
                }
            }

            ;
            background-color: var(--bg-deep);
            color: var(--text-main);
            overflow-x: hidden;
            line-height: 1.7;
        }

        /* Dynamic Background (The Nebula) */
        .universe-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            z-index: -1;
            background: radial-gradient(circle at 15% 50%, rgba(76, 29, 149, 0.15), transparent 25%),
                radial-gradient(circle at 85% 30%, rgba(34, 211, 238, 0.15), transparent 25%);
            filter: blur(60px);
            animation: pulseNebula 10s infinite alternate;
        }

        /* Container */
        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 2rem;
            position: relative;
            z-index: 2;
        }

        /* Glassmorphism Utility */
        .glass-panel {
            background: var(--glass-bg);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--glass-border);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
        }

        /* Navigation */
        .navbar {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            width: 90%;
            max-width: 1200px;
            z-index: 1000;
            border-radius: 20px;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            padding: 0.8rem 1.5rem;
        }

        .navbar.scrolled {
            background: rgba(3, 0, 20, 0.7);
            border: 1px solid var(--primary-glow);
            box-shadow: 0 0 20px rgba(0, 210, 255, 0.2);
        }

        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 1rem;
            font-weight: 800;
            font-size: 1.5rem;
            color: var(--text-main);
            text-decoration: none;
            letter-spacing: 1px;
        }

        .logo img {
            height: 40px;
            filter: drop-shadow(0 0 5px var(--primary-glow));
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 2.5rem;
            list-style: none;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--text-muted);
            font-weight: 500;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-links a:hover,
        .nav-links a.active {
            color: var(--text-main);
            text-shadow: 0 0 8px var(--primary-glow);
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--primary-glow), var(--secondary-glow));
            transition: width 0.3s ease;
        }

        .nav-links a:hover::after {
            width: 100%;
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        /* Futuristic Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            /* Capsule shape */
            font-weight: 600;
            text-decoration: none;
            transition: all 0.4s ease;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            z-index: 1;
            border: 1px solid transparent;
        }

        .btn-primary {
            background: transparent;
            color: var(--text-main);
            border-color: var(--primary-glow);
            box-shadow: 0 0 15px rgba(0, 210, 255, 0.3) inset;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 0%;
            height: 100%;
            background: var(--primary-glow);
            z-index: -1;
            transition: width 0.4s ease;
        }

        .btn-primary:hover::before {
            width: 100%;
        }

        .btn-primary:hover {
            color: #000;
            box-shadow: 0 0 30px var(--primary-glow);
        }

        .btn-accent {
            background: linear-gradient(135deg, var(--secondary-glow), var(--accent-glow));
            color: white;
            border: none;
            box-shadow: 0 10px 20px rgba(157, 0, 255, 0.3);
        }

        .btn-accent:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 15px 30px rgba(157, 0, 255, 0.5);
        }

        .lang-switch {
            background: transparent;
            color: var(--text-muted);
            border: 1px solid var(--glass-border);
            padding: 0.5rem 1rem;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.3s;
        }

        .lang-switch:hover {
            border-color: var(--text-main);
            color: var(--text-main);
        }

        /* Hero Section */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            padding-top: 120px;
            overflow: hidden;
        }

        .hero::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 150px;
            background: linear-gradient(to top, var(--bg-deep), transparent);
            pointer-events: none;
        }

        .hero-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }

        .hero-badge {
            display: inline-block;
            padding: 0.5rem 1.2rem;
            background: rgba(0, 210, 255, 0.1);
            border: 1px solid rgba(0, 210, 255, 0.3);
            color: var(--primary-glow);
            border-radius: 30px;
            font-size: 0.85rem;
            letter-spacing: 1px;
            margin-bottom: 1.5rem;
            box-shadow: 0 0 10px rgba(0, 210, 255, 0.2);
            backdrop-filter: blur(5px);
        }

        .hero h1 {
            font-size: 4rem;
            font-weight: 900;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            background: linear-gradient(135deg, #fff 0%, #a5b4fc 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 0 30px rgba(255, 255, 255, 0.1);
        }

        .hero h2 {
            font-size: 1.5rem;
            color: var(--primary-glow);
            margin-bottom: 1.5rem;
            font-weight: 300;
        }

        .hero p {
            font-size: 1.15rem;
            color: var(--text-muted);
            margin-bottom: 2.5rem;
            max-width: 90%;
        }

        /* Holographic Mockup */
        .hero-visual {
            perspective: 1500px;
        }

        .hero-mockup {
            background: rgba(20, 20, 40, 0.6);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 0 50px rgba(0, 210, 255, 0.15),
                inset 0 0 20px rgba(0, 0, 0, 0.5);
            padding: 1rem;
            transform: rotateY(-10deg) rotateX(5deg);
            transition: transform 0.5s ease;
            backdrop-filter: blur(20px);
            position: relative;
        }

        .hero-mockup::before {
            content: '';
            position: absolute;
            inset: -2px;
            border-radius: 22px;
            background: linear-gradient(45deg, var(--primary-glow), transparent, var(--secondary-glow));
            z-index: -1;
            opacity: 0.5;
            filter: blur(10px);
        }

        .hero-mockup:hover {
            transform: rotateY(0) rotateX(0) scale(1.02);
        }

        .mockup-content {
            background: rgba(0, 0, 0, 0.4);
            border-radius: 12px;
            padding: 1.5rem;
            min-height: 350px;
        }

        /* Abstract Representation of UI inside Mockup */
        .mockup-nav {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .mockup-nav-item {
            height: 8px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
        }

        .mockup-cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }

        .mockup-card {
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.05), rgba(255, 255, 255, 0.01));
            border: 1px solid rgba(255, 255, 255, 0.05);
            padding: 15px;
            border-radius: 8px;
        }

        .mockup-table-row {
            display: flex;
            gap: 10px;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .mockup-table-cell {
            height: 6px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 3px;
            flex: 1;
        }

        /* Features Section (Holocards) */
        .features {
            padding: 8rem 0;
            position: relative;
        }

        .section-header h2 {
            font-size: 3rem;
            font-weight: 800;
            color: var(--text-main);
            margin-bottom: 1rem;
            text-align: center;
        }

        .section-header p {
            color: var(--text-muted);
            text-align: center;
            max-width: 600px;
            margin: 0 auto 4rem;
            font-size: 1.2rem;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .feature-card {
            background: linear-gradient(160deg, rgba(255, 255, 255, 0.03) 0%, rgba(255, 255, 255, 0.01) 100%);
            border: 1px solid var(--glass-border);
            padding: 2.5rem;
            border-radius: 24px;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            border-color: var(--primary-glow);
            box-shadow: 0 10px 40px -10px rgba(0, 210, 255, 0.2);
        }

        /* Neon effect on hover */
        .feature-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--primary-glow), transparent);
            transform: scaleX(0);
            transition: transform 0.5s ease;
        }

        .feature-card:hover::after {
            transform: scaleX(1);
        }

        .feature-icon {
            width: 70px;
            height: 70px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin-bottom: 1.5rem;
            box-shadow: inset 0 0 20px rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .feature-card h3 {
            font-size: 1.5rem;
            color: var(--text-main);
            margin-bottom: 1rem;
        }

        .feature-card p {
            color: var(--text-muted);
            font-weight: 300;
        }

        /* Stats (Digital Counters) */
        .stats {
            padding: 6rem 0;
            background: linear-gradient(90deg, rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.1), rgba(0, 0, 0, 0.3));
            border-top: 1px solid var(--glass-border);
            border-bottom: 1px solid var(--glass-border);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 2rem;
            text-align: center;
        }

        .stat-number {
            font-size: 4rem;
            font-weight: 800;
            background: linear-gradient(to bottom, #fff, var(--text-muted));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-family: var(--font-en);
            /* Keep numbers strictly English font for style */
            text-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }

        .stat-label {
            color: var(--primary-glow);
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            font-size: 0.9rem;
        }

        /* Screenshots (Holo-Tabs) */
        .screenshots {
            padding: 8rem 0;
        }

        .screenshots-tabs {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            margin-bottom: 4rem;
            flex-wrap: wrap;
        }

        .tab-btn {
            background: transparent;
            border: 1px solid var(--glass-border);
            color: var(--text-muted);
            padding: 1rem 2.5rem;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .tab-btn:hover,
        .tab-btn.active {
            background: rgba(255, 255, 255, 0.1);
            border-color: var(--primary-glow);
            color: var(--text-main);
            box-shadow: 0 0 20px rgba(0, 210, 255, 0.2);
        }

        .screenshot-display {
            background: var(--bg-deep);
            border: 1px solid var(--glass-border);
            border-radius: 30px;
            padding: 1rem;
            box-shadow: 0 0 100px -20px rgba(0, 0, 0, 0.8);
            position: relative;
        }

        .screenshot-placeholder {
            background: #0f1021;
            border-radius: 20px;
            min-height: 500px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border: 1px dashed rgba(255, 255, 255, 0.1);
        }

        /* Contact Section */
        .contact {
            padding: 8rem 0;
            position: relative;
        }

        /* Decoration Circle */
        .contact::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(157, 0, 255, 0.1) 0%, transparent 70%);
            z-index: -1;
            filter: blur(50px);
        }

        .contact-card {
            background: rgba(255, 255, 255, 0.02);
            backdrop-filter: blur(10px);
            padding: 3rem 2rem;
            border-radius: 20px;
            text-align: center;
            border: 1px solid var(--glass-border);
            transition: 0.3s;
        }

        .contact-card:hover {
            border-color: var(--accent-glow);
            background: rgba(255, 255, 255, 0.04);
        }

        .contact-icon {
            width: 60px;
            height: 60px;
            margin: 0 auto 1.5rem;
            background: var(--gradient-accent);
            /* Fallback */
            background: linear-gradient(135deg, var(--secondary-glow), var(--accent-glow));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 0 20px rgba(157, 0, 255, 0.4);
        }

        .contact-card p {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--text-main);
            margin-top: 0.5rem;
        }

        /* Footer */
        .footer {
            background: #02000e;
            border-top: 1px solid var(--glass-border);
            padding: 4rem 0;
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        .footer-logo img {
            filter: brightness(0) invert(1);
            /* Ensure white logo */
        }

        /* Animations */
        @keyframes pulseNebula {
            0% {
                opacity: 0.5;
                transform: scale(1);
            }

            100% {
                opacity: 0.8;
                transform: scale(1.1);
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0) rotateX(5deg) rotateY(-10deg);
            }

            50% {
                transform: translateY(-20px) rotateX(5deg) rotateY(-10deg);
            }
        }

        .floating {
            animation: float 6s ease-in-out infinite;
        }

        /* Scroll Reveal Animation Classes */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s cubic-bezier(0.5, 0, 0, 1);
        }

        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .hero-content {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .hero-visual {
                display: none;
            }

            /* Hide visual on tablet for simplicity */
            .hero h1 {
                font-size: 3rem;
            }

            .features-grid,
            .stats-grid,
            .contact-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }

            .features-grid,
            .stats-grid,
            .contact-grid {
                grid-template-columns: 1fr;
            }

            .hero h1 {
                font-size: 2.5rem;
            }

            .stats-grid {
                gap: 1rem;
            }
        }
    </style>
</head>

<body>
    <div class="universe-bg"></div>

    <nav class="navbar glass-panel" id="navbar">
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
                    {{ app()->getLocale() == 'ar' ? 'EN' : 'عربي' }}
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

    <section class="hero" id="home">
        <div class="container">
            <div class="hero-content">
                <div class="hero-text reveal">
                    <span class="hero-badge">✨ {{ __('landing.hero_subtitle') }} // V.3025</span>
                    <h1>{{ __('landing.hero_title') }}</h1>
                    <h2>{{ __('landing.hero_subtitle') }}</h2>
                    <p>{{ __('landing.hero_description') }}</p>
                    <div class="hero-buttons">
                        @auth
                        <a href="/admin" class="btn btn-accent">{{ __('landing.go_to_dashboard') }}</a>
                        @else
                        <a href="/admin/login" class="btn btn-accent">{{ __('landing.hero_cta') }}</a>
                        @endauth
                        <a href="#features" class="btn btn-primary" style="margin-inline-start: 10px;">
                            {{ __('landing.hero_learn_more') }}
                        </a>
                    </div>
                </div>

                <div class="hero-visual floating reveal" style="transition-delay: 0.2s;">
                    <div class="hero-mockup glass-panel">
                        <div class="mockup-header" style="display:flex; gap:8px; margin-bottom:15px;">
                            <div style="width:10px; height:10px; background:#ff5f57; border-radius:50%;"></div>
                            <div style="width:10px; height:10px; background:#febc2e; border-radius:50%;"></div>
                            <div style="width:10px; height:10px; background:#28c840; border-radius:50%;"></div>
                        </div>
                        <div class="mockup-content">
                            <div class="mockup-nav">
                                <div class="mockup-nav-item" style="width: 20%;"></div>
                                <div class="mockup-nav-item" style="width: 30%;"></div>
                                <div class="mockup-nav-item" style="width: 20%;"></div>
                            </div>
                            <div class="mockup-cards">
                                <div class="mockup-card"></div>
                                <div class="mockup-card"></div>
                                <div class="mockup-card"></div>
                            </div>
                            <div class="mockup-table">
                                <div class="mockup-table-row">
                                    <div class="mockup-table-cell"></div>
                                    <div class="mockup-table-cell"></div>
                                </div>
                                <div class="mockup-table-row">
                                    <div class="mockup-table-cell"></div>
                                    <div class="mockup-table-cell"></div>
                                </div>
                                <div class="mockup-table-row">
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

    <section class="features" id="features">
        <div class="container">
            <div class="section-header reveal">
                <h2>{{ __('landing.features_title') }}</h2>
                <p>{{ __('landing.features_subtitle') }}</p>
            </div>

            <div class="features-grid">
                <div class="feature-card reveal">
                    <div class="feature-icon">📦</div>
                    <h3>{{ __('landing.feature_inventory_title') }}</h3>
                    <p>{{ __('landing.feature_inventory_desc') }}</p>
                </div>

                <div class="feature-card reveal" style="transition-delay: 0.1s;">
                    <div class="feature-icon">💰</div>
                    <h3>{{ __('landing.feature_sales_title') }}</h3>
                    <p>{{ __('landing.feature_sales_desc') }}</p>
                </div>

                <div class="feature-card reveal" style="transition-delay: 0.2s;">
                    <div class="feature-icon">👥</div>
                    <h3>{{ __('landing.feature_reps_title') }}</h3>
                    <p>{{ __('landing.feature_reps_desc') }}</p>
                </div>

                <div class="feature-card reveal">
                    <div class="feature-icon">🏢</div>
                    <h3>{{ __('landing.feature_customers_title') }}</h3>
                    <p>{{ __('landing.feature_customers_desc') }}</p>
                </div>

                <div class="feature-card reveal" style="transition-delay: 0.1s;">
                    <div class="feature-icon">📊</div>
                    <h3>{{ __('landing.feature_reports_title') }}</h3>
                    <p>{{ __('landing.feature_reports_desc') }}</p>
                </div>

                <div class="feature-card reveal" style="transition-delay: 0.2s;">
                    <div class="feature-icon">🏪</div>
                    <h3>{{ __('landing.feature_multi_store_title') }}</h3>
                    <p>{{ __('landing.feature_multi_store_desc') }}</p>
                </div>
            </div>
        </div>
    </section>

    <section class="stats reveal">
        <div class="container">
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

    <section class="screenshots" id="screenshots">
        <div class="container">
            <div class="section-header reveal">
                <h2>{{ __('landing.screenshots_title') }}</h2>
                <p>{{ __('landing.screenshots_subtitle') }}</p>
            </div>

            <div class="screenshots-tabs reveal">
                <button class="tab-btn active">{{ __('landing.screen_dashboard') }}</button>
                <button class="tab-btn">{{ __('landing.screen_inventory') }}</button>
                <button class="tab-btn">{{ __('landing.screen_sales') }}</button>
                <button class="tab-btn">{{ __('landing.screen_reports') }}</button>
            </div>

            <div class="screenshot-display reveal">
                <div class="screenshot-placeholder">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="rgba(255,255,255,0.2)" width="80" height="80">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <span style="margin-top:20px; color:var(--text-muted);">{{ __('landing.screen_dashboard') }} Interface</span>
                </div>
            </div>
        </div>
    </section>

    <section class="contact" id="contact">
        <div class="container">
            <div class="section-header reveal">
                <h2>{{ __('landing.contact_title') }}</h2>
                <p>{{ __('landing.contact_subtitle') }}</p>
            </div>

            <div class="contact-grid">
                <div class="contact-card reveal">
                    <div class="contact-icon">📧</div>
                    <h3>{{ __('landing.contact_email') }}</h3>
                    <p>info@vanstock.com</p>
                </div>

                <div class="contact-card reveal" style="transition-delay: 0.1s;">
                    <div class="contact-icon">📞</div>
                    <h3>{{ __('landing.contact_phone') }}</h3>
                    <p dir="ltr">+967 123 456 789</p>
                </div>

                <div class="contact-card reveal" style="transition-delay: 0.2s;">
                    <div class="contact-icon">📍</div>
                    <h3>{{ __('landing.contact_address') }}</h3>
                    <p>{{ __('landing.contact_address_value') }}</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="container">
            <div class="footer-content" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:20px;">
                <div class="footer-logo logo">
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
            if (window.scrollY > 20) {
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

        // Scroll Reveal Animation
        function reveal() {
            var reveals = document.querySelectorAll(".reveal");
            for (var i = 0; i < reveals.length; i++) {
                var windowHeight = window.innerHeight;
                var elementTop = reveals[i].getBoundingClientRect().top;
                var elementVisible = 100;
                if (elementTop < windowHeight - elementVisible) {
                    reveals[i].classList.add("active");
                }
            }
        }
        window.addEventListener("scroll", reveal);
        // Trigger once on load
        reveal();
    </script>
</body>

</html>