@extends('layouts.app')

@section('title', $post->title . ' - ISKAB')

@section('content')
<article class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 pt-28 md:pt-32">
    <!-- Breadcrumb -->
    <div class="mb-8">
        <a href="{{ route('home') }}" class="text-green-600 hover:text-green-700">Beranda</a>
        <span class="text-gray-500 mx-2">/</span>
        @if($post->type === 'berita')
            <a href="{{ route('posts.berita') }}" class="text-green-600 hover:text-green-700">Berita</a>
        @else
            <a href="{{ route('posts.pena-santri') }}" class="text-green-600 hover:text-green-700">Pena Santri</a>
        @endif
        <span class="text-gray-500 mx-2">/</span>
        <span class="text-gray-700">{{ $post->title }}</span>
    </div>

    <!-- Header -->
    <header class="mb-8 pb-8 border-b">
        <div class="mb-4">
            <span class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">{{ $post->category->name }}</span>
        </div>
        <h1 class="text-4xl md:text-5xl font-bold mb-4">{{ $post->title }}</h1>
        <div class="flex flex-wrap items-center gap-4 text-gray-600">
            <span>Oleh <strong>{{ $post->author->name }}</strong></span>
            <span>{{ $post->published_at?->format('d F Y') }}</span>
            <span>👁️ {{ $post->view_count }} views</span>
        </div>
    </header>

    <!-- Featured Image -->
    @if($post->thumbnail)
        <div class="mb-8">
            <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}" class="w-full rounded-lg shadow-lg">
        </div>
    @endif

    <!-- Content -->
    <div class="prose prose-lg max-w-none mb-12">
        {!! $post->content !!}
    </div>

    <!-- Related Posts -->
    @if($relatedPosts->count() > 0)
        <section class="mt-16 pt-12 border-t">
            <h2 class="text-3xl font-bold mb-8">Artikel Terkait</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($relatedPosts as $related)
                    <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                        @if($related->thumbnail)
                            <img src="{{ asset('storage/' . $related->thumbnail) }}" alt="{{ $related->title }}" class="w-full h-40 object-cover">
                        @else
                            <div class="w-full h-40 bg-gray-300"></div>
                        @endif
                        <div class="p-4">
                            <h3 class="text-lg font-bold mb-2 line-clamp-2">
                                <a href="{{ route('posts.show', $related->slug) }}" class="hover:text-green-600">{{ $related->title }}</a>
                            </h3>
                            <p class="text-sm text-gray-600 line-clamp-2 mb-3">{{ strip_tags($related->content) }}</p>
                            <a href="{{ route('posts.show', $related->slug) }}" class="text-green-600 hover:text-green-700 font-semibold">Baca →</a>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    @endif
</article>
@endsection
