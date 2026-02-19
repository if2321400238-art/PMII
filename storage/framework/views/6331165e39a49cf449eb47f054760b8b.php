<?php $__env->startSection('title', 'Berita - PMII'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .news-layout {
        display: block;
    }

    .news-main {
        min-width: 0;
    }

    .news-sidebar {
        margin-top: 1.5rem;
    }

    @media (min-width: 1024px) {
        .news-layout {
            display: flex;
            align-items: flex-start;
            gap: 1.5rem;
        }

        .news-main {
            flex: 1 1 auto;
        }

        .news-sidebar {
            flex: 0 0 340px;
            width: 340px;
            margin-top: 0;
        }
    }
</style>

<section class="max-w-7xl mx-auto">
    <div class="news-layout">
        <div class="news-main">
            <header class="mb-6 md:mb-8">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900">Berita</h1>
                <p class="mt-2 text-gray-600">Kumpulan berita terbaru PMII UNUJA</p>
            </header>

            <div class="mb-6 overflow-x-auto">
                <div class="flex items-center gap-2 min-w-max">
                    <a href="<?php echo e(route('posts.berita')); ?>"
                       class="px-4 py-2 rounded-full text-sm font-semibold transition <?php echo e(request('category') ? 'bg-gray-100 text-gray-700 hover:bg-gray-200' : 'bg-[#1e3a5f] text-white'); ?>">
                        Semua
                    </a>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('posts.berita', array_merge(request()->except('page'), ['category' => $category->id]))); ?>"
                           class="px-4 py-2 rounded-full text-sm font-semibold transition <?php echo e((string)request('category') === (string)$category->id ? 'bg-[#1e3a5f] text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'); ?>">
                            <?php echo e($category->name); ?>

                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <div class="mb-6 rounded-xl border border-dashed border-blue-300 bg-blue-50 p-4">
                <p class="text-xs font-bold uppercase tracking-wide text-blue-800">Ruang Iklan</p>
                <?php if($leftAd): ?>
                    <?php if($leftAd->target_url): ?>
                        <a href="<?php echo e($leftAd->target_url); ?>" target="_blank" rel="noopener noreferrer nofollow" class="mt-3 block">
                            <div class="w-full overflow-hidden rounded-lg border border-blue-200" style="aspect-ratio: 10 / 3;">
                                <img src="<?php echo e(asset('storage/' . $leftAd->image_path)); ?>" alt="<?php echo e($leftAd->title); ?>" class="h-full w-full object-cover">
                            </div>
                        </a>
                    <?php else: ?>
                        <div class="mt-3 w-full overflow-hidden rounded-lg border border-blue-200" style="aspect-ratio: 10 / 3;">
                            <img src="<?php echo e(asset('storage/' . $leftAd->image_path)); ?>" alt="<?php echo e($leftAd->title); ?>" class="h-full w-full object-cover">
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <p class="mt-2 text-sm text-blue-900">Promosi kegiatan rayon, agenda kampus, atau sponsor.</p>
                    <div class="mt-3 rounded-lg bg-white/70 border border-blue-200 flex items-center justify-center text-sm text-blue-700 font-medium" style="aspect-ratio: 10 / 3;">
                        Banner Iklan
                    </div>
                <?php endif; ?>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 divide-y">
                <?php $__empty_1 = true; $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <article class="p-4 md:p-5 hover:bg-gray-50 transition">
                        <a href="<?php echo e(route('posts.show', $post->slug)); ?>" class="flex items-start gap-3 md:gap-4">
                            <div class="shrink-0 w-28 h-20 md:w-40 md:h-24 rounded-lg overflow-hidden bg-gray-200">
                                <?php if($post->thumbnail): ?>
                                    <img src="<?php echo e(asset('storage/' . $post->thumbnail)); ?>" alt="<?php echo e($post->title); ?>" class="w-full h-full object-cover">
                                <?php endif; ?>
                            </div>

                            <div class="min-w-0 flex-1">
                                <div class="flex items-center gap-2 mb-2 text-xs text-gray-500">
                                    <span class="inline-flex px-2 py-0.5 rounded-full bg-blue-100 text-blue-800 font-medium"><?php echo e($post->category->name); ?></span>
                                    <span><?php echo e($post->published_at?->format('d M Y, H:i')); ?></span>
                                </div>

                                <h2 class="text-base md:text-xl font-semibold text-gray-900 leading-snug line-clamp-2">
                                    <?php echo e($post->title); ?>

                                </h2>

                                <p class="mt-1 text-sm text-gray-600 line-clamp-2"><?php echo e(strip_tags($post->content)); ?></p>

                                <div class="mt-2 flex items-center gap-3 text-xs text-gray-500">
                                    <span>Oleh <?php echo e($post->author?->name ?? 'Unknown'); ?></span>
                                    <span><?php echo e($post->view_count); ?> views</span>
                                </div>
                            </div>
                        </a>
                    </article>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="p-10 text-center text-gray-500">
                        Belum ada berita ditemukan
                    </div>
                <?php endif; ?>
            </div>

            <div class="mt-8">
                <?php echo e($posts->links()); ?>

            </div>
        </div>

        <aside class="news-sidebar">
            <div class="lg:sticky lg:top-28 rounded-xl border border-gray-200 bg-white shadow-sm p-4 md:p-5">
                <h2 class="text-lg font-bold text-gray-900">Artikel Populer</h2>
                <p class="mt-1 text-sm text-gray-500">Paling banyak dibaca minggu ini</p>

                <div class="mt-4 space-y-4">
                    <?php $__empty_1 = true; $__currentLoopData = $popularPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $popular): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <article>
                            <a href="<?php echo e(route('posts.show', $popular->slug)); ?>" class="group flex gap-3">
                                <div class="w-20 h-16 rounded-md overflow-hidden bg-gray-200 shrink-0">
                                    <?php if($popular->thumbnail): ?>
                                        <img src="<?php echo e(asset('storage/' . $popular->thumbnail)); ?>" alt="<?php echo e($popular->title); ?>" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                    <?php endif; ?>
                                </div>
                                <div class="min-w-0">
                                    <h3 class="text-sm font-semibold leading-snug line-clamp-2 text-gray-900 group-hover:text-blue-700 transition">
                                        <?php echo e($popular->title); ?>

                                    </h3>
                                    <div class="mt-1 text-xs text-gray-500">
                                        <?php echo e($popular->author?->name ?? 'Unknown'); ?> &bull; <?php echo e($popular->view_count); ?> views
                                    </div>
                                </div>
                            </a>
                        </article>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-sm text-gray-500">Belum ada artikel populer.</p>
                    <?php endif; ?>
                </div>
            </div>
        </aside>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/resources/views/frontend/rubrik/berita.blade.php ENDPATH**/ ?>