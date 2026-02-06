<?php $__env->startSection('title', 'Posts - Admin ISKAB'); ?>

<?php $__env->startSection('content'); ?>
<div class="w-full">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-4 md:mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Kelola Posts</h1>
                <p class="text-xs md:text-sm text-gray-600 mt-1">Kelola berita dan artikel Pena Santri</p>
            </div>
            <a href="<?php echo e(route('admin.posts.create')); ?>"
               class="px-4 md:px-6 py-2 md:py-3 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-lg hover:from-green-700 hover:to-green-800 transition font-medium text-sm md:text-base shadow-lg shadow-green-500/30 flex items-center whitespace-nowrap">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Buat Post Baru
            </a>
        </div>

        <?php if(session('success')): ?>
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 px-3 md:px-4 py-2 md:py-3 rounded mb-4 md:mb-6 flex items-center text-xs md:text-sm">
                <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span><?php echo e(session('success')); ?></span>
            </div>
        <?php endif; ?>

        <!-- Filter Status -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-3 md:p-4 mb-4 md:mb-6">
            <form method="GET" class="flex flex-col sm:flex-row gap-2 sm:gap-3 items-start sm:items-center">
                <label class="text-xs md:text-sm font-semibold text-gray-700">Filter Status:</label>
                <select name="approval_status" class="border border-gray-300 rounded-lg px-3 md:px-4 py-2 text-xs md:text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 w-full sm:w-auto" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="draft" <?php echo e(request('approval_status') == 'draft' ? 'selected' : ''); ?>>Draft</option>
                    <option value="pending" <?php echo e(request('approval_status') == 'pending' ? 'selected' : ''); ?>>Menunggu Approval</option>
                    <option value="approved" <?php echo e(request('approval_status') == 'approved' ? 'selected' : ''); ?>>Disetujui</option>
                    <option value="rejected" <?php echo e(request('approval_status') == 'rejected' ? 'selected' : ''); ?>>Ditolak</option>
                </select>
            </form>
        </div>

        <!-- Mobile Cards View -->
        <h2 class="sr-only">Daftar Posts</h2>
        <div class="block md:hidden space-y-4">
            <?php $__empty_1 = true; $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <article class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                    <div class="flex justify-between items-start mb-2">
                        <div class="flex-1 min-w-0 pr-2">
                            <h3 class="font-semibold text-gray-900 text-base line-clamp-2"><?php echo e($post->title); ?></h3>
                            <p class="text-xs text-gray-500 mt-1 truncate"><?php echo e($post->slug); ?></p>
                        </div>
                        <span class="flex-shrink-0 px-2 py-1 rounded-full text-xs font-semibold <?php echo e($post->type === 'berita' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800'); ?>">
                            <?php echo e(ucfirst($post->type)); ?>

                        </span>
                    </div>
                    <div class="flex flex-wrap gap-2 text-xs text-gray-600 mb-3">
                        <span class="flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                            <?php echo e($post->category->name); ?>

                        </span>
                        <span class="flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <?php echo e($post->author?->name ?? 'Unknown'); ?>

                        </span>
                    </div>
                    <div class="flex items-center justify-between mb-3">
                        <?php if($post->approval_status === 'approved'): ?>
                            <span class="px-2.5 py-1 rounded text-xs font-semibold bg-green-100 text-green-800">Disetujui</span>
                        <?php elseif($post->approval_status === 'pending'): ?>
                            <span class="px-2.5 py-1 rounded text-xs font-semibold bg-yellow-100 text-yellow-800">Pending</span>
                        <?php elseif($post->approval_status === 'draft'): ?>
                            <span class="px-2.5 py-1 rounded text-xs font-semibold bg-gray-100 text-gray-800">Draft</span>
                        <?php else: ?>
                            <span class="px-2.5 py-1 rounded text-xs font-semibold bg-red-100 text-red-800">Ditolak</span>
                        <?php endif; ?>
                    </div>
                    <div class="flex flex-wrap gap-2 pt-3 border-t border-gray-100">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('approve', $post)): ?>
                            <?php if($post->approval_status === 'pending'): ?>
                                <form method="POST" action="<?php echo e(route('admin.posts.approve', $post)); ?>" class="inline-block">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="px-3 py-2 text-xs font-medium bg-green-600 text-white rounded-lg hover:bg-green-700">
                                        ✓ Setujui
                                    </button>
                                </form>
                                <button onclick="showRejectForm(<?php echo e($post->id); ?>)" class="px-3 py-2 text-xs font-medium bg-red-600 text-white rounded-lg hover:bg-red-700">
                                    ✗ Tolak
                                </button>
                            <?php endif; ?>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $post)): ?>
                            <a href="<?php echo e(route('admin.posts.edit', $post)); ?>"
                               class="flex-1 inline-flex items-center justify-center px-3 py-2 text-sm font-medium bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Edit
                            </a>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete', $post)): ?>
                            <form method="POST" action="<?php echo e(route('admin.posts.destroy', $post)); ?>" class="flex-1" onsubmit="return confirm('Yakin hapus post ini?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="w-full inline-flex items-center justify-center px-3 py-2 text-sm font-medium bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Hapus
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                </article>

                <!-- Form Reject Modal (for mobile) -->
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('approve', $post)): ?>
                    <?php if($post->approval_status === 'pending'): ?>
                        <div id="reject-form-<?php echo e($post->id); ?>" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
                            <div class="bg-white p-4 md:p-6 rounded-lg max-w-md w-full">
                                <h3 class="font-bold text-lg mb-4">Tolak Post</h3>
                                <form method="POST" action="<?php echo e(route('admin.posts.reject', $post)); ?>">
                                    <?php echo csrf_field(); ?>
                                    <div class="mb-4">
                                        <label class="block text-sm font-semibold mb-2">Alasan Penolakan:</label>
                                        <textarea name="rejection_reason" class="w-full border rounded px-3 py-2 text-sm" rows="4" required></textarea>
                                    </div>
                                    <div class="flex gap-2">
                                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 text-sm font-semibold">
                                            Tolak
                                        </button>
                                        <button type="button" onclick="hideRejectForm(<?php echo e($post->id); ?>)" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 text-sm font-semibold">
                                            Batal
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 text-center">
                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="text-gray-500 font-medium">Belum ada posts</p>
                    <p class="text-gray-500 text-sm mt-1">Buat post pertama Anda</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Desktop Table View -->
        <div class="hidden md:block bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-green-50 to-green-100 border-b border-green-200">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Judul</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Tipe</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Kategori</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Penulis</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php $__empty_1 = true; $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <p class="font-semibold text-gray-900 line-clamp-1"><?php echo e($post->title); ?></p>
                                    <p class="text-xs text-gray-500 mt-1"><?php echo e($post->slug); ?></p>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold <?php echo e($post->type === 'berita' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800'); ?>">
                                        <?php echo e(ucfirst($post->type)); ?>

                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm"><?php echo e($post->category->name); ?></td>
                                <td class="px-6 py-4 text-sm"><?php echo e($post->author?->name ?? 'Unknown'); ?></td>
                                <td class="px-6 py-4 text-sm">
                                    <?php if($post->approval_status === 'approved'): ?>
                                        <span class="px-3 py-1 rounded text-xs font-semibold bg-green-100 text-green-800">Disetujui</span>
                                    <?php elseif($post->approval_status === 'pending'): ?>
                                        <span class="px-3 py-1 rounded text-xs font-semibold bg-yellow-100 text-yellow-800">Pending</span>
                                    <?php elseif($post->approval_status === 'draft'): ?>
                                        <span class="px-3 py-1 rounded text-xs font-semibold bg-gray-100 text-gray-800">Draft</span>
                                    <?php else: ?>
                                        <span class="px-3 py-1 rounded text-xs font-semibold bg-red-100 text-red-800">Ditolak</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex gap-2 justify-center flex-wrap">
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('approve', $post)): ?>
                                            <?php if($post->approval_status === 'pending'): ?>
                                                <form method="POST" action="<?php echo e(route('admin.posts.approve', $post)); ?>" class="inline-block">
                                                    <?php echo csrf_field(); ?>
                                                    <button type="submit" class="px-3 py-1 text-xs bg-green-600 text-white rounded hover:bg-green-700">
                                                        ✓ Setujui
                                                    </button>
                                                </form>
                                                <button onclick="showRejectForm(<?php echo e($post->id); ?>)" class="px-3 py-1 text-xs bg-red-600 text-white rounded hover:bg-red-700">
                                                    ✗ Tolak
                                                </button>

                                                <div id="reject-form-<?php echo e($post->id); ?>" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
                                                    <div class="bg-white p-6 rounded-lg max-w-md w-full">
                                                        <h3 class="font-bold text-lg mb-4">Tolak Post</h3>
                                                        <form method="POST" action="<?php echo e(route('admin.posts.reject', $post)); ?>">
                                                            <?php echo csrf_field(); ?>
                                                            <div class="mb-4">
                                                                <label class="block text-sm font-semibold mb-2">Alasan Penolakan:</label>
                                                                <textarea name="rejection_reason" class="w-full border rounded px-3 py-2 text-sm" rows="4" required></textarea>
                                                            </div>
                                                            <div class="flex gap-2">
                                                                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 text-sm font-semibold">
                                                                    Tolak
                                                                </button>
                                                                <button type="button" onclick="hideRejectForm(<?php echo e($post->id); ?>)" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 text-sm font-semibold">
                                                                    Batal
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        <?php endif; ?>

                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $post)): ?>
                                            <a href="<?php echo e(route('admin.posts.edit', $post)); ?>"
                                               class="inline-flex items-center px-3 py-1 text-xs bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                                Edit
                                            </a>
                                        <?php endif; ?>

                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete', $post)): ?>
                                            <form method="POST" action="<?php echo e(route('admin.posts.destroy', $post)); ?>" class="inline-block" onsubmit="return confirm('Yakin hapus post ini?')">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="inline-flex items-center px-3 py-1 text-xs bg-red-600 text-white rounded hover:bg-red-700 transition">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                    Hapus
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <p class="text-gray-500 font-medium">Belum ada posts</p>
                                        <p class="text-gray-500 text-sm mt-1">Buat post pertama Anda</p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-4 md:mt-6 text-sm">
            <?php echo e($posts->links()); ?>

        </div>
    </div>
</div>

<script>
function showRejectForm(postId) {
    document.getElementById('reject-form-' + postId).classList.remove('hidden');
}

function hideRejectForm(postId) {
    document.getElementById('reject-form-' + postId).classList.add('hidden');
}

function showPublishForm(postId) {
    document.getElementById('publish-form-' + postId).classList.remove('hidden');
}

function hidePublishForm(postId) {
    document.getElementById('publish-form-' + postId).classList.add('hidden');
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/resources/views/admin/posts/index.blade.php ENDPATH**/ ?>