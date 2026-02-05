@extends('layouts.admin')

@section('title', 'Edit Rayon - Admin ISKAB')
@section('page_title', 'Edit Rayon')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Edit Rayon</h1>
        <p class="text-gray-600 mt-1">Perbarui informasi rayon {{ $rayon->name }}</p>
    </div>

    <form action="{{ route('admin.rayon.update', $rayon) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Informasi Dasar -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
                <h2 class="text-lg font-semibold text-white flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Informasi Dasar
                </h2>
            </div>
            <div class="p-6 space-y-6">
                <!-- Korwil -->
                <div>
                    <label for="korwil_id" class="block text-sm font-semibold text-gray-700 mb-2">Pilih Korwil <span class="text-red-500">*</span></label>
                    @if($korwils->count() === 1)
                        <input type="hidden" name="korwil_id" value="{{ $korwils->first()->id }}">
                        <div class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-700">
                            {{ $korwils->first()->name }}
                        </div>
                    @else
                        <select id="korwil_id" name="korwil_id"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('korwil_id') border-red-500 @enderror"
                            required>
                            <option value="">-- Pilih Korwil --</option>
                            @foreach($korwils as $korwil)
                                <option value="{{ $korwil->id }}" @selected(old('korwil_id', $rayon->korwil_id) == $korwil->id)>{{ $korwil->name }}</option>
                            @endforeach
                        </select>
                    @endif
                    @error('korwil_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nama -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Rayon <span class="text-red-500">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name', $rayon->name) }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('name') border-red-500 @enderror"
                        required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email & Password -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
                        <input type="email" id="email" name="email" value="{{ old('email', $rayon->email) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('email') border-red-500 @enderror"
                            placeholder="contoh: rayon@iskab.id" required>
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password <span class="text-red-500">(Kosongkan jika tidak ingin mengubah)</span></label>
                        <input type="password" id="password" name="password"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('password') border-red-500 @enderror"
                            placeholder="Masukkan password baru">
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Deskripsi -->
                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi</label>
                    <textarea id="description" name="description" rows="4"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('description') border-red-500 @enderror">{{ old('description', $rayon->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- SK & Kontak -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
                <h2 class="text-lg font-semibold text-white flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    SK & Kontak
                </h2>
            </div>
            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nomor SK -->
                    <div>
                        <label for="nomor_sk" class="block text-sm font-semibold text-gray-700 mb-2">Nomor SK</label>
                        <input type="text" id="nomor_sk" name="nomor_sk" value="{{ old('nomor_sk', $rayon->nomor_sk) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('nomor_sk') border-red-500 @enderror">
                        @error('nomor_sk')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal SK -->
                    <div>
                        <label for="tanggal_sk" class="block text-sm font-semibold text-gray-700 mb-2">Tanggal SK</label>
                        <input type="date" id="tanggal_sk" name="tanggal_sk" value="{{ old('tanggal_sk', $rayon->tanggal_sk?->format('Y-m-d')) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('tanggal_sk') border-red-500 @enderror">
                        @error('tanggal_sk')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Contact -->
                <div>
                    <label for="contact" class="block text-sm font-semibold text-gray-700 mb-2">Kontak</label>
                    <input type="text" id="contact" name="contact" value="{{ old('contact', $rayon->contact) }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('contact') border-red-500 @enderror">
                    @error('contact')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Buttons -->
        <div class="flex gap-4">
            <a href="{{ route('admin.rayon.index') }}" class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition">
                Batal
            </a>
            <button type="submit" class="flex-1 px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white font-semibold rounded-lg hover:from-green-700 hover:to-green-800 transition shadow-lg">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
