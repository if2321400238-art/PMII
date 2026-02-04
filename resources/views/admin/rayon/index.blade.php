@extends('layouts.admin')

@section('title', 'Rayon - Admin ISKAB')
@section('page_title', 'Kelola Rayon')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h2 class="text-2xl font-bold">Data Rayon</h2>
    <a href="{{ route('admin.rayon.create') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
        Tambah Rayon
    </a>
</div>

<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-100 border-b">
            <tr>
                <th class="px-6 py-3 text-left text-sm font-semibold">Nama</th>
                <th class="px-6 py-3 text-left text-sm font-semibold">Korwil</th>
                <th class="px-6 py-3 text-left text-sm font-semibold">No. SK</th>
                <th class="px-6 py-3 text-left text-sm font-semibold">Anggota</th>
                <th class="px-6 py-3 text-center text-sm font-semibold">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($rayons as $rayon)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 font-semibold text-gray-900">{{ $rayon->name }}</td>
                    <td class="px-6 py-4 text-sm">{{ $rayon->korwil->name }}</td>
                    <td class="px-6 py-4 text-sm font-mono">{{ $rayon->nomor_sk ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm">{{ $rayon->anggota_count ?? $rayon->anggota->count() }} anggota</td>
                    <td class="px-6 py-4 text-center">
                        <a href="{{ route('admin.rayon.edit', $rayon) }}" class="inline-block px-3 py-1 text-sm bg-green-600 text-white rounded hover:bg-green-700 mr-2">
                            Edit
                        </a>
                        <form method="POST" action="{{ route('admin.rayon.destroy', $rayon) }}" class="inline-block" onsubmit="return confirm('Yakin hapus?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1 text-sm bg-red-600 text-white rounded hover:bg-red-700">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                        Belum ada data Rayon
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6 flex justify-center">
    {{ $rayons->links() }}
</div>
@endsection
