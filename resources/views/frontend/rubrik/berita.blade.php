@extends('layouts.app')

@section('title', 'Berita - PMII')

@section('content')
<style>
    .news-layout {
        display: block;
    }

    .news-main {
        min-width: 0;
    }

    .news-sidebar {
        margin-top: 1.5rem;
    }

    @media (min-width: 1024px) {
        .news-layout {
            display: flex;
            align-items: flex-start;
            gap: 1.5rem;
        }

        .news-main {
            flex: 1 1 auto;
        }

        .news-sidebar {
            flex: 0 0 340px;
            width: 340px;
            margin-top: 0;
        }
    }
</style>

<section class="max-w-7xl mx-auto">
    <div class="news-layout">
        <div class="news-main">
            <header class="mb-6 md:mb-8">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900">Berita</h1>
                <p class="mt-2 text-gray-600">Kumpulan berita terbaru PMII UNUJA</p>
            </header>

            <div class="mb-6 overflow-x-auto">
                <div class="flex items-center gap-2 min-w-max">
                    <a href="{{ route('posts.berita') }}"
                       class="px-4 py-2 rounded-full text-sm font-semibold transition {{ request('category') ? 'bg-gray-100 text-gray-700 hover:bg-gray-200' : 'bg-[#1e3a5f] text-white' }}">
                        Semua
                    </a>
                    @foreach($categories as $category)
                        <a href="{{ route('posts.berita', array_merge(request()->except('page'), ['category' => $category->id])) }}"
                           class="px-4 py-2 rounded-full text-sm font-semibold transition {{ (string)request('category') === (string)$category->id ? 'bg-[#1e3a5f] text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="mb-6 rounded-xl border border-dashed border-blue-300 bg-blue-50 p-4">
                <p class="text-xs font-bold uppercase tracking-wide text-blue-800">Ruang Iklan</p>
                @if($leftAd)
                    @if($leftAd->target_url)
                        <a href="{{ $leftAd->target_url }}" target="_blank" rel="noopener noreferrer nofollow" class="mt-3 block">
                            <div class="w-full overflow-hidden rounded-lg border border-blue-200" style="aspect-ratio: 10 / 3;">
                                <img src="{{ asset('storage/' . $leftAd->image_path) }}" alt="{{ $leftAd->title }}" class="h-full w-full object-cover">
                            </div>
                        </a>
                    @else
                        <div class="mt-3 w-full overflow-hidden rounded-lg border border-blue-200" style="aspect-ratio: 10 / 3;">
                            <img src="{{ asset('storage/' . $leftAd->image_path) }}" alt="{{ $leftAd->title }}" class="h-full w-full object-cover">
                        </div>
                    @endif
                @else
                    <p class="mt-2 text-sm text-blue-900">Promosi kegiatan rayon, agenda kampus, atau sponsor.</p>
                    <div class="mt-3 rounded-lg bg-white/70 border border-blue-200 flex items-center justify-center text-sm text-blue-700 font-medium" style="aspect-ratio: 10 / 3;">
                        Banner Iklan
                    </div>
                @endif
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 divide-y">
                @forelse($posts as $post)
                    <article class="p-4 md:p-5 hover:bg-gray-50 transition">
                        <a href="{{ route('posts.show', $post->slug) }}" class="flex items-start gap-3 md:gap-4">
                            <div class="shrink-0 w-28 h-20 md:w-40 md:h-24 rounded-lg overflow-hidden bg-gray-200">
                                @if($post->thumbnail)
                                    <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                                @endif
                            </div>

                            <div class="min-w-0 flex-1">
                                <div class="flex items-center gap-2 mb-2 text-xs text-gray-500">
                                    <span class="inline-flex px-2 py-0.5 rounded-full bg-blue-100 text-blue-800 font-medium">{{ $post->category->name }}</span>
                                    <span>{{ $post->published_at?->format('d M Y, H:i') }}</span>
                                </div>

                                <h2 class="text-base md:text-xl font-semibold text-gray-900 leading-snug line-clamp-2">
                                    {{ $post->title }}
                                </h2>

                                <p class="mt-1 text-sm text-gray-600 line-clamp-2">{{ strip_tags($post->content) }}</p>

                                <div class="mt-2 flex items-center gap-3 text-xs text-gray-500">
                                    <span>Oleh {{ $post->author?->name ?? 'Unknown' }}</span>
                                    <span>{{ $post->view_count }} views</span>
                                </div>
                            </div>
                        </a>
                    </article>
                @empty
                    <div class="p-10 text-center text-gray-500">
                        Belum ada berita ditemukan
                    </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $posts->links() }}
            </div>
        </div>

        <aside class="news-sidebar">
            <div class="lg:sticky lg:top-28 rounded-xl border border-gray-200 bg-white shadow-sm p-4 md:p-5">
                <h2 class="text-lg font-bold text-gray-900">Artikel Populer</h2>
                <p class="mt-1 text-sm text-gray-500">Paling banyak dibaca minggu ini</p>

                <div class="mt-4 space-y-4">
                    @forelse($popularPosts as $popular)
                        <article>
                            <a href="{{ route('posts.show', $popular->slug) }}" class="group flex gap-3">
                                <div class="w-20 h-16 rounded-md overflow-hidden bg-gray-200 shrink-0">
                                    @if($popular->thumbnail)
                                        <img src="{{ asset('storage/' . $popular->thumbnail) }}" alt="{{ $popular->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <h3 class="text-sm font-semibold leading-snug line-clamp-2 text-gray-900 group-hover:text-blue-700 transition">
                                        {{ $popular->title }}
                                    </h3>
                                    <div class="mt-1 text-xs text-gray-500">
                                        {{ $popular->author?->name ?? 'Unknown' }} &bull; {{ $popular->view_count }} views
                                    </div>
                                </div>
                            </a>
                        </article>
                    @empty
                        <p class="text-sm text-gray-500">Belum ada artikel populer.</p>
                    @endforelse
                </div>
            </div>
        </aside>
    </div>
</section>
@endsection
