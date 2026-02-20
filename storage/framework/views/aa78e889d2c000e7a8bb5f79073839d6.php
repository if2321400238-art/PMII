<?php $__env->startSection('title', 'Galeri - PMII'); ?>

<?php $__env->startSection('content'); ?>
<div>
    <h1 class="text-3xl md:text-4xl font-bold mb-6 md:mb-8 text-blue-900">Galeri</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 md:gap-6 mb-10 md:mb-12">
        <?php $__empty_1 = true; $__currentLoopData = $galleries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gallery): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <a href="<?php echo e(route('gallery.show', $gallery)); ?>" class="relative group overflow-hidden rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 h-56 md:h-52 bg-slate-100">
                <?php if($gallery->type === 'photo' && $gallery->file_path): ?>
                    <img src="<?php echo e(asset('storage/' . $gallery->file_path)); ?>" alt="<?php echo e($gallery->title); ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                <?php elseif($gallery->type === 'video'): ?>
                    <?php if($gallery->file_path): ?>
                        <video class="w-full h-full object-cover" muted playsinline preload="metadata">
                            <source src="<?php echo e(asset('storage/' . $gallery->file_path)); ?>">
                        </video>
                    <?php elseif($gallery->video_thumbnail_url): ?>
                        <img src="<?php echo e($gallery->video_thumbnail_url); ?>" alt="<?php echo e($gallery->title); ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                    <?php else: ?>
                        <div class="w-full h-full bg-gray-800 flex items-center justify-center">
                            <svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8 5v14l11-7z"/>
                            </svg>
                        </div>
                    <?php endif; ?>
                    <div class="absolute top-3 right-3 rounded-full bg-black/55 px-2.5 py-1 text-[11px] font-semibold text-white">Video</div>
                <?php else: ?>
                    <div class="w-full h-full bg-gray-300 flex items-center justify-center">
                        <span class="text-gray-600 text-sm">Media</span>
                    </div>
                <?php endif; ?>

                <div class="absolute inset-0 bg-gradient-to-t from-blue-950/90 via-blue-900/40 to-transparent"></div>
                <div class="absolute bottom-0 inset-x-0 p-4 text-white">
                    <p class="font-bold leading-snug line-clamp-2 break-words"><?php echo e($gallery->title); ?></p>
                    <?php if($gallery->kegiatan): ?>
                            <p class="text-sm text-gray-200 mt-1 line-clamp-1 break-words"><?php echo e($gallery->kegiatan); ?></p>
                        <?php endif; ?>
                </div>
            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-span-full text-center py-12">
                <p class="text-gray-500 text-lg">Belum ada galeri ditemukan</p>
            </div>
        <?php endif; ?>
    </div>

    <div class="flex justify-center">
        <?php echo e($galleries->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/resources/views/frontend/galeri.blade.php ENDPATH**/ ?>