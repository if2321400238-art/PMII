@extends('layouts.admin')

@section('title', 'Edit Profil Organisasi')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Profil Organisasi</h1>
            <p class="text-gray-600 mt-1">Kelola informasi dan tampilan profil organisasi PMII</p>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded mb-6 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded mb-6">
                <div class="flex items-start">
                    <svg class="w-5 h-5 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form action="{{ route('admin.profil-organisasi.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Informasi Dasar -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
                        <h2 class="text-lg font-semibold text-white flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Informasi Dasar
                        </h2>
                    </div>
                    <div class="p-6 space-y-6">
                        <!-- Nama Organisasi -->
                        <div>
                            <label for="nama_organisasi" class="block text-sm font-semibold text-gray-700 mb-2">
                                Nama Organisasi <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   name="nama_organisasi"
                                   id="nama_organisasi"
                                   value="{{ old('nama_organisasi', $profil->nama_organisasi) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
                                   required>
                        </div>

                        <!-- Logo -->
                        <div>
                            <label for="logo_path" class="block text-sm font-semibold text-gray-700 mb-2">
                                Logo Organisasi
                            </label>
                            @if($profil->logo_path)
                                <div class="mb-3 inline-block">
                                    <img src="{{ asset('storage/' . $profil->logo_path) }}" alt="Logo" class="h-20 w-20 object-contain border-2 border-gray-200 rounded-lg p-2 bg-gray-50">
                                </div>
                            @endif
                            <input type="file"
                                   name="logo_path"
                                   id="logo_path"
                                   accept="image/jpeg,image/png,image/jpg"
                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 cursor-pointer">
                            <p class="text-xs text-gray-500 mt-2">Format: JPG, PNG. Maksimal 2MB</p>
                        </div>
                    </div>
                </div>

                <!-- Gambar Hero Slider -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
                        <h2 class="text-lg font-semibold text-white flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Gambar Hero Beranda
                        </h2>
                        <p class="text-green-100 text-sm mt-1">Upload hingga 3 gambar untuk slider otomatis di halaman beranda</p>
                    </div>
                    <div class="p-6">
                        <div class="grid md:grid-cols-3 gap-6">
                            <!-- Hero 1 -->
                            <div class="space-y-3">
                                <label class="block text-sm font-semibold text-gray-700">Hero 1</label>
                                @if($profil->hero_image)
                                    <img src="{{ asset('storage/' . $profil->hero_image) }}" alt="Hero 1" class="w-full h-32 object-cover rounded-lg border-2 border-gray-200">
                                @else
                                    <div class="w-full h-32 bg-gray-100 rounded-lg border-2 border-dashed border-gray-300 flex items-center justify-center">
                                        <span class="text-gray-400 text-sm">Belum ada gambar</span>
                                    </div>
                                @endif
                                <input type="file" name="hero_image" accept="image/jpeg,image/png,image/jpg"
                                       class="block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                            </div>

                            <!-- Hero 2 -->
                            <div class="space-y-3">
                                <label class="block text-sm font-semibold text-gray-700">Hero 2</label>
                                @if($profil->hero_image_2)
                                    <img src="{{ asset('storage/' . $profil->hero_image_2) }}" alt="Hero 2" class="w-full h-32 object-cover rounded-lg border-2 border-gray-200">
                                @else
                                    <div class="w-full h-32 bg-gray-100 rounded-lg border-2 border-dashed border-gray-300 flex items-center justify-center">
                                        <span class="text-gray-400 text-sm">Belum ada gambar</span>
                                    </div>
                                @endif
                                <input type="file" name="hero_image_2" accept="image/jpeg,image/png,image/jpg"
                                       class="block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                            </div>

                            <!-- Hero 3 -->
                            <div class="space-y-3">
                                <label class="block text-sm font-semibold text-gray-700">Hero 3</label>
                                @if($profil->hero_image_3)
                                    <img src="{{ asset('storage/' . $profil->hero_image_3) }}" alt="Hero 3" class="w-full h-32 object-cover rounded-lg border-2 border-gray-200">
                                @else
                                    <div class="w-full h-32 bg-gray-100 rounded-lg border-2 border-dashed border-gray-300 flex items-center justify-center">
                                        <span class="text-gray-400 text-sm">Belum ada gambar</span>
                                    </div>
                                @endif
                                <input type="file" name="hero_image_3" accept="image/jpeg,image/png,image/jpg"
                                       class="block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 mt-4 flex items-start">
                            <svg class="w-4 h-4 mr-1 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            Format: JPG, PNG. Maksimal 5MB per gambar. Rekomendasi ukuran: 1920x600px
                        </p>
                    </div>
                </div>

                <!-- Konten Profil -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
                        <h2 class="text-lg font-semibold text-white flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Konten Profil
                        </h2>
                    </div>
                    <div class="p-6 space-y-6">
                        <!-- Sejarah -->
                        <div>
                            <label for="sejarah" class="block text-sm font-semibold text-gray-700 mb-2">Sejarah</label>
                            <textarea name="sejarah" id="sejarah" rows="5"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
                                      placeholder="Tulis sejarah organisasi...">{{ old('sejarah', $profil->sejarah) }}</textarea>
                        </div>

                        <!-- Visi -->
                        <div>
                            <label for="visi" class="block text-sm font-semibold text-gray-700 mb-2">Visi</label>
                            <textarea name="visi" id="visi" rows="3"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
                                      placeholder="Tulis visi organisasi...">{{ old('visi', $profil->visi) }}</textarea>
                        </div>

                        <!-- Misi -->
                        <div>
                            <label for="misi" class="block text-sm font-semibold text-gray-700 mb-2">Misi</label>
                            <textarea name="misi" id="misi" rows="5"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
                                      placeholder="Tulis misi organisasi...">{{ old('misi', $profil->misi) }}</textarea>
                        </div>

                        <!-- Struktur Organisasi -->
                        <div>
                            <label for="struktur_organisasi" class="block text-sm font-semibold text-gray-700 mb-2">Struktur Organisasi</label>
                            <textarea name="struktur_organisasi" id="struktur_organisasi" rows="4"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
                                      placeholder="Tulis struktur organisasi...">{{ old('struktur_organisasi', $profil->struktur_organisasi) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end space-x-4 pt-4">
                    <a href="{{ route('admin.dashboard') }}"
                       class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-medium flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Batal
                    </a>
                    <button type="submit"
                            class="px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-lg hover:from-green-700 hover:to-green-800 transition font-medium shadow-lg shadow-green-500/30 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
    </div>
</div>
@endsection
