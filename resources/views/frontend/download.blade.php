@extends('layouts.app')

@section('title', 'Download - PMII')

@section('content')
<div>
    <h1 class="text-3xl md:text-4xl font-bold mb-6 md:mb-8">Download</h1>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Mobile cards -->
        <div class="md:hidden divide-y">
            @forelse($downloads as $download)
                <article class="p-4 {{ !$download->fileExists() ? 'bg-red-50' : '' }}">
                    <div class="flex items-start justify-between gap-3">
                        <h2 class="font-semibold text-gray-900">{{ $download->nama_file }}</h2>
                        @if(!$download->fileExists())
                            <span class="shrink-0 text-xs bg-red-100 text-red-800 px-2 py-1 rounded">File Missing</span>
                        @endif
                    </div>

                    <div class="mt-3">
                        <span class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs">
                            {{ str_replace('_', ' ', ucfirst($download->kategori)) }}
                        </span>
                    </div>

                    <p class="mt-3 text-sm text-gray-600">{{ $download->deskripsi ?? '-' }}</p>

                    <div class="mt-4">
                        @if($download->fileExists())
                            <a href="{{ route('download.show', $download) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">
                                Lihat Detail & Download
                            </a>
                        @else
                            <button type="button" disabled class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-500 rounded-lg text-sm cursor-not-allowed">
                                Tidak Tersedia
                            </button>
                        @endif
                    </div>
                </article>
            @empty
                <div class="px-4 py-10 text-center text-gray-500">
                    Belum ada file untuk didownload
                </div>
            @endforelse
        </div>

        <!-- Desktop table -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full min-w-[720px]">
                <thead class="bg-[#1e3a5f]/95 text-white">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold">Nama File</th>
                        <th class="px-6 py-4 text-left font-semibold">Kategori</th>
                        <th class="px-6 py-4 text-left font-semibold">Deskripsi</th>
                        <th class="px-6 py-4 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($downloads as $download)
                        <tr class="hover:bg-gray-50 {{ !$download->fileExists() ? 'bg-red-50' : '' }}">
                            <td class="px-6 py-4 font-semibold">
                                {{ $download->nama_file }}
                                @if(!$download->fileExists())
                                    <span class="ml-2 text-xs bg-red-100 text-red-800 px-2 py-1 rounded">File Missing</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                                    {{ str_replace('_', ' ', ucfirst($download->kategori)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-600">{{ $download->deskripsi ?? '-' }}</td>
                            <td class="px-6 py-4 text-center">
                                @if($download->fileExists())
                                    <a href="{{ route('download.show', $download) }}" class="inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">
                                        Lihat Detail & Download
                                    </a>
                                @else
                                    <button type="button" disabled class="inline-block px-4 py-2 bg-gray-300 text-gray-500 rounded-lg text-sm cursor-not-allowed">
                                        Tidak Tersedia
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                Belum ada file untuk didownload
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($downloads, 'links'))
            <div class="px-6 py-4 border-t bg-gray-50">
                {{ $downloads->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
