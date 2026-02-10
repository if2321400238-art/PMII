@extends('layouts.admin')

@section('title', 'Ajukan SK - Admin PMII')
@section('page_title', 'Ajukan SK Baru')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Ajukan SK Baru</h1>
            <p class="text-gray-600 mt-2">Silakan isi form di bawah untuk mengajukan Surat Keputusan baru</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <form action="{{ route('admin.sk-pengajuan.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
                @csrf

                <!-- Info Korwil/Rayon dari Auth Guard -->
                @if($korwil)
                    <div class="bg-gradient-to-r from-green-50 to-green-100 border-l-4 border-green-500 rounded-lg p-6">
                        <h3 class="font-semibold text-green-900 mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Informasi Korwil Anda
                        </h3>
                        <div class="space-y-2 text-sm text-green-800">
                            <p><strong>Nama:</strong> {{ $korwil->name }}</p>
                            @if($korwil->wilayah)
                                <p><strong>Wilayah:</strong> {{ $korwil->wilayah }}</p>
                            @endif
                        </div>
                    </div>
                @elseif($rayon)
                    <div class="bg-gradient-to-r from-green-50 to-green-100 border-l-4 border-green-500 rounded-lg p-6">
                        <h3 class="font-semibold text-green-900 mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Informasi Rayon Anda
                        </h3>
                        <div class="space-y-2 text-sm text-green-800">
                            <p><strong>Nama:</strong> {{ $rayon->name }}</p>
                            <p><strong>Korwil:</strong> {{ $rayon->korwil->name }}</p>
                        </div>
                    </div>
                @endif

                <!-- Nama SK -->
                <div>
                    <label for="nama" class="block text-sm font-semibold text-gray-700 mb-2">Nomor SK <span class="text-red-500">*</span></label>
                    <input type="text" id="nama" name="nama" value="{{ old('nama') }}" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition @error('nama') border-red-500 @enderror"
                        placeholder="Contoh: SK/BPH-PB/001/2026">
                    @error('nama')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div>
                    <label for="deskripsi" class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" rows="4"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition @error('deskripsi') border-red-500 @enderror"
                        placeholder="Deskripsi atau keterangan tambahan...">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Dokumen -->
                <div>
                    <label for="dokumen" class="block text-sm font-semibold text-gray-700 mb-2">Dokumen SK <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input type="file" id="dokumen" name="dokumen" accept=".pdf,.doc,.docx" required
                            class="w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition @error('dokumen') border-red-500 @enderror"
                            onchange="updateFileName(this)">
                        <p class="text-gray-500 text-sm mt-2">Format: PDF, DOC, DOCX (Maks 5MB)</p>
                    </div>
                    @error('dokumen')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="flex gap-4 pt-6 border-t border-gray-200">
                    <button type="submit" class="flex-1 px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white font-semibold rounded-lg hover:from-green-700 hover:to-green-800 transition shadow-lg shadow-green-500/30 flex items-center justify-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                        Kirim Pengajuan
                    </button>
                    <a href="{{ route('admin.sk-pengajuan.index') }}" class="flex-1 px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition text-center flex items-center justify-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function updateFileName(input) {
    if (input.files && input.files[0]) {
        const fileName = input.files[0].name;
        // Bisa tambah custom logic untuk menampilkan nama file jika perlu
    }
}
</script>
@endsection
