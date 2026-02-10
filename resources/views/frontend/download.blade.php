@extends('layouts.app')

@section('title', 'Download - PMII')

@section('content')
<div class="">
    <h1 class="text-4xl font-bold mb-8">Download</h1>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <table class="w-full">
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
                                <a href="{{ route('download.file', $download) }}" class="inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">
                                    ⬇️ Download
                                </a>
                            @else
                                <button type="button" disabled class="inline-block px-4 py-2 bg-gray-300 text-gray-500 rounded-lg text-sm cursor-not-allowed">
                                    ❌ Tidak Tersedia
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

        @if(method_exists($downloads, 'links'))
            <div class="px-6 py-4 border-t bg-gray-50">
                {{ $downloads->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
