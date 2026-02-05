@extends('layouts.admin')

@section('title', 'KTA Template')

@section('content')
<div class="px-6 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">KTA Template</h1>
                <p class="text-gray-600 mt-1">Kelola template Kartu Tanda Anggota</p>
            </div>
            <a href="{{ route('admin.kta-template.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition">
                <svg class="inline w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Upload Template Baru
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
        <div class="flex">
            <svg class="h-5 w-5 text-green-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            <p class="text-green-700">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    <!-- Templates List -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($templates as $template)
        <div class="bg-white rounded-lg shadow hover:shadow-lg transition border border-gray-200">
            <!-- Template Preview -->
            <div class="aspect-square bg-gray-100 overflow-hidden rounded-t-lg">
                @if($template->image_path)
                    <img src="{{ asset('storage/' . $template->image_path) }}" alt="{{ $template->name }}" class="w-full h-full object-cover">
                @else
                    <div class="flex items-center justify-center h-full text-gray-400">
                        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                @endif
            </div>

            <!-- Template Info -->
            <div class="p-4">
                <h3 class="font-semibold text-gray-900">{{ $template->name }}</h3>

                <div class="mt-3 flex items-center gap-2">
                    @if($template->is_active)
                        <span class="inline-block px-3 py-1 bg-green-100 text-green-800 text-sm rounded-full font-medium">Aktif</span>
                    @else
                        <span class="inline-block px-3 py-1 bg-gray-100 text-gray-800 text-sm rounded-full font-medium">Nonaktif</span>
                    @endif
                </div>

                <p class="text-sm text-gray-600 mt-2">
                    Digunakan oleh {{ $template->anggota()->count() }} anggota
                </p>

                <!-- Actions -->
                <div class="mt-4 flex gap-2">
                    <a href="{{ route('admin.kta-template.edit', $template) }}" class="flex-1 bg-blue-50 hover:bg-blue-100 text-blue-600 font-medium py-2 px-3 rounded text-center text-sm transition">
                        Edit
                    </a>
                    <form action="{{ route('admin.kta-template.destroy', $template) }}" method="POST" class="flex-1" onsubmit="return confirm('Yakin hapus template ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full bg-red-50 hover:bg-red-100 text-red-600 font-medium py-2 px-3 rounded text-sm transition">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="md:col-span-2 lg:col-span-3">
            <div class="bg-white rounded-lg shadow border border-gray-200 p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">Belum ada template</h3>
                <p class="text-gray-600 mt-1">Upload template KTA pertama Anda untuk memulai</p>
                <a href="{{ route('admin.kta-template.create') }}" class="mt-4 inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition">
                    Upload Template
                </a>
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection
