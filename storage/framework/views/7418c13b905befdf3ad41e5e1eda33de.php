<div class="bg-white h-screen overflow-hidden">
    <div class="p-4 md:p-6 h-full">
        <div class="bg-[#1e3a5f] rounded-3xl overflow-hidden h-full flex flex-col relative">
            <?php echo $__env->make('layouts.navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <?php
                $heroImages = array_filter([
                    $profil->hero_image ?? null,
                    $profil->hero_image_2 ?? null,
                   $profil->hero_image_3 ?? null,
                ]);
            ?>

            <div class="relative z-10 px-4 md:px-6 pb-4 flex-1 flex flex-col overflow-hidden">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 md:gap-4 mt-6 flex-1 min-h-0">

                    
                    <div class="lg:col-span-5 flex flex-col gap-2 opacity-0-start animate-fade-in-left">
                        <div class="relative rounded-2xl overflow-hidden border border-white/20 flex-1 min-h-0 h-[360px] sm:h-[420px] md:h-auto">
                            <?php if(count($heroImages) > 0): ?>
                                <div class="hero-slider absolute inset-0">
                                    <?php $__currentLoopData = $heroImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $heroImage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="hero-slide absolute inset-0 transition-opacity duration-1000 <?php echo e($index === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0'); ?>" data-index="<?php echo e($index); ?>">
                                            <img src="<?php echo e(asset('storage/' . $heroImage)); ?>" alt="Hero Background <?php echo e($index + 1); ?>" class="w-full h-full object-cover">
                                            <div class="absolute inset-0 bg-black/40"></div>
                                            <div class="absolute inset-0 bg-gradient-to-t from-[#1e3a5f] via-[#1e3a5f]/30 to-[#1e3a5f]/50"></div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php else: ?>
                                <div class="absolute inset-0 bg-gradient-to-br from-blue-600 to-blue-800"></div>
                            <?php endif; ?>

                            <div class="absolute inset-0 flex flex-col justify-between p-4 md:p-6 z-20">
                                <div class="text-xs md:text-sm uppercase tracking-wider text-white drop-shadow-lg" style="text-shadow: 0 2px 4px rgba(0,0,0,0.5);">
                                    PMII KOMISARIAT UNIVERSITAS NURUL JADID
                                </div>
                                <div>
                                    <h2 class="text-xl md:text-2xl lg:text-3xl font-bold text-white leading-tight mb-4 drop-shadow-lg" style="text-shadow: 0 2px 8px rgba(0,0,0,0.5);">
                                        PERGERAKAN<br>MAHASISWA<br>ISLAM INDONESIA
                                    </h2>
                                    <a href="<?php echo e(route('posts.berita')); ?>" class="px-4 py-2 bg-yellow-500 border border-yellow-400 rounded-full text-[#0f172a] text-xs md:text-sm font-bold hover:bg-yellow-400 hover:scale-105 transition-all duration-300 shadow-lg animate-pulse-glow">
                                        Baca Berita
                                    </a>
                                </div>
                            </div>

                            <?php if(count($heroImages) > 1): ?>
                                <div class="absolute bottom-4 right-4 z-20 flex gap-2">
                                    <?php $__currentLoopData = $heroImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $heroImage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <button class="hero-dot w-2 h-2 rounded-full <?php echo e($index === 0 ? 'bg-white' : 'bg-white/40'); ?> transition-all duration-300" data-slide="<?php echo e($index); ?>"></button>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="mt-3 grid grid-cols-2 gap-2 md:hidden">
                            <div class="rounded-xl bg-[#0f172a] border border-yellow-500/30 px-3 py-2 text-center">
                                <div class="text-sm font-bold text-yellow-400"><?php echo e($stats['rayon']); ?></div>
                                <div class="text-[10px] uppercase text-white/70">Rayon</div>
                            </div>
                            <div class="rounded-xl bg-[#0f172a] border border-yellow-500/30 px-3 py-2 text-center">
                                <div class="text-sm font-bold text-yellow-400"><?php echo e($stats['anggota']); ?></div>
                                <div class="text-[10px] uppercase text-white/70">Kader</div>
                            </div>
                        </div>

                        <div class="hidden md:flex gap-2 opacity-0-start animate-fade-in-up delay-300">
                            <a href="<?php echo e(route('gallery.index')); ?>" class="flex-1 py-2 bg-[#0f172a] border border-white/20 rounded-full text-white text-center text-sm font-medium hover:bg-blue-700 hover:scale-105 transition-all duration-300">GALERI</a>
                            <a href="#" id="dataKader" class="flex-1 py-2 bg-[#0f172a] border border-white/20 rounded-full text-white text-center text-sm font-medium hover:bg-blue-700 hover:scale-105 transition-all duration-300">DATA KADER</a>
                        </div>
                    </div>

                    
                    <div class="hidden md:flex lg:col-span-7 flex-col gap-2 opacity-0-start animate-fade-in-right delay-200">
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

                        <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-4 md:p-5 flex-1 min-h-0 flex flex-col opacity-0-start animate-scale-in delay-300">
                            <h1 class="text-xl md:text-2xl lg:text-3xl font-bold text-white mb-3">Apa itu PMII?</h1>
                            <p class="text-white/80 text-sm leading-relaxed mb-4">
                                PMII adalah organisasi kemahasiswaan yang berafiliasi dengan Nahdlatul Ulama (NU). Didirikan pada 17 April 1960, PMII berkomitmen membentuk kader intelektual yang religius, kritis, dan aktif dalam pembangunan masyarakat Indonesia.
                            </p>

                            <div class="grid grid-cols-2 gap-3 mb-3 mt-auto">
                                <div class="bg-[#0f172a] border border-yellow-500/30 rounded-xl p-3 text-center hover:scale-105 transition-transform duration-300">
                                    <div class="text-xl md:text-2xl font-bold text-yellow-400 counter" data-target="<?php echo e($stats['rayon']); ?>">0</div>
                                    <div class="text-xs text-white/60 uppercase">Rayon</div>
                                </div>
                                <div class="bg-[#0f172a] border border-yellow-500/30 rounded-xl p-3 text-center hover:scale-105 transition-transform duration-300">
                                    <div class="text-xl md:text-2xl font-bold text-yellow-400 counter" data-target="<?php echo e($stats['anggota']); ?>">0</div>
                                    <div class="text-xs text-white/60 uppercase">Kader</div>
                                </div>
                            </div>

                            <div class="flex justify-end">
                                <a href="<?php echo e(route('about.profil')); ?>" class="w-9 h-9 rounded-full bg-yellow-500 border border-yellow-400 flex items-center justify-center hover:bg-yellow-400 hover:scale-110 transition-all duration-300 shadow-lg animate-float-p">
                                    <svg class="w-5 h-5 text-[#0f172a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 opacity-0-start animate-fade-in-up delay-400">
                            <a href="<?php echo e(route('about.rayon')); ?>" class="flex-1 py-2 bg-[#0f172a] border border-white/20 rounded-xl text-white text-center text-sm font-medium hover:bg-blue-700 hover:scale-105 transition-all duration-300">RAYON</a>
                            <div class="flex-1 flex justify-center">
                                <a href="#tentang-pmii" class="px-4 py-2 bg-white/5 border border-white/30 rounded-full text-white text-xs font-medium hover:bg-white/10 hover:scale-105 transition-all duration-300 flex items-center gap-2 animate-float">
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
</div>
<script>
if (dataKader) {
            dataKader.addEventListener('click', (e) => {
                e.preventDefault();
                alert('Fitur ini akan segera tersedia');
            });
        }
</script>

<?php /**PATH /var/www/resources/views/components/home/hero-section.blade.php ENDPATH**/ ?>