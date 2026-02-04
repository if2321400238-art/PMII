@extends('layouts.app')

@section('title', 'Form Pengajuan SK - ISKAB')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-12 pt-28 md:pt-32">
    <div class="bg-white rounded-lg shadow-lg p-8">
        <h1 class="text-3xl font-bold mb-2">Form Pengajuan Surat Keputusan (SK)</h1>
        <p class="text-gray-600 mb-8">Silakan isi form di bawah untuk mengajukan SK baru untuk Korwil atau Rayon</p>

        <form action="{{ route('frontend.sk-store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Nama Pemohon -->
            <div>
                <label for="nama_pemohon" class="block text-sm font-semibold text-gray-700 mb-2">Nama Pemohon <span class="text-red-500">*</span></label>
                <input type="text" id="nama_pemohon" name="nama_pemohon" value="{{ old('nama_pemohon') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('nama_pemohon') border-red-500 @enderror"
                    required>
                @error('nama_pemohon')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
                <input type="email" id="email" name="email" value="{{ old('email') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('email') border-red-500 @enderror"
                    required>
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nomor HP -->
            <div>
                <label for="nomor_hp" class="block text-sm font-semibold text-gray-700 mb-2">Nomor HP <span class="text-red-500">*</span></label>
                <input type="text" id="nomor_hp" name="nomor_hp" value="{{ old('nomor_hp') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('nomor_hp') border-red-500 @enderror"
                    placeholder="contoh: 08123456789" required>
                @error('nomor_hp')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Jenis SK -->
            <div>
                <label for="jenis_sk" class="block text-sm font-semibold text-gray-700 mb-2">Jenis SK <span class="text-red-500">*</span></label>
                <select id="jenis_sk" name="jenis_sk"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('jenis_sk') border-red-500 @enderror"
                    onchange="toggleKorwilField()" required>
                    <option value="">-- Pilih Jenis SK --</option>
                    <option value="korwil" @selected(old('jenis_sk') == 'korwil')>Korwil (Koordinator Wilayah)</option>
                    <option value="rayon" @selected(old('jenis_sk') == 'rayon')>Rayon</option>
                </select>
                @error('jenis_sk')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Korwil (Conditional) -->
            <div id="korwil_field" class="hidden">
                <label for="korwil_id" class="block text-sm font-semibold text-gray-700 mb-2">Pilih Korwil <span class="text-red-500">*</span></label>
                <select id="korwil_id" name="korwil_id"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('korwil_id') border-red-500 @enderror">
                    <option value="">-- Pilih Korwil --</option>
                    @foreach($korwils as $korwil)
                        <option value="{{ $korwil->id }}" @selected(old('korwil_id') == $korwil->id)>{{ $korwil->name }}</option>
                    @endforeach
                </select>
                @error('korwil_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nama Organisasi -->
            <div>
                <label for="nama_organisasi" class="block text-sm font-semibold text-gray-700 mb-2">Nama Organisasi <span class="text-red-500">*</span></label>
                <input type="text" id="nama_organisasi" name="nama_organisasi" value="{{ old('nama_organisasi') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('nama_organisasi') border-red-500 @enderror"
                    placeholder="contoh: Rayon Jakarta Pusat" required>
                @error('nama_organisasi')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Wilayah -->
            <div>
                <label for="wilayah" class="block text-sm font-semibold text-gray-700 mb-2">Wilayah <span class="text-red-500">*</span></label>
                <input type="text" id="wilayah" name="wilayah" value="{{ old('wilayah') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('wilayah') border-red-500 @enderror"
                    placeholder="contoh: Jakarta Pusat" required>
                @error('wilayah')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex gap-4 pt-6">
                <button type="submit" class="flex-1 px-6 py-3 bg-orange-600 text-white font-semibold rounded-lg hover:bg-orange-700 transition">
                    Ajukan SK
                </button>
                <a href="{{ route('data.index') }}" class="flex-1 px-6 py-3 bg-gray-300 text-gray-800 font-semibold rounded-lg hover:bg-gray-400 transition text-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function toggleKorwilField() {
    const jenissk = document.getElementById('jenis_sk').value;
    const korwilField = document.getElementById('korwil_field');
    const korwilSelect = document.getElementById('korwil_id');

    if (jenissk === 'rayon') {
        korwilField.classList.remove('hidden');
        korwilSelect.setAttribute('required', 'required');
    } else {
        korwilField.classList.add('hidden');
        korwilSelect.removeAttribute('required');
        korwilSelect.value = '';
    }
}

// Trigger on page load
document.addEventListener('DOMContentLoaded', function() {
    toggleKorwilField();
    document.getElementById('jenis_sk').addEventListener('change', toggleKorwilField);
});
</script>
@endsection
