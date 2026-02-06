<!-- Footer -->
<footer class="bg-gradient-to-r from-gray-800 to-gray-900 text-gray-300 py-16 mt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
            <!-- About Section -->
            <div>
                <h3 class="text-white font-bold text-lg mb-4">ISKAB</h3>
                <p class="text-sm text-gray-400 leading-relaxed mb-4">Ikatan Santri Kota Bandung adalah organisasi mahasiswa Islam yang berdedikasi untuk membangun ukhuwah dan menyebarkan nilai-nilai islam.</p>
                <div class="flex space-x-4">
                    <a href="#" class="text-orange-400 hover:text-orange-300 transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    <a href="#" class="text-orange-400 hover:text-orange-300 transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2s9 5 20 5a9.5 9.5 0 00-9-5.5c4.75 2.25 7-7 7-7"/></svg>
                    </a>
                    <a href="#" class="text-orange-400 hover:text-orange-300 transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16.5 5.5a2.121 2.121 0 100 4.243 2.121 2.121 0 000-4.243M5.5 12a6.5 6.5 0 1113 0 6.5 6.5 0 01-13 0z" fill="white"/></svg>
                    </a>
                </div>
            </div>

            <!-- Links Section 1 -->
            <div>
                <h4 class="text-white font-semibold mb-4">Navigasi</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="<?php echo e(route('home')); ?>" class="text-gray-400 hover:text-orange-400 transition">Beranda</a></li>
                    <li><a href="<?php echo e(route('about.profil')); ?>" class="text-gray-400 hover:text-orange-400 transition">Profil</a></li>
                    <li><a href="<?php echo e(route('about.korwil')); ?>" class="text-gray-400 hover:text-orange-400 transition">Korwil</a></li>
                    <li><a href="<?php echo e(route('about.rayon')); ?>" class="text-gray-400 hover:text-orange-400 transition">Rayon</a></li>
                    <li><a href="<?php echo e(route('data.index')); ?>" class="text-gray-400 hover:text-orange-400 transition">Data Struktur</a></li>
                </ul>
            </div>

            <!-- Links Section 2 -->
            <div>
                <h4 class="text-white font-semibold mb-4">Konten</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="<?php echo e(route('posts.berita')); ?>" class="text-gray-400 hover:text-orange-400 transition">Berita</a></li>
                    <li><a href="<?php echo e(route('posts.pena-santri')); ?>" class="text-gray-400 hover:text-orange-400 transition">Pena Santri</a></li>
                    <li><a href="<?php echo e(route('gallery.index')); ?>" class="text-gray-400 hover:text-orange-400 transition">Galeri</a></li>
                    <li><a href="<?php echo e(route('download.index')); ?>" class="text-gray-400 hover:text-orange-400 transition">Download</a></li>
                </ul>
            </div>

            <!-- Contact Section -->
            <div>
                <h4 class="text-white font-semibold mb-4">Kontak</h4>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li class="flex items-start">
                        <span class="mr-2">📍</span>
                        <span>Kota Bandung, Jawa Barat</span>
                    </li>
                    <li class="flex items-start">
                        <span class="mr-2">📧</span>
                        <span>info@iskab.com</span>
                    </li>
                    <li class="flex items-start">
                        <span class="mr-2">📱</span>
                        <span>+62 812-3456-7890</span>
                    </li>
                    <li class="mt-4">
                        <a href="https://wa.me/6281234567890" class="inline-block bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded text-xs font-semibold transition">
                            Chat WhatsApp
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Divider -->
        <div class="border-t border-gray-700 pt-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Copyright -->
                <div class="text-sm text-gray-500">
                    <p>&copy; 2026 Ikatan Santri Kota Bandung. All rights reserved.</p>
                </div>

                <!-- Footer Links -->
                <div class="flex justify-center md:justify-end space-x-6 text-sm">
                    <a href="#" class="text-gray-500 hover:text-gray-300 transition">Privacy Policy</a>
                    <a href="#" class="text-gray-500 hover:text-gray-300 transition">Terms of Service</a>
                    <a href="#" class="text-gray-500 hover:text-gray-300 transition">Sitemap</a>
                </div>
            </div>
        </div>
    </div>
</footer>
<?php /**PATH /var/www/resources/views/layouts/footer.blade.php ENDPATH**/ ?>