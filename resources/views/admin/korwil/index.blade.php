@extends('layouts.admin')

@section('title', 'Korwil - Admin ISKAB')
@section('page_title', 'Kelola Korwil')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h2 class="text-2xl font-bold">Data Korwil</h2>
    <a href="{{ route('admin.korwil.create') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
        Tambah Korwil
    </a>
</div>

<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-100 border-b">
            <tr>
                <th class="px-6 py-3 text-left text-sm font-semibold">Nama</th>
                <th class="px-6 py-3 text-left text-sm font-semibold">Wilayah</th>
                <th class="px-6 py-3 text-left text-sm font-semibold">No. SK</th>
                <th class="px-6 py-3 text-left text-sm font-semibold">Rayons</th>
                <th class="px-6 py-3 text-center text-sm font-semibold">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($korwils as $korwil)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 font-semibold text-gray-900">{{ $korwil->name }}</td>
                    <td class="px-6 py-4 text-sm">{{ $korwil->wilayah }}</td>
                    <td class="px-6 py-4 text-sm font-mono">{{ $korwil->nomor_sk ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm">{{ $korwil->rayons_count ?? $korwil->rayons->count() }} rayon</td>
                    <td class="px-6 py-4 text-center">
                        <a href="{{ route('admin.korwil.edit', $korwil) }}" class="inline-block px-3 py-1 text-sm bg-green-600 text-white rounded hover:bg-green-700 mr-2">
                            Edit
                        </a>
                        <form method="POST" action="{{ route('admin.korwil.destroy', $korwil) }}" class="inline-block" onsubmit="return confirm('Yakin hapus?')">
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
                        Belum ada data Korwil
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6 flex justify-center">
    {{ $korwils->links() }}
</div>
@endsection
