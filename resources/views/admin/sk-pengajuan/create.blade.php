@extends('layouts.admin')

@section('title', 'Ajukan SK - Admin ISKAB')
@section('page_title', 'Ajukan SK Baru')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-8">
        <h2 class="text-2xl font-bold mb-6">Form Pengajuan SK</h2>

        <form action="{{ route('admin.sk-pengajuan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Info Korwil/Rayon dari User -->
            @if($userRole === 'bph_korwil' && $korwil)
                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                    <h3 class="font-semibold text-green-800 mb-2">Informasi Korwil Anda:</h3>
                    <div class="text-sm text-green-700">
                        <p><strong>Nama:</strong> {{ $korwil->name }}</p>
                        <p><strong>Wilayah:</strong> {{ $korwil->wilayah }}</p>
                        @if($korwil->contact)
                            <p><strong>Kontak:</strong> {{ $korwil->contact }}</p>
                        @endif
                    </div>
                </div>
            @elseif($userRole === 'bph_rayon' && $rayon)
                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                    <h3 class="font-semibold text-green-800 mb-2">Informasi Rayon Anda:</h3>
                    <div class="text-sm text-green-700">
                        <p><strong>Nama:</strong> {{ $rayon->name }}</p>
                        <p><strong>Korwil:</strong> {{ $rayon->korwil->name }}</p>
                        @if($rayon->contact)
                            <p><strong>Kontak:</strong> {{ $rayon->contact }}</p>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Nama SK -->
            <div>
                <label for="nama" class="block text-sm font-semibold text-gray-700 mb-2">Nomor SK <span class="text-red-500">*</span></label>
                <input type="text" id="nama" name="nama" value="{{ old('nama') }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('nama') border-red-500 @enderror"
                    placeholder="Contoh: SK/BPH-PB/001/2026">
                @error('nama')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Deskripsi -->
            <div>
                <label for="deskripsi" class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" rows="4"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('deskripsi') border-red-500 @enderror"
                    placeholder="Deskripsi atau keterangan tambahan...">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Dokumen -->
            <div>
                <label for="dokumen" class="block text-sm font-semibold text-gray-700 mb-2">Dokumen SK <span class="text-red-500">*</span></label>
                <input type="file" id="dokumen" name="dokumen" accept=".pdf,.doc,.docx" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('dokumen') border-red-500 @enderror">
                <p class="text-gray-600 text-sm mt-1">Format: PDF, DOC, DOCX (Maks 5MB)</p>
                @error('dokumen')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex gap-4 pt-6 border-t">
                <button type="submit" class="flex-1 px-6 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition">
                    Kirim Pengajuan
                </button>
                <a href="{{ route('admin.sk-pengajuan.index') }}" class="flex-1 px-6 py-3 bg-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-400 transition text-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
