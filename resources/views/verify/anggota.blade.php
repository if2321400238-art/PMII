@extends('layouts.app')

@section('title', 'Verifikasi Anggota - ' . $anggota->nama)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-blue-100 py-12">
    <div class="max-w-lg mx-auto px-4">
        <!-- Success Badge -->
        <div class="text-center mb-6">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-green-100 mb-4" aria-hidden="true">
                <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-green-800">Anggota Terverifikasi</h1>
            <p class="text-gray-700 mt-2">Data anggota ini terdaftar secara resmi</p>
        </div>

        <!-- Member Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-800 to-blue-900 px-6 py-4 text-center">
                <h2 class="text-white font-bold text-lg">KARTU TANDA ANGGOTA</h2>
                <p class="text-blue-100 text-sm">PMII Komisariat Universitas Nurul Jadid</p>
            </div>

            <!-- Photo & Info -->
            <div class="p-6">
                <div class="flex flex-col md:flex-row gap-6">
                    <!-- Photo -->
                    <div class="flex-shrink-0 mx-auto md:mx-0">
                        @if($anggota->foto)
                            <img src="{{ asset('storage/' . $anggota->foto) }}"
                                 alt="Foto {{ $anggota->nama }}"
                                 class="w-32 h-40 object-cover rounded-lg border-4 border-blue-100 shadow-md">
                        @else
                            <div class="w-32 h-40 bg-gray-200 rounded-lg flex items-center justify-center border-4 border-blue-100" role="img" aria-label="Tidak ada foto">
                                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                        @endif
                    </div>

                    <!-- Info -->
                    <div class="flex-grow text-center md:text-left">
                        <h3 class="text-xl font-bold text-gray-900 mb-1">{{ $anggota->nama }}</h3>
                        <div class="inline-block bg-blue-100 text-blue-900 px-3 py-1 rounded-full text-sm font-semibold mb-4">
                            No. {{ $anggota->nomor_anggota }}
                        </div>

                        <dl class="space-y-2 text-sm text-gray-700">
                            @if($anggota->pondok)
                            <div class="flex items-center justify-center md:justify-start gap-2">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                <dt class="sr-only">Pondok</dt>
                                <dd>{{ $anggota->pondok }}</dd>
                            </div>
                            @endif

                            @if($anggota->rayon)
                            <div class="flex items-center justify-center md:justify-start gap-2">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <dt class="sr-only">Rayon</dt>
                                <dd>Rayon {{ $anggota->rayon->name }}</dd>
                            </div>
                            @endif

                            @if($anggota->korwil)
                            <div class="flex items-center justify-center md:justify-start gap-2">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <dt class="sr-only">Korwil</dt>
                                <dd>{{ $anggota->korwil->name }}</dd>
                            </div>
                            @endif

                            @if($anggota->alamat)
                            <div class="flex items-start justify-center md:justify-start gap-2 mt-2">
                                <svg class="w-4 h-4 text-blue-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                <dt class="sr-only">Alamat</dt>
                                <dd class="text-left">{{ $anggota->alamat }}</dd>
                            </div>
                            @endif
                        </dl>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="bg-gray-50 px-6 py-4 border-t text-center">
                <p class="text-sm text-gray-600">
                    Diverifikasi pada {{ now()->isoFormat('dddd, D MMMM Y, HH:mm') }} WIB
                </p>
            </div>
        </div>

        <!-- Back Link -->
        <div class="text-center mt-6">
            <a href="{{ route('home') }}" class="inline-flex items-center justify-center min-h-[48px] px-6 py-3 text-blue-700 hover:text-blue-900 hover:bg-blue-100 font-semibold rounded-lg transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection
