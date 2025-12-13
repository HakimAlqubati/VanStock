<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ __('landing.hero_description') }}">
    <meta name="keywords" content="VanStock, inventory, sales, distribution, مخزون, مبيعات, توزيع">
    <title>VanStock - {{ __('landing.hero_title') }}</title>
    <link rel="icon" href="{{ asset('/imgs/logo.png') }}" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&family=Almarai:wght@300;400;700;800&family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-deep: #030014;
            --bg-space: #0f0c29;
            --bg-card: rgba(255, 255, 255, 0.02);
            --primary-glow: #00d2ff;
            --secondary-glow: #9d00ff;
            --accent-glow: #ff0055;
            --success-glow: #10b981;
            --warning-glow: #f59e0b;
            --glass-bg: rgba(255, 255, 255, 0.03);
            --glass-border: rgba(255, 255, 255, 0.08);
            --glass-shine: rgba(255, 255, 255, 0.15);
            --text-main: #ffffff;
            --text-muted: #94a3b8;
            --font-ar: 'Cairo', 'Almarai', sans-serif;
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
            /* font-family: {
                    {
                    app()->getLocale()=='ar' ? 'var(--font-ar)': 'var(--font-en)'
                }
            } */

            /* ; */
            font-family: 'Cairo', 'Almarai', sans-serif;
            background-color: var(--bg-deep);
            color: var(--text-main);
            overflow-x: hidden;
            line-height: 1.8;
        }

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

        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 2rem;
            position: relative;
            z-index: 2;
        }

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
            background: rgba(3, 0, 20, 0.85);
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
            height: 45px;
            filter: drop-shadow(0 0 8px var(--primary-glow));
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

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.4s ease;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            z-index: 1;
            border: 1px solid transparent;
            font-size: 0.95rem;
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

        .btn-large {
            padding: 1rem 3rem;
            font-size: 1.1rem;
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
            padding: 0.6rem 1.5rem;
            background: rgba(0, 210, 255, 0.1);
            border: 1px solid rgba(0, 210, 255, 0.3);
            color: var(--primary-glow);
            border-radius: 30px;
            font-size: 0.9rem;
            letter-spacing: 1px;
            margin-bottom: 1.5rem;
            box-shadow: 0 0 15px rgba(0, 210, 255, 0.2);
            backdrop-filter: blur(5px);
        }

        .hero h1 {
            font-size: 3.8rem;
            font-weight: 900;
            line-height: 1.15;
            margin-bottom: 1.5rem;
            background: linear-gradient(135deg, #fff 0%, #a5b4fc 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 0 30px rgba(255, 255, 255, 0.1);
        }

        .hero h2 {
            font-size: 1.4rem;
            color: var(--primary-glow);
            margin-bottom: 1.5rem;
            font-weight: 400;
        }

        .hero p {
            font-size: 1.15rem;
            color: var(--text-muted);
            margin-bottom: 2.5rem;
            max-width: 90%;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .hero-visual {
            perspective: 1500px;
        }

        .hero-mockup {
            background: rgba(20, 20, 40, 0.6);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 0 50px rgba(0, 210, 255, 0.15), inset 0 0 20px rgba(0, 0, 0, 0.5);
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
            height: 60px;
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

        /* Section Headers */
        .section-header {
            text-align: center;
            margin-bottom: 4rem;
        }

        .section-header h2 {
            font-size: 2.8rem;
            font-weight: 800;
            color: var(--text-main);
            margin-bottom: 1rem;
        }

        .section-header p {
            color: var(--text-muted);
            max-width: 600px;
            margin: 0 auto;
            font-size: 1.15rem;
        }

        .section-badge {
            display: inline-block;
            padding: 0.4rem 1.2rem;
            background: rgba(157, 0, 255, 0.1);
            border: 1px solid rgba(157, 0, 255, 0.3);
            color: var(--secondary-glow);
            border-radius: 30px;
            font-size: 0.85rem;
            margin-bottom: 1rem;
        }

        /* Features Section */
        .features {
            padding: 8rem 0;
            position: relative;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
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

        .feature-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
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
            font-size: 1.3rem;
            color: var(--text-main);
            margin-bottom: 0.75rem;
        }

        .feature-card p {
            color: var(--text-muted);
            font-weight: 300;
            font-size: 0.95rem;
            line-height: 1.7;
        }

        /* How It Works */
        .how-it-works {
            padding: 8rem 0;
            background: linear-gradient(180deg, transparent, rgba(0, 210, 255, 0.02), transparent);
        }

        .steps-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 2rem;
            position: relative;
        }

        .steps-grid::before {
            content: '';
            position: absolute;
            top: 50px;
            left: 10%;
            right: 10%;
            height: 2px;
            background: linear-gradient(90deg, var(--primary-glow), var(--secondary-glow), var(--primary-glow));
            opacity: 0.3;
        }

        .step-card {
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .step-number {
            width: 80px;
            height: 80px;
            margin: 0 auto 1.5rem;
            background: linear-gradient(135deg, var(--primary-glow), var(--secondary-glow));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            font-weight: 800;
            color: white;
            box-shadow: 0 10px 30px rgba(0, 210, 255, 0.3);
        }

        .step-card h3 {
            font-size: 1.2rem;
            margin-bottom: 0.75rem;
            color: var(--text-main);
        }

        .step-card p {
            color: var(--text-muted);
            font-size: 0.95rem;
        }

        /* Modules Section */
        .modules {
            padding: 8rem 0;
        }

        .modules-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 2rem;
        }

        .module-card {
            background: linear-gradient(160deg, rgba(255, 255, 255, 0.03) 0%, rgba(255, 255, 255, 0.01) 100%);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            padding: 2.5rem;
            transition: all 0.4s ease;
        }

        .module-card:hover {
            border-color: var(--secondary-glow);
            box-shadow: 0 10px 40px -10px rgba(157, 0, 255, 0.2);
        }

        .module-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .module-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--secondary-glow), var(--accent-glow));
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
        }

        .module-header h3 {
            font-size: 1.5rem;
            color: var(--text-main);
        }

        .module-features {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
        }

        .module-feature {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        .module-feature::before {
            content: '✓';
            color: var(--success-glow);
            font-weight: bold;
        }

        /* Why VanStock */
        .why-section {
            padding: 8rem 0;
            background: linear-gradient(180deg, transparent, rgba(157, 0, 255, 0.02), transparent);
        }

        .why-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
        }

        .why-card {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s ease;
        }

        .why-card:hover {
            transform: translateY(-5px);
            border-color: var(--primary-glow);
        }

        .why-icon {
            width: 70px;
            height: 70px;
            margin: 0 auto 1.5rem;
            background: rgba(0, 210, 255, 0.1);
            border: 1px solid rgba(0, 210, 255, 0.3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
        }

        .why-card h3 {
            font-size: 1.2rem;
            margin-bottom: 0.75rem;
            color: var(--text-main);
        }

        .why-card p {
            color: var(--text-muted);
            font-size: 0.95rem;
        }

        /* Stats Section */
        .stats {
            padding: 6rem 0;
            background: linear-gradient(90deg, rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.1), rgba(0, 0, 0, 0.3));
            border-top: 1px solid var(--glass-border);
            border-bottom: 1px solid var(--glass-border);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 2rem;
            text-align: center;
        }

        .stat-item {
            padding: 1rem;
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 800;
            background: linear-gradient(to bottom, #fff, var(--text-muted));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-family: var(--font-en);
        }

        .stat-label {
            color: var(--primary-glow);
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            font-size: 0.85rem;
            margin-top: 0.5rem;
        }

        /* FAQ Section */
        .faq {
            padding: 8rem 0;
        }

        .faq-grid {
            max-width: 800px;
            margin: 0 auto;
        }

        .faq-item {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: 16px;
            margin-bottom: 1rem;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .faq-item:hover {
            border-color: var(--primary-glow);
        }

        .faq-question {
            padding: 1.5rem 2rem;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: 600;
            font-size: 1.1rem;
            color: var(--text-main);
        }

        .faq-question::after {
            content: '+';
            font-size: 1.5rem;
            color: var(--primary-glow);
            transition: transform 0.3s ease;
        }

        .faq-item.active .faq-question::after {
            transform: rotate(45deg);
        }

        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
            padding: 0 2rem;
            color: var(--text-muted);
            line-height: 1.8;
        }

        .faq-item.active .faq-answer {
            max-height: 200px;
            padding: 0 2rem 1.5rem;
        }

        /* About Section */
        .about {
            padding: 8rem 0;
        }

        .about-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }

        .about-text h2 {
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
            color: var(--text-main);
        }

        .about-text p {
            color: var(--text-muted);
            margin-bottom: 2rem;
            font-size: 1.1rem;
            line-height: 1.8;
        }

        .about-points {
            list-style: none;
        }

        .about-points li {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            margin-bottom: 1rem;
            color: var(--text-muted);
        }

        .about-points li::before {
            content: '✓';
            color: var(--success-glow);
            font-weight: bold;
            background: rgba(16, 185, 129, 0.1);
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .about-visual {
            background: linear-gradient(160deg, rgba(255, 255, 255, 0.03) 0%, rgba(255, 255, 255, 0.01) 100%);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .about-stat {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            background: rgba(0, 0, 0, 0.2);
            border-radius: 12px;
        }

        .about-stat-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--primary-glow), var(--secondary-glow));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .about-stat-text h4 {
            color: var(--text-main);
            font-size: 1.1rem;
        }

        .about-stat-text p {
            color: var(--text-muted);
            font-size: 0.85rem;
        }

        /* CTA Section */
        .cta-section {
            padding: 8rem 0;
            background: linear-gradient(135deg, rgba(157, 0, 255, 0.1), rgba(0, 210, 255, 0.1));
            position: relative;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(157, 0, 255, 0.2) 0%, transparent 70%);
            z-index: 0;
            filter: blur(50px);
        }

        .cta-content {
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .cta-content h2 {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: var(--text-main);
        }

        .cta-content p {
            font-size: 1.2rem;
            color: var(--text-muted);
            margin-bottom: 2rem;
        }

        .cta-note {
            font-size: 0.9rem;
            color: var(--text-muted);
            margin-top: 1rem;
        }

        /* Contact Section */
        .contact {
            padding: 8rem 0;
            position: relative;
        }

        .contact-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
        }

        .contact-card {
            background: rgba(255, 255, 255, 0.02);
            backdrop-filter: blur(10px);
            padding: 2.5rem 2rem;
            border-radius: 20px;
            text-align: center;
            border: 1px solid var(--glass-border);
            transition: all 0.3s ease;
        }

        .contact-card:hover {
            border-color: var(--accent-glow);
            background: rgba(255, 255, 255, 0.04);
        }

        .contact-icon {
            width: 70px;
            height: 70px;
            margin: 0 auto 1.5rem;
            background: linear-gradient(135deg, var(--secondary-glow), var(--accent-glow));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            box-shadow: 0 0 30px rgba(157, 0, 255, 0.4);
        }

        .contact-card h3 {
            color: var(--primary-glow);
            font-size: 1rem;
            margin-bottom: 0.5rem;
        }

        .contact-card p {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--text-main);
        }

        /* Footer */
        .footer {
            background: #02000e;
            border-top: 1px solid var(--glass-border);
            padding: 4rem 0 2rem;
            color: var(--text-muted);
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 4rem;
            margin-bottom: 3rem;
        }

        .footer-brand .logo {
            margin-bottom: 1rem;
        }

        .footer-brand p {
            font-size: 0.95rem;
            line-height: 1.7;
            max-width: 300px;
        }

        .footer-links h4,
        .footer-contact h4 {
            color: var(--text-main);
            font-size: 1.1rem;
            margin-bottom: 1.5rem;
        }

        .footer-links ul {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 0.75rem;
        }

        .footer-links a {
            color: var(--text-muted);
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-links a:hover {
            color: var(--primary-glow);
        }

        .footer-contact p {
            margin-bottom: 0.75rem;
            font-size: 0.95rem;
        }

        .footer-bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 2rem;
            border-top: 1px solid var(--glass-border);
            flex-wrap: wrap;
            gap: 1rem;
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
        @media (max-width: 1200px) {

            .features-grid,
            .why-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .stats-grid {
                grid-template-columns: repeat(3, 1fr);
            }

            .steps-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .steps-grid::before {
                display: none;
            }
        }

        @media (max-width: 1024px) {
            .hero-content {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .hero-visual {
                display: none;
            }

            .hero h1 {
                font-size: 3rem;
            }

            .hero p {
                max-width: 100%;
            }

            .hero-buttons {
                justify-content: center;
            }

            .about-content {
                grid-template-columns: 1fr;
            }

            .modules-grid {
                grid-template-columns: 1fr;
            }

            .footer-grid {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .footer-brand p {
                max-width: 100%;
            }
        }

        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }

            .features-grid,
            .why-grid,
            .contact-grid {
                grid-template-columns: 1fr;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .steps-grid {
                grid-template-columns: 1fr;
            }

            .hero h1 {
                font-size: 2.5rem;
            }

            .section-header h2 {
                font-size: 2rem;
            }

            .module-features {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="universe-bg"></div>

    <!-- Navigation -->
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

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="container">
            <div class="hero-content">
                <div class="hero-text reveal">
                    <span class="hero-badge">✨ {{ __('landing.hero_subtitle') }}</span>
                    <h1 style="font-family: 'Almarai', sans-serif">{{ __('landing.hero_title') }}</h1>
                    <h2 style="font-family: 'Almarai', sans-serif">{{ __('landing.hero_subtitle') }}</h2>
                    <p style="font-family: 'Almarai', sans-serif">{{ __('landing.hero_description') }}</p>
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

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="container">
            <div class="section-header reveal">
                <span class="section-badge">{{ __('landing.nav_features') }}</span>
                <h2 style="font-family: Cairo', 'Almarai', sans-serif">
                    {{ __('landing.features_title') }}
                </h2>
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

                <div class="feature-card reveal">
                    <div class="feature-icon">🛍️</div>
                    <h3>{{ __('landing.feature_products_title') }}</h3>
                    <p>{{ __('landing.feature_products_desc') }}</p>
                </div>

                <div class="feature-card reveal" style="transition-delay: 0.1s;">
                    <div class="feature-icon">🚛</div>
                    <h3>{{ __('landing.feature_vehicles_title') }}</h3>
                    <p>{{ __('landing.feature_vehicles_desc') }}</p>
                </div>

                <div class="feature-card reveal" style="transition-delay: 0.2s;">
                    <div class="feature-icon">📍</div>
                    <h3>{{ __('landing.feature_locations_title') }}</h3>
                    <p>{{ __('landing.feature_locations_desc') }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="how-it-works" id="how-it-works">
        <div class="container">
            <div class="section-header reveal">
                <span class="section-badge">{{ __('landing.how_it_works_title') }}</span>
                <h2>{{ __('landing.how_it_works_title') }}</h2>
                <p>{{ __('landing.how_it_works_subtitle') }}</p>
            </div>

            <div class="steps-grid">
                <div class="step-card reveal">
                    <div class="step-number">1</div>
                    <h3>{{ __('landing.step_1_title') }}</h3>
                    <p>{{ __('landing.step_1_desc') }}</p>
                </div>

                <div class="step-card reveal" style="transition-delay: 0.1s;">
                    <div class="step-number">2</div>
                    <h3>{{ __('landing.step_2_title') }}</h3>
                    <p>{{ __('landing.step_2_desc') }}</p>
                </div>

                <div class="step-card reveal" style="transition-delay: 0.2s;">
                    <div class="step-number">3</div>
                    <h3>{{ __('landing.step_3_title') }}</h3>
                    <p>{{ __('landing.step_3_desc') }}</p>
                </div>

                <div class="step-card reveal" style="transition-delay: 0.3s;">
                    <div class="step-number">4</div>
                    <h3>{{ __('landing.step_4_title') }}</h3>
                    <p>{{ __('landing.step_4_desc') }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats reveal">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-number">∞</div>
                    <div class="stat-label">{{ __('landing.stats_products') }}</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">∞</div>
                    <div class="stat-label">{{ __('landing.stats_transactions') }}</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">∞</div>
                    <div class="stat-label">{{ __('landing.stats_stores') }}</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">∞</div>
                    <div class="stat-label">{{ __('landing.stats_reps') }}</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">6</div>
                    <div class="stat-label">{{ __('landing.stats_reports') }}</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">4+</div>
                    <div class="stat-label">{{ __('landing.stats_modules') }}</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modules Section -->
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
                        <div class="module-icon">📦</div>
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
                        <div class="module-icon">💰</div>
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
                        <div class="module-icon">👥</div>
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
                        <div class="module-icon">🚛</div>
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

    <!-- Why VanStock Section -->
    <section class="why-section" id="why">
        <div class="container">
            <div class="section-header reveal">
                <span class="section-badge">{{ __('landing.why_title') }}</span>
                <h2>{{ __('landing.why_title') }}</h2>
                <p>{{ __('landing.why_subtitle') }}</p>
            </div>

            <div class="why-grid">
                <div class="why-card reveal">
                    <div class="why-icon">🌐</div>
                    <h3>{{ __('landing.why_1_title') }}</h3>
                    <p>{{ __('landing.why_1_desc') }}</p>
                </div>

                <div class="why-card reveal" style="transition-delay: 0.1s;">
                    <div class="why-icon">✨</div>
                    <h3>{{ __('landing.why_2_title') }}</h3>
                    <p>{{ __('landing.why_2_desc') }}</p>
                </div>

                <div class="why-card reveal" style="transition-delay: 0.2s;">
                    <div class="why-icon">📈</div>
                    <h3>{{ __('landing.why_3_title') }}</h3>
                    <p>{{ __('landing.why_3_desc') }}</p>
                </div>

                <div class="why-card reveal">
                    <div class="why-icon">🔐</div>
                    <h3>{{ __('landing.why_4_title') }}</h3>
                    <p>{{ __('landing.why_4_desc') }}</p>
                </div>

                <div class="why-card reveal" style="transition-delay: 0.1s;">
                    <div class="why-icon">🏪</div>
                    <h3>{{ __('landing.why_5_title') }}</h3>
                    <p>{{ __('landing.why_5_desc') }}</p>
                </div>

                <div class="why-card reveal" style="transition-delay: 0.2s;">
                    <div class="why-icon">💬</div>
                    <h3>{{ __('landing.why_6_title') }}</h3>
                    <p>{{ __('landing.why_6_desc') }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq" id="faq">
        <div class="container">
            <div class="section-header reveal">
                <span class="section-badge">FAQ</span>
                <h2>{{ __('landing.faq_title') }}</h2>
                <p>{{ __('landing.faq_subtitle') }}</p>
            </div>

            <div class="faq-grid">
                <div class="faq-item reveal">
                    <div class="faq-question">{{ __('landing.faq_1_q') }}</div>
                    <div class="faq-answer">{{ __('landing.faq_1_a') }}</div>
                </div>

                <div class="faq-item reveal">
                    <div class="faq-question">{{ __('landing.faq_2_q') }}</div>
                    <div class="faq-answer">{{ __('landing.faq_2_a') }}</div>
                </div>

                <div class="faq-item reveal">
                    <div class="faq-question">{{ __('landing.faq_3_q') }}</div>
                    <div class="faq-answer">{{ __('landing.faq_3_a') }}</div>
                </div>

                <div class="faq-item reveal">
                    <div class="faq-question">{{ __('landing.faq_4_q') }}</div>
                    <div class="faq-answer">{{ __('landing.faq_4_a') }}</div>
                </div>

                <div class="faq-item reveal">
                    <div class="faq-question">{{ __('landing.faq_5_q') }}</div>
                    <div class="faq-answer">{{ __('landing.faq_5_a') }}</div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
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
                        <div class="about-stat-icon">📦</div>
                        <div class="about-stat-text">
                            <h4>{{ __('landing.feature_inventory_title') }}</h4>
                            <p>{{ __('landing.feature_inventory_desc') }}</p>
                        </div>
                    </div>
                    <div class="about-stat">
                        <div class="about-stat-icon">💰</div>
                        <div class="about-stat-text">
                            <h4>{{ __('landing.feature_sales_title') }}</h4>
                            <p>{{ __('landing.feature_sales_desc') }}</p>
                        </div>
                    </div>
                    <div class="about-stat">
                        <div class="about-stat-icon">📊</div>
                        <div class="about-stat-text">
                            <h4>{{ __('landing.feature_reports_title') }}</h4>
                            <p>{{ __('landing.feature_reports_desc') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section" id="cta">
        <div class="container">
            <div class="cta-content reveal">
                <h2>{{ __('landing.cta_title') }}</h2>
                <p>{{ __('landing.cta_subtitle') }}</p>
                @auth
                <a href="/admin" class="btn btn-accent btn-large">{{ __('landing.go_to_dashboard') }}</a>
                @else
                <a href="/admin/login" class="btn btn-accent btn-large">{{ __('landing.cta_button') }}</a>
                @endauth
                <!-- <p class="cta-note">{{ __('landing.cta_note') }}</p> -->
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact" id="contact">
        <div class="container">
            <div class="section-header reveal">
                <span class="section-badge">{{ __('landing.nav_contact') }}</span>
                <h2>{{ __('landing.contact_title') }}</h2>
                <p>{{ __('landing.contact_subtitle') }}</p>
            </div>

            <div class="contact-grid">
                <!-- <div class="contact-card reveal">
                    <div class="contact-icon">📧</div>
                    <h3>{{ __('landing.contact_email') }}</h3>
                    <p>hakimahmed123321@gmail.com</p>
                </div> -->

                <div class="contact-card reveal" style="transition-delay: 0.1s;">
                    <div class="contact-icon">📞</div>
                    <h3>{{ __('landing.contact_phone') }}</h3>
                    <p dir="ltr">+967 773030069</p>
                </div>

                <div class="contact-card reveal" style="transition-delay: 0.2s;">
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
                    <!-- <p>📧 hakimahmed123321@gmail.com</p> -->
                    <p dir="ltr">📞 +967 773030069</p>
                    <p>📍 {{ __('landing.contact_address_value') }}</p>
                </div>
            </div>

            <div class="footer-bottom">
                <div>© {{ date('Y') }} VanStock. {{ __('landing.footer_rights') }}</div>
                <div>{{ __('landing.footer_powered_by') . ' VanStock Team' }} </div>
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

        // FAQ Toggle
        document.querySelectorAll('.faq-question').forEach(function(question) {
            question.addEventListener('click', function() {
                const item = this.parentElement;
                const isActive = item.classList.contains('active');

                // Close all
                document.querySelectorAll('.faq-item').forEach(function(i) {
                    i.classList.remove('active');
                });

                // Toggle current
                if (!isActive) {
                    item.classList.add('active');
                }
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
        reveal();
    </script>
</body>

</html>