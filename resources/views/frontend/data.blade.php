@extends('layouts.app')

@section('title', 'Data - ISKAB')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 pt-28 md:pt-32">
    <!-- Statistics Section -->
    <div class="mb-16">
        <h1 class="text-4xl font-bold mb-12 text-center">Data Organisasi ISKAB</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Korwil Card -->
            <div class="bg-gradient-to-br from-blue-500 to-blue-700 text-white rounded-lg shadow-lg p-8">
                <div class="text-center">
                    <p class="text-blue-100 text-lg mb-2">Koordinator Wilayah Terdaftar</p>
                    <h2 class="text-5xl font-bold mb-4">{{ $korwilCount ?? 0 }}</h2>
                    <p class="text-blue-50">Korwil</p>
                </div>
            </div>

            <!-- Rayon Card -->
            <div class="bg-gradient-to-br from-green-500 to-green-700 text-white rounded-lg shadow-lg p-8">
                <div class="text-center">
                    <p class="text-green-100 text-lg mb-2">Rayon Terdaftar</p>
                    <h2 class="text-5xl font-bold mb-4">{{ $rayonCount ?? 0 }}</h2>
                    <p class="text-green-50">Rayon</p>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <section class="mt-16">
        <div class="bg-gradient-to-r from-green-500 to-green-600 text-white rounded-lg shadow-lg p-12">
            <div class="text-center">
                <h3 class="text-3xl font-bold mb-4">Ajukan Surat Keputusan (SK)</h3>
                <p class="text-green-100 mb-8 text-lg">
                    @auth
                        @if(in_array(auth()->user()->role?->slug, ['bph_korwil', 'bph_rayon']))
                            Anda dapat mengajukan SK melalui panel admin
                        @else
                            Hanya BPH Korwil dan BPH Rayon yang dapat mengajukan SK
                        @endif
                    @else
                        Silakan login terlebih dahulu untuk mengajukan SK Korwil atau Rayon
                    @endauth
                </p>
                @auth
                    @if(in_array(auth()->user()->role?->slug, ['bph_korwil', 'bph_rayon']))
                        <a href="{{ route('admin.sk-pengajuan.create') }}" class="inline-block px-8 py-4 bg-white text-green-600 rounded-lg font-bold text-lg hover:bg-green-50 transition">
                            Ajukan SK Baru
                        </a>
                    @else
                        <a href="{{ route('admin.dashboard') }}" class="inline-block px-8 py-4 bg-white text-green-600 rounded-lg font-bold text-lg hover:bg-green-50 transition">
                            Ke Dashboard
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="inline-block px-8 py-4 bg-white text-green-600 rounded-lg font-bold text-lg hover:bg-green-50 transition">
                        Login untuk Mengajukan SK
                    </a>
                @endauth
            </div>
        </div>
    </section>
</div>
@endsection
