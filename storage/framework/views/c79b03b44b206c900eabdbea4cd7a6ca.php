<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
        <meta name="robots" content="index, follow">
        <link rel="canonical" href="<?php echo e(url()->current()); ?>">

        <title><?php echo $__env->yieldContent('title', 'PMII Komisariat Universitas Nurul Jadid'); ?></title>
        <meta name="description" content="<?php echo $__env->yieldContent('description', 'PMII Komisariat Universitas Nurul Jadid - Pergerakan Mahasiswa Islam Indonesia yang berafiliasi dengan Nahdlatul Ulama (NU), membentuk kader intelektual yang religius dan kritis.'); ?>">
        <meta name="keywords" content="<?php echo $__env->yieldContent('keywords', 'PMII, PMII UNUJA, Pergerakan Mahasiswa Islam Indonesia, Universitas Nurul Jadid, Mahasiswa Islam, NU'); ?>">
        <meta name="author" content="PMII Komisariat UNUJA">

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="<?php echo e(asset('images/logo-pmii.png')); ?>">
        <link rel="apple-touch-icon" href="<?php echo e(asset('images/logo-pmii.png')); ?>">

        <meta property="og:type" content="website">
        <meta property="og:url" content="<?php echo e(url()->current()); ?>">
        <meta property="og:title" content="<?php echo $__env->yieldContent('title', 'PMII Komisariat Universitas Nurul Jadid'); ?>">
        <meta property="og:description" content="<?php echo $__env->yieldContent('description', 'Pergerakan Mahasiswa Islam Indonesia - Komisariat UNUJA'); ?>">
        <meta property="og:image" content="<?php echo $__env->yieldContent('image', asset('images/PMII-og.jpg')); ?>">
        <meta property="og:locale" content="id_ID">

        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="<?php echo $__env->yieldContent('title', 'PMII Komisariat Universitas Nurul Jadid'); ?>">
        <meta name="twitter:description" content="<?php echo $__env->yieldContent('description', 'Pergerakan Mahasiswa Islam Indonesia - Komisariat UNUJA'); ?>">
        <meta name="twitter:image" content="<?php echo $__env->yieldContent('image', asset('images/PMII-og.jpg')); ?>">

        <!-- Scripts -->
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
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
        <?php echo $__env->yieldPushContent('head'); ?>
    </head>
    <body class="font-sans antialiased">
        <!-- Loading Screen (Only on Homepage) -->
        <?php if(request()->routeIs('home')): ?>
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
                    <img src="<?php echo e(asset('images/logo-pmii.png')); ?>" alt="Logo PMII" style="width: 80px; height: 80px; border-radius: 9999px; object-fit: cover; border: 4px solid #facc15; box-shadow: 0 0 30px rgba(234, 179, 8, 0.6), inset 0 0 20px rgba(234, 179, 8, 0.2), 0 25px 50px -12px rgba(0, 0, 0, 0.25);">
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
        <?php endif; ?>

        <div class="min-h-screen bg-white flex flex-col relative">
            <?php if(!request()->routeIs('home')): ?>
                <?php echo $__env->make('layouts.navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php endif; ?>

            <!-- Page Content -->
            <main class="flex-grow" role="main">
                <?php if(request()->routeIs('home')): ?>
                    <?php echo $__env->yieldContent('home-section'); ?>
                <?php else: ?>
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2">
                <?php echo $__env->yieldContent('content'); ?>
                </div>
                <?php endif; ?>

            </main>

            <!-- Footer -->
            <?php echo $__env->make('layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>

        <script>
            // Mobile viewport height fix (avoids 100vh issues with browser UI bars)
            function setAppViewportHeight() {
                const vh = window.innerHeight * 0.01;
                document.documentElement.style.setProperty('--app-vh', `${vh}px`);
            }

            setAppViewportHeight();
            window.addEventListener('resize', setAppViewportHeight);
            window.addEventListener('orientationchange', setAppViewportHeight);

            // Only run loading screen script if it exists (homepage only)
            const loadingScreen = document.getElementById('loadingScreen');

            if (loadingScreen) {
                // Hide loading screen when page is fully loaded
                window.addEventListener('load', function() {
                    loadingScreen.style.opacity = '0';
                    setTimeout(() => {
                        loadingScreen.style.display = 'none';
                    }, 250);
                });

                // Fallback: hide quickly if load event is delayed
                setTimeout(() => {
                    if (loadingScreen && window.getComputedStyle(loadingScreen).display !== 'none') {
                        loadingScreen.style.opacity = '0';
                        setTimeout(() => {
                            loadingScreen.style.display = 'none';
                        }, 250);
                    }
                }, 1200);
            }
        </script>
    </body>
</html>
<?php /**PATH /var/www/resources/views/layouts/app.blade.php ENDPATH**/ ?>