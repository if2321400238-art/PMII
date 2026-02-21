@extends('layouts.admin')

@section('title', 'SK Pengajuan - Admin PMII')
@section('page_title', 'SK Pengajuan')

@section('content')
@php
    $role = auth()->user()->role_slug
    ?? (auth()->guard('rayon')->check() ? 'rayon' : null);
@endphp
<div class="container mx-auto px-4 py-4 md:py-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-4 md:mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">
                    @if(in_array($role, ['admin']))
                        Kelola Pengajuan SK
                    @else
                        SK Saya
                    @endif
                </h1>
                <p class="text-gray-600 text-sm md:text-base mt-1">Kelola pengajuan Surat Keputusan organisasi</p>
            </div>
            @if(in_array($role, ['admin']))
                <a href="{{ route('admin.sk-pengajuan.create') }}"
                   class="px-4 md:px-6 py-2 md:py-3 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-lg hover:from-green-700 hover:to-green-800 transition font-medium shadow-lg shadow-green-500/30 flex items-center justify-center text-sm md:text-base w-full sm:w-auto">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Ajukan SK Baru
                </a>
            @endif
        </div>

        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded mb-4 md:mb-6 flex items-center" role="alert">
                <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Filter -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-3 md:p-4 mb-4 md:mb-6">
            <form method="GET" class="flex flex-col sm:flex-row gap-2 sm:gap-3 items-start sm:items-center flex-wrap">
                <span class="text-sm font-semibold text-gray-700">Filter:</span>
                <div class="flex flex-wrap gap-2 w-full sm:w-auto">
                    <label for="filter-status" class="sr-only">Filter berdasarkan status</label>
                    <select id="filter-status" name="status" class="flex-1 sm:flex-none border-gray-300 rounded-lg px-3 md:px-4 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                        <option value="revised" {{ request('status') == 'revised' ? 'selected' : '' }}>Revisi</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                    <label for="filter-tipe" class="sr-only">Filter berdasarkan tipe</label>
                    <select id="filter-tipe" name="tipe" class="flex-1 sm:flex-none border-gray-300 rounded-lg px-3 md:px-4 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500" onchange="this.form.submit()">
                        <option value="">Semua Tipe</option>
                        <option value="korwil" {{ request('tipe') == 'korwil' ? 'selected' : '' }}>Korwil</option>
                        <option value="rayon" {{ request('tipe') == 'rayon' ? 'selected' : '' }}>Rayon</option>
                    </select>
                </div>
                @if(request()->has('status') || request()->has('tipe'))
                    <a href="{{ route('admin.sk-pengajuan.index') }}" class="text-sm text-blue-600 hover:underline">Reset Filter</a>
                @endif
            </form>
        </div>

        <!-- Mobile Cards View -->
        <h2 class="sr-only">Daftar SK Pengajuan</h2>
        <div class="block md:hidden space-y-4">
            @forelse($pengajuan as $sk)
                <article class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                    <div class="flex justify-between items-start mb-2">
                        <div class="flex-1 min-w-0 pr-2">
                            <h3 class="font-semibold text-gray-900 text-base line-clamp-2">{{ $sk->nama }}</h3>
                            <p class="text-xs text-gray-500 mt-1 line-clamp-1">{{ Str::limit($sk->deskripsi ?? '', 50) }}</p>
                        </div>
                        <span class="flex-shrink-0 px-2.5 py-1 text-xs font-semibold rounded-full {{ $sk->tipe === 'korwil' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                            {{ ucfirst($sk->tipe) }}
                        </span>
                    </div>
                    <div class="flex flex-wrap gap-2 text-xs mb-3">
                        @if($sk->tipe === 'korwil')
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">{{ $sk->korwil->name }}</span>
                        @else
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">{{ $sk->rayon->name }}</span>
                        @endif
                        <span class="flex items-center text-gray-600">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            {{ $sk->created_at->format('d M Y') }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between mb-3">
                        @if($sk->status === 'approved')
                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Disetujui</span>
                        @elseif($sk->status === 'pending')
                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                        @elseif($sk->status === 'rejected')
                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>
                        @else
                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Revisi</span>
                        @endif
                    </div>
                    <div class="flex flex-wrap gap-2 pt-3 border-t border-gray-100">
                        @if($sk->dokumen)
                            <a href="{{ asset('storage/' . $sk->dokumen) }}" target="_blank"
                               class="flex-1 inline-flex items-center justify-center px-3 py-2 text-sm font-medium bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                                Download
                            </a>
                        @endif
                        <a href="{{ route('admin.sk-pengajuan.show', $sk) }}"
                           class="flex-1 inline-flex items-center justify-center px-3 py-2 text-sm font-medium bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            Lihat
                        </a>
                    </div>
                </article>
            @empty
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 text-center">
                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="text-gray-500 font-medium">Belum ada pengajuan SK</p>
                    <p class="text-gray-500 text-sm mt-1">Mulai dengan mengajukan Surat Keputusan baru</p>
                </div>
            @endforelse
        </div>

        <!-- Desktop Table View -->
        <div class="hidden md:block bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-green-50 to-green-100 border-b border-green-200">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Nomor SK</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Pengaju</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Tipe</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Tanggal</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($pengajuan as $sk)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-gray-900">{{ $sk->nama }}</div>
                                    <div class="text-xs text-gray-500 mt-1">{{ Str::limit($sk->deskripsi ?? '', 60) }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    @if($sk->tipe === 'korwil')
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">{{ $sk->korwil->name }}</span>
                                    @else
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">{{ $sk->rayon->name }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $sk->tipe === 'korwil' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                        {{ ucfirst($sk->tipe) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $sk->created_at->format('d M Y') }}</td>
                                <td class="px-6 py-4">
                                    @if($sk->status === 'approved')
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Disetujui</span>
                                    @elseif($sk->status === 'pending')
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                    @elseif($sk->status === 'rejected')
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>
                                    @else
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Revisi</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col gap-2">
                                        <div class="flex gap-2 justify-center">
                                            @if($sk->dokumen)
                                                <a href="{{ asset('storage/' . $sk->dokumen) }}" target="_blank"
                                                   class="inline-flex items-center px-3 py-1.5 text-xs font-medium bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition" title="Download">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                                    </svg>
                                                    Download
                                                </a>
                                            @endif
                                            <a href="{{ route('admin.sk-pengajuan.show', $sk) }}"
                                               class="inline-flex items-center px-3 py-1.5 text-xs font-medium bg-green-600 text-white rounded-lg hover:bg-green-700 transition" title="Lihat Detail">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                                Lihat
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <p class="text-gray-500 font-medium">Belum ada pengajuan SK</p>
                                        <p class="text-gray-500 text-sm mt-1">Mulai dengan mengajukan Surat Keputusan baru</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $pengajuan->links() }}
        </div>
    </div>
</div>
@endsection
