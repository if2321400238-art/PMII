@extends('layouts.app')

@section('title', $download->nama_file . ' - Download')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="mb-6 flex items-center gap-2 text-sm text-gray-600">
        <a href="{{ route('download.index') }}" class="text-blue-600 hover:text-blue-800 transition">Download</a>
        <span class="text-gray-400">/</span>
        <span class="text-gray-900 font-medium">{{ $download->nama_file }}</span>
    </nav>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Preview Section -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <!-- Preview Container -->
                <div class="aspect-video bg-gray-100 flex items-center justify-center p-4">
                    @if($isPdf)
                        <!-- PDF Preview -->
                        <iframe 
                            src="{{ asset('storage/' . $download->file_path) }}#toolbar=0&navpanes=0&scrollbar=0" 
                            class="w-full h-full rounded"
                            title="PDF Preview">
                        </iframe>
                    @elseif($isImage)
                        <!-- Image Preview -->
                        <img 
                            src="{{ asset('storage/' . $download->file_path) }}" 
                            alt="{{ $download->nama_file }}" 
                            class="max-w-full max-h-full object-contain rounded"
                        >
                    @else
                        <!-- File Type Icon -->
                        <div class="text-center">
                            <svg class="w-24 h-24 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p class="text-gray-600 font-medium">File {{ strtoupper($extension) }}</p>
                            <p class="text-gray-500 text-sm mt-2">Preview tidak tersedia untuk format ini</p>
                        </div>
                    @endif
                </div>

                <!-- File Info -->
                <div class="border-t p-6">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $download->nama_file }}</h1>
                    
                    <div class="flex flex-wrap items-center gap-4 mb-6">
                        <span class="inline-block bg-blue-100 text-blue-800 px-4 py-2 rounded-full text-sm font-medium">
                            {{ str_replace('_', ' ', ucfirst($download->kategori)) }}
                        </span>
                        <span class="text-gray-600 text-sm">
                            Diperbarui: {{ $download->updated_at->locale('id')->format('d F Y H:i') }}
                        </span>
                    </div>

                    @if($download->deskripsi)
                        <div class="mb-6">
                            <h3 class="font-semibold text-gray-900 mb-2">Deskripsi</h3>
                            <p class="text-gray-700 leading-relaxed">{{ $download->deskripsi }}</p>
                        </div>
                    @endif

                    <!-- Additional Info -->
                    <div class="grid grid-cols-2 gap-4 p-4 bg-gray-50 rounded-lg">
                        <div>
                            <p class="text-xs text-gray-600 uppercase tracking-wide">Format File</p>
                            <p class="text-lg font-semibold text-gray-900">{{ strtoupper($extension) }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600 uppercase tracking-wide">Jumlah Download</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $download->download_count ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <div class="sticky top-24 space-y-4">
                <!-- Download Button -->
                <form action="{{ route('download.file', $download) }}" method="POST" class="w-full">
                    @csrf
                    <button 
                        type="submit" 
                        class="w-full inline-flex items-center justify-center gap-2 px-6 py-4 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition shadow-md"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Download File
                    </button>
                </form>

                <!-- Back Button -->
                <a 
                    href="{{ route('download.index') }}" 
                    class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali
                </a>

                <!-- Info Cards -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <p class="text-sm text-blue-900">
                        <strong>Tip:</strong> Anda dapat melihat preview file sebelum mendownload. Fitur ini membantu Anda memastikan file yang ingin didownload.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Downloads -->
    @php
        $related = \App\Models\Download::where('kategori', $download->kategori)
            ->where('id', '!=', $download->id)
            ->latest()
            ->take(3)
            ->get();
    @endphp

    @if($related->count() > 0)
        <div class="mt-12 pt-8 border-t">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">File Terkait</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($related as $item)
                    <a href="{{ route('download.show', $item) }}" class="group">
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                            <div class="aspect-square bg-gray-100 flex items-center justify-center p-4">
                                <div class="text-center">
                                    <p class="text-4xl font-bold text-gray-400">{{ strtoupper(pathinfo($item->file_path, PATHINFO_EXTENSION))[0] ?? 'F' }}</p>
                                </div>
                            </div>
                            <div class="p-4">
                                <h3 class="font-semibold text-gray-900 group-hover:text-blue-600 transition line-clamp-2">{{ $item->nama_file }}</h3>
                                <p class="text-sm text-gray-600 mt-2 line-clamp-2">{{ $item->deskripsi ?? '-' }}</p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
