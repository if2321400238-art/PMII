<?php $__env->startSection('title', 'Rayon - PMII Komisariat UNUJA'); ?>

<?php $__env->startSection('content'); ?>
<div class="">
    <h1 class="text-4xl font-bold mb-4">Daftar Rayon</h1>
    <p class="text-gray-600 text-lg mb-6">Daftar Rayon di bawah Komisariat Universitas Nurul Jadid</p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <?php $__empty_1 = true; $__currentLoopData = $rayons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rayon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="bg-white rounded-lg shadow-md p-8 border-t-4 border-blue-600 hover:shadow-lg transition">
               <div class="mb-4">
                    <h2 class="text-2xl font-bold text-blue-600"><?php echo e($rayon->name); ?></h2>
                </div>

                <div class="space-y-4 mb-6">
                    <?php if($rayon->contact): ?>
                        <div>
                            <p class="text-sm text-gray-600 font-semibold">Kontak</p>
                            <p class="text-lg text-gray-900">📞 <?php echo e($rayon->contact); ?></p>
                        </div>
                    <?php endif; ?>

                    <?php if($rayon->description): ?>
                        <div>
                            <p class="text-sm text-gray-600 font-semibold">Deskripsi</p>
                            <p class="text-gray-700"><?php echo e($rayon->description); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-span-full text-center py-12">
                <p class="text-gray-500 text-lg">Belum ada data Rayon</p>
            </div>
        <?php endif; ?>
    </div>

    <div class="mt-12 flex justify-center">
        <?php echo e($rayons->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/resources/views/frontend/tentang-kami/rayon.blade.php ENDPATH**/ ?>