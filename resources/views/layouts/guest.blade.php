<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'NVR Monitoring') }} — Login</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            .login-bg {
                background: linear-gradient(160deg, #333385 0%, #2a2a70 30%, #1e1e5a 50%, #252570 70%, #333385 100%);
                position: relative;
                overflow: hidden;
            }
            .login-bg::before {
                content: '';
                position: absolute;
                top: -50%;
                left: -50%;
                width: 200%;
                height: 200%;
                background: radial-gradient(ellipse at 30% 20%, rgba(100, 100, 200, 0.15) 0%, transparent 50%),
                            radial-gradient(ellipse at 70% 80%, rgba(80, 80, 180, 0.1) 0%, transparent 50%);
                animation: shimmer 15s ease-in-out infinite alternate;
            }
            @keyframes shimmer {
                0% { transform: translate(0, 0) rotate(0deg); }
                100% { transform: translate(2%, 2%) rotate(1deg); }
            }
            .logo-strip {
                background: rgba(255, 255, 255, 0.08);
                backdrop-filter: blur(20px);
                border: 1px solid rgba(255, 255, 255, 0.12);
            }
            .main-logo-glow {
                background: linear-gradient(135deg, rgba(255,255,255,0.12) 0%, rgba(255,255,255,0.04) 100%);
                backdrop-filter: blur(12px);
                border: 1px solid rgba(255, 255, 255, 0.15);
                box-shadow: 0 8px 32px rgba(0, 0, 0, 0.25), 0 0 60px rgba(51, 51, 133, 0.3);
            }
            .login-card {
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(20px);
                border: 1px solid rgba(255, 255, 255, 0.3);
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4), 0 0 40px rgba(51, 51, 133, 0.15);
            }
            .floating-dot {
                position: absolute;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.04);
                animation: floatDot 20s ease-in-out infinite;
            }
            @keyframes floatDot {
                0%, 100% { transform: translateY(0px) scale(1); }
                50% { transform: translateY(-30px) scale(1.1); }
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex flex-col items-center justify-center login-bg px-4 py-8">
            <!-- Floating decorative dots -->
            <div class="floating-dot w-64 h-64 top-10 -left-20" style="animation-delay: 0s;"></div>
            <div class="floating-dot w-40 h-40 bottom-20 right-10" style="animation-delay: 5s;"></div>
            <div class="floating-dot w-32 h-32 top-1/3 right-1/4" style="animation-delay: 10s;"></div>

            <!-- Partner Logos Strip -->
            <div class="logo-strip rounded-2xl px-6 py-3 mb-10 flex items-center justify-center space-x-5 relative z-10">
                <img src="{{ asset('assets/media/logos/satyakerta-logo.jpeg') }}" alt="Kab. Tangerang" class="h-10 sm:h-12 rounded-lg object-contain shadow-md bg-white/90 p-0.5">
                <img src="{{ asset('assets/media/logos/kartar-teluknaga-logo.jpeg') }}" alt="Karang Taruna" class="h-10 sm:h-12 rounded-lg object-contain shadow-md bg-white/90 p-0.5">
                <img src="{{ asset('assets/media/logos/pik2-logo.jpeg') }}" alt="PIK2 Development" class="h-10 sm:h-12 rounded-lg object-contain shadow-md bg-white/90 p-0.5">
                <img src="{{ asset('assets/media/logos/asg-logo.jpeg') }}" alt="ASG Indonesia" class="h-10 sm:h-12 rounded-lg object-contain shadow-md bg-white/90 p-0.5">
            </div>

            <!-- Main Logo / App Icon -->
            <div class="main-logo-glow rounded-3xl p-5 mb-6 relative z-10">
                <img src="{{ asset('assets/media/logos/cbd-logo.jpeg') }}" alt="CBD PIK2" class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl object-contain shadow-lg">
            </div>

            <!-- App Title -->
            <div class="text-center mb-8 relative z-10">
                <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight drop-shadow-lg">
                    NVR Monitoring
                </h1>
                <p class="text-sm sm:text-base font-semibold text-blue-200/80 uppercase tracking-[0.25em] mt-2">
                    One Monitoring System
                </p>
            </div>

            <!-- Login Card -->
            <div class="w-full sm:max-w-md login-card rounded-2xl p-8 relative z-10">
                {{ $slot }}
            </div>

            <!-- Footer -->
            <p class="mt-8 text-xs text-blue-200/40 relative z-10 text-center">
                &copy; {{ date('Y') }} CBD PIK2 &mdash; NVR Monitoring System. All rights reserved.
            </p>
        </div>
    </body>
</html>
