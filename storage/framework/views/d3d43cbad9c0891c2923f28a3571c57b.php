<?php $__env->startSection('title', 'Profil Organisasi - PMII Komisariat UNUJA'); ?>

<?php $__env->startSection('content'); ?>
    <div class="">
        <?php if($profil): ?>
            <!-- Logo & Nama -->
            <div class="text-center mb-12">
                <div>
                    <img src="<?php echo e(asset('images/logo-pmii.png')); ?>" alt="Logo PMII"
                        style="width: 80px; height: 80px; border-radius: 9999px; object-fit: cover; border: 4px solid #facc15; box-shadow: 0 0 30px rgba(234, 179, 8, 0.6), inset 0 0 20px rgba(234, 179, 8, 0.2), 0 25px 50px -12px rgba(0, 0, 0, 0.25);">
                </div>
                <h1 class="text-4xl font-bold"><?php echo e($profil->nama_organisasi); ?></h1>
            </div>

            <!-- Sejarah -->
            <section class="mb-12">
                <h2 class="text-3xl font-bold mb-4 text-blue-600">Sejarah</h2>
                <div class="bg-white rounded-lg shadow-md p-8">
                    <?php echo nl2br($profil->sejarah); ?>

                </div>
            </section>

            <!-- Visi -->
            <section class="mb-12">
                <h2 class="text-3xl font-bold mb-4 text-blue-600">Visi</h2>
                <div class="bg-emerald-50 rounded-lg shadow-md p-8 border-l-4 border-blue-600">
                    <?php echo nl2br($profil->visi); ?>

                </div>
            </section>

            <!-- Misi -->
            <section class="mb-12">
                <h2 class="text-3xl font-bold mb-4 text-blue-600">Misi</h2>
                <div class="bg-blue-50 rounded-lg shadow-md p-8 border-l-4 border-blue-600">
                    <?php if(is_array($profil->misi)): ?>
                        <ul class="space-y-3">
                            <?php $__currentLoopData = $profil->misi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="flex items-start">
                                    <span class="text-blue-600 font-bold mr-4">✓</span>
                                    <span><?php echo e($m); ?></span>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    <?php else: ?>
                        <?php echo nl2br($profil->misi); ?>

                    <?php endif; ?>
                </div>
            </section>

            <!-- Struktur Organisasi -->
            <?php if($profil->struktur_organisasi): ?>
                <section class="mb-12">
                    <h2 class="text-3xl font-bold mb-4 text-blue-600">Struktur Organisasi</h2>
                    <div class="bg-white rounded-lg shadow-md p-8">
                        <?php echo $profil->struktur_organisasi; ?>

                    </div>
                </section>
            <?php endif; ?>
        <?php else: ?>
            <div class="text-center py-12">
                <p class="text-gray-500 text-lg">Data profil organisasi belum tersedia</p>
            </div>
        <?php endif; ?>

        <!-- CTA -->
        <div class="mt-16 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg shadow-lg p-8 text-center">
            <h3 class="text-2xl font-bold mb-4">Ingin Bergabung?</h3>
            <p class="text-emerald-100 mb-6">Hubungi Rayon terdekat untuk informasi lebih lanjut</p>
            <a href="<?php echo e(route('about.rayon')); ?>"
                class="inline-block px-6 py-3 bg-white text-blue-600 rounded-lg font-semibold hover:bg-gray-100">
                Lihat Kontak Rayon
            </a>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/resources/views/frontend/tentang-kami/profil.blade.php ENDPATH**/ ?>