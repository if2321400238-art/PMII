<?php $__env->startSection('title', 'Anggota - Admin PMII'); ?>
<?php $__env->startSection('page_title', 'Kelola Anggota'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-4 md:mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Data Anggota</h1>
    <a href="<?php echo e(route('admin.anggota.create')); ?>" class="px-4 md:px-6 py-2 md:py-3 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-lg hover:from-green-700 hover:to-green-800 transition font-medium shadow-lg shadow-green-500/30 flex items-center justify-center text-sm md:text-base w-full sm:w-auto">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Tambah Anggota
    </a>
</div>

<div class="bg-white rounded-lg shadow-md p-4 md:p-6 mb-4 md:mb-6">
    <form method="GET" class="grid grid-cols-1 sm:grid-cols-2 gap-3 md:gap-4">
        <div>
            <label for="search-anggota" class="sr-only">Cari nama atau nomor anggota</label>
            <input type="text" id="search-anggota" name="search" placeholder="Cari nama atau nomor anggota" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500" value="<?php echo e(request('search')); ?>">
        </div>
        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm font-medium">
            Filter
        </button>
    </form>
</div>

<!-- Mobile Cards View -->
<h2 class="sr-only">Daftar Anggota</h2>
<div class="block md:hidden space-y-4">
    <?php $__empty_1 = true; $__currentLoopData = $anggota; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <article class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <div class="mb-3">
                <h3 class="font-semibold text-gray-900 text-base"><?php echo e($a->nama); ?></h3>
                <?php if($a->pondok): ?>
                    <p class="text-sm text-gray-600 mt-1"><?php echo e($a->pondok); ?></p>
                <?php endif; ?>
            </div>
            <div class="flex flex-wrap gap-2 text-xs mb-3">
                <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded font-mono"><?php echo e($a->nomor_anggota); ?></span>
                <span class="px-2 py-1 bg-blue-50 text-blue-700 rounded"><?php echo e($a->rayon->name); ?></span>
            </div>
            <div class="flex flex-wrap gap-2 pt-3 border-t border-gray-100">
                <a href="<?php echo e(route('admin.anggota.edit', $a)); ?>"
                   class="flex-1 inline-flex items-center justify-center px-3 py-2 text-sm font-medium bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit
                </a>
                <a href="<?php echo e(route('admin.anggota.download-kta', $a)); ?>"
                   class="inline-flex items-center justify-center px-3 py-2 text-sm font-medium bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    KTA
                </a>
                <form method="POST" action="<?php echo e(route('admin.anggota.destroy', $a)); ?>" onsubmit="return confirm('Yakin hapus?')" class="flex-1">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="w-full inline-flex items-center justify-center px-3 py-2 text-sm font-medium bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
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
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            <p class="text-gray-500 font-medium">Belum ada data anggota</p>
            <p class="text-gray-500 text-sm mt-1">Tambahkan anggota pertama untuk memulai</p>
        </div>
    <?php endif; ?>
</div>

<!-- Desktop Table View -->
<div class="hidden md:block bg-white rounded-lg shadow-md overflow-hidden">
    <table class="w-full">
        <thead class="bg-gradient-to-r from-green-50 to-green-100 border-b border-green-200">
            <tr>
                <th scope="col" class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Nama</th>
                <th scope="col" class="px-6 py-4 text-left text-sm font-semibold text-gray-700">No. Anggota</th>
                <th scope="col" class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Rayon</th>
                <th scope="col" class="px-6 py-4 text-center text-sm font-semibold text-gray-700">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            <?php $__empty_1 = true; $__currentLoopData = $anggota; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4">
                        <p class="font-semibold text-gray-900"><?php echo e($a->nama); ?></p>
                        <?php if($a->pondok): ?>
                            <p class="text-sm text-gray-600"><?php echo e($a->pondok); ?></p>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 font-mono text-sm"><?php echo e($a->nomor_anggota); ?></td>
                    <td class="px-6 py-4 text-sm"><?php echo e($a->rayon->name); ?></td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <a href="<?php echo e(route('admin.anggota.edit', $a)); ?>" class="inline-flex items-center px-3 py-1.5 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Edit
                            </a>
                            <a href="<?php echo e(route('admin.anggota.download-kta', $a)); ?>" class="inline-flex items-center px-3 py-1.5 text-sm bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                                KTA
                            </a>
                            <form method="POST" action="<?php echo e(route('admin.anggota.destroy', $a)); ?>" class="inline-block" onsubmit="return confirm('Yakin hapus?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="inline-flex items-center px-3 py-1.5 text-sm bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
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
                    <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                        <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Belum ada data anggota
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="mt-6 flex justify-center">
    <?php echo e($anggota->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/resources/views/admin/anggota/index.blade.php ENDPATH**/ ?>