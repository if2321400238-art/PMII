@extends('layouts.app')

@section('title', 'Galeri - PMII')

@section('content')
<div>
    <h1 class="text-4xl font-bold mb-8">Galeri</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        @forelse($galleries as $gallery)
            <a href="{{ route('gallery.show', $gallery) }}" class="relative group overflow-hidden rounded-lg shadow-md h-48">
                @if($gallery->type === 'photo' && $gallery->file_path)
                    <img src="{{ asset('storage/' . $gallery->file_path) }}" alt="{{ $gallery->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                @elseif($gallery->type === 'video')
                    @if($gallery->file_path)
                        <video class="w-full h-full object-cover" muted playsinline preload="metadata">
                            <source src="{{ asset('storage/' . $gallery->file_path) }}">
                        </video>
                    @elseif($gallery->video_thumbnail_url)
                        <img src="{{ $gallery->video_thumbnail_url }}" alt="{{ $gallery->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                    @else
                        <div class="w-full h-full bg-gray-800 flex items-center justify-center">
                            <svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8 5v14l11-7z"/>
                            </svg>
                        </div>
                    @endif
                    <div class="absolute top-3 right-3 rounded-full bg-black/55 px-2.5 py-1 text-[11px] font-semibold text-white">Video</div>
                @else
                    <div class="w-full h-full bg-gray-300 flex items-center justify-center">
                        <span class="text-gray-600 text-sm">Media</span>
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

    <div class="flex justify-center">
        {{ $galleries->links() }}
    </div>
</div>
@endsection
