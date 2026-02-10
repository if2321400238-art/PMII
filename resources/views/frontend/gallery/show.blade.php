@extends('layouts.app')

@section('title', $gallery->title . ' - PMII')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- Breadcrumb -->
    <nav class="text-sm mb-8">
        <ol class="flex gap-2 text-gray-600">
            <li><a href="{{ route('home') }}" class="hover:text-orange-600">Beranda</a></li>
            <li>/</li>
            <li><a href="{{ route('gallery.index') }}" class="hover:text-orange-600">Galeri</a></li>
            <li>/</li>
            <li class="text-gray-900 font-semibold">{{ $gallery->title }}</li>
        </ol>
    </nav>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Media Display -->
        <div class="lg:col-span-2">
            <div class="bg-black rounded-lg overflow-hidden">
                @if($gallery->type === 'photo')
                    <img src="{{ asset('storage/' . $gallery->file_path) }}" alt="{{ $gallery->title }}" class="w-full h-auto max-h-96 object-cover">
                @else
                    <!-- Video Embed -->
                    <div class="relative" style="padding-bottom: 56.25%;">
                        <iframe src="{{ $gallery->embed_url }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="absolute top-0 left-0 w-full h-full"></iframe>
                    </div>
                @endif
            </div>

            <!-- Gallery Info -->
            <div class="mt-8">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $gallery->title }}</h1>

                <div class="flex flex-wrap gap-4 mb-6 pb-6 border-b">
                    <div class="flex items-center gap-2 text-gray-600">
                        <span class="text-lg">📅</span>
                        <span>Tahun {{ $gallery->tahun }}</span>
                    </div>
                    <div class="flex items-center gap-2 text-gray-600">
                        <span class="text-lg">🎯</span>
                        <span>{{ $gallery->kegiatan }}</span>
                    </div>
                    <div class="flex items-center gap-2 text-gray-600">
                        <span class="text-lg">
                            @if($gallery->type === 'photo')
                                📸 Foto
                            @else
                                🎬 Video
                            @endif
                        </span>
                    </div>
                </div>

                @if($gallery->description)
                    <div class="prose prose-sm max-w-none">
                        <p class="text-gray-700 leading-relaxed">{{ $gallery->description }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Related Items -->
            @if($related->count() > 0)
                <div class="bg-gray-50 rounded-lg p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Galeri Terkait</h3>

                    <div class="space-y-4">
                        @foreach($related as $item)
                            <a href="{{ route('gallery.show', $item) }}" class="block group">
                                <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition">
                                    @if($item->type === 'photo')
                                        <div class="h-32 overflow-hidden bg-gray-200">
                                            <img src="{{ asset('storage/' . $item->file_path) }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-105 transition">
                                        </div>
                                    @else
                                        <div class="h-32 bg-gradient-to-br from-gray-300 to-gray-400 flex items-center justify-center">
                                            <span class="text-3xl">🎬</span>
                                        </div>
                                    @endif
                                    <div class="p-3">
                                        <h4 class="font-semibold text-sm text-gray-900 group-hover:text-orange-600 line-clamp-2">{{ $item->title }}</h4>
                                        <p class="text-xs text-gray-500 mt-1">{{ $item->kegiatan }} • {{ $item->tahun }}</p>
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
