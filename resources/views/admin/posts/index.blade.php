@extends('layouts.admin')

@section('title', 'Posts - Admin ISKAB')
@section('page_title', 'Kelola Posts')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h2 class="text-2xl font-bold">Posts (Berita & Pena Santri)</h2>
    <a href="{{ route('admin.posts.create') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
        ➕ Buat Post Baru
    </a>
</div>

<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-100 border-b">
            <tr>
                <th class="px-6 py-3 text-left text-sm font-semibold">Judul</th>
                <th class="px-6 py-3 text-left text-sm font-semibold">Tipe</th>
                <th class="px-6 py-3 text-left text-sm font-semibold">Kategori</th>
                <th class="px-6 py-3 text-left text-sm font-semibold">Penulis</th>
                <th class="px-6 py-3 text-left text-sm font-semibold">Status</th>
                <th class="px-6 py-3 text-left text-sm font-semibold">Views</th>
                <th class="px-6 py-3 text-center text-sm font-semibold">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($posts as $post)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <p class="font-semibold text-gray-900 line-clamp-1">{{ $post->title }}</p>
                        <p class="text-sm text-gray-600">{{ $post->slug }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $post->type === 'berita' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                            {{ ucfirst($post->type) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm">{{ $post->category->name }}</td>
                    <td class="px-6 py-4 text-sm">{{ $post->author->name }}</td>
                    <td class="px-6 py-4">
                        @if($post->published_at)
                            <div>
                                <span class="px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                                    Published
                                </span>
                                <p class="text-xs text-gray-500 mt-1">{{ $post->published_at->format('Y-m-d H:i') }}</p>
                            </div>
                        @else
                            <span class="px-3 py-1 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800">
                                Draft
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm">👁️ {{ $post->view_count }}</td>
                    <td class="px-6 py-4 text-center">
                        <a href="{{ route('admin.posts.edit', $post) }}" class="inline-block px-3 py-1 text-sm bg-blue-600 text-white rounded hover:bg-blue-700 mr-2">
                            Edit
                        </a>
                        <form method="POST" action="{{ route('admin.posts.destroy', $post) }}" class="inline-block" onsubmit="return confirm('Yakin hapus?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1 text-sm bg-red-600 text-white rounded hover:bg-red-700">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                        Belum ada posts
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6 flex justify-center">
    {{ $posts->links() }}
</div>
@endsection
