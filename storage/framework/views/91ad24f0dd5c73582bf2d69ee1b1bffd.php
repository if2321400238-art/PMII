<?php $__env->startSection('title', 'Galeri - Admin ISKAB'); ?>

<?php $__env->startSection('content'); ?>
<?php
    $role = auth()->user()->role
        ?? (auth()->guard('korwil')->check() ? 'korwil_admin' : (auth()->guard('rayon')->check() ? 'rayon_admin' : null));
?>
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Kelola Galeri</h1>
                <p class="text-gray-600 mt-1">Kelola foto dan video dokumentasi organisasi</p>
            </div>
            <a href="<?php echo e(route('admin.gallery.create')); ?>"
               class="px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-lg hover:from-green-700 hover:to-green-800 transition font-medium shadow-lg shadow-green-500/30 flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Galeri
            </a>
        </div>

        <?php if(session('success')): ?>
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded mb-6 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span><?php echo e(session('success')); ?></span>
            </div>
        <?php endif; ?>

        <!-- Filter -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-6">
            <form method="GET" class="flex gap-3 items-center flex-wrap">
                <label class="text-sm font-semibold text-gray-700">Filter:</label>
                <select name="type" class="border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500" onchange="this.form.submit()">
                    <option value="">Semua Tipe</option>
                    <option value="photo" <?php echo e(request('type') === 'photo' ? 'selected' : ''); ?>>Foto</option>
                    <option value="video" <?php echo e(request('type') === 'video' ? 'selected' : ''); ?>>Video</option>
                </select>
                <select name="approval_status" class="border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="draft" <?php echo e(request('approval_status') === 'draft' ? 'selected' : ''); ?>>Draft</option>
                    <option value="pending" <?php echo e(request('approval_status') === 'pending' ? 'selected' : ''); ?>>Menunggu Approval</option>
                    <option value="approved" <?php echo e(request('approval_status') === 'approved' ? 'selected' : ''); ?>>Disetujui</option>
                    <option value="rejected" <?php echo e(request('approval_status') === 'rejected' ? 'selected' : ''); ?>>Ditolak</option>
                </select>
                <?php if(request()->has('type') || request()->has('approval_status')): ?>
                    <a href="<?php echo e(route('admin.gallery.index')); ?>" class="text-sm text-blue-600 hover:underline">Reset Filter</a>
                <?php endif; ?>
            </form>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-green-50 to-green-100 border-b border-green-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Judul</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Tipe</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Kegiatan</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Tahun</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status Approval</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php $__empty_1 = true; $__currentLoopData = $galleries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gallery): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-gray-900"><?php echo e($gallery->title); ?></div>
                                    <div class="text-xs text-gray-500 mt-1"><?php echo e(Str::limit($gallery->description, 80)); ?></div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full <?php echo e($gallery->type === 'photo' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800'); ?>">
                                        <?php echo e(ucfirst($gallery->type)); ?>

                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700"><?php echo e($gallery->kegiatan ?? '-'); ?></td>
                                <td class="px-6 py-4 text-sm text-gray-700"><?php echo e($gallery->tahun ?? '-'); ?></td>
                                <td class="px-6 py-4">
                                    <?php if($gallery->approval_status === 'approved'): ?>
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Disetujui</span>
                                    <?php elseif($gallery->approval_status === 'pending'): ?>
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                    <?php elseif($gallery->approval_status === 'rejected'): ?>
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>
                                    <?php else: ?>
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Draft</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col gap-2">
                                        <!-- Tombol Approve/Reject untuk admin jika status pending -->
                                        <?php if(in_array($role, ['admin', 'pb']) && $gallery->approval_status === 'pending'): ?>
                                            <form action="<?php echo e(route('admin.gallery.approve', $gallery)); ?>" method="POST" class="inline">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="inline-flex items-center px-3 py-1.5 text-xs font-medium bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                    Setujui
                                                </button>
                                            </form>
                                            <button onclick="showRejectFormGallery(<?php echo e($gallery->id); ?>)"
                                                    class="inline-flex items-center px-3 py-1.5 text-xs font-medium bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                                Tolak
                                            </button>

                                            <!-- Form Reject (Hidden) -->
                                            <div id="reject-form-gallery-<?php echo e($gallery->id); ?>" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                                                <div class="bg-white p-6 rounded-lg max-w-md shadow-xl">
                                                    <h3 class="font-bold text-lg mb-4 text-gray-900">Tolak Galeri</h3>
                                                    <form method="POST" action="<?php echo e(route('admin.gallery.reject', $gallery)); ?>">
                                                        <?php echo csrf_field(); ?>
                                                        <div class="mb-4">
                                                            <label class="block text-sm font-semibold mb-2 text-gray-700">Alasan Penolakan:</label>
                                                            <textarea name="rejection_reason" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500" rows="4" required></textarea>
                                                        </div>
                                                        <div class="flex gap-2 justify-end">
                                                            <button type="button" onclick="hideRejectFormGallery(<?php echo e($gallery->id); ?>)"
                                                                    class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                                                                Batal
                                                            </button>
                                                            <button type="submit"
                                                                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                                                                Tolak
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                        <!-- Tombol Edit dan Hapus -->
                                        <div class="flex gap-2 justify-center">
                                            <a href="<?php echo e(route('admin.gallery.edit', $gallery)); ?>"
                                               class="inline-flex items-center px-3 py-1.5 text-xs font-medium bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                                Edit
                                            </a>
                                            <form action="<?php echo e(route('admin.gallery.destroy', $gallery)); ?>" method="POST" onsubmit="return confirm('Hapus item ini?')" class="inline">
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
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <p class="text-gray-500 font-medium">Belum ada data galeri</p>
                                        <p class="text-gray-400 text-sm mt-1">Tambahkan foto atau video pertama Anda</p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            <?php echo e($galleries->withQueryString()->links()); ?>

        </div>
    </div>
</div>

<script>
function showRejectFormGallery(galleryId) {
    document.getElementById('reject-form-gallery-' + galleryId).classList.remove('hidden');
}

function hideRejectFormGallery(galleryId) {
    document.getElementById('reject-form-gallery-' + galleryId).classList.add('hidden');
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/resources/views/admin/gallery/index.blade.php ENDPATH**/ ?>