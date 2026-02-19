<style>
    .hero-shell {
        height: calc(var(--app-vh, 1vh) * 100);
        overflow: hidden;
    }

    .hero-mobile-media {
        min-height: 300px;
    }

    .hero-noise {
        background-image:
            radial-gradient(circle at 20% 20%, rgba(250, 204, 21, 0.18), transparent 35%),
            radial-gradient(circle at 80% 85%, rgba(59, 130, 246, 0.28), transparent 45%);
    }

    .hero-mobile-contrast::after {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(
            to bottom,
            rgba(6, 16, 34, 0.26) 0%,
            rgba(6, 16, 34, 0.46) 38%,
            rgba(6, 16, 34, 0.68) 100%
        );
        pointer-events: none;
        z-index: 15;
    }

    .hero-mobile-content {
        position: relative;
        z-index: 20;
    }

    .hero-mobile-layout {
        display: flex;
    }

    .hero-desktop-layout {
        display: none;
    }

    @media (min-width: 768px) {
        .hero-shell {
            height: calc(var(--app-vh, 1vh) * 100);
            overflow: hidden;
        }

        .hero-inner {
            height: 100%;
        }

        .hero-surface {
            height: 100%;
        }

        .hero-content-wrap {
            height: 100%;
            min-height: 0;
            padding-bottom: 16px;
        }

        .hero-mobile-layout {
            display: none;
        }

        .hero-desktop-layout {
            display: grid;
            height: 100%;
            min-height: 0;
            padding-bottom: 6px;
        }

        .hero-desktop-col {
            min-height: 0;
        }
    }

    .hero-mobile-title {
        text-shadow: 0 8px 22px rgba(0, 0, 0, 0.55);
    }

    .hero-mobile-desc {
        text-shadow: 0 4px 14px rgba(0, 0, 0, 0.45);
    }
</style>

<?php
    $heroImages = array_filter([
        $profil->hero_image ?? null,
        $profil->hero_image_2 ?? null,
        $profil->hero_image_3 ?? null,
    ]);
?>

