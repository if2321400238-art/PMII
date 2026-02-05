@extends('layouts.admin')

@section('title', $ktaTemplate->name)

@section('content')
<div class="px-6 py-8">
    <!-- Header -->
    <div class="mb-8">
        <a href="{{ route('admin.kta-template.index') }}" class="text-blue-600 hover:text-blue-700 font-medium mb-4 inline-flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali
        </a>
        <h1 class="text-3xl font-bold text-gray-900">{{ $ktaTemplate->name }}</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Template Image -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
                <h2 class="font-semibold text-gray-900 mb-4">Template Preview</h2>
                <div class="bg-gray-100 rounded-lg flex items-center justify-center" style="aspect-ratio: 3.5/5.3;">
                    @if($ktaTemplate->image_path)
                        <img src="{{ asset('storage/' . $ktaTemplate->image_path) }}" alt="{{ $ktaTemplate->name }}" class="max-w-full max-h-full">
                    @else
                        <span class="text-gray-400">Image tidak ditemukan</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div>
            <!-- Status -->
            <div class="bg-white rounded-lg shadow border border-gray-200 p-6 mb-6">
                <h3 class="font-semibold text-gray-900 mb-4">Status</h3>
                @if($ktaTemplate->is_active)
                    <span class="inline-block px-4 py-2 bg-green-100 text-green-800 rounded-full font-medium">
                        ✓ Aktif
                    </span>
                @else
                    <span class="inline-block px-4 py-2 bg-gray-100 text-gray-800 rounded-full font-medium">
                        Nonaktif
                    </span>
                @endif
            </div>

            <!-- Usage -->
            <div class="bg-white rounded-lg shadow border border-gray-200 p-6 mb-6">
                <h3 class="font-semibold text-gray-900 mb-4">Penggunaan</h3>
                <p class="text-3xl font-bold text-blue-600">{{ $ktaTemplate->anggota()->count() }}</p>
                <p class="text-gray-600 text-sm">Anggota menggunakan template ini</p>
            </div>

            <!-- Actions -->
            <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
                <h3 class="font-semibold text-gray-900 mb-4">Aksi</h3>
                <div class="space-y-2">
                    <a href="{{ route('admin.kta-template.edit', $ktaTemplate) }}" class="block text-center bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition">
                        Edit Template
                    </a>
                    <form action="{{ route('admin.kta-template.destroy', $ktaTemplate) }}" method="POST" onsubmit="return confirm('Yakin hapus template ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition">
                            Hapus Template
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Anggota Using This Template -->
    @if($ktaTemplate->anggota()->count() > 0)
    <div class="mt-8 bg-white rounded-lg shadow border border-gray-200 p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Anggota yang Menggunakan Template Ini</h2>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="text-left py-3 px-4 font-semibold text-gray-900">Nama</th>
                        <th class="text-left py-3 px-4 font-semibold text-gray-900">No. Anggota</th>
                        <th class="text-left py-3 px-4 font-semibold text-gray-900">Rayon</th>
                        <th class="text-left py-3 px-4 font-semibold text-gray-900">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ktaTemplate->anggota()->limit(10)->get() as $anggota)
                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                        <td class="py-3 px-4">{{ $anggota->nama }}</td>
                        <td class="py-3 px-4">{{ $anggota->nomor_anggota }}</td>
                        <td class="py-3 px-4">{{ $anggota->rayon?->nama ?? '-' }}</td>
                        <td class="py-3 px-4">
                            <a href="{{ route('anggota.download-kta', $anggota) }}" class="text-blue-600 hover:text-blue-700 font-medium">
                                Download KTA
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($ktaTemplate->anggota()->count() > 10)
            <p class="text-gray-600 text-sm mt-4">
                ... dan {{ $ktaTemplate->anggota()->count() - 10 }} anggota lainnya
            </p>
        @endif
    </div>
    @endif
</div>
@endsection
