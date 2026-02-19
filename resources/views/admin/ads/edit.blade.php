@extends('layouts.admin')

@section('title', 'Edit Iklan - Admin PMII')
@section('page_title', 'Edit Iklan')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
        <h1 class="text-xl font-bold text-gray-900 mb-1">Edit Iklan</h1>
        <p class="text-sm text-gray-600 mb-6">Perbarui banner iklan yang ditampilkan di halaman berita.</p>

        <form action="{{ route('admin.ads.update', $ad) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label for="title" class="block text-sm font-semibold text-gray-700 mb-1">Judul Iklan</label>
                <input id="title" name="title" type="text" required value="{{ old('title', $ad->title) }}"
                       class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div>
                <label for="position" class="block text-sm font-semibold text-gray-700 mb-1">Posisi</label>
                <select id="position" name="position" required class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    <option value="berita_left" {{ old('position', $ad->position) === 'berita_left' ? 'selected' : '' }}>Halaman Berita - Slot Kiri</option>
                </select>
            </div>

            <div>
                <p class="block text-sm font-semibold text-gray-700 mb-1">Banner Saat Ini</p>
                <div class="w-full max-w-xl overflow-hidden rounded-lg border border-gray-200" style="aspect-ratio: 10 / 3;">
                    <img src="{{ asset('storage/' . $ad->image_path) }}" alt="{{ $ad->title }}" class="h-full w-full object-cover">
                </div>
            </div>

            <div>
                <label for="image_path" class="block text-sm font-semibold text-gray-700 mb-1">Ganti Gambar (opsional)</label>
                <input id="image_path" name="image_path" type="file" accept=".jpg,.jpeg,.png,.webp"
                       class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG, WEBP. Maksimal 5MB.</p>
                <p class="mt-1 text-xs text-blue-700 font-medium">Ukuran disarankan: 1200x360 px (rasio 10:3). Alternatif: 1000x300 px. Minimum: 800x240 px.</p>
            </div>

            <div>
                <label for="target_url" class="block text-sm font-semibold text-gray-700 mb-1">URL Tujuan (opsional)</label>
                <input id="target_url" name="target_url" type="url" value="{{ old('target_url', $ad->target_url) }}" placeholder="https://contoh.com"
                       class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="start_at" class="block text-sm font-semibold text-gray-700 mb-1">Mulai Tayang</label>
                    <input id="start_at" name="start_at" type="datetime-local"
                           value="{{ old('start_at', optional($ad->start_at)->format('Y-m-d\TH:i')) }}"
                           class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div>
                    <label for="end_at" class="block text-sm font-semibold text-gray-700 mb-1">Akhir Tayang</label>
                    <input id="end_at" name="end_at" type="datetime-local"
                           value="{{ old('end_at', optional($ad->end_at)->format('Y-m-d\TH:i')) }}"
                           class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-center">
                <div>
                    <label for="sort_order" class="block text-sm font-semibold text-gray-700 mb-1">Urutan Tampil</label>
                    <input id="sort_order" name="sort_order" type="number" min="0" value="{{ old('sort_order', $ad->sort_order) }}"
                           class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                </div>
                <label class="inline-flex items-center gap-2 mt-6 md:mt-0">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $ad->is_active) ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <span class="text-sm font-semibold text-gray-700">Aktifkan iklan</span>
                </label>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="inline-flex rounded-lg bg-green-700 px-4 py-2 text-sm font-semibold text-white hover:bg-green-800 transition">
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.ads.index') }}" class="inline-flex rounded-lg bg-gray-100 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-200 transition">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
