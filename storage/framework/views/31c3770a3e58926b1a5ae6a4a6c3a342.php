<!-- Navbar Absolute Transparan di Atas Hero -->
<div class="absolute top-0 left-0 right-0 z-50 py-4">
    <nav x-data="{ open: false, profilOpen: false, rubrikOpen: false }"
         class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"
         role="navigation"
         aria-label="Main navigation">

        <!-- Container Putih dengan Rounded -->
        <div class="bg-white rounded-3xl shadow-lg px-6 py-4">
            <div class="flex justify-between items-center">

                <!-- Logo -->
                <a href="<?php echo e(route('home')); ?>"
                   class="flex items-center space-x-2 sm:space-x-3"
                   aria-label="ISKAB Home">
                    <?php
                        $profil = \App\Models\ProfilOrganisasi::first();
                    ?>
                    <?php if($profil && $profil->logo_path): ?>
                        <img src="<?php echo e(asset('storage/' . $profil->logo_path)); ?>" alt="Logo ISKAB" class="w-10 h-10 sm:w-12 sm:h-12 object-contain">
                    <?php else: ?>
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-green-700 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 sm:w-8 sm:h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2L2 7v10c0 5.5 3.8 9.7 10 11 6.2-1.3 10-5.5 10-11V7l-10-5zm0 18c-4.4-1-7-4-7-8V8.3l7-3.9 7 3.9V12c0 4-2.6 7-7 8z"/>
                            </svg>
                        </div>
                    <?php endif; ?>
                    <span class="font-bold text-lg sm:text-xl md:text-2xl text-green-700"><?php echo e($profil?->nama_organisasi ?? 'ISKAB'); ?></span>
                </a>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">

                    <a href="<?php echo e(route('home')); ?>"
                       class="font-semibold text-green-700 hover:text-green-800 transition">
                        Beranda
                    </a>

                    <!-- Profil Dropdown -->
                    <div class="relative group">
                        <button class="font-semibold text-green-700 hover:text-green-800 flex items-center transition focus:outline-none"
                            aria-haspopup="true">
                            Profil
                            <svg class="w-4 h-4 ml-1 transition-transform group-hover:rotate-180"
                                 fill="currentColor" viewBox="0 0 20 20"
                                 aria-hidden="true">
                                <path fill-rule="evenodd"
                                      d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                      clip-rule="evenodd" />
                            </svg>
                        </button>

                        <!-- Dropdown dengan padding atas untuk hover continuity -->
                        <div class="hidden group-hover:block absolute left-0 pt-2 w-48 z-50">
                            <div class="bg-white rounded-lg shadow-xl border border-gray-200">
                                <a href="<?php echo e(route('about.profil')); ?>"
                                   class="block px-4 py-3 text-green-700 hover:bg-green-50 rounded-t-lg transition">Profil Organisasi</a>
                                <a href="<?php echo e(route('about.korwil')); ?>"
                                   class="block px-4 py-3 text-green-700 hover:bg-green-50 transition">Korwil</a>
                                <a href="<?php echo e(route('about.rayon')); ?>"
                                   class="block px-4 py-3 text-green-700 hover:bg-green-50 rounded-b-lg transition">Rayon</a>
                            </div>
                        </div>
                    </div>

                    <!-- Rubrik Dropdown -->
                    <div class="relative group">
                        <button class="font-semibold text-green-700 hover:text-green-800 flex items-center transition focus:outline-none"
                            aria-haspopup="true">
                            Rubrik
                            <svg class="w-4 h-4 ml-1 transition-transform group-hover:rotate-180"
                                 fill="currentColor" viewBox="0 0 20 20"
                                 aria-hidden="true">
                                <path fill-rule="evenodd"
                                      d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                      clip-rule="evenodd" />
                            </svg>
                        </button>

                        <!-- Dropdown dengan padding atas untuk hover continuity -->
                        <div class="hidden group-hover:block absolute left-0 pt-2 w-48 z-50">
                            <div class="bg-white rounded-lg shadow-xl border border-gray-200">
                                <a href="<?php echo e(route('posts.berita')); ?>"
                                   class="block px-4 py-3 text-green-700 hover:bg-green-50 rounded-t-lg transition">Berita</a>
                                <a href="<?php echo e(route('posts.pena-santri')); ?>"
                                   class="block px-4 py-3 text-green-700 hover:bg-green-50 rounded-b-lg transition">Pena Santri</a>
                            </div>
                        </div>
                    </div>

                    <a href="<?php echo e(route('gallery.index')); ?>" class="font-semibold text-green-700 hover:text-green-800 transition">Galeri</a>
                    <a href="<?php echo e(route('download.index')); ?>" class="font-semibold text-green-700 hover:text-green-800 transition">Download</a>
                    <a href="<?php echo e(route('data.index')); ?>" class="font-semibold text-green-700 hover:text-green-800 transition">Data</a>
                </div>

                <!-- Search Box & Mobile Toggle -->
                <div class="flex items-center space-x-4">
                    <!-- Search Box -->
                    <div class="hidden md:block relative">
                        <input type="text"
                               placeholder="Cari..."
                               class="w-64 pl-4 pr-10 py-2 bg-gray-100 border border-gray-200 rounded-full text-sm text-gray-700 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-500 focus:bg-white transition">
                        <button class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-600 hover:text-green-700 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </div>

                    <!-- Mobile Toggle -->
                    <button @click="open = !open"
                            class="md:hidden text-green-700"
                            aria-label="Toggle mobile menu"
                            aria-expanded="false"
                            :aria-expanded="open.toString()">
                        <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor"
                             viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg x-show="open" class="w-6 h-6" fill="none" stroke="currentColor"
                             viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div x-show="open" x-transition class="md:hidden mt-4 pt-4 border-t border-gray-200">
                <div class="space-y-2">
                    <a href="<?php echo e(route('home')); ?>" class="block px-4 py-2 text-green-700 hover:bg-green-50 rounded-lg transition">Beranda</a>

                    <!-- Profil Mobile -->
                    <div x-data="{ profilOpen: false }">
                        <button @click="profilOpen = !profilOpen" class="w-full text-left px-4 py-2 text-green-700 hover:bg-green-50 rounded-lg transition flex justify-between items-center">
                            <span>Profil</span>
                            <svg class="w-4 h-4 transition-transform" :class="profilOpen && 'rotate-180'" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div x-show="profilOpen" x-transition class="ml-4 mt-1 space-y-1">
                            <a href="<?php echo e(route('about.profil')); ?>" class="block px-4 py-2 text-green-600 hover:bg-green-50 rounded-lg transition text-sm">Profil Organisasi</a>
                            <a href="<?php echo e(route('about.korwil')); ?>" class="block px-4 py-2 text-green-600 hover:bg-green-50 rounded-lg transition text-sm">Korwil</a>
                            <a href="<?php echo e(route('about.rayon')); ?>" class="block px-4 py-2 text-green-600 hover:bg-green-50 rounded-lg transition text-sm">Rayon</a>
                        </div>
                    </div>

                    <!-- Rubrik Mobile -->
                    <div x-data="{ rubrikOpen: false }">
                        <button @click="rubrikOpen = !rubrikOpen" class="w-full text-left px-4 py-2 text-green-700 hover:bg-green-50 rounded-lg transition flex justify-between items-center">
                            <span>Rubrik</span>
                            <svg class="w-4 h-4 transition-transform" :class="rubrikOpen && 'rotate-180'" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div x-show="rubrikOpen" x-transition class="ml-4 mt-1 space-y-1">
                            <a href="<?php echo e(route('posts.berita')); ?>" class="block px-4 py-2 text-green-600 hover:bg-green-50 rounded-lg transition text-sm">Berita</a>
                            <a href="<?php echo e(route('posts.pena-santri')); ?>" class="block px-4 py-2 text-green-600 hover:bg-green-50 rounded-lg transition text-sm">Pena Santri</a>
                        </div>
                    </div>

                    <a href="<?php echo e(route('gallery.index')); ?>" class="block px-4 py-2 text-green-700 hover:bg-green-50 rounded-lg transition">Galeri</a>
                    <a href="<?php echo e(route('download.index')); ?>" class="block px-4 py-2 text-green-700 hover:bg-green-50 rounded-lg transition">Download</a>
                    <a href="<?php echo e(route('data.index')); ?>" class="block px-4 py-2 text-green-700 hover:bg-green-50 rounded-lg transition">Data</a>
                </div>
            </div>
        </div>
    </nav>
</div>
<?php /**PATH /var/www/resources/views/layouts/navigation.blade.php ENDPATH**/ ?>