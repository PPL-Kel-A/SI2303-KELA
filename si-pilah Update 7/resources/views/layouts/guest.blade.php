<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Si-Pilah') }} — Sistem Pengelolaan Sampah</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            *, *::before, *::after { box-sizing: border-box; }
            body { font-family: 'Poppins', sans-serif; margin: 0; }

            /* ── Layout ── */
            .auth-wrapper {
                display: flex;
                min-height: 100vh;
            }

            /* ── Left Hero Panel ── */
            .auth-hero {
                position: relative;
                display: none;
                width: 50%;
                overflow: hidden;
                background: linear-gradient(135deg, #0d3b0e 0%, #1b5e20 30%, #2e7d32 60%, #388e3c 100%);
            }
            @media (min-width: 1024px) {
                .auth-hero { display: flex; align-items: center; justify-content: center; }
            }

            /* Animated mesh gradient overlay */
            .auth-hero::before {
                content: '';
                position: absolute;
                inset: 0;
                background:
                    radial-gradient(ellipse 600px 600px at 20% 80%, rgba(76,175,80,.25) 0%, transparent 70%),
                    radial-gradient(ellipse 500px 500px at 80% 20%, rgba(129,199,132,.2) 0%, transparent 70%);
                animation: meshShift 12s ease-in-out infinite alternate;
            }
            @keyframes meshShift {
                0%   { opacity: .6; transform: scale(1); }
                100% { opacity: 1;  transform: scale(1.15); }
            }

            /* Leaf pattern overlay */
            .auth-hero::after {
                content: '';
                position: absolute;
                inset: 0;
                opacity: .06;
                background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='80' height='80' viewBox='0 0 80 80'%3E%3Cpath d='M40 2C40 2 20 20 20 40C20 55 28 65 40 78C52 65 60 55 60 40C60 20 40 2 40 2Z' fill='%23ffffff'/%3E%3C/svg%3E");
                background-size: 80px 80px;
            }

            .hero-content {
                position: relative;
                z-index: 10;
                text-align: center;
                padding: 3rem;
                max-width: 440px;
            }
            .hero-logo {
                font-size: 3.2rem;
                font-weight: 800;
                color: #fff;
                letter-spacing: -1px;
                margin-bottom: .5rem;
                font-style: italic;
            }
            .hero-logo span {
                color: #a5d6a7;
            }
            .hero-tagline {
                color: rgba(255,255,255,.8);
                font-size: 1.05rem;
                font-weight: 300;
                line-height: 1.7;
                margin-bottom: 2.5rem;
            }

            /* Floating eco icons */
            .floating-icons {
                display: flex;
                justify-content: center;
                gap: 1.8rem;
                margin-bottom: 2.5rem;
            }
            .floating-icon {
                width: 64px;
                height: 64px;
                background: rgba(255,255,255,.1);
                backdrop-filter: blur(10px);
                -webkit-backdrop-filter: blur(10px);
                border: 1px solid rgba(255,255,255,.15);
                border-radius: 20px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.7rem;
                animation: floatUp 4s ease-in-out infinite;
            }
            .floating-icon:nth-child(2) { animation-delay: -1.3s; }
            .floating-icon:nth-child(3) { animation-delay: -2.6s; }
            @keyframes floatUp {
                0%, 100% { transform: translateY(0); }
                50%      { transform: translateY(-12px); }
            }

            /* Stats bar */
            .hero-stats {
                display: flex;
                justify-content: center;
                gap: 2.2rem;
            }
            .hero-stat {
                text-align: center;
            }
            .hero-stat-value {
                font-size: 1.6rem;
                font-weight: 700;
                color: #fff;
            }
            .hero-stat-label {
                font-size: .72rem;
                color: rgba(255,255,255,.6);
                text-transform: uppercase;
                letter-spacing: 1px;
                margin-top: 2px;
            }

            /* ── Right Form Panel ── */
            .auth-form-panel {
                flex: 1;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 2rem 1.5rem;
                background: #f8faf8;
                position: relative;
                overflow: hidden;
            }
            /* Subtle green dot grid */
            .auth-form-panel::before {
                content: '';
                position: absolute;
                inset: 0;
                opacity: .035;
                background-image: radial-gradient(#1b5e20 1px, transparent 1px);
                background-size: 28px 28px;
            }

            .auth-form-container {
                position: relative;
                z-index: 10;
                width: 100%;
                max-width: 440px;
                animation: fadeSlideUp .6s ease-out;
            }
            @keyframes fadeSlideUp {
                from { opacity: 0; transform: translateY(24px); }
                to   { opacity: 1; transform: translateY(0); }
            }

            /* Mobile-only branding */
            .mobile-brand {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: .6rem;
                margin-bottom: 1.5rem;
            }
            .mobile-brand-icon {
                width: 42px;
                height: 42px;
                background: linear-gradient(135deg, #1b5e20, #4caf50);
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.3rem;
            }
            .mobile-brand-text {
                font-size: 1.5rem;
                font-weight: 800;
                font-style: italic;
                color: #1b5e20;
            }
            @media (min-width: 1024px) {
                .mobile-brand { display: none; }
            }

            /* Card */
            .auth-card {
                background: #fff;
                border-radius: 20px;
                padding: 2.5rem 2rem;
                box-shadow:
                    0 1px 3px rgba(0,0,0,.04),
                    0 8px 30px rgba(27,94,32,.06);
                border: 1px solid rgba(27,94,32,.06);
            }

            .auth-card-title {
                font-size: 1.65rem;
                font-weight: 700;
                color: #1a1a1a;
                margin: 0 0 .35rem;
            }
            .auth-card-subtitle {
                font-size: .9rem;
                color: #6b7280;
                margin: 0 0 2rem;
                font-weight: 400;
            }

            /* Form Elements */
            .form-group {
                margin-bottom: 1.25rem;
            }
            .form-group label {
                display: block;
                font-size: .82rem;
                font-weight: 600;
                color: #374151;
                margin-bottom: .4rem;
            }
            .form-group input[type="text"],
            .form-group input[type="email"],
            .form-group input[type="password"] {
                width: 100%;
                padding: .75rem 1rem;
                border: 1.5px solid #d1d5db;
                border-radius: 12px;
                font-size: .92rem;
                font-family: 'Poppins', sans-serif;
                color: #1a1a1a;
                background: #fff;
                transition: all .25s ease;
                outline: none;
            }
            .form-group input:focus {
                border-color: #2e7d32;
                box-shadow: 0 0 0 3px rgba(46,125,50,.12);
            }
            .form-group input::placeholder {
                color: #9ca3af;
            }

            /* Checkbox */
            .form-check {
                display: flex;
                align-items: center;
                gap: .5rem;
                margin: 1rem 0;
            }
            .form-check input[type="checkbox"] {
                width: 18px;
                height: 18px;
                accent-color: #1b5e20;
                border-radius: 4px;
                cursor: pointer;
            }
            .form-check label {
                font-size: .85rem;
                color: #6b7280;
                cursor: pointer;
            }

            /* Primary Button */
            .btn-sipilah {
                display: block;
                width: 100%;
                padding: .85rem;
                border: none;
                border-radius: 12px;
                font-family: 'Poppins', sans-serif;
                font-size: .95rem;
                font-weight: 600;
                color: #fff;
                background: linear-gradient(135deg, #1b5e20, #2e7d32);
                cursor: pointer;
                transition: all .3s ease;
                box-shadow: 0 4px 15px rgba(27,94,32,.25);
                text-transform: none;
                letter-spacing: 0;
            }
            .btn-sipilah:hover {
                background: linear-gradient(135deg, #145218, #256d28);
                box-shadow: 0 6px 25px rgba(27,94,32,.35);
                transform: translateY(-1px);
            }
            .btn-sipilah:active {
                transform: translateY(0);
            }

            /* Links */
            .auth-link {
                font-size: .85rem;
                color: #2e7d32;
                font-weight: 500;
                text-decoration: none;
                transition: color .2s;
            }
            .auth-link:hover {
                color: #1b5e20;
                text-decoration: underline;
            }

            .form-footer {
                display: flex;
                align-items: center;
                justify-content: space-between;
                margin-top: 1.5rem;
            }

            /* Divider */
            .auth-divider {
                display: flex;
                align-items: center;
                gap: 1rem;
                margin: 1.5rem 0;
                color: #9ca3af;
                font-size: .8rem;
            }
            .auth-divider::before,
            .auth-divider::after {
                content: '';
                flex: 1;
                height: 1px;
                background: #e5e7eb;
            }

            .auth-bottom-link {
                text-align: center;
                margin-top: 1.5rem;
                font-size: .88rem;
                color: #6b7280;
            }
            .auth-bottom-link a {
                color: #2e7d32;
                font-weight: 600;
                text-decoration: none;
                transition: color .2s;
            }
            .auth-bottom-link a:hover {
                color: #1b5e20;
                text-decoration: underline;
            }

            /* Validation Errors */
            .input-error-msg {
                color: #dc2626;
                font-size: .78rem;
                margin-top: .35rem;
            }
        </style>
    </head>
    <body>
        <div class="auth-wrapper">
            {{-- ── Left Hero Panel ── --}}
            <div class="auth-hero">
                <div class="hero-content">
                    <div class="floating-icons">
                        <div class="floating-icon">♻️</div>
                        <div class="floating-icon">🌱</div>
                        <div class="floating-icon">🌍</div>
                    </div>

                    <div class="hero-logo">Si<span>-Pilah</span></div>
                    <p class="hero-tagline">
                        Ubah kebiasaan, ubah dunia.<br>
                        Pilah sampahmu dari rumah dan jadilah bagian dari gerakan kota hijau yang berkelanjutan.
                    </p>

                    <div class="hero-stats">
                        <div class="hero-stat">
                            <div class="hero-stat-value">1.2K+</div>
                            <div class="hero-stat-label">Pengguna</div>
                        </div>
                        <div class="hero-stat">
                            <div class="hero-stat-value">5.8T</div>
                            <div class="hero-stat-label">Ton Terpilah</div>
                        </div>
                        <div class="hero-stat">
                            <div class="hero-stat-value">98%</div>
                            <div class="hero-stat-label">Kepuasan</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── Right Form Panel ── --}}
            <div class="auth-form-panel">
                <div class="auth-form-container">
                    {{-- Mobile-only brand --}}
                    <div class="mobile-brand">
                        <div class="mobile-brand-icon">♻️</div>
                        <div class="mobile-brand-text">Si-Pilah</div>
                    </div>

                    <div class="auth-card">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
