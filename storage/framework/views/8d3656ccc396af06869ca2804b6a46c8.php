<?php $__env->startSection('title', 'Download - PMII'); ?>

<?php $__env->startSection('content'); ?>
<div>
    <h1 class="text-3xl md:text-4xl font-bold mb-6 md:mb-8">Download</h1>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Mobile cards -->
        <div class="md:hidden divide-y">
            <?php $__empty_1 = true; $__currentLoopData = $downloads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $download): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <article class="p-4 <?php echo e(!$download->fileExists() ? 'bg-red-50' : ''); ?>">
                    <div class="flex items-start justify-between gap-3">
                        <h2 class="font-semibold text-gray-900"><?php echo e($download->nama_file); ?></h2>
                        <?php if(!$download->fileExists()): ?>
                            <span class="shrink-0 text-xs bg-red-100 text-red-800 px-2 py-1 rounded">File Missing</span>
                        <?php endif; ?>
                    </div>

                    <div class="mt-3">
                        <span class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs">
                            <?php echo e(str_replace('_', ' ', ucfirst($download->kategori))); ?>

                        </span>
                    </div>

                    <p class="mt-3 text-sm text-gray-600"><?php echo e($download->deskripsi ?? '-'); ?></p>

                    <div class="mt-4">
                        <?php if($download->fileExists()): ?>
                            <a href="<?php echo e(route('download.file', $download)); ?>" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">
                                Download
                            </a>
                        <?php else: ?>
                            <button type="button" disabled class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-500 rounded-lg text-sm cursor-not-allowed">
                                Tidak Tersedia
                            </button>
                        <?php endif; ?>
                    </div>
                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="px-4 py-10 text-center text-gray-500">
                    Belum ada file untuk didownload
                </div>
            <?php endif; ?>
        </div>

        <!-- Desktop table -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full min-w-[720px]">
                <thead class="bg-[#1e3a5f]/95 text-white">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold">Nama File</th>
                        <th class="px-6 py-4 text-left font-semibold">Kategori</th>
                        <th class="px-6 py-4 text-left font-semibold">Deskripsi</th>
                        <th class="px-6 py-4 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    <?php $__empty_1 = true; $__currentLoopData = $downloads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $download): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-50 <?php echo e(!$download->fileExists() ? 'bg-red-50' : ''); ?>">
                            <td class="px-6 py-4 font-semibold">
                                <?php echo e($download->nama_file); ?>

                                <?php if(!$download->fileExists()): ?>
                                    <span class="ml-2 text-xs bg-red-100 text-red-800 px-2 py-1 rounded">File Missing</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                                    <?php echo e(str_replace('_', ' ', ucfirst($download->kategori))); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-600"><?php echo e($download->deskripsi ?? '-'); ?></td>
                            <td class="px-6 py-4 text-center">
                                <?php if($download->fileExists()): ?>
                                    <a href="<?php echo e(route('download.file', $download)); ?>" class="inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">
                                        Download
                                    </a>
                                <?php else: ?>
                                    <button type="button" disabled class="inline-block px-4 py-2 bg-gray-300 text-gray-500 rounded-lg text-sm cursor-not-allowed">
                                        Tidak Tersedia
                                    </button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                Belum ada file untuk didownload
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if(method_exists($downloads, 'links')): ?>
            <div class="px-6 py-4 border-t bg-gray-50">
                <?php echo e($downloads->links()); ?>

            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/resources/views/frontend/download.blade.php ENDPATH**/ ?>