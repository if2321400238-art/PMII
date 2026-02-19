@extends('layouts.app')

@section('title', $gallery->title . ' - PMII')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <nav class="text-sm mb-8">
        <ol class="flex gap-2 text-gray-600">
            <li><a href="{{ route('home') }}" class="hover:text-orange-600">Beranda</a></li>
            <li>/</li>
            <li><a href="{{ route('gallery.index') }}" class="hover:text-orange-600">Galeri</a></li>
            <li>/</li>
            <li class="text-gray-900 font-semibold">{{ $gallery->title }}</li>
        </ol>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <div class="bg-black rounded-lg overflow-hidden">
                @if($gallery->type === 'photo' && $gallery->file_path)
                    <img src="{{ asset('storage/' . $gallery->file_path) }}" alt="{{ $gallery->title }}" class="w-full h-auto max-h-[560px] object-cover">
                @elseif($gallery->file_path)
                    <video controls preload="metadata" class="w-full h-auto max-h-[560px] bg-black">
                        <source src="{{ asset('storage/' . $gallery->file_path) }}">
                        Browser Anda tidak mendukung pemutaran video.
                    </video>
                @elseif($gallery->embed_player_url)
                    <div class="relative" style="padding-bottom: 56.25%;">
                        <iframe src="{{ $gallery->embed_player_url }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="absolute top-0 left-0 w-full h-full"></iframe>
                    </div>
                @else
                    <div class="w-full h-72 bg-gray-900 text-white/80 flex items-center justify-center">
                        Video tidak tersedia
                    </div>
                @endif
            </div>

            <div class="mt-8">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $gallery->title }}</h1>

                <div class="flex flex-wrap gap-4 mb-6 pb-6 border-b">
                    <div class="flex items-center gap-2 text-gray-600">
                        <span>Tahun {{ $gallery->tahun }}</span>
                    </div>
                    <div class="flex items-center gap-2 text-gray-600">
                        <span>{{ $gallery->kegiatan }}</span>
                    </div>
                    <div class="flex items-center gap-2 text-gray-600">
                        <span>{{ $gallery->type === 'photo' ? 'Foto' : 'Video' }}</span>
                    </div>
                </div>

                @if($gallery->description)
                    <div class="prose prose-sm max-w-none">
                        <p class="text-gray-700 leading-relaxed">{{ $gallery->description }}</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="lg:col-span-1">
            @if($related->count() > 0)
                <div class="bg-gray-50 rounded-lg p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Galeri Terkait</h3>

                    <div class="space-y-4">
                        @foreach($related as $item)
                            <a href="{{ route('gallery.show', $item) }}" class="block group">
                                <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition">
                                    @if($item->type === 'photo' && $item->file_path)
                                        <div class="h-32 overflow-hidden bg-gray-200">
                                            <img src="{{ asset('storage/' . $item->file_path) }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-105 transition">
                                        </div>
                                    @elseif($item->file_path)
                                        <div class="h-32 overflow-hidden bg-black relative">
                                            <video class="w-full h-full object-cover" muted playsinline preload="metadata">
                                                <source src="{{ asset('storage/' . $item->file_path) }}">
                                            </video>
                                            <span class="absolute top-2 right-2 rounded-full bg-black/60 px-2 py-0.5 text-[10px] font-semibold text-white">Video</span>
                                        </div>
                                    @elseif($item->video_thumbnail_url)
                                        <div class="h-32 overflow-hidden bg-gray-200 relative">
                                            <img src="{{ $item->video_thumbnail_url }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-105 transition">
                                            <span class="absolute top-2 right-2 rounded-full bg-black/60 px-2 py-0.5 text-[10px] font-semibold text-white">Video</span>
                                        </div>
                                    @else
                                        <div class="h-32 bg-gradient-to-br from-gray-300 to-gray-400 flex items-center justify-center">
                                            <svg class="w-10 h-10 text-white/85" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M8 5v14l11-7z"/>
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="p-3">
                                        <h4 class="font-semibold text-sm text-gray-900 group-hover:text-orange-600 line-clamp-2">{{ $item->title }}</h4>
                                        <p class="text-xs text-gray-500 mt-1">{{ $item->kegiatan }} &bull; {{ $item->tahun }}</p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    <a href="{{ route('gallery.index') }}" class="block mt-6 px-4 py-2 bg-orange-600 text-white text-center rounded-lg hover:bg-orange-700 transition font-semibold">
                        Lihat Semua Galeri
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
