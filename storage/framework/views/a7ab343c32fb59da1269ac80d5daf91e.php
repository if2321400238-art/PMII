<section class="bg-[#1e3a5f] py-10 md:py-12 overflow-hidden section-reveal cinematic-section" data-reveal data-cinematic>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="parallax-title text-2xl sm:text-3xl md:text-4xl font-bold text-center text-white mb-6 md:mb-8" data-parallax-title>Berita Terkini</h2>

        <div class="relative">
            <button id="prevBerita" aria-label="Berita sebelumnya" class="absolute left-0 top-1/2 -translate-y-1/2 z-20 bg-white hover:bg-gray-50 text-blue-700 rounded-full p-2 md:p-3 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-110 focus:outline-none focus-visible:ring-2 focus-visible:ring-yellow-300">
                <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>

            <button id="nextBerita" aria-label="Berita berikutnya" class="absolute right-0 top-1/2 -translate-y-1/2 z-20 bg-white hover:bg-gray-50 text-blue-700 rounded-full p-2 md:p-3 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-110 focus:outline-none focus-visible:ring-2 focus-visible:ring-yellow-300">
                <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>

            <div class="relative overflow-x-auto overflow-y-hidden scroll-smooth scrollbar-hide mx-8">
                <div id="beritaCarousel">
                    <div id="beritaContainer" class="flex gap-4 lg:gap-6 py-2">
                        <?php $__empty_1 = true; $__currentLoopData = $beritaTerkini; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <article class="card-reveal subtle-hover flex-none w-full lg:w-[calc(33.333%-1rem)] bg-white rounded-2xl overflow-hidden transition transform hover:-translate-y-1 relative h-72 md:h-64 cursor-pointer shadow-xl shadow-black/15" style="--reveal-delay: <?php echo e($loop->index * 80); ?>ms;" data-reveal-card onclick="window.location.href='<?php echo e(route('posts.show', $post->slug)); ?>'">
                                <?php if($post->thumbnail): ?>
                                    <img src="<?php echo e(asset('storage/' . $post->thumbnail)); ?>" alt="<?php echo e($post->title); ?>" class="w-full h-full object-cover">
                                <?php else: ?>
                                    <div class="w-full h-full bg-gradient-to-br from-yellow-500 to-blue-600"></div>
                                <?php endif; ?>
                                <div class="absolute inset-0" style="background: linear-gradient(to bottom, rgba(250, 204, 21, 0.45) 0%, rgba(250, 204, 21, 0.00) 45%);"></div>
                                <div class="absolute inset-0 bg-gradient-to-t from-blue-900 via-transparent to-transparent"></div>
                                <div class="absolute bottom-0 left-0 right-0 p-4 text-white">
                                    <div class="inline-block bg-gradient-to-l from-blue-500 to-blue-700 text-white text-xs font-semibold px-2.5 py-1 rounded-full mb-2">Berita PMII</div>
                                    <h3 class="text-base md:text-base font-bold line-clamp-2">
                                        <a href="<?php echo e(route('posts.show', $post->slug)); ?>" class="hover:text-yellow-400"><?php echo e($post->title); ?></a>
                                    </h3>
                                    <p class="text-gray-200 text-sm md:text-xs line-clamp-2 md:line-clamp-1"><?php echo e(strip_tags($post->content)); ?></p>
                                </div>
                            </article>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="w-full text-center py-8">
                                <p class="text-white text-lg">Belum ada berita terkini</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div id="beritaDots" class="flex justify-center gap-2 mt-6"></div>
    </div>
</section>
<?php /**PATH /var/www/resources/views/components/home/news-carousel.blade.php ENDPATH**/ ?>