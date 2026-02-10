@extends('layouts.admin')

@section('title', 'Tambah Anggota - Admin PMII')
@section('page_title', 'Tambah Anggota Baru')

@section('content')
<div class="max-w-2xl mx-auto">
    <form method="POST" action="{{ route('admin.anggota.store') }}" enctype="multipart/form-data" class="bg-white rounded-lg shadow-md p-8">
        @csrf

        <div class="mb-6">
            <label class="block text-sm font-semibold mb-2">Nama Lengkap</label>
            <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Masukkan nama lengkap" class="w-full px-4 py-2 border border-gray-300 rounded-lg @error('nama') border-red-500 @enderror">
            @error('nama')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-6">
            <label class="block text-sm font-semibold mb-2">Nomor Anggota</label>
            <input type="text" name="nomor_anggota" value="{{ old('nomor_anggota') }}" placeholder="Cth: PMII-2024-001" class="w-full px-4 py-2 border border-gray-300 rounded-lg @error('nomor_anggota') border-red-500 @enderror">
            @error('nomor_anggota')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-6">
            <label class="block text-sm font-semibold mb-2">Rayon</label>
            @if($rayonCurrent)
                <input type="hidden" name="rayon_id" value="{{ $rayonCurrent->id }}">
                <div class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-700">
                    {{ $rayonCurrent->name }}
                </div>
            @else
                <select name="rayon_id" id="rayon_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg @error('rayon_id') border-red-500 @enderror">
                    <option value="">Pilih Rayon</option>
                    @foreach($rayons as $r)
                        <option value="{{ $r->id }}" {{ old('rayon_id') == $r->id ? 'selected' : '' }}>{{ $r->name }}</option>
                    @endforeach
                </select>
            @endif
            @error('rayon_id')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-6">
            <label class="block text-sm font-semibold mb-2">Pondok</label>
            <input type="text" name="pondok" value="{{ old('pondok') }}" placeholder="Nama pondok pesantren" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
        </div>

        <div class="mb-6">
            <label class="block text-sm font-semibold mb-2">Alamat</label>
            <textarea name="alamat" rows="3" placeholder="Alamat lengkap" class="w-full px-4 py-2 border border-gray-300 rounded-lg">{{ old('alamat') }}</textarea>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-semibold mb-2">Foto</label>
            <input type="file" name="foto" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
            <p class="text-gray-600 text-sm mt-1">Format: JPG, PNG (max 2MB)</p>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-semibold">
                Simpan Anggota
            </button>
            <a href="{{ route('admin.anggota.index') }}" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 font-semibold">
                Batal
            </a>
        </div>
    </form>
</div>

@endsection