<section class="bg-slate-100 overflow-hidden hero-shell">
    <div class="hero-inner h-full p-3 sm:p-4 md:p-6">
        <div class="hero-surface h-full rounded-3xl bg-[#1e3a5f] shadow-2xl shadow-[#0f172a]/40 border border-white/10 overflow-hidden flex flex-col">
            <?php echo $__env->make('layouts.navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <div class="hero-content-wrap relative flex-1 min-h-0 px-3 sm:px-4 md:px-6 pb-3 md:pb-3 hero-noise">
                <!-- Mobile -->
                <div class="hero-mobile-layout h-full flex-col gap-3">
                    <div class="hero-mobile-contrast relative flex-1 min-h-0 hero-mobile-media rounded-3xl border border-white/20 overflow-hidden shadow-xl shadow-black/30">
                        <?php if(count($heroImages) > 0): ?>
                            <div class="hero-slider absolute inset-0">
                                <?php $__currentLoopData = $heroImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $heroImage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="hero-slide absolute inset-0 transition-opacity duration-1000 <?php echo e($index === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0'); ?>" data-index="<?php echo e($index); ?>">
                                        <img src="<?php echo e(asset('storage/' . $heroImage)); ?>" alt="Hero PMII <?php echo e($index + 1); ?>" class="w-full h-full object-cover">
                                        <div class="absolute inset-0 bg-gradient-to-b from-[#0f172a]/35 via-[#1e3a5f]/45 to-[#0f172a]/80"></div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php else: ?>
                            <div class="absolute inset-0 bg-gradient-to-br from-blue-800 via-blue-700 to-blue-900"></div>
                        <?php endif; ?>

                        <div class="absolute inset-0 p-4 flex flex-col justify-between z-20">
                            <div class="flex items-center justify-between gap-2">
                                <span class="inline-flex rounded-full border border-white/40 bg-white/10 px-3 py-1 text-[11px] font-medium tracking-wide uppercase text-white backdrop-blur-sm">
                                    PMII UNUJA
                                </span>
                                <span class="inline-flex rounded-full bg-yellow-400 px-3 py-1 text-[11px] font-semibold text-[#0f172a]">
                                    Organisasi Mahasiswa
                                </span>
                            </div>

                            <div class="hero-mobile-content p-4 rounded-2xl bg-gradient-to-t from-[#071a35]/55 via-[#071a35]/28 to-transparent">
                                <h1 class="hero-mobile-title text-4xl leading-tight font-bold text-white mb-2 tracking-tight">Bergerak, Kritis, dan Berdaya</h1>
                                <p class="hero-mobile-desc text-base text-white leading-relaxed mb-4">
                                    Wadah kaderisasi intelektual dan kepemimpinan mahasiswa Islam di Universitas Nurul Jadid.
                                </p>
                                <div class="flex gap-2">
                                    <a href="<?php echo e(route('posts.berita')); ?>" class="inline-flex min-h-11 items-center justify-center rounded-full bg-yellow-400 px-4 text-sm font-bold text-[#0f172a] hover:bg-yellow-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-yellow-300 transition">
                                        Baca Berita
                                    </a>
                                    <a href="<?php echo e(route('about.profil')); ?>" class="inline-flex min-h-11 items-center justify-center rounded-full border border-white/60 bg-white/15 px-4 text-sm font-semibold text-white hover:bg-white/25 focus:outline-none focus-visible:ring-2 focus-visible:ring-white transition">
                                        Tentang PMII
                                    </a>
                                </div>
                            </div>
                        </div>

                        <?php if(count($heroImages) > 1): ?>
                            <div class="absolute bottom-4 right-4 z-30 flex gap-2" role="tablist" aria-label="Slide hero">
                                <?php $__currentLoopData = $heroImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $heroImage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <button
                                        class="hero-dot h-2.5 rounded-full <?php echo e($index === 0 ? 'w-6 bg-white' : 'w-2.5 bg-white/40'); ?> transition-all duration-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-white"
                                        data-slide="<?php echo e($index); ?>"
                                        aria-label="Tampilkan slide <?php echo e($index + 1); ?>"
                                    ></button>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="rounded-2xl border border-white/15 bg-[#16355a]/80 backdrop-blur-sm p-2.5 shadow-xl shadow-black/25">
                        <div class="grid grid-cols-2 gap-2 mb-2">
                            <div class="rounded-xl bg-[#0b1f3a] border border-yellow-500/25 px-3 py-2.5 text-center">
                                <p class="text-xl font-bold text-yellow-300"><?php echo e($stats['rayon']); ?></p>
                                <p class="text-[11px] uppercase tracking-wide text-white/75">Rayon Aktif</p>
                            </div>
                            <div class="rounded-xl bg-[#0b1f3a] border border-yellow-500/25 px-3 py-2.5 text-center">
                                <p class="text-xl font-bold text-yellow-300"><?php echo e($stats['anggota']); ?></p>
                                <p class="text-[11px] uppercase tracking-wide text-white/75">Kader</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-2">
                            <a href="<?php echo e(route('gallery.index')); ?>" class="inline-flex min-h-11 items-center justify-center rounded-xl bg-[#0b1f3a] border border-white/15 px-3 text-sm font-semibold text-white hover:bg-[#0e2748] focus:outline-none focus-visible:ring-2 focus-visible:ring-white/80 transition">
                                Galeri
                            </a>
                            <a href="#" id="dataKader" class="inline-flex min-h-11 items-center justify-center rounded-xl bg-[#0b1f3a] border border-white/15 px-3 text-sm font-semibold text-white hover:bg-[#0e2748] focus:outline-none focus-visible:ring-2 focus-visible:ring-white/80 transition">
                                Data Kader
                            </a>
                        </div>
                    </div>

                    <a href="#tentang-pmii" class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl border border-white/25 bg-white/10 px-3 text-xs font-semibold tracking-wide uppercase text-white/95 hover:bg-white/15 focus:outline-none focus-visible:ring-2 focus-visible:ring-white/80 transition">
                        <span>Lanjut ke Tentang PMII</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                        </svg>
                    </a>
                </div>

                <!-- Desktop -->
                <div class="hero-desktop-layout grid-cols-1 lg:grid-cols-12 gap-4 mt-4">
                    <div class="hero-desktop-col lg:col-span-5 flex flex-col gap-2">
                        <div class="relative rounded-2xl overflow-hidden border border-white/20 flex-1 min-h-0 shadow-xl shadow-black/30">
                            <?php if(count($heroImages) > 0): ?>
                                <div class="hero-slider absolute inset-0">
                                    <?php $__currentLoopData = $heroImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $heroImage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="hero-slide absolute inset-0 transition-opacity duration-1000 <?php echo e($index === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0'); ?>" data-index="<?php echo e($index); ?>">
                                            <img src="<?php echo e(asset('storage/' . $heroImage)); ?>" alt="Hero PMII <?php echo e($index + 1); ?>" class="w-full h-full object-cover">
                                            <div class="absolute inset-0 bg-gradient-to-t from-[#1e3a5f] via-[#1e3a5f]/35 to-[#1e3a5f]/55"></div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php else: ?>
                                <div class="absolute inset-0 bg-gradient-to-br from-blue-700 to-blue-900"></div>
                            <?php endif; ?>

                            <div class="absolute inset-0 flex flex-col justify-between p-5 z-20">
                                <div class="text-sm uppercase tracking-wider text-white">
                                    PMII KOMISARIAT UNIVERSITAS NURUL JADID
                                </div>
                                <div>
                                    <h2 class="text-3xl font-bold text-white leading-tight mb-4">PERGERAKAN<br>MAHASISWA<br>ISLAM INDONESIA</h2>
                                    <a href="<?php echo e(route('posts.berita')); ?>" class="px-4 py-2 bg-yellow-500 border border-yellow-400 rounded-full text-[#0f172a] text-sm font-bold hover:bg-yellow-400 transition-all duration-300">
                                        Baca Berita
                                    </a>
                                </div>
                            </div>

                            <?php if(count($heroImages) > 1): ?>
                                <div class="absolute bottom-4 right-4 z-20 flex gap-2" role="tablist" aria-label="Slide hero">
                                    <?php $__currentLoopData = $heroImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $heroImage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <button class="hero-dot w-2 h-2 rounded-full <?php echo e($index === 0 ? 'bg-white' : 'bg-white/40'); ?> transition-all duration-300" data-slide="<?php echo e($index); ?>" aria-label="Tampilkan slide <?php echo e($index + 1); ?>"></button>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="flex gap-2">
                            <a href="<?php echo e(route('gallery.index')); ?>" class="flex-1 py-2 bg-[#0f172a] border border-white/20 rounded-full text-white text-center text-sm font-medium hover:bg-blue-700 transition-all duration-300">GALERI</a>
                            <a href="#" id="dataKaderDesktop" class="flex-1 py-2 bg-[#0f172a] border border-white/20 rounded-full text-white text-center text-sm font-medium hover:bg-blue-700 transition-all duration-300">DATA KADER</a>
                        </div>
                    </div>

                    <div class="hero-desktop-col lg:col-span-7 flex flex-col gap-2">
                        <div class="flex items-center gap-4">
                            <div class="flex-1 relative">
                                <input type="text" id="searchInput" placeholder="Search........" class="w-full bg-[#0f172a] border border-white/20 rounded-full px-4 py-2 text-sm text-white placeholder-white/40 focus:outline-none focus:border-yellow-500 transition" />
                            </div>
                            <button id="cameraBtn" class="w-9 h-9 rounded-lg bg-black border border-white/20 flex items-center justify-center hover:bg-gray-900 transition text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </button>
                            <button id="micBtn" class="w-9 h-9 rounded-lg bg-black border border-white/20 flex items-center justify-center hover:bg-gray-900 transition text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                                </svg>
                            </button>
                        </div>

                        <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-4 md:p-4 flex-1 min-h-0 flex flex-col">
                            <h2 class="text-xl md:text-2xl lg:text-3xl font-bold text-white mb-3">Apa itu PMII?</h2>
                            <p class="text-white/80 text-sm leading-relaxed mb-4">
                                PMII adalah organisasi kemahasiswaan yang berafiliasi dengan Nahdlatul Ulama (NU). Didirikan pada 17 April 1960, PMII berkomitmen membentuk kader intelektual yang religius, kritis, dan aktif dalam pembangunan masyarakat Indonesia.
                            </p>

                            <div class="grid grid-cols-2 gap-3 mb-3 mt-auto">
                                <div class="bg-[#0f172a] border border-yellow-500/30 rounded-xl p-3 text-center">
                                    <div class="text-xl md:text-2xl font-bold text-yellow-400 counter" data-target="<?php echo e($stats['rayon']); ?>">0</div>
                                    <div class="text-xs text-white/60 uppercase">Rayon</div>
                                </div>
                                <div class="bg-[#0f172a] border border-yellow-500/30 rounded-xl p-3 text-center">
                                    <div class="text-xl md:text-2xl font-bold text-yellow-400 counter" data-target="<?php echo e($stats['anggota']); ?>">0</div>
                                    <div class="text-xs text-white/60 uppercase">Kader</div>
                                </div>
                            </div>

                            <div class="flex justify-end">
                                <a href="<?php echo e(route('about.profil')); ?>" class="w-9 h-9 rounded-full bg-yellow-500 border border-yellow-400 flex items-center justify-center hover:bg-yellow-400 transition-all duration-300">
                                    <svg class="w-5 h-5 text-[#0f172a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            <a href="<?php echo e(route('about.rayon')); ?>" class="flex-1 py-2 bg-[#0f172a] border border-white/20 rounded-xl text-white text-center text-sm font-medium hover:bg-blue-700 transition-all duration-300">RAYON</a>
                            <div class="flex-1 flex justify-center">
                                <a href="#tentang-pmii" class="px-4 py-2 bg-white/5 border border-white/30 rounded-full text-white text-xs font-medium hover:bg-white/10 transition-all duration-300 flex items-center gap-2">
                                    <span>SCROLL</span>
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const showDataKaderMessage = function (event) {
            event.preventDefault();
            alert('Fitur ini akan segera tersedia');
        };

        const dataKaderMobile = document.getElementById('dataKader');
        const dataKaderDesktop = document.getElementById('dataKaderDesktop');

        if (dataKaderMobile) {
            dataKaderMobile.addEventListener('click', showDataKaderMessage);
        }

        if (dataKaderDesktop) {
            dataKaderDesktop.addEventListener('click', showDataKaderMessage);
        }
    });
</script>
<?php /**PATH /var/www/resources/views/components/home/hero-section.blade.php ENDPATH**/ ?>