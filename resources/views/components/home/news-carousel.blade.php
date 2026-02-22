<section class="news-pinboard-section py-14 md:py-18 overflow-hidden section-reveal cinematic-section premium-section" data-reveal data-cinematic>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10">
        <h2 class="parallax-title premium-title text-2xl sm:text-3xl md:text-4xl font-bold text-center text-[#1d4ed8] mb-7 md:mb-9" data-parallax-title>Papan Berita</h2>

        @php
            $pinnedPosts = $beritaTerkini->take(4);
            $pinClasses = ['pin-a', 'pin-b', 'pin-c', 'pin-d'];
        @endphp

        @if ($pinnedPosts->isNotEmpty())
            <div class="news-pinboard-stage">
                <span class="news-pinboard-rope rope-a" aria-hidden="true"></span>
                <span class="news-pinboard-rope rope-b" aria-hidden="true"></span>
                <span class="news-pinboard-rope rope-c" aria-hidden="true"></span>

                @foreach ($pinnedPosts as $post)
                    @php
                        $pinClass = $pinClasses[$loop->index] ?? 'pin-d';
                    @endphp

                    <article class="news-pinboard-card {{ $pinClass }}" onclick="window.location.href='{{ route('posts.show', $post->slug) }}'">
                        <span class="news-card-pin" aria-hidden="true"></span>

                        <div class="news-card-sheet">
                            <div class="news-card-media">
                                @if ($post->thumbnail)
                                    <img src="{{ route('img.optimized', ['path' => $post->thumbnail, 'w' => 640]) }}" alt="{{ $post->title }}" class="w-full h-full object-cover" loading="lazy" decoding="async" fetchpriority="low">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-yellow-500 to-blue-600"></div>
                                @endif
                            </div>

                            <div class="news-card-content px-3 md:px-4 pt-2 md:pt-3 pb-3 md:pb-4">
                                <p class="text-[11px] md:text-xs tracking-wide font-semibold text-slate-500 mb-1">0{{ $loop->iteration }}</p>
                                <h3 class="text-[15px] md:text-[19px] font-extrabold leading-snug text-slate-900 line-clamp-2 break-words">
                                    <a href="{{ route('posts.show', $post->slug) }}" class="hover:text-blue-700">{{ $post->title }}</a>
                                </h3>
                                <p class="text-[11px] md:text-xs text-slate-500 mt-1">
                                    <span>Oleh {{ $post->author->name ?? 'Admin' }}</span>
                                    <span class="mx-1">•</span>
                                    <span>{{ ($post->published_at ?? $post->created_at)?->translatedFormat('d M Y') }}</span>
                                </p>
                                <p class="text-[12px] md:text-sm text-slate-600 mt-1 line-clamp-2">{{ strip_tags($post->content) }}</p>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="w-full text-center py-8">
                <p class="text-slate-600 text-lg">Belum ada berita terkini</p>
            </div>
        @endif
    </div>
</section>
