<?php $__env->startSection('title', $post->title . ' - ISKAB'); ?>

<?php $__env->startSection('content'); ?>
<article class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 pt-28 md:pt-32">
    <!-- Breadcrumb -->
    <div class="mb-8">
        <a href="<?php echo e(route('home')); ?>" class="text-green-600 hover:text-green-700">Beranda</a>
        <span class="text-gray-500 mx-2">/</span>
        <?php if($post->type === 'berita'): ?>
            <a href="<?php echo e(route('posts.berita')); ?>" class="text-green-600 hover:text-green-700">Berita</a>
        <?php else: ?>
            <a href="<?php echo e(route('posts.pena-santri')); ?>" class="text-green-600 hover:text-green-700">Pena Santri</a>
        <?php endif; ?>
        <span class="text-gray-500 mx-2">/</span>
        <span class="text-gray-700"><?php echo e($post->title); ?></span>
    </div>

    <!-- Header -->
    <header class="mb-8 pb-8 border-b">
        <div class="mb-4">
            <span class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold"><?php echo e($post->category->name); ?></span>
        </div>
        <h1 class="text-4xl md:text-5xl font-bold mb-4"><?php echo e($post->title); ?></h1>
        <div class="flex flex-wrap items-center gap-4 text-gray-600">
            <span>Oleh <strong><?php echo e($post->author?->name ?? 'Unknown'); ?></strong></span>
            <span><?php echo e($post->published_at?->format('d F Y')); ?></span>
            <span>👁️ <?php echo e($post->view_count); ?> views</span>
        </div>
    </header>

    <!-- Featured Image -->
    <?php if($post->thumbnail): ?>
        <div class="mb-8">
            <img src="<?php echo e(asset('storage/' . $post->thumbnail)); ?>" alt="<?php echo e($post->title); ?>" class="w-full rounded-lg shadow-lg">
        </div>
    <?php endif; ?>

    <!-- Content -->
    <div class="prose prose-lg max-w-none mb-12">
        <?php echo $post->content; ?>

    </div>

    <!-- Related Posts -->
    <?php if($relatedPosts->count() > 0): ?>
        <section class="mt-16 pt-12 border-t">
            <h2 class="text-3xl font-bold mb-8">Artikel Terkait</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <?php $__currentLoopData = $relatedPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $related): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                        <?php if($related->thumbnail): ?>
                            <img src="<?php echo e(asset('storage/' . $related->thumbnail)); ?>" alt="<?php echo e($related->title); ?>" class="w-full h-40 object-cover">
                        <?php else: ?>
                            <div class="w-full h-40 bg-gray-300"></div>
                        <?php endif; ?>
                        <div class="p-4">
                            <h3 class="text-lg font-bold mb-2 line-clamp-2">
                                <a href="<?php echo e(route('posts.show', $related->slug)); ?>" class="hover:text-green-600"><?php echo e($related->title); ?></a>
                            </h3>
                            <p class="text-sm text-gray-600 line-clamp-2 mb-3"><?php echo e(strip_tags($related->content)); ?></p>
                            <a href="<?php echo e(route('posts.show', $related->slug)); ?>" class="text-green-600 hover:text-green-700 font-semibold">Baca →</a>
                        </div>
                    </article>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </section>
    <?php endif; ?>
</article>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/resources/views/frontend/post/show.blade.php ENDPATH**/ ?>