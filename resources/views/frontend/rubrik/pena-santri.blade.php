@extends('layouts.app')

@section('title', 'Pena Santri - ISKAB')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 pt-28 md:pt-32">
    <h1 class="text-4xl font-bold mb-4">Pena Santri</h1>
    <p class="text-gray-600 text-lg mb-8">Wadah bagi santri untuk mengekspresikan pemikiran dan ide-ide cemerlang</p>

    <!-- Filter -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
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
                    @foreach($categories as $author)
                        <option value="{{ $author->id }}" {{ request('author') == $author->id ? 'selected' : '' }}>{{ $author->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">Filter</button>
            </div>
        </form>
    </div>

    <!-- Posts Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
        @forelse($posts as $post)
            <article class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
                <div class="flex items-start justify-between mb-3">
                    <span class="text-sm font-semibold text-green-600">{{ $post->category->name }}</span>
                    <span class="text-sm text-gray-500">{{ $post->published_at?->format('d M Y') }}</span>
                </div>
                <h3 class="text-2xl font-bold mb-3 line-clamp-2">
                    <a href="{{ route('posts.show', $post->slug) }}" class="hover:text-green-600">{{ $post->title }}</a>
                </h3>
                <p class="text-gray-600 line-clamp-3 mb-4">{{ strip_tags($post->content) }}</p>
                <div class="border-t pt-4">
                    <div class="text-sm text-gray-500 mb-3">Penulis: <span class="font-semibold">{{ $post->author->name }}</span></div>
                    <a href="{{ route('posts.show', $post->slug) }}" class="text-green-600 hover:text-green-700 font-semibold">Baca Selengkapnya →</a>
                </div>
            </article>
        @empty
            <div class="col-span-full text-center py-12">
                <p class="text-gray-500 text-lg">Belum ada artikel pena santri ditemukan</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="flex justify-center">
        {{ $posts->links() }}
    </div>
</div>
@endsection
