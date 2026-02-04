@extends('layouts.admin')

@section('title', 'Edit Korwil - Admin ISKAB')
@section('page_title', 'Edit Korwil')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-8">
        <h2 class="text-2xl font-bold mb-6">Edit Korwil</h2>

        <form action="{{ route('admin.korwil.update', $korwil) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Nama -->
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Korwil <span class="text-red-500">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name', $korwil->name) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('name') border-red-500 @enderror"
                    required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Wilayah -->
            <div>
                <label for="wilayah" class="block text-sm font-semibold text-gray-700 mb-2">Wilayah <span class="text-red-500">*</span></label>
                <input type="text" id="wilayah" name="wilayah" value="{{ old('wilayah', $korwil->wilayah) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('wilayah') border-red-500 @enderror"
                    required>
                @error('wilayah')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nomor SK -->
            <div>
                <label for="nomor_sk" class="block text-sm font-semibold text-gray-700 mb-2">Nomor SK</label>
                <input type="text" id="nomor_sk" name="nomor_sk" value="{{ old('nomor_sk', $korwil->nomor_sk) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('nomor_sk') border-red-500 @enderror">
                @error('nomor_sk')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tanggal SK -->
            <div>
                <label for="tanggal_sk" class="block text-sm font-semibold text-gray-700 mb-2">Tanggal SK</label>
                <input type="date" id="tanggal_sk" name="tanggal_sk" value="{{ old('tanggal_sk', $korwil->tanggal_sk?->format('Y-m-d')) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('tanggal_sk') border-red-500 @enderror">
                @error('tanggal_sk')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Contact -->
            <div>
                <label for="contact" class="block text-sm font-semibold text-gray-700 mb-2">Kontak</label>
                <input type="text" id="contact" name="contact" value="{{ old('contact', $korwil->contact) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('contact') border-red-500 @enderror">
                @error('contact')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Deskripsi -->
            <div>
                <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi</label>
                <textarea id="description" name="description" rows="4"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('description') border-red-500 @enderror">{{ old('description', $korwil->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex gap-4 pt-6 border-t">
                <button type="submit" class="flex-1 px-6 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition">
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.korwil.index') }}" class="flex-1 px-6 py-3 bg-gray-300 text-gray-800 font-semibold rounded-lg hover:bg-gray-400 transition text-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
