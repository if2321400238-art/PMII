<?php $__env->startSection('title', 'Galeri - PMII'); ?>

<?php $__env->startSection('content'); ?>
<div class="">
    <h1 class="text-4xl font-bold mb-8">Galeri</h1>

    <!-- Gallery Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        <?php $__empty_1 = true; $__currentLoopData = $galleries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gallery): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <a href="<?php echo e(route('gallery.show', $gallery)); ?>" class="relative group overflow-hidden rounded-lg shadow-md h-48">
                <?php if($gallery->type === 'photo' && $gallery->file_path): ?>
                    <img src="<?php echo e(asset('storage/' . $gallery->file_path)); ?>" alt="<?php echo e($gallery->title); ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                <?php elseif($gallery->type === 'video'): ?>
                    <div class="w-full h-full bg-gray-800 flex items-center justify-center">
                        <svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M8 5v14l11-7z"/>
                        </svg>
                    </div>
                <?php else: ?>
                    <div class="w-full h-full bg-gray-300 flex items-center justify-center">
                        <span class="text-4xl">📷</span>
                    </div>
                <?php endif; ?>
                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-60 transition-all duration-300 flex items-center justify-center">
                    <div class="text-white opacity-0 group-hover:opacity-100 transition-opacity text-center px-4">
                        <p class="font-bold line-clamp-2"><?php echo e($gallery->title); ?></p>
                        <?php if($gallery->kegiatan): ?>
                            <p class="text-sm text-gray-300"><?php echo e($gallery->kegiatan); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-span-full text-center py-12">
                <p class="text-gray-500 text-lg">Belum ada galeri ditemukan</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <div class="flex justify-center">
        <?php echo e($galleries->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/resources/views/frontend/galeri.blade.php ENDPATH**/ ?>