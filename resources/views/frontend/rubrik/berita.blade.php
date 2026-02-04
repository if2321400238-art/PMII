@extends('layouts.app')

@section('title', 'Berita - ISKAB')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 pt-28 md:pt-32">
    <h1 class="text-4xl font-bold mb-8">Berita</h1>

    <!-- Filter -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-semibold mb-2">Kategori</label>
                <select name="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold mb-2">Penulis</label>
                <select name="author" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    <option value="">Semua Penulis</option>
                    @foreach($authors as $author)
                        <option value="{{ $author->id }}" {{ request('author') == $author->id ? 'selected' : '' }}>{{ $author->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold mb-2">Urutan</label>
                <select name="sort" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                    <option value="populer" {{ request('sort') == 'populer' ? 'selected' : '' }}>Terpopuler</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">Filter</button>
            </div>
        </form>
    </div>

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
                        <span class="text-sm bg-green-100 text-green-800 px-3 py-1 rounded-full">{{ $post->category->name }}</span>
                        <span class="text-sm text-gray-500">{{ $post->published_at?->format('d M Y') }}</span>
                    </div>
                    <h3 class="text-xl font-bold mb-2 line-clamp-2">
                        <a href="{{ route('posts.show', $post->slug) }}" class="hover:text-green-600">{{ $post->title }}</a>
                    </h3>
                    <p class="text-gray-600 line-clamp-3 mb-4">{{ strip_tags($post->content) }}</p>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">👁️ {{ $post->view_count }}</span>
                        <a href="{{ route('posts.show', $post->slug) }}" class="text-green-600 hover:text-green-700 font-semibold">Baca →</a>
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
