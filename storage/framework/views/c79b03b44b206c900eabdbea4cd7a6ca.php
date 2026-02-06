<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
        <meta name="robots" content="index, follow">
        <link rel="canonical" href="<?php echo e(url()->current()); ?>">

        <title><?php echo $__env->yieldContent('title', 'ISKAB - Ikatan Santri Kalimantan Barat'); ?></title>
        <meta name="description" content="<?php echo $__env->yieldContent('description', 'Ikatan Santri Kalimantan Barat (ISKAB) - Organisasi santri se-Kalimantan Barat untuk mempererat silaturahmi dan mengembangkan potensi santri.'); ?>">
        <meta name="keywords" content="<?php echo $__env->yieldContent('keywords', 'ISKAB, Ikatan Santri, Kalimantan Barat, Santri, Pesantren, Organisasi Santri'); ?>">
        <meta name="author" content="ISKAB">

        <meta property="og:type" content="website">
        <meta property="og:url" content="<?php echo e(url()->current()); ?>">
        <meta property="og:title" content="<?php echo $__env->yieldContent('title', 'ISKAB - Ikatan Santri Kalimantan Barat'); ?>">
        <meta property="og:description" content="<?php echo $__env->yieldContent('description', 'Organisasi santri se-Kalimantan Barat'); ?>">
        <meta property="og:image" content="<?php echo $__env->yieldContent('image', asset('images/iskab-og.jpg')); ?>">
        <meta property="og:locale" content="id_ID">

        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="<?php echo $__env->yieldContent('title', 'ISKAB - Ikatan Santri Kalimantan Barat'); ?>">
        <meta name="twitter:description" content="<?php echo $__env->yieldContent('description', 'Organisasi santri se-Kalimantan Barat'); ?>">
        <meta name="twitter:image" content="<?php echo $__env->yieldContent('image', asset('images/iskab-og.jpg')); ?>">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
        <?php echo $__env->yieldPushContent('head'); ?>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 flex flex-col relative">
            <?php echo $__env->make('layouts.navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <!-- Page Content -->
            <main class="flex-grow" role="main">
                <?php echo $__env->yieldContent('content'); ?>
            </main>

            <!-- Footer -->
            <?php echo $__env->make('layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
    </body>
</html>
<?php /**PATH /var/www/resources/views/layouts/app.blade.php ENDPATH**/ ?>