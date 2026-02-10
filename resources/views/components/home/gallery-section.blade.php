<section class="bg-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-20">
        <h2 class="text-3xl md:text-4xl font-bold text-center text-blue-700 mb-8">Galeri</h2>

        {{-- Mobile: Carousel --}}
        <div class="lg:hidden relative">
            <button id="prevGallery" class="absolute left-0 top-1/2 -translate-y-1/2 z-20 bg-blue-700 hover:bg-blue-800 text-white rounded-full p-2 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-110">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>

            <button id="nextGallery" class="absolute right-0 top-1/2 -translate-y-1/2 z-20 bg-blue-700 hover:bg-blue-800 text-white rounded-full p-2 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-110">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>

            <div id="galleryCarousel" class="overflow-x-auto overflow-y-hidden scroll-smooth scrollbar-hide mx-8">
                <div class="flex gap-4 py-2">
                    @forelse($galleryHighlight as $gallery)
                        <article class="flex-none w-full bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition transform hover:-translate-y-1 relative h-72 cursor-pointer" onclick="window.location.href='{{ route('gallery.show', $gallery->id) }}'">
                            @if ($gallery->file_path)
                                <img src="{{ asset('storage/' . $gallery->file_path) }}" alt="{{ $gallery->title }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-yellow-500 to-blue-600"></div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-blue-900 via-transparent to-transparent"></div>
                            <div class="absolute bottom-0 left-0 right-0 p-5 text-white">
                                <div class="inline-block bg-gradient-to-r from-blue-500 to-blue-700 text-white text-xs font-semibold px-3 py-1 rounded-full mb-3">Galeri</div>
                                <h3 class="text-lg font-bold mb-2 line-clamp-2">
                                    <a href="{{ route('gallery.show', $gallery->id) }}" class="hover:text-yellow-400">{{ $gallery->title }}</a>
                                </h3>
                                <p class="text-gray-200 text-sm line-clamp-2">{{ strip_tags($gallery->description) }}</p>
                            </div>
                        </article>
                    @empty
                        <div class="w-full text-center py-8">
                            <p class="text-gray-500 text-lg">Belum ada galeri</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <div id="galleryDots" class="flex justify-center gap-2 mt-6"></div>
        </div>

        {{-- Desktop: Grid Layout --}}
        <div class="hidden lg:grid grid-cols-3 gap-6">
            @forelse($galleryHighlight as $index => $gallery)
                @if ($index === 0)
                    <article class="col-span-1 row-span-2 bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition transform hover:-translate-y-1 relative min-h-[320px] cursor-pointer" onclick="window.location.href='{{ route('gallery.show', $gallery->id) }}'">
                        @if ($gallery->file_path)
                            <img src="{{ asset('storage/' . $gallery->file_path) }}" alt="{{ $gallery->title }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-yellow-500 to-blue-600"></div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-blue-900 via-transparent to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                            <div class="inline-block bg-gradient-to-r from-blue-500 to-blue-700 text-white text-xs font-semibold px-3 py-1 rounded-full mb-3">Galeri</div>
                            <h3 class="text-2xl font-bold mb-2">
                                <a href="{{ route('gallery.show', $gallery->id) }}" class="hover:text-yellow-400">{{ $gallery->title }}</a>
                            </h3>
                            <p class="text-gray-200 text-sm line-clamp-2">{{ strip_tags($gallery->description) }}</p>
                        </div>
                    </article>
                @else
                    <article class="bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition transform hover:-translate-y-1 relative h-48 cursor-pointer" onclick="window.location.href='{{ route('gallery.show', $gallery->id) }}'">
                        @if ($gallery->file_path)
                            <img src="{{ asset('storage/' . $gallery->file_path) }}" alt="{{ $gallery->title }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-yellow-500 to-blue-600"></div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-blue-900 via-transparent to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-4 text-white">
                            <div class="inline-block bg-gradient-to-l from-blue-500 to-blue-700 text-white text-xs font-semibold px-2 py-1 rounded-full mb-2">Galeri</div>
                            <h3 class="text-base font-bold line-clamp-2">
                                <a href="{{ route('gallery.show', $gallery->id) }}" class="hover:text-yellow-400">{{ $gallery->title }}</a>
                            </h3>
                            <p class="text-gray-200 text-xs line-clamp-1">{{ strip_tags($gallery->description) }}</p>
                        </div>
                    </article>
                @endif
            @empty
                <div class="col-span-3 text-center">
                    <p class="text-gray-500 text-lg">Belum ada galeri</p>
                </div>
            @endforelse

            @if ($galleryHighlight->count() < 5)
                @for ($i = $galleryHighlight->count(); $i < 5; $i++)
                    @if ($i === 0)
                        <article class="col-span-1 row-span-2 bg-white rounded-2xl shadow-xl overflow-hidden relative min-h-[320px]">
                            <div class="w-full h-full bg-gradient-to-br from-yellow-400 to-yellow-500"></div>
                            <div class="absolute inset-0 bg-gradient-to-t from-blue-900 via-transparent to-transparent"></div>
                            <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                                <div class="inline-block bg-gradient-to-l from-blue-500 to-blue-700 text-white text-xs font-semibold px-3 py-1 rounded-full mb-3">Galeri</div>
                                <h3 class="text-2xl font-bold mb-2">Lorem ipsum dolor consectetur</h3>
                                <p class="text-gray-200 text-sm line-clamp-2">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                            </div>
                        </article>
                    @else
                        <article class="bg-white rounded-2xl shadow-xl overflow-hidden relative h-48">
                            <div class="w-full h-full bg-gradient-to-br from-gray-300 to-gray-400"></div>
                            <div class="absolute inset-0 bg-gradient-to-t from-blue-900 via-transparent to-transparent"></div>
                            <div class="absolute bottom-0 left-0 right-0 p-4 text-white">
                                <div class="inline-block bg-blue-500 text-white text-xs font-semibold px-2 py-1 rounded-full mb-2">Galeri</div>
                                <h3 class="text-base font-bold line-clamp-2">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h3>
                                <p class="text-gray-200 text-xs line-clamp-1">Lorem ipsum dolor sit amet.</p>
                            </div>
                        </article>
                    @endif
                @endfor
            @endif
        </div>
    </div>
</section>
