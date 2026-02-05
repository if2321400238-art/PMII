@extends('layouts.admin')

@section('title', 'Detail SK Pengajuan - Admin ISKAB')
@section('page_title', 'Detail SK Pengajuan')

@section('content')
@php
    $role = auth()->user()->role ?? (auth()->guard('korwil')->check() ? 'korwil_admin' : (auth()->guard('rayon')->check() ? 'rayon_admin' : null));
    $isAdmin = in_array($role, ['admin', 'pb']);
@endphp

<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('admin.sk-pengajuan.index') }}" class="text-blue-600 hover:text-blue-700 font-medium flex items-center mb-4">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali ke Daftar
            </a>
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $pengajuan->nama }}</h1>
                    <p class="text-gray-600 mt-2">
                        @if($pengajuan->tipe === 'korwil')
                            <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full bg-blue-100 text-blue-800">Korwil: {{ $pengajuan->korwil->name }}</span>
                        @else
                            <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full bg-purple-100 text-purple-800">Rayon: {{ $pengajuan->rayon->name }}</span>
                        @endif
                    </p>
                </div>
                <div>
                    @if($pengajuan->status === 'approved')
                        <span class="inline-block px-4 py-2 rounded-full text-sm font-semibold bg-green-100 text-green-800">Disetujui</span>
                    @elseif($pengajuan->status === 'pending')
                        <span class="inline-block px-4 py-2 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800">Pending</span>
                    @elseif($pengajuan->status === 'rejected')
                        <span class="inline-block px-4 py-2 rounded-full text-sm font-semibold bg-red-100 text-red-800">Ditolak</span>
                    @else
                        <span class="inline-block px-4 py-2 rounded-full text-sm font-semibold bg-blue-100 text-blue-800">Revisi</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column - Details -->
            <div class="lg:col-span-2">
                <!-- Info Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pengajuan</h2>
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-gray-600">Tanggal Pengajuan</p>
                            <p class="text-base font-semibold text-gray-900">{{ $pengajuan->created_at->format('d F Y H:i') }}</p>
                        </div>
                        @if($pengajuan->deskripsi)
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Deskripsi</p>
                                <p class="text-gray-700">{{ $pengajuan->deskripsi }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Document Card -->
                @if($pengajuan->dokumen)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
                        <div class="bg-gradient-to-r from-blue-50 to-blue-100 border-b border-blue-200 p-4">
                            <h3 class="font-semibold text-blue-900 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                </svg>
                                Dokumen SK
                            </h3>
                        </div>
                        <div class="p-4">
                            <a href="{{ asset('storage/' . $pengajuan->dokumen) }}" target="_blank"
                               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                                Download Dokumen
                            </a>
                        </div>
                    </div>
                @endif

                <!-- Notes Card -->
                @if($pengajuan->catatan_revisi)
                    <div class="bg-yellow-50 border-l-4 border-yellow-500 rounded-lg p-4 mb-6">
                        <h3 class="font-semibold text-yellow-900 mb-2">Catatan Revisi/Penolakan</h3>
                        <p class="text-yellow-800">{{ $pengajuan->catatan_revisi }}</p>
                    </div>
                @endif
            </div>

            <!-- Right Column - Actions -->
            <div>
                <!-- Status Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
                    <h3 class="font-semibold text-gray-900 mb-4">Status Pengajuan</h3>
                    <div class="space-y-2">
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Status</p>
                            <p class="font-semibold text-gray-900">
                                @if($pengajuan->status === 'approved') Disetujui
                                @elseif($pengajuan->status === 'pending') Menunggu Approval
                                @elseif($pengajuan->status === 'rejected') Ditolak
                                @else Perlu Revisi @endif
                            </p>
                        </div>
                        @if($pengajuan->status === 'approved' && $pengajuan->approvedBy)
                            <div>
                                <p class="text-xs text-gray-500 uppercase tracking-wide">Disetujui Oleh</p>
                                <p class="font-semibold text-gray-900">{{ $pengajuan->approvedBy->name ?? 'Admin' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase tracking-wide">Tanggal Approval</p>
                                <p class="font-semibold text-gray-900">{{ $pengajuan->approved_at?->format('d M Y H:i') }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Admin Actions -->
                @if($isAdmin && $pengajuan->status === 'pending')
                    <div class="space-y-4">
                        <!-- Approve Button -->
                        <form method="POST" action="{{ route('admin.sk-pengajuan.approve', $pengajuan) }}">
                            @csrf
                            <button type="submit"
                                    onclick="return confirm('Setujui pengajuan SK ini?')"
                                    class="w-full px-4 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-lg hover:from-green-700 hover:to-green-800 transition font-semibold flex items-center justify-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Setujui
                            </button>
                        </form>

                        <!-- Revise Button & Form -->
                        <button type="button" onclick="toggleReviseForm()" class="w-full px-4 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition font-semibold flex items-center justify-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Minta Revisi
                        </button>

                        <!-- Reject Button & Form -->
                        <button type="button" onclick="toggleRejectForm()" class="w-full px-4 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-lg hover:from-red-700 hover:to-red-800 transition font-semibold flex items-center justify-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Tolak
                        </button>
                    </div>
                @elseif($pengajuan->status === 'approved')
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                        <div class="flex items-center text-green-800">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="font-semibold">Pengajuan Telah Disetujui</span>
                        </div>
                    </div>
                @else
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                        <p class="text-gray-600 font-medium text-center">Tidak ada aksi yang tersedia</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Revise Form Modal -->
        <div id="revise-form-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-xl shadow-xl max-w-md w-full mx-4">
                <div class="bg-gradient-to-r from-blue-50 to-blue-100 border-b border-blue-200 px-6 py-4">
                    <h3 class="font-semibold text-blue-900 text-lg">Minta Revisi</h3>
                </div>
                <form method="POST" action="{{ route('admin.sk-pengajuan.revise', $pengajuan) }}" class="p-6">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Catatan Revisi</label>
                        <textarea name="catatan_revisi" rows="4" required
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                  placeholder="Jelaskan apa yang perlu direvisi..."></textarea>
                    </div>
                    <div class="flex gap-2 justify-end">
                        <button type="button" onclick="toggleReviseForm()" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold">
                            Kirim
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Reject Form Modal -->
        <div id="reject-form-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-xl shadow-xl max-w-md w-full mx-4">
                <div class="bg-gradient-to-r from-red-50 to-red-100 border-b border-red-200 px-6 py-4">
                    <h3 class="font-semibold text-red-900 text-lg">Tolak Pengajuan</h3>
                </div>
                <form method="POST" action="{{ route('admin.sk-pengajuan.reject', $pengajuan) }}" class="p-6">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Alasan Penolakan</label>
                        <textarea name="catatan_revisi" rows="4" required
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                  placeholder="Jelaskan alasan penolakan pengajuan..."></textarea>
                    </div>
                    <div class="flex gap-2 justify-end">
                        <button type="button" onclick="toggleRejectForm()" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                            Batal
                        </button>
                        <button type="submit" onclick="return confirm('Tolak pengajuan SK ini?')" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-semibold">
                            Tolak
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function toggleReviseForm() {
    document.getElementById('revise-form-modal').classList.toggle('hidden');
}

function toggleRejectForm() {
    document.getElementById('reject-form-modal').classList.toggle('hidden');
}
</script>
@endsection
