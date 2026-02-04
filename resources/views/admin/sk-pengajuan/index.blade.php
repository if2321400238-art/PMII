@extends('layouts.admin')

@section('title', 'SK Pengajuan - Admin ISKAB')
@section('page_title', 'SK Pengajuan')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h2 class="text-2xl font-bold">
        @if(auth()->user()->role?->slug === 'bph_pb')
            Kelola Pengajuan SK
        @else
            SK Saya
        @endif
    </h2>
    @if(in_array(auth()->user()->role?->slug, ['bph_korwil', 'bph_rayon']))
        <a href="{{ route('admin.sk-pengajuan.create') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
            Ajukan SK Baru
        </a>
    @endif
</div>

<div class="bg-white rounded-lg shadow-md p-6 mb-6"
        <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="revised" {{ request('status') == 'revised' ? 'selected' : '' }}>Revised</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>
            <div>
                <select name="tipe" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    <option value="">Semua Tipe</option>
                    <option value="korwil" {{ request('tipe') == 'korwil' ? 'selected' : '' }}>Korwil</option>
                    <option value="rayon" {{ request('tipe') == 'rayon' ? 'selected' : '' }}>Rayon</option>
                </select>
            </div>
            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                Filter
            </button>
        </form>
    </div>
</div>

<div class="space-y-4">
    @forelse($pengajuan as $sk)
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 {{ $sk->status === 'pending' ? 'border-yellow-500' : ($sk->status === 'approved' ? 'border-green-500' : ($sk->status === 'rejected' ? 'border-red-500' : 'border-blue-500')) }}">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h3 class="text-xl font-bold">{{ $sk->nama }}</h3>
                    <p class="text-sm text-gray-600">
                        <strong>Tipe:</strong> {{ ucfirst($sk->tipe) }} |
                        <strong>Pengajuan:</strong> {{ $sk->created_at->format('d M Y') }} |
                        <strong>Oleh:</strong> {{ $sk->submittedBy->name }}
                    </p>
                </div>
                <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold {{
                    $sk->status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                    ($sk->status === 'approved' ? 'bg-green-100 text-green-800' :
                    ($sk->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800'))
                }}">
                    {{ ucfirst($sk->status) }}
                </span>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4 text-sm text-gray-600">
                @if($sk->alamat)
                    <div>
                        <strong>Alamat:</strong>
                        <p>{{ $sk->alamat }}</p>
                    </div>
                @endif
                @if($sk->pondok)
                    <div>
                        <strong>Pondok:</strong>
                        <p>{{ $sk->pondok }}</p>
                    </div>
                @endif
                @if($sk->korwil)
                    <div>
                        <strong>Korwil:</strong>
                        <p>{{ $sk->korwil->name }}</p>
                    </div>
                @endif
                @if($sk->rayon)
                    <div>
                        <strong>Rayon:</strong>
                        <p>{{ $sk->rayon->name }}</p>
                    </div>
                @endif
            </div>

            @if($sk->catatan_revisi)
                <div class="mb-4 p-4 bg-blue-50 rounded-lg">
                    <p class="text-sm"><strong>Catatan:</strong></p>
                    <p class="text-sm text-gray-700">{{ $sk->catatan_revisi }}</p>
                </div>
            @endif

            @if($sk->file_pendukung)
                <div class="mb-4">
                    <a href="{{ asset('storage/' . $sk->file_pendukung) }}" target="_blank" class="text-blue-600 hover:text-blue-700 text-sm font-semibold">
                        📎 Lihat File Pendukung
                    </a>
                </div>
            @endif

            <div class="flex gap-2">
                <a href="{{ route('admin.sk-pengajuan.show', $sk) }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm font-semibold">
                    Detail
                </a>
                @if($sk->status === 'pending')
                    <form method="POST" action="{{ route('admin.sk-pengajuan.approve', $sk) }}" class="inline">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm font-semibold" onclick="return confirm('Setujui pengajuan ini?')">
                            Setujui
                        </button>
                    </form>
                @endif
            </div>
        </div>
    @empty
        <div class="text-center py-12 bg-white rounded-lg shadow-md">
            <p class="text-gray-500 text-lg">Tidak ada pengajuan SK</p>
        </div>
    @endforelse
</div>

<div class="mt-6 flex justify-center">
    {{ $pengajuan->links() }}
</div>
@endsection
