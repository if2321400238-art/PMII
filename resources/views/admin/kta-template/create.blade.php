@extends('layouts.admin')

@section('title', 'Upload KTA Template Baru')

@section('content')
<div class="px-6 py-8">
    <!-- Header -->
    <div class="mb-8">
        <a href="{{ route('admin.kta-template.index') }}" class="text-blue-600 hover:text-blue-700 font-medium mb-4 inline-flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali
        </a>
        <h1 class="text-3xl font-bold text-gray-900">Upload Template KTA</h1>
        <p class="text-gray-600 mt-1">Unggah image template untuk Kartu Tanda Anggota</p>
    </div>

    <form action="{{ route('admin.kta-template.store') }}" method="POST" enctype="multipart/form-data" class="max-w-2xl">
        @csrf

        <!-- Name -->
        <div class="mb-6">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                Nama Template
            </label>
            <input type="text" id="name" name="name" value="{{ old('name') }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                placeholder="Contoh: KTA Standar ISKAB"
                required>
            @error('name')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Image Upload -->
        <div class="mb-6">
            <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                Upload Image Template
            </label>

            <div id="dropZone" class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center cursor-pointer hover:border-blue-500 hover:bg-blue-50 transition">
                <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                </svg>
                <p class="text-gray-600">Drag & drop image Anda di sini, atau</p>
                <p class="text-blue-600 font-medium">klik untuk browse</p>
                <p class="text-gray-500 text-sm mt-2">PNG, JPG (Max 5MB)</p>
                <input type="file" id="image" name="image" accept="image/*" class="hidden" required>
            </div>

            <!-- Image Preview -->
            <div id="preview" class="mt-4 hidden">
                <img id="previewImage" src="" alt="Preview" class="max-w-full h-auto rounded-lg border border-gray-200">
            </div>

            @error('image')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Info -->
        <div class="mb-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <h3 class="font-semibold text-blue-900 mb-2">💡 Panduan Upload</h3>
            <ul class="text-sm text-blue-800 space-y-1">
                <li>• Upload gambar template KTA dalam format PNG atau JPG</li>
                <li>• Ukuran minimum: 500x800px (untuk ID card standar)</li>
                <li>• Maksimal file: 5MB</li>
                <li>• Nama dan data anggota akan ditambahkan secara otomatis ke template</li>
            </ul>
        </div>

        <!-- Buttons -->
        <div class="flex gap-3">
            <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition">
                Upload Template
            </button>
            <a href="{{ route('admin.kta-template.index') }}" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-900 font-medium py-2 px-4 rounded-lg transition text-center">
                Batal
            </a>
        </div>
    </form>
</div>

<script>
    const dropZone = document.getElementById('dropZone');
    const fileInput = document.getElementById('image');
    const preview = document.getElementById('preview');
    const previewImage = document.getElementById('previewImage');

    dropZone.addEventListener('click', () => fileInput.click());

    dropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropZone.classList.add('border-blue-500', 'bg-blue-50');
    });

    dropZone.addEventListener('dragleave', () => {
        dropZone.classList.remove('border-blue-500', 'bg-blue-50');
    });

    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.classList.remove('border-blue-500', 'bg-blue-50');

        const files = e.dataTransfer.files;
        if (files.length > 0) {
            fileInput.files = files;
            handleFileSelect();
        }
    });

    fileInput.addEventListener('change', handleFileSelect);

    function handleFileSelect() {
        const file = fileInput.files[0];
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = (e) => {
                previewImage.src = e.target.result;
                preview.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection
