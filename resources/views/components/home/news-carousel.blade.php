<section class="bg-[#1e3a5f] py-12 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl md:text-4xl font-bold text-center text-white mb-8">Berita Terkini</h2>

        <div class="relative">
            <button id="prevBerita" class="absolute left-0 top-1/2 -translate-y-1/2 z-20 bg-white hover:bg-gray-50 text-blue-700 rounded-full p-2 md:p-3 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-110">
                <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>

            <button id="nextBerita" class="absolute right-0 top-1/2 -translate-y-1/2 z-20 bg-white hover:bg-gray-50 text-blue-700 rounded-full p-2 md:p-3 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-110">
                <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>

            <div class="relative overflow-x-auto overflow-y-hidden scroll-smooth scrollbar-hide mx-8">
                <div id="beritaCarousel">
                    <div id="beritaContainer" class="flex gap-4 lg:gap-6 py-2">
                        @forelse($beritaTerkini as $post)
                            <article class="flex-none w-full lg:w-[calc(33.333%-1rem)] bg-white rounded-2xl overflow-hidden transition transform hover:-translate-y-1 relative h-64 cursor-pointer" onclick="window.location.href='{{ route('posts.show', $post->slug) }}'">
                                @if ($post->thumbnail)
                                    <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-yellow-500 to-blue-600"></div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-blue-900 via-transparent to-transparent"></div>
                                <div class="absolute bottom-0 left-0 right-0 p-4 text-white">
                                    <div class="inline-block bg-gradient-to-l from-blue-500 to-blue-700 text-white text-xs font-semibold px-2 py-1 rounded-full mb-2">Berita PMII</div>
                                    <h3 class="text-sm md:text-base font-bold line-clamp-2">
                                        <a href="{{ route('posts.show', $post->slug) }}" class="hover:text-yellow-400">{{ $post->title }}</a>
                                    </h3>
                                    <p class="text-gray-200 text-xs line-clamp-1">{{ strip_tags($post->content) }}</p>
                                </div>
                            </article>
                        @empty
                            <div class="w-full text-center py-8">
                                <p class="text-white text-lg">Belum ada berita terkini</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <div id="beritaDots" class="flex justify-center gap-2 mt-6"></div>
    </div>
</section>
