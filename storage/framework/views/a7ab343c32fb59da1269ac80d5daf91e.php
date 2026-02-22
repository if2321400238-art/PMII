<section class="news-pinboard-section py-14 md:py-18 overflow-hidden section-reveal cinematic-section premium-section" data-reveal data-cinematic>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10">
        <h2 class="parallax-title premium-title text-2xl sm:text-3xl md:text-4xl font-bold text-center text-[#1d4ed8] mb-7 md:mb-9" data-parallax-title>Papan Berita</h2>

        <?php
            $pinnedPosts = $beritaTerkini->take(4);
            $pinClasses = ['pin-a', 'pin-b', 'pin-c', 'pin-d'];
        ?>

        <?php if($pinnedPosts->isNotEmpty()): ?>
            <div class="news-pinboard-stage">
                <span class="news-pinboard-rope rope-a" aria-hidden="true"></span>
                <span class="news-pinboard-rope rope-b" aria-hidden="true"></span>
                <span class="news-pinboard-rope rope-c" aria-hidden="true"></span>

                <?php $__currentLoopData = $pinnedPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $pinClass = $pinClasses[$loop->index] ?? 'pin-d';
                    ?>

                    <article class="news-pinboard-card <?php echo e($pinClass); ?>" onclick="window.location.href='<?php echo e(route('posts.show', $post->slug)); ?>'">
                        <span class="news-card-pin" aria-hidden="true"></span>

                        <div class="news-card-sheet">
                            <div class="news-card-media">
                                <?php if($post->thumbnail): ?>
                                    <img src="<?php echo e(route('img.optimized', ['path' => $post->thumbnail, 'w' => 640])); ?>" alt="<?php echo e($post->title); ?>" class="w-full h-full object-cover" loading="lazy" decoding="async" fetchpriority="low">
                                <?php else: ?>
                                    <div class="w-full h-full bg-gradient-to-br from-yellow-500 to-blue-600"></div>
                                <?php endif; ?>
                            </div>

                            <div class="news-card-content px-3 md:px-4 pt-2 md:pt-3 pb-3 md:pb-4">
                                <p class="text-[11px] md:text-xs tracking-wide font-semibold text-slate-500 mb-1">0<?php echo e($loop->iteration); ?></p>
                                <h3 class="text-[15px] md:text-[19px] font-extrabold leading-snug text-slate-900 line-clamp-2 break-words">
                                    <a href="<?php echo e(route('posts.show', $post->slug)); ?>" class="hover:text-blue-700"><?php echo e($post->title); ?></a>
                                </h3>
                                <p class="text-[11px] md:text-xs text-slate-500 mt-1">
                                    <span>Oleh <?php echo e($post->author->name ?? 'Admin'); ?></span>
                                    <span class="mx-1">•</span>
                                    <span><?php echo e(($post->published_at ?? $post->created_at)?->translatedFormat('d M Y')); ?></span>
                                </p>
                                <p class="text-[12px] md:text-sm text-slate-600 mt-1 line-clamp-2"><?php echo e(strip_tags($post->content)); ?></p>
                            </div>
                        </div>
                    </article>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <div class="w-full text-center py-8">
                <p class="text-slate-600 text-lg">Belum ada berita terkini</p>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php /**PATH /var/www/resources/views/components/home/news-carousel.blade.php ENDPATH**/ ?>