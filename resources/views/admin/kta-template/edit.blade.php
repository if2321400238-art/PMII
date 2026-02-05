@extends('layouts.admin')

@section('title', 'Edit KTA Template')

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
        <h1 class="text-3xl font-bold text-gray-900">Edit Template: {{ $ktaTemplate->name }}</h1>
    </div>

    <form action="{{ route('admin.kta-template.update', $ktaTemplate) }}" method="POST" enctype="multipart/form-data" class="max-w-4xl">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Left: Current Template -->
            <div>
                <h2 class="font-semibold text-gray-900 mb-4">Template Saat Ini</h2>
                <div class="bg-gray-100 rounded-lg p-4 aspect-square flex items-center justify-center border border-gray-200">
                    @if($ktaTemplate->image_path && file_exists(storage_path('app/' . $ktaTemplate->image_path)))
                        <img src="{{ asset('storage/' . $ktaTemplate->image_path) }}" alt="{{ $ktaTemplate->name }}" class="max-w-full max-h-full">
                    @else
                        <span class="text-gray-400">Image tidak ditemukan</span>
                    @endif
                </div>
            </div>

            <!-- Right: Edit Form -->
            <div>
                <!-- Name -->
                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Template
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name', $ktaTemplate->name) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                        required>
                    @error('name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Is Active -->
                <div class="mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" {{ $ktaTemplate->is_active ? 'checked' : '' }} class="w-4 h-4 text-blue-600 rounded">
                        <span class="ml-3 text-gray-700">Template aktif (gunakan sebagai default)</span>
                    </label>
                </div>

                <!-- Replace Image -->
                <div class="mb-6">
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                        Ganti Image (Opsional)
                    </label>

                    <div id="dropZone" class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center cursor-pointer hover:border-blue-500 hover:bg-blue-50 transition">
                        <svg class="mx-auto h-8 w-8 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                        <p class="text-gray-600 text-sm">Drag & drop atau klik</p>
                        <input type="file" id="image" name="image" accept="image/*" class="hidden">
                    </div>

                    <!-- New Preview -->
                    <div id="preview" class="mt-4 hidden">
                        <img id="previewImage" src="" alt="Preview" class="max-w-full h-auto rounded-lg border border-gray-200">
                    </div>

                    @error('image')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Usage Stats -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 text-sm">
                    <p class="text-blue-900">
                        <span class="font-semibold">{{ $ktaTemplate->anggota()->count() }}</span> anggota menggunakan template ini
                    </p>
                </div>
            </div>
        </div>

        <!-- Buttons -->
        <div class="mt-8 flex gap-3">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition">
                Simpan Perubahan
            </button>
            <a href="{{ route('admin.kta-template.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-900 font-medium py-2 px-6 rounded-lg transition">
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
