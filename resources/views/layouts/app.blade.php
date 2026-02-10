<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="robots" content="index, follow">
        <link rel="canonical" href="{{ url()->current() }}">

        <title>@yield('title', 'PMII Komisariat Universitas Nurul Jadid')</title>
        <meta name="description" content="@yield('description', 'PMII Komisariat Universitas Nurul Jadid - Pergerakan Mahasiswa Islam Indonesia yang berafiliasi dengan Nahdlatul Ulama (NU), membentuk kader intelektual yang religius dan kritis.')">
        <meta name="keywords" content="@yield('keywords', 'PMII, PMII UNUJA, Pergerakan Mahasiswa Islam Indonesia, Universitas Nurul Jadid, Mahasiswa Islam, NU')">
        <meta name="author" content="PMII Komisariat UNUJA">

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('images/logo-pmii.png') }}">
        <link rel="apple-touch-icon" href="{{ asset('images/logo-pmii.png') }}">

        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:title" content="@yield('title', 'PMII Komisariat Universitas Nurul Jadid')">
        <meta property="og:description" content="@yield('description', 'Pergerakan Mahasiswa Islam Indonesia - Komisariat UNUJA')">
        <meta property="og:image" content="@yield('image', asset('images/PMII-og.jpg'))">
        <meta property="og:locale" content="id_ID">

        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="@yield('title', 'PMII Komisariat Universitas Nurul Jadid')">
        <meta name="twitter:description" content="@yield('description', 'Pergerakan Mahasiswa Islam Indonesia - Komisariat UNUJA')">
        <meta name="twitter:image" content="@yield('image', asset('images/PMII-og.jpg'))">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            @keyframes pulse-glow {
                0%, 100% { box-shadow: 0 0 10px rgba(234, 179, 8, 0.4); }
                50% { box-shadow: 0 0 20px rgba(234, 179, 8, 0.6); }
            }
            @keyframes pulse-glow-text {
                0%, 100% { text-shadow: 0 0 4px rgba(234, 179, 8, 0.4); }
                50% { text-shadow: 0 0 8px rgba(234, 179, 8, 0.7); }
            }
            @keyframes loading-spin {
                from { transform: rotate(0deg); }
                to { transform: rotate(360deg); }
            }
            @keyframes loading-pulse {
                0%, 100% {
                    box-shadow: 0 0 20px rgba(234, 179, 8, 0.3),
                                0 0 40px rgba(30, 58, 95, 0.2);
                    transform: scale(1);
                }
                50% {
                    box-shadow: 0 0 40px rgba(234, 179, 8, 0.5),
                                0 0 60px rgba(30, 58, 95, 0.3);
                    transform: scale(1.05);
                }
            }
            @keyframes orbit {
                from { transform: rotate(0deg) translateX(60px) rotate(0deg); }
                to { transform: rotate(360deg) translateX(60px) rotate(-360deg); }
            }
            @keyframes orbit-reverse {
                from { transform: rotate(0deg) translateX(80px) rotate(0deg); }
                to { transform: rotate(-360deg) translateX(80px) rotate(360deg); }
            }
            @keyframes bounce {
                0%, 100% {
                    transform: translateY(0);
                    animation-timing-function: cubic-bezier(0.8, 0, 1, 1);
                }
                50% {
                    transform: translateY(-25%);
                    animation-timing-function: cubic-bezier(0, 0, 0.2, 1);
                }
            }
            @keyframes loading-fade-out {
                0% { opacity: 1; }
                100% { opacity: 0; }
            }
            #loadingScreen {
                transition: opacity 0.5s ease-in-out;
            }
            .animate-pulse-glow { animation: pulse-glow 2s ease-in-out infinite; }
            .animate-pulse-glow-text { animation: pulse-glow-text 2s ease-in-out infinite; }
            .loading-spin { animation: loading-spin 3s linear infinite; }
            .loading-pulse { animation: loading-pulse 2s ease-in-out infinite; }
            .orbit { animation: orbit 4s linear infinite; }
            .orbit-reverse { animation: orbit-reverse 5s linear infinite; }
            .loading-screen { animation: loading-fade-out 0.5s ease-in-out forwards; }
        </style>
        @stack('head')
    </head>
    <body class="font-sans antialiased" @if(request()->routeIs('home')) style="overflow: hidden;" @endif>
        <!-- Loading Screen (Only on Homepage) -->
        @if(request()->routeIs('home'))
        <div id="loadingScreen" style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(to bottom, #0f172a, #1e3a5f); display: flex !important; align-items: center; justify-content: center; z-index: 99999; opacity: 1 !important;">
            <div style="position: relative; width: 160px; height: 160px;">
                <!-- Outer pulsing ring 1 -->
                <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; border-radius: 9999px; border: 2px solid transparent; border-top-color: #facc15; border-right-color: #facc15; opacity: 0.6;" class="loading-spin"></div>

                <!-- Outer pulsing ring 2 -->
                <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; border-radius: 9999px; border: 2px solid transparent; border-bottom-color: #eab308; border-left-color: #eab308; opacity: 0.4; animation-duration: 4s; animation-direction: reverse;" class="loading-spin"></div>

                <!-- Pulsing glow ring -->
                <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; border-radius: 9999px;" class="loading-pulse"></div>

                <!-- Orbiting dots - Ring 1 -->
                <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0;" class="orbit">
                    <div style="position: absolute; width: 12px; height: 12px; background-color: #facc15; border-radius: 9999px; top: 0; left: 50%; transform: translateX(-50%);"></div>
                </div>

                <!-- Orbiting dots - Ring 2 -->
                <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0;" class="orbit-reverse">
                    <div style="position: absolute; width: 8px; height: 8px; background-color: #eab308; border-radius: 9999px; top: 0; left: 50%; transform: translateX(-50%);"></div>
                </div>

                <!-- Center logo -->
                <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; display: flex; align-items: center; justify-content: center;">
                    <img src="{{ asset('images/logo-pmii.png') }}" alt="Logo PMII" style="width: 80px; height: 80px; border-radius: 9999px; object-fit: cover; border: 4px solid #facc15; box-shadow: 0 0 30px rgba(234, 179, 8, 0.6), inset 0 0 20px rgba(234, 179, 8, 0.2), 0 25px 50px -12px rgba(0, 0, 0, 0.25);">
                </div>

                <!-- Loading text -->
                <div style="position: absolute; bottom: 0; left: 50%; transform: translateX(-50%) translateY(80px); text-align: center;">
                    <p style="color: #facc15; font-size: 0.875rem; font-weight: 600; letter-spacing: 0.1em;">MEMUAT</p>
                    <div style="display: flex; gap: 4px; justify-content: center; margin-top: 8px;">
                        <span style="width: 8px; height: 8px; background-color: #facc15; border-radius: 9999px; animation: bounce 1s infinite; animation-delay: 0s;"></span>
                        <span style="width: 8px; height: 8px; background-color: #facc15; border-radius: 9999px; animation: bounce 1s infinite; animation-delay: 0.15s;"></span>
                        <span style="width: 8px; height: 8px; background-color: #facc15; border-radius: 9999px; animation: bounce 1s infinite; animation-delay: 0.3s;"></span>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="min-h-screen bg-white flex flex-col relative">
            @if(!request()->routeIs('home'))
                @include('layouts.navigation')
            @endif

            <!-- Page Content -->
            <main class="flex-grow" role="main">
                @if(request()->routeIs('home'))
                    @yield('home-section')
                @else
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                @yield('content')
                </div>
                @endif

            </main>

            <!-- Footer -->
            @include('layouts.footer')
        </div>

        <script>
            // Only run loading screen script if it exists (homepage only)
            const loadingScreen = document.getElementById('loadingScreen');

            if (loadingScreen) {
                console.log('Loading script initialized');

                // Ensure loading screen shows immediately
                document.addEventListener('DOMContentLoaded', function() {
                    console.log('DOMContentLoaded - Loading screen found');
                    console.log('Background style:', loadingScreen.style.background);

                    loadingScreen.style.display = 'flex';
                    loadingScreen.style.opacity = '1';
                    console.log('Loading screen forced to display with inline styles');
                });

                // Track when page started loading
                const pageLoadStart = Date.now();
                const minimumLoadingTime = 2000; // Show loading for at least 2 seconds

                // Hide loading screen when page is fully loaded
                window.addEventListener('load', function() {
                    console.log('Window loaded');
                    const bodyElement = document.body;

                    const elapsedTime = Date.now() - pageLoadStart;
                    const remainingTime = Math.max(0, minimumLoadingTime - elapsedTime);

                    console.log('Elapsed time:', elapsedTime, 'Remaining time:', remainingTime);

                    setTimeout(() => {
                        console.log('Starting fade out');
                        loadingScreen.style.opacity = '0';
                        bodyElement.style.overflow = 'auto'; // Re-enable scrolling
                        setTimeout(() => {
                            loadingScreen.style.display = 'none';
                            console.log('Loading screen hidden');
                        }, 500);
                    }, remainingTime);
                });

                // Fallback: hide after 5 seconds max (in case assets take too long)
                setTimeout(() => {
                    const bodyElement = document.body;
                    if (loadingScreen && window.getComputedStyle(loadingScreen).display !== 'none') {
                        console.log('Fallback timeout triggered');
                        loadingScreen.style.opacity = '0';
                        bodyElement.style.overflow = 'auto';
                        setTimeout(() => {
                            loadingScreen.style.display = 'none';
                        }, 500);
                    }
                }, 5000);
            }
        </script>
    </body>
</html>
