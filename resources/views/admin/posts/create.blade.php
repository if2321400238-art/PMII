@extends('layouts.admin')

@section('title', 'Buat Post - Admin ISKAB')
@section('page_title', 'Buat Post Baru')

@section('content')
<div class="max-w-4xl mx-auto">
    <form method="POST" action="{{ route('admin.posts.store') }}" enctype="multipart/form-data" class="bg-white rounded-lg shadow-md p-8">
        @csrf

        <div class="mb-6">
            <label class="block text-sm font-semibold mb-2">Tipe Post</label>
            <select name="type" class="w-full px-4 py-2 border border-gray-300 rounded-lg @error('type') border-red-500 @enderror">
                <option value="">Pilih Tipe</option>
                <option value="berita">Berita</option>
                <option value="pena_santri">Pena Santri</option>
            </select>
            @error('type')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-6">
            <label class="block text-sm font-semibold mb-2">Judul</label>
            <input type="text" name="title" value="{{ old('title') }}" placeholder="Masukkan judul post" class="w-full px-4 py-2 border border-gray-300 rounded-lg @error('title') border-red-500 @enderror">
            @error('title')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-6">
            <label class="block text-sm font-semibold mb-2">Kategori</label>
            <select name="category_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg @error('category_id') border-red-500 @enderror">
                <option value="">Pilih Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
            @error('category_id')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-6">
            <label class="block text-sm font-semibold mb-2">Konten</label>
            <textarea name="content" rows="12" placeholder="Masukkan konten post" class="w-full px-4 py-2 border border-gray-300 rounded-lg @error('content') border-red-500 @enderror">{{ old('content') }}</textarea>
            @error('content')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-6">
            <label class="block text-sm font-semibold mb-2">Thumbnail</label>
            <input type="file" name="thumbnail" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg @error('thumbnail') border-red-500 @enderror">
            <p class="text-gray-600 text-sm mt-1">Format: JPG, PNG (max 2MB)</p>
            @error('thumbnail')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <label class="block text-sm font-semibold mb-2">Tanggal Publikasi</label>
                <input type="datetime-local" name="published_at" value="{{ old('published_at') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                <p class="text-gray-600 text-sm mt-1">Kosongkan untuk publish sekarang</p>
                @error('published_at')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="flex items-end">
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox" name="is_popular" value="1" {{ old('is_popular') ? 'checked' : '' }} class="w-4 h-4 rounded border-gray-300">
                    <span class="ml-2 text-sm font-semibold">Tandai sebagai Populer</span>
                </label>
            </div>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-semibold">
                Simpan Post
            </button>
            <a href="{{ route('admin.posts.index') }}" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 font-semibold">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
