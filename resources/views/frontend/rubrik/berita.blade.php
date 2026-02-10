@extends('layouts.app')

@section('title', 'Berita - PMII')

@section('content')
<div class="">
    <h1 class="text-4xl font-bold mb-8">Berita</h1>

    <!-- Posts Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
        @forelse($posts as $post)
            <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                @if($post->thumbnail)
                    <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}" class="w-full h-48 object-cover">
                @else
                    <div class="w-full h-48 bg-gray-300"></div>
                @endif
                <div class="p-6">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm bg-emerald-100 text-blue-800 px-3 py-1 rounded-full">{{ $post->category->name }}</span>
                        <span class="text-sm text-gray-500">{{ $post->published_at?->format('d M Y') }}</span>
                    </div>
                    <h3 class="text-xl font-bold mb-2 line-clamp-2">
                        <a href="{{ route('posts.show', $post->slug) }}" class="hover:text-blue-600">{{ $post->title }}</a>
                    </h3>
                    <p class="text-gray-600 line-clamp-3 mb-4">{{ strip_tags($post->content) }}</p>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">👁️ {{ $post->view_count }}</span>
                        <a href="{{ route('posts.show', $post->slug) }}" class="text-blue-600 hover:text-blue-700 font-semibold">Baca →</a>
                    </div>
                </div>
            </article>
        @empty
            <div class="col-span-full text-center py-12">
                <p class="text-gray-500 text-lg">Belum ada berita ditemukan</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="flex justify-center">
        {{ $posts->links() }}
    </div>
</div>
@endsection
