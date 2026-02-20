@extends('layouts.app')

@section('title', 'Galeri - PMII')

@section('content')
<div>
    <h1 class="text-3xl md:text-4xl font-bold mb-6 md:mb-8 text-blue-900">Galeri</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 md:gap-6 mb-10 md:mb-12">
        @forelse($galleries as $gallery)
            <a href="{{ route('gallery.show', $gallery) }}" class="relative group overflow-hidden rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 h-56 md:h-52 bg-slate-100">
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

                <div class="absolute inset-0 bg-gradient-to-t from-blue-950/90 via-blue-900/40 to-transparent"></div>
                <div class="absolute bottom-0 inset-x-0 p-4 text-white">
                    <p class="font-bold leading-snug line-clamp-2 break-words">{{ $gallery->title }}</p>
                    @if($gallery->kegiatan)
                            <p class="text-sm text-gray-200 mt-1 line-clamp-1 break-words">{{ $gallery->kegiatan }}</p>
                        @endif
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
