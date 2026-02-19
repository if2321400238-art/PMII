@extends('layouts.app')

@section('title', $post->title . ' - PMII')

@section('content')
<style>
    .article-content {
        font-size: 1.05rem;
        line-height: 1.95;
        color: #1f2937;
        word-break: break-word;
    }

    .article-content p {
        margin: 0 0 1.15rem 0;
    }

    .article-content h1,
    .article-content h2,
    .article-content h3,
    .article-content h4 {
        color: #0f172a;
        line-height: 1.3;
        margin-top: 1.5rem;
        margin-bottom: 0.8rem;
    }

    .article-content h1 { font-size: 1.75rem; }
    .article-content h2 { font-size: 1.45rem; }
    .article-content h3 { font-size: 1.25rem; }
    .article-content h4 { font-size: 1.1rem; }

    .article-content a {
        color: #1d4ed8;
        text-decoration: underline;
        text-decoration-thickness: 1.5px;
        text-underline-offset: 2px;
    }

    .article-content ul,
    .article-content ol {
        padding-left: 1.25rem;
        margin-bottom: 1rem;
    }

    .article-content img {
        border-radius: 0.75rem;
        margin: 1rem 0;
        width: 100%;
        height: auto;
    }

    .article-content blockquote {
        border-left: 3px solid #1d4ed8;
        padding-left: 0.9rem;
        color: #374151;
        margin: 1rem 0;
        background: #f8fafc;
        padding-top: 0.75rem;
        padding-bottom: 0.75rem;
        border-radius: 0 0.5rem 0.5rem 0;
    }

    @media (min-width: 768px) {
        .article-content {
            font-size: 1.06rem;
            line-height: 1.95;
        }
    }
</style>

<article class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-8 pt-4 md:pt-8">
    <!-- Breadcrumb -->
    <div class="mb-5 text-sm">
        <a href="{{ route('home') }}" class="text-blue-600 hover:text-blue-700">Beranda</a>
        <span class="text-gray-500 mx-2">/</span>
        @if($post->type === 'berita')
            <a href="{{ route('posts.berita') }}" class="text-blue-600 hover:text-blue-700">Berita</a>
        @else

        @endif
        <span class="text-gray-500 mx-2">/</span>
        <span class="text-gray-700">{{ $post->title }}</span>
    </div>

    <!-- Featured Image -->
    @if($post->thumbnail)
        <div class="mb-6 md:mb-8">
            <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}" class="w-full rounded-xl shadow-md">
            @if($post->thumbnail_caption)
                <p class="mt-2 text-sm text-gray-500 italic">{{ $post->thumbnail_caption }}</p>
            @endif
        </div>
    @endif

    <!-- Header -->
    <header class="mb-6 md:mb-8 pb-6 md:pb-8 border-b">
        <div class="mb-3">
            <span class="inline-block bg-emerald-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">{{ $post->category->name }}</span>
        </div>
        <h1 class="text-2xl md:text-5xl font-bold mb-4 leading-tight">{{ $post->title }}</h1>
        <div class="flex flex-wrap items-center gap-2 text-xs md:text-sm text-gray-600">
            <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1">
                Oleh <strong class="ml-1">{{ $post->author?->name ?? 'Unknown' }}</strong>
            </span>
            <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1">
                {{ $post->published_at?->format('d F Y') }}
            </span>
            <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1">
                {{ $post->view_count }} views
            </span>
        </div>
    </header>

    <!-- Content -->
    <div class="article-content max-w-none mb-10 md:mb-12">
        {!! $post->content !!}
    </div>

    <!-- Related Posts -->
    @if($relatedPosts->count() > 0)
        <section class="mt-10 md:mt-16 pt-8 md:pt-12 border-t">
            <h2 class="text-2xl md:text-3xl font-bold mb-5 md:mb-8">Artikel Terkait</h2>
            <div class="space-y-3 md:space-y-0 md:grid md:grid-cols-3 md:gap-8">
                @foreach($relatedPosts as $related)
                    <article class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition">
                        <div class="flex md:block">
                            @if($related->thumbnail)
                                <img src="{{ asset('storage/' . $related->thumbnail) }}" alt="{{ $related->title }}" class="w-28 h-24 md:w-full md:h-40 object-cover flex-shrink-0">
                            @else
                                <div class="w-28 h-24 md:w-full md:h-40 bg-gray-300 flex-shrink-0"></div>
                            @endif
                            <div class="p-3 md:p-4 min-w-0">
                                <h3 class="text-sm md:text-lg font-bold mb-1.5 md:mb-2 line-clamp-2">
                                    <a href="{{ route('posts.show', $related->slug) }}" class="hover:text-blue-600">{{ $related->title }}</a>
                                </h3>
                                <div class="text-[11px] md:text-xs text-gray-500 mb-2 md:mb-3">
                                    {{ $related->author?->name ?? 'Unknown' }} • {{ $related->published_at?->format('d M Y') }}
                                </div>
                                <p class="hidden md:block text-sm text-gray-600 line-clamp-2 mb-3">{{ strip_tags($related->content) }}</p>
                                <a href="{{ route('posts.show', $related->slug) }}" class="text-sm text-blue-600 hover:text-blue-700 font-semibold">Baca Selengkapnya</a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    @endif
</article>
@endsection
