@extends('layouts.admin')

@section('title', 'Manajemen Iklan - Admin PMII')
@section('page_title', 'Manajemen Iklan')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Iklan</h1>
            <p class="mt-1 text-sm text-gray-600">Kelola banner iklan yang ditampilkan di halaman berita.</p>
        </div>
        <a href="{{ route('admin.ads.create') }}"
           class="inline-flex items-center rounded-lg bg-green-700 px-4 py-2 text-sm font-semibold text-white hover:bg-green-800 transition">
            Tambah Iklan
        </a>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">Banner</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">Judul</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">Posisi</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">Urutan</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide text-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($ads as $ad)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">
                                <img src="{{ asset('storage/' . $ad->image_path) }}" alt="{{ $ad->title }}" class="h-16 w-28 rounded-md object-cover border border-gray-200">
                            </td>
                            <td class="px-4 py-3">
                                <p class="font-medium text-gray-900">{{ $ad->title }}</p>
                                <p class="text-xs text-gray-500 mt-0.5">{{ $ad->target_url ?? '-' }}</p>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-700">
                                {{ $ad->position === 'berita_left' ? 'Berita - Kiri' : $ad->position }}
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $ad->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                                    {{ $ad->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $ad->sort_order }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.ads.edit', $ad) }}"
                                       class="inline-flex rounded-lg bg-blue-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-blue-700 transition">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.ads.destroy', $ad) }}" method="POST" onsubmit="return confirm('Hapus iklan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex rounded-lg bg-red-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-red-700 transition">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-10 text-center text-sm text-gray-500">
                                Belum ada iklan. Tambahkan banner pertama.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($ads->hasPages())
        <div class="mt-6">
            {{ $ads->links() }}
        </div>
    @endif
</div>
@endsection
