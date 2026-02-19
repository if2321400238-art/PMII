<section class="bg-white py-10 md:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-20">
        <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-center text-blue-700 mb-6 md:mb-8">Galeri</h2>

        
        <div class="lg:hidden relative">
            <button id="prevGallery" aria-label="Galeri sebelumnya" class="absolute left-0 top-1/2 -translate-y-1/2 z-20 bg-blue-700 hover:bg-blue-800 text-white rounded-full p-2 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-110 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>

            <button id="nextGallery" aria-label="Galeri berikutnya" class="absolute right-0 top-1/2 -translate-y-1/2 z-20 bg-blue-700 hover:bg-blue-800 text-white rounded-full p-2 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-110 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>

            <div id="galleryCarousel" class="overflow-x-auto overflow-y-hidden scroll-smooth scrollbar-hide mx-8">
                <div class="flex gap-4 py-2">
                    <?php $__empty_1 = true; $__currentLoopData = $galleryHighlight; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gallery): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <article class="flex-none w-full bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition transform hover:-translate-y-1 relative h-80 cursor-pointer" onclick="window.location.href='<?php echo e(route('gallery.show', $gallery->id)); ?>'">
                            <?php if($gallery->file_path): ?>
                                <img src="<?php echo e(asset('storage/' . $gallery->file_path)); ?>" alt="<?php echo e($gallery->title); ?>" class="w-full h-full object-cover">
                            <?php else: ?>
                                <div class="w-full h-full bg-gradient-to-br from-yellow-500 to-blue-600"></div>
                            <?php endif; ?>
                            <div class="absolute inset-0 bg-gradient-to-t from-blue-900 via-transparent to-transparent"></div>
                            <div class="absolute bottom-0 left-0 right-0 p-5 text-white">
                                <div class="inline-block bg-gradient-to-r from-yellow-500 to-yellow-700 text-white text-xs font-semibold px-3 py-1 rounded-full mb-3">Galeri</div>
                                <h3 class="text-lg font-bold mb-2 line-clamp-2">
                                    <a href="<?php echo e(route('gallery.show', $gallery->id)); ?>" class="hover:text-yellow-400"><?php echo e($gallery->title); ?></a>
                                </h3>
                                <p class="text-gray-200 text-sm line-clamp-2"><?php echo e(strip_tags($gallery->description)); ?></p>
                            </div>
                        </article>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="w-full text-center py-8">
                            <p class="text-gray-500 text-lg">Belum ada galeri</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div id="galleryDots" class="flex justify-center gap-2 mt-6"></div>
        </div>

        
        <div class="hidden lg:grid grid-cols-3 gap-6">
            <?php $__empty_1 = true; $__currentLoopData = $galleryHighlight; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $gallery): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php if($index === 0): ?>
                    <article class="col-span-1 row-span-2 bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition transform hover:-translate-y-1 relative min-h-[320px] cursor-pointer" onclick="window.location.href='<?php echo e(route('gallery.show', $gallery->id)); ?>'">
                        <?php if($gallery->file_path): ?>
                            <img src="<?php echo e(asset('storage/' . $gallery->file_path)); ?>" alt="<?php echo e($gallery->title); ?>" class="w-full h-full object-cover">
                        <?php else: ?>
                            <div class="w-full h-full bg-gradient-to-br from-yellow-500 to-blue-600"></div>
                        <?php endif; ?>
                        <div class="absolute inset-0 bg-gradient-to-t from-blue-900 via-transparent to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                            <div class="inline-block bg-gradient-to-r from-blue-500 to-blue-700 text-white text-xs font-semibold px-3 py-1 rounded-full mb-3">Galeri</div>
                            <h3 class="text-2xl font-bold mb-2">
                                <a href="<?php echo e(route('gallery.show', $gallery->id)); ?>" class="hover:text-yellow-400"><?php echo e($gallery->title); ?></a>
                            </h3>
                            <p class="text-gray-200 text-sm line-clamp-2"><?php echo e(strip_tags($gallery->description)); ?></p>
                        </div>
                    </article>
                <?php else: ?>
                    <article class="bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition transform hover:-translate-y-1 relative h-48 cursor-pointer" onclick="window.location.href='<?php echo e(route('gallery.show', $gallery->id)); ?>'">
                        <?php if($gallery->file_path): ?>
                            <img src="<?php echo e(asset('storage/' . $gallery->file_path)); ?>" alt="<?php echo e($gallery->title); ?>" class="w-full h-full object-cover">
                        <?php else: ?>
                            <div class="w-full h-full bg-gradient-to-br from-yellow-500 to-blue-600"></div>
                        <?php endif; ?>
                        <div class="absolute inset-0 bg-gradient-to-t from-blue-900 via-transparent to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-4 text-white">
                            <div class="inline-block bg-gradient-to-l from-blue-500 to-blue-700 text-white text-xs font-semibold px-2 py-1 rounded-full mb-2">Galeri</div>
                            <h3 class="text-base font-bold line-clamp-2">
                                <a href="<?php echo e(route('gallery.show', $gallery->id)); ?>" class="hover:text-yellow-400"><?php echo e($gallery->title); ?></a>
                            </h3>
                            <p class="text-gray-200 text-xs line-clamp-1"><?php echo e(strip_tags($gallery->description)); ?></p>
                        </div>
                    </article>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-span-3 text-center">
                    <p class="text-gray-500 text-lg">Belum ada galeri</p>
                </div>
            <?php endif; ?>

            <?php if($galleryHighlight->count() < 5): ?>
                <?php for($i = $galleryHighlight->count(); $i < 5; $i++): ?>
                    <?php if($i === 0): ?>
                        <article class="col-span-1 row-span-2 bg-white rounded-2xl shadow-xl overflow-hidden relative min-h-[320px]">
                            <div class="w-full h-full bg-gradient-to-br from-yellow-400 to-yellow-500"></div>
                            <div class="absolute inset-0 bg-gradient-to-t from-blue-900 via-transparent to-transparent"></div>
                            <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                                <div class="inline-block bg-gradient-to-l from-blue-500 to-blue-700 text-white text-xs font-semibold px-3 py-1 rounded-full mb-3">Galeri</div>
                                <h3 class="text-2xl font-bold mb-2">Lorem ipsum dolor consectetur</h3>
                                <p class="text-gray-200 text-sm line-clamp-2">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                            </div>
                        </article>
                    <?php else: ?>
                        <article class="bg-white rounded-2xl shadow-xl overflow-hidden relative h-48">
                            <div class="w-full h-full bg-gradient-to-br from-gray-300 to-gray-400"></div>
                            <div class="absolute inset-0 bg-gradient-to-t from-blue-900 via-transparent to-transparent"></div>
                            <div class="absolute bottom-0 left-0 right-0 p-4 text-white">
                                <div class="inline-block bg-blue-500 text-white text-xs font-semibold px-2 py-1 rounded-full mb-2">Galeri</div>
                                <h3 class="text-base font-bold line-clamp-2">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h3>
                                <p class="text-gray-200 text-xs line-clamp-1">Lorem ipsum dolor sit amet.</p>
                            </div>
                        </article>
                    <?php endif; ?>
                <?php endfor; ?>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php /**PATH /var/www/resources/views/components/home/gallery-section.blade.php ENDPATH**/ ?>