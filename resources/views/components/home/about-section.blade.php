<section class="bg-white py-16 pt-8 md:pt-12" id="tentang-pmii">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl md:text-4xl font-bold text-center text-blue-700 mb-8">
            <a href="{{ route('about.profil') }}">Tentang PMII UNUJA</a>
        </h2>
        <div class="max-w-5xl mx-auto">
            @if ($profil)
                <p class="text-gray-700 leading-relaxed text-justify mb-4">
                    {{ $profil->sejarah ?? 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor.' }}
                </p>
            @else
                <p class="text-gray-700 leading-relaxed text-justify mb-4">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi.
                </p>
                <p class="text-gray-700 leading-relaxed text-justify mb-4">
                    Ut nisi nec eros. Suspendisse pulvinar tellus ac nisl. Pellentesque vitae lacus. Maecenas ullamcorper, diam vitae commodo placerat, sapien ipsum dictum eros, vel consequat massa orci vel felis.
                </p>
                <p class="text-gray-700 leading-relaxed text-justify">
                    Nulla at leo nec metus aliquam semper. Sed adipiscing ornare risus. Morbi est est, blandit sit amet, sagittis vel, euismod vel, velit.
                </p>
            @endif
        </div>
    </div>
</section>
