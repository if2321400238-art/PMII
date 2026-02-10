<?php $__env->startSection('title', 'Berita - PMII'); ?>

<?php $__env->startSection('content'); ?>
<div class="">
    <h1 class="text-4xl font-bold mb-8">Berita</h1>

    <!-- Posts Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
        <?php $__empty_1 = true; $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                <?php if($post->thumbnail): ?>
                    <img src="<?php echo e(asset('storage/' . $post->thumbnail)); ?>" alt="<?php echo e($post->title); ?>" class="w-full h-48 object-cover">
                <?php else: ?>
                    <div class="w-full h-48 bg-gray-300"></div>
                <?php endif; ?>
                <div class="p-6">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm bg-emerald-100 text-blue-800 px-3 py-1 rounded-full"><?php echo e($post->category->name); ?></span>
                        <span class="text-sm text-gray-500"><?php echo e($post->published_at?->format('d M Y')); ?></span>
                    </div>
                    <h3 class="text-xl font-bold mb-2 line-clamp-2">
                        <a href="<?php echo e(route('posts.show', $post->slug)); ?>" class="hover:text-blue-600"><?php echo e($post->title); ?></a>
                    </h3>
                    <p class="text-gray-600 line-clamp-3 mb-4"><?php echo e(strip_tags($post->content)); ?></p>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">👁️ <?php echo e($post->view_count); ?></span>
                        <a href="<?php echo e(route('posts.show', $post->slug)); ?>" class="text-blue-600 hover:text-blue-700 font-semibold">Baca →</a>
                    </div>
                </div>
            </article>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-span-full text-center py-12">
                <p class="text-gray-500 text-lg">Belum ada berita ditemukan</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <div class="flex justify-center">
        <?php echo e($posts->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/resources/views/frontend/rubrik/berita.blade.php ENDPATH**/ ?>