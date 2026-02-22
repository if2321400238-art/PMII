<section class="bg-white py-12 md:py-14 section-reveal cinematic-section premium-section" data-reveal data-cinematic>
    <style>
        .gallery-collage {
            display: grid;
            grid-template-columns: repeat(6, minmax(0, 1fr));
            grid-auto-rows: 90px;
            gap: 14px;
            position: relative;
        }

        @media (max-width: 1023px) {
            .gallery-collage {
                grid-template-columns: repeat(4, minmax(0, 1fr));
                grid-auto-rows: 90px;
                gap: 12px;
            }
        }

        @media (max-width: 639px) {
            .gallery-collage {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                grid-auto-rows: 110px;
                gap: 10px;
            }
        }

        .gallery-tile {
            position: relative;
            border-radius: 12px;
            overflow: hidden;
            background: #0f172a;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.16);
            transform: rotate(var(--tilt, 0deg)) translate(var(--tx, 0px), var(--ty, 0px));
            transition: transform 220ms ease, box-shadow 220ms ease;
        }

        .gallery-tile:hover {
            transform: translateY(-4px) rotate(0deg);
            box-shadow: 0 16px 34px rgba(15, 23, 42, 0.2);
        }

        .gallery-tile img,
        .gallery-tile video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .gallery-tag {
            position: absolute;
            left: 10px;
            bottom: 10px;
            display: inline-flex;
            gap: 6px;
        }

        .gallery-tag span {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            padding: 4px 8px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.9);
            color: #1e3a8a;
        }

        .tile-a { grid-column: span 2; grid-row: span 2; --tilt: -4deg; --tx: -4px; --ty: 2px; }
        .tile-b { grid-column: span 1; grid-row: span 1; --tilt: 3deg; --tx: 2px; --ty: -2px; }
        .tile-c { grid-column: span 2; grid-row: span 3; --tilt: -2deg; --tx: 3px; --ty: 4px; }
        .tile-d { grid-column: span 1; grid-row: span 2; --tilt: 5deg; --tx: -3px; --ty: 2px; }
        .tile-e { grid-column: span 2; grid-row: span 1; --tilt: -6deg; --tx: 2px; --ty: -2px; }
        .tile-f { grid-column: span 1; grid-row: span 1; --tilt: -3deg; --tx: -2px; --ty: 3px; }
        .tile-g { grid-column: span 2; grid-row: span 2; --tilt: 4deg; --tx: 4px; --ty: -2px; }
        .tile-h { grid-column: span 1; grid-row: span 2; --tilt: -5deg; --tx: 1px; --ty: 2px; }
        .tile-i { grid-column: span 2; grid-row: span 1; --tilt: 2deg; --tx: -2px; --ty: -1px; }
        .tile-j { grid-column: span 1; grid-row: span 1; --tilt: 6deg; --tx: 2px; --ty: 1px; }
        .tile-k { grid-column: span 2; grid-row: span 2; --tilt: -2deg; --tx: 0px; --ty: -2px; }
        .tile-l { grid-column: span 1; grid-row: span 1; --tilt: 3deg; --tx: -1px; --ty: 2px; }
    </style>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10">
        <div class="mb-7 md:mb-9 text-center">
            <h2 class="parallax-title premium-title text-2xl sm:text-3xl md:text-4xl font-bold text-blue-700" data-parallax-title>Galeri</h2>
        </div>

        @if($galleryHighlight->isNotEmpty())
            @php
                $layoutClasses = ['tile-a','tile-b','tile-c','tile-d','tile-e','tile-f','tile-g','tile-h','tile-i','tile-j','tile-k','tile-l'];
            @endphp
            <div class="gallery-collage" data-reveal>
                @foreach($galleryHighlight as $gallery)
                    @php
                        $galleryTitle = \Illuminate\Support\Str::limit(trim($gallery->title ?? ''), 48);
                        $layoutClass = $layoutClasses[$loop->index % count($layoutClasses)];
                    @endphp
                    <article class="gallery-tile {{ $layoutClass }} card-reveal cursor-pointer" style="--reveal-delay: {{ $loop->index * 60 }}ms;" data-reveal-card onclick="window.location.href='{{ route('gallery.show', $gallery->id) }}'">
                        @if ($gallery->type === 'video')
                            @if($gallery->file_path)
                                <video muted playsinline preload="none">
                                    <source src="{{ asset('storage/' . $gallery->file_path) }}">
                                </video>
                            @elseif($gallery->video_thumbnail_url)
                                <img src="{{ $gallery->video_thumbnail_url }}" alt="{{ $galleryTitle }}" loading="lazy" decoding="async" fetchpriority="low">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-slate-700 to-slate-900 flex items-center justify-center">
                                    <svg class="w-10 h-10 text-white/85" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M8 5v14l11-7z"/>
                                    </svg>
                                </div>
                            @endif
                        @else
                            @if ($gallery->file_path)
                                <img src="{{ route('img.optimized', ['path' => $gallery->file_path, 'w' => 720]) }}" alt="{{ $galleryTitle }}" loading="lazy" decoding="async" fetchpriority="low">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-yellow-500 to-blue-600"></div>
                            @endif
                        @endif

                        <div class="gallery-tag">
                            <span>Galeri</span>
                            @if($gallery->type === 'video')
                                <span>Video</span>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="text-center py-10 rounded-2xl border border-dashed border-slate-300 bg-white/80">
                <p class="text-gray-500 text-lg">Belum ada galeri</p>
            </div>
        @endif

        <div class="mt-8 flex justify-center">
            <a href="{{ route('gallery.index') }}" class="inline-flex items-center gap-2 rounded-full border border-blue-200 bg-white px-5 py-2.5 text-sm font-semibold text-blue-700 shadow-sm hover:bg-blue-50 transition">
                <span>Lihat Semua Galeri</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>
    </div>
</section>
