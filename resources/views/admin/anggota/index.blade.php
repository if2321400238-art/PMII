@extends('layouts.admin')

@section('title', 'Anggota - Admin ISKAB')
@section('page_title', 'Kelola Anggota')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h2 class="text-2xl font-bold">Data Anggota</h2>
    <a href="{{ route('admin.anggota.create') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
        Tambah Anggota
    </a>
</div>

<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <select name="korwil" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                <option value="">Semua Korwil</option>
                @foreach($korwils as $k)
                    <option value="{{ $k->id }}" {{ request('korwil') == $k->id ? 'selected' : '' }}>{{ $k->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <input type="text" name="search" placeholder="Cari nama atau nomor anggota" class="w-full px-4 py-2 border border-gray-300 rounded-lg" value="{{ request('search') }}">
        </div>
        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
            Filter
        </button>
    </form>
</div>

<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-100 border-b">
            <tr>
                <th class="px-6 py-3 text-left text-sm font-semibold">Nama</th>
                <th class="px-6 py-3 text-left text-sm font-semibold">No. Anggota</th>
                <th class="px-6 py-3 text-left text-sm font-semibold">Rayon</th>
                <th class="px-6 py-3 text-left text-sm font-semibold">Korwil</th>
                <th class="px-6 py-3 text-center text-sm font-semibold">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($anggota as $a)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <p class="font-semibold text-gray-900">{{ $a->nama }}</p>
                        @if($a->pondok)
                            <p class="text-sm text-gray-600">{{ $a->pondok }}</p>
                        @endif
                    </td>
                    <td class="px-6 py-4 font-mono text-sm">{{ $a->nomor_anggota }}</td>
                    <td class="px-6 py-4 text-sm">{{ $a->rayon->name }}</td>
                    <td class="px-6 py-4 text-sm">{{ $a->korwil->name }}</td>
                    <td class="px-6 py-4 text-center">
                        <a href="{{ route('admin.anggota.edit', $a) }}" class="inline-block px-3 py-1 text-sm bg-green-600 text-white rounded hover:bg-green-700 mr-2">
                            Edit
                        </a>
                        <a href="{{ route('admin.anggota.download-kta', $a) }}" class="inline-block px-3 py-1 text-sm bg-blue-600 text-white rounded hover:bg-blue-700 mr-2">
                            📥 KTA
                        </a>
                        <form method="POST" action="{{ route('admin.anggota.destroy', $a) }}" class="inline-block" onsubmit="return confirm('Yakin hapus?')">
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
                        Belum ada data anggota
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6 flex justify-center">
    {{ $anggota->links() }}
</div>
@endsection
