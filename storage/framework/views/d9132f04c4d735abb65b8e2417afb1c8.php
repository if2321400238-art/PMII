<?php $__env->startSection('title', 'Manajemen File Download - Admin PMII'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Manajemen File Download</h1>
                <p class="text-gray-600 mt-1">Kelola file dokumen yang dapat diunduh oleh pengunjung</p>
            </div>
            <a href="<?php echo e(route('admin.download.create')); ?>"
               class="px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-lg hover:from-green-700 hover:to-green-800 transition font-medium shadow-lg shadow-green-500/30 flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah File
            </a>
        </div>

        <?php if(session('success')): ?>
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded mb-6 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span><?php echo e(session('success')); ?></span>
            </div>
        <?php endif; ?>

        <!-- Mobile Cards View -->
        <h2 class="sr-only">Daftar File Download</h2>
        <div class="block md:hidden space-y-4">
            <?php $__empty_1 = true; $__currentLoopData = $downloads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $download): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <article class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                    <div class="flex items-start gap-3 mb-3">
                        <svg class="w-5 h-5 text-gray-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                        <div class="flex-1 min-w-0">
                            <h3 class="font-semibold text-gray-900 text-base"><?php echo e($download->nama_file); ?></h3>
                            <p class="text-xs text-gray-500 mt-1 line-clamp-2"><?php echo e(\Illuminate\Support\Str::limit($download->deskripsi, 80)); ?></p>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-2 items-center mb-3">
                        <?php
                            $colors = [
                                'logo' => 'bg-blue-100 text-blue-700 border-blue-200',
                                'ad_art' => 'bg-green-100 text-green-700 border-green-200',
                                'administrasi' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                                'surat_template' => 'bg-purple-100 text-purple-700 border-purple-200',
                                'panduan_lain' => 'bg-gray-100 text-gray-700 border-gray-200',
                            ];
                        ?>
                        <span class="px-2.5 py-1 text-xs font-medium rounded-full border <?php echo e($colors[$download->kategori] ?? 'bg-gray-100 text-gray-700 border-gray-200'); ?>">
                            <?php echo e(str_replace('_', ' ', ucwords(str_replace('_', ' ', $download->kategori)))); ?>

                        </span>
                        <span class="flex items-center text-xs text-gray-600">
                            <svg class="w-3 h-3 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            <?php echo e($download->download_count ?? 0); ?> unduhan
                        </span>
                    </div>
                    <div class="flex gap-2 pt-3 border-t border-gray-100">
                        <a href="<?php echo e(route('admin.download.edit', $download)); ?>"
                           class="flex-1 inline-flex items-center justify-center px-3 py-2 text-sm font-medium bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit
                        </a>
                        <form action="<?php echo e(route('admin.download.destroy', $download)); ?>" method="POST"
                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus file ini?')" class="flex-1">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit"
                                    class="w-full inline-flex items-center justify-center px-3 py-2 text-sm font-medium bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Hapus
                            </button>
                        </form>
                    </div>
                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 text-center">
                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                    <p class="text-gray-500 font-medium">Belum ada file download</p>
                    <p class="text-gray-500 text-sm mt-1">Tambahkan file pertama Anda untuk memulai</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Desktop Table View -->
        <div class="hidden md:block bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-green-50 to-green-100">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Nama File</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Kategori</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Deskripsi</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Unduhan</th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php $__empty_1 = true; $__currentLoopData = $downloads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $download): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                        </svg>
                                        <span class="font-semibold text-gray-900"><?php echo e($download->nama_file); ?></span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <?php
                                        $colors = [
                                            'logo' => 'bg-blue-100 text-blue-700 border-blue-200',
                                            'ad_art' => 'bg-green-100 text-green-700 border-green-200',
                                            'administrasi' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                                            'surat_template' => 'bg-purple-100 text-purple-700 border-purple-200',
                                            'panduan_lain' => 'bg-gray-100 text-gray-700 border-gray-200',
                                        ];
                                    ?>
                                    <span class="px-3 py-1.5 text-xs font-medium rounded-full border <?php echo e($colors[$download->kategori] ?? 'bg-gray-100 text-gray-700 border-gray-200'); ?>">
                                        <?php echo e(str_replace('_', ' ', ucwords(str_replace('_', ' ', $download->kategori)))); ?>

                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    <?php echo e(\Illuminate\Support\Str::limit($download->deskripsi, 80)); ?>

                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center text-sm text-gray-700">
                                        <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                        </svg>
                                        <span class="font-medium"><?php echo e($download->download_count ?? 0); ?></span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="<?php echo e(route('admin.download.edit', $download)); ?>"
                                           class="inline-flex items-center px-3 py-1.5 text-xs font-medium bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                            Edit
                                        </a>
                                        <form action="<?php echo e(route('admin.download.destroy', $download)); ?>" method="POST"
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus file ini?')" class="inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit"
                                                    class="inline-flex items-center px-3 py-1.5 text-xs font-medium bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                    </svg>
                                    <p class="text-gray-500 font-medium">Belum ada file download</p>
                                    <p class="text-gray-500 text-sm mt-1">Tambahkan file pertama Anda untuk memulai</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <?php if($downloads->hasPages()): ?>
            <div class="mt-6">
                <?php echo e($downloads->links()); ?>

            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/resources/views/admin/download/index.blade.php ENDPATH**/ ?>