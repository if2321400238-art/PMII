@extends('layouts.admin')

@section('title', 'Edit Profil Organisasi')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Edit Profil Organisasi</h1>
                <p class="text-gray-600 mt-1">Kelola informasi profil organisasi ISKAB</p>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.profil-organisasi.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Nama Organisasi -->
                <div class="mb-6">
                    <label for="nama_organisasi" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Organisasi <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           name="nama_organisasi"
                           id="nama_organisasi"
                           value="{{ old('nama_organisasi', $profil->nama_organisasi) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                           required>
                </div>

                <!-- Logo -->
                <div class="mb-6">
                    <label for="logo_path" class="block text-sm font-medium text-gray-700 mb-2">
                        Logo Organisasi
                    </label>
                    @if($profil->logo_path)
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $profil->logo_path) }}" alt="Logo" class="h-24 w-24 object-contain border rounded">
                        </div>
                    @endif
                    <input type="file"
                           name="logo_path"
                           id="logo_path"
                           accept="image/jpeg,image/png,image/jpg"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG. Maksimal 2MB</p>
                </div>

                <!-- Hero Image -->
                <div class="mb-6">
                    <label for="hero_image" class="block text-sm font-medium text-gray-700 mb-2">
                        Gambar Hero (Background Beranda)
                    </label>
                    @if($profil->hero_image)
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $profil->hero_image) }}" alt="Hero Image" class="w-full max-w-md h-48 object-cover border rounded">
                        </div>
                    @endif
                    <input type="file"
                           name="hero_image"
                           id="hero_image"
                           accept="image/jpeg,image/png,image/jpg"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG. Maksimal 5MB. Rekomendasi ukuran: 1920x600px</p>
                </div>

                <!-- Sejarah -->
                <div class="mb-6">
                    <label for="sejarah" class="block text-sm font-medium text-gray-700 mb-2">
                        Sejarah Organisasi
                    </label>
                    <textarea name="sejarah"
                              id="sejarah"
                              rows="6"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">{{ old('sejarah', $profil->sejarah) }}</textarea>
                </div>

                <!-- Visi -->
                <div class="mb-6">
                    <label for="visi" class="block text-sm font-medium text-gray-700 mb-2">
                        Visi
                    </label>
                    <textarea name="visi"
                              id="visi"
                              rows="4"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">{{ old('visi', $profil->visi) }}</textarea>
                </div>

                <!-- Misi -->
                <div class="mb-6">
                    <label for="misi" class="block text-sm font-medium text-gray-700 mb-2">
                        Misi
                    </label>
                    <textarea name="misi"
                              id="misi"
                              rows="6"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">{{ old('misi', $profil->misi) }}</textarea>
                </div>

                <!-- Struktur Organisasi -->
                <div class="mb-6">
                    <label for="struktur_organisasi" class="block text-sm font-medium text-gray-700 mb-2">
                        Struktur Organisasi
                    </label>
                    <textarea name="struktur_organisasi"
                              id="struktur_organisasi"
                              rows="4"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">{{ old('struktur_organisasi', $profil->struktur_organisasi) }}</textarea>
                </div>

                <!-- Buttons -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('admin.dashboard') }}"
                       class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                        Batal
                    </a>
                    <button type="submit"
                            class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
