@extends('layouts.app')

@section('title', 'Galeri - ISKAB')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 pt-28 md:pt-32">
    <h1 class="text-4xl font-bold mb-8">Galeri</h1>

    <!-- Filter -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-semibold mb-2">Tipe</label>
                <select name="type" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    <option value="">Semua</option>
                    <option value="photo" {{ request('type') == 'photo' ? 'selected' : '' }}>Foto</option>
                    <option value="video" {{ request('type') == 'video' ? 'selected' : '' }}>Video</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold mb-2">Kegiatan</label>
                <select name="kegiatan" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    <option value="">Semua Kegiatan</option>
                    @foreach($kegiatan as $k)
                        <option value="{{ $k }}" {{ request('kegiatan') == $k ? 'selected' : '' }}>{{ $k }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold mb-2">Tahun</label>
                <select name="tahun" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    <option value="">Semua Tahun</option>
                    @foreach($tahun as $t)
                        <option value="{{ $t }}" {{ request('tahun') == $t ? 'selected' : '' }}>{{ $t }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">Filter</button>
            </div>
        </form>
    </div>

    <!-- Gallery Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        @forelse($galleries as $gallery)
            <a href="{{ route('gallery.show', $gallery) }}" class="relative group overflow-hidden rounded-lg shadow-md h-48">
                @if($gallery->type === 'photo' && $gallery->file_path)
                    <img src="{{ asset('storage/' . $gallery->file_path) }}" alt="{{ $gallery->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                @elseif($gallery->type === 'video')
                    <div class="w-full h-full bg-gray-800 flex items-center justify-center">
                        <svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M8 5v14l11-7z"/>
                        </svg>
                    </div>
                @else
                    <div class="w-full h-full bg-gray-300 flex items-center justify-center">
                        <span class="text-4xl">📷</span>
                    </div>
                @endif
                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-60 transition-all duration-300 flex items-center justify-center">
                    <div class="text-white opacity-0 group-hover:opacity-100 transition-opacity text-center px-4">
                        <p class="font-bold line-clamp-2">{{ $gallery->title }}</p>
                        @if($gallery->kegiatan)
                            <p class="text-sm text-gray-300">{{ $gallery->kegiatan }}</p>
                        @endif
                    </div>
                </div>
            </a>
        @empty
            <div class="col-span-full text-center py-12">
                <p class="text-gray-500 text-lg">Belum ada galeri ditemukan</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="flex justify-center">
        {{ $galleries->links() }}
    </div>
</div>
@endsection
