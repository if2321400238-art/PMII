<section class="bg-slate-50 py-12 md:py-16 md:pt-14 section-reveal cinematic-section premium-section" id="tentang-pmii" data-reveal data-cinematic>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="parallax-title premium-title text-2xl sm:text-3xl md:text-4xl font-bold text-center text-blue-700 mb-7 md:mb-10" data-parallax-title>
            <a href="<?php echo e(route('about.profil')); ?>">Tentang PMII UNUJA</a>
        </h2>
        <div class="max-w-5xl mx-auto rounded-3xl border border-blue-100/90 bg-gradient-to-b from-white to-blue-50/40 px-4 py-5 sm:p-7 shadow-xl shadow-slate-900/10 premium-elevated">
            <?php if($profil): ?>
                <p class="text-gray-700/95 leading-8 text-justify text-[15px] sm:text-base mb-4">
                    <?php echo e($profil->sejarah ?? 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor.'); ?>

                </p>
            <?php else: ?>
                <p class="text-gray-700/95 leading-8 text-justify text-[15px] sm:text-base mb-4">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi.
                </p>
                <p class="text-gray-700/95 leading-8 text-justify text-[15px] sm:text-base mb-4">
                    Ut nisi nec eros. Suspendisse pulvinar tellus ac nisl. Pellentesque vitae lacus. Maecenas ullamcorper, diam vitae commodo placerat, sapien ipsum dictum eros, vel consequat massa orci vel felis.
                </p>
                <p class="text-gray-700/95 leading-8 text-justify text-[15px] sm:text-base">
                    Nulla at leo nec metus aliquam semper. Sed adipiscing ornare risus. Morbi est est, blandit sit amet, sagittis vel, euismod vel, velit.
                </p>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php /**PATH /var/www/resources/views/components/home/about-section.blade.php ENDPATH**/ ?>