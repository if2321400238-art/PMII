@extends('layouts.admin')

@section('title', 'Detail SK Pengajuan - Admin ISKAB')
@section('page_title', 'Detail SK Pengajuan')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-8 mb-6">
        <div class="mb-6 pb-6 border-b">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h1 class="text-3xl font-bold">{{ $pengajuan->nama }}</h1>
                    <p class="text-gray-600">Tipe: {{ ucfirst($pengajuan->tipe) }}</p>
                </div>
                <span class="inline-block px-4 py-2 rounded-full text-lg font-semibold {{
                    $pengajuan->status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                    ($pengajuan->status === 'approved' ? 'bg-green-100 text-green-800' :
                    ($pengajuan->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800'))
                }}">
                    {{ ucfirst($pengajuan->status) }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-6 mb-8">
            <div>
                <p class="text-sm text-gray-600 font-semibold">Alamat</p>
                <p class="text-lg">{{ $pengajuan->alamat ?? '-' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600 font-semibold">Pondok</p>
                <p class="text-lg">{{ $pengajuan->pondok ?? '-' }}</p>
            </div>
            @if($pengajuan->korwil)
                <div>
                    <p class="text-sm text-gray-600 font-semibold">Korwil</p>
                    <p class="text-lg">{{ $pengajuan->korwil->name }}</p>
                </div>
            @endif
            @if($pengajuan->rayon)
                <div>
                    <p class="text-sm text-gray-600 font-semibold">Rayon</p>
                    <p class="text-lg">{{ $pengajuan->rayon->name }}</p>
                </div>
            @endif
            <div>
                <p class="text-sm text-gray-600 font-semibold">Diajukan Oleh</p>
                <p class="text-lg">{{ $pengajuan->submittedBy->name }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600 font-semibold">Tanggal Pengajuan</p>
                <p class="text-lg">{{ $pengajuan->created_at->format('d F Y H:i') }}</p>
            </div>
        </div>

        @if($pengajuan->file_pendukung)
            <div class="mb-8 p-4 bg-blue-50 rounded-lg">
                <p class="text-sm font-semibold text-gray-700 mb-2">File Pendukung:</p>
                <a href="{{ asset('storage/' . $pengajuan->file_pendukung) }}" target="_blank" class="text-blue-600 hover:text-blue-700 font-semibold">
                    📎 Buka File
                </a>
            </div>
        @endif

        @if($pengajuan->catatan_revisi)
            <div class="mb-8 p-4 bg-yellow-50 rounded-lg border-l-4 border-yellow-500">
                <p class="text-sm font-semibold text-gray-700 mb-2">Catatan/Revisi:</p>
                <p class="text-gray-700">{{ $pengajuan->catatan_revisi }}</p>
            </div>
        @endif

        @if($pengajuan->status === 'pending')
            <div class="bg-gray-50 p-6 rounded-lg">
                <h3 class="text-xl font-bold mb-4">Ambil Tindakan</h3>

                <!-- Approve Form -->
                <form method="POST" action="{{ route('admin.sk-pengajuan.approve', $pengajuan) }}" class="mb-4">
                    @csrf
                    <button type="submit" class="w-full px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 font-semibold text-lg" onclick="return confirm('Setujui pengajuan ini?')">
                        Setujui Pengajuan
                    </button>
                </form>

                <!-- Revise Form -->
                <form method="POST" action="{{ route('admin.sk-pengajuan.revise', $pengajuan) }}" class="mb-4">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-semibold mb-2">Catatan Revisi</label>
                        <textarea name="catatan_revisi" rows="4" placeholder="Masukkan catatan untuk revisi" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required></textarea>
                    </div>
                    <button type="submit" class="w-full px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 font-semibold text-lg">
                        Minta Revisi
                    </button>
                </form>

                <!-- Reject Form -->
                <form method="POST" action="{{ route('admin.sk-pengajuan.reject', $pengajuan) }}">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-semibold mb-2">Alasan Penolakan</label>
                        <textarea name="catatan_revisi" rows="4" placeholder="Masukkan alasan penolakan" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required></textarea>
                    </div>
                    <button type="submit" class="w-full px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 font-semibold text-lg" onclick="return confirm('Tolak pengajuan ini?')">
                        ❌ Tolak Pengajuan
                    </button>
                </form>
            </div>
        @else
            <div class="p-6 rounded-lg {{ $pengajuan->status === 'approved' ? 'bg-green-50' : 'bg-gray-50' }}">
                <p class="font-semibold text-gray-700 mb-2">
                    {{ $pengajuan->status === 'approved' ? 'Pengajuan Telah Disetujui' : 'Status: ' . ucfirst($pengajuan->status) }}
                </p>
                @if($pengajuan->approvedBy)
                    <p class="text-sm text-gray-600">Oleh: {{ $pengajuan->approvedBy->name }}</p>
                    <p class="text-sm text-gray-600">Tanggal: {{ $pengajuan->approved_at?->format('d F Y H:i') }}</p>
                @endif
            </div>
        @endif
    </div>

    <a href="{{ route('admin.sk-pengajuan.index') }}" class="inline-block px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 font-semibold">
        ← Kembali
    </a>
</div>
@endsection
