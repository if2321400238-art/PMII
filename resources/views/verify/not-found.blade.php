@extends('layouts.app')

@section('title', 'Anggota Tidak Ditemukan')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-red-50 to-red-100 py-12">
    <div class="max-w-lg mx-auto px-4">
        <!-- Error Badge -->
        <div class="text-center mb-6">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-red-100 mb-4">
                <svg class="w-12 h-12 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-red-700">Anggota Tidak Ditemukan</h1>
            <p class="text-gray-600 mt-2">Data anggota dengan nomor ini tidak terdaftar</p>
        </div>

        <!-- Error Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-4 text-center">
                <h2 class="text-white font-bold text-lg">VERIFIKASI GAGAL</h2>
                <p class="text-red-200 text-sm">KTA tidak valid atau sudah tidak berlaku</p>
            </div>

            <!-- Content -->
            <div class="p-6 text-center">
                <div class="bg-gray-100 rounded-lg p-4 mb-4">
                    <p class="text-sm text-gray-600 mb-1">Nomor yang dicari:</p>
                    <p class="text-xl font-bold text-gray-900 font-mono">{{ $nomor_anggota }}</p>
                </div>

                <div class="text-sm text-gray-600">
                    <p class="mb-2">Kemungkinan penyebab:</p>
                    <ul class="text-left list-disc list-inside space-y-1 text-gray-500">
                        <li>Nomor anggota salah atau sudah tidak berlaku</li>
                        <li>KTA palsu atau dipalsukan</li>
                        <li>Anggota sudah dinonaktifkan</li>
                    </ul>
                </div>

                <div class="mt-6 p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                    <p class="text-yellow-800 text-sm">
                        <strong>Peringatan:</strong> Jika Anda menemukan KTA yang mencurigakan,
                        silakan hubungi pengurus ISKAB untuk verifikasi lebih lanjut.
                    </p>
                </div>
            </div>

            <!-- Footer -->
            <div class="bg-gray-50 px-6 py-4 border-t text-center">
                <p class="text-xs text-gray-500">
                    Dicek pada {{ now()->isoFormat('dddd, D MMMM Y, HH:mm') }} WIB
                </p>
            </div>
        </div>

        <!-- Back Link -->
        <div class="text-center mt-6">
            <a href="{{ route('home') }}" class="text-blue-600 hover:text-blue-800 font-medium inline-flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection
