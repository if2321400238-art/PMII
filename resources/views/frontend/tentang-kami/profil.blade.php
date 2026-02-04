@extends('layouts.app')

@section('title', 'Profil Organisasi - ISKAB')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-12 md:pt-40">
    @if($profil)
        <!-- Logo & Nama -->
        <div class="text-center mb-12">
            @if($profil->logo_path)
                <img src="{{ asset('storage/' . $profil->logo_path) }}" alt="Logo" class="w-32 h-32 mx-auto mb-4">
            @else
                <div class="w-32 h-32 mx-auto mb-4 bg-green-100 rounded-full flex items-center justify-center">
                    <span class="text-6xl">📚</span>
                </div>
            @endif
            <h1 class="text-4xl font-bold">{{ $profil->nama_organisasi }}</h1>
        </div>

        <!-- Sejarah -->
        <section class="mb-12">
            <h2 class="text-3xl font-bold mb-4 text-green-600">Sejarah</h2>
            <div class="bg-white rounded-lg shadow-md p-8">
                {!! nl2br($profil->sejarah) !!}
            </div>
        </section>

        <!-- Visi -->
        <section class="mb-12">
            <h2 class="text-3xl font-bold mb-4 text-green-600">Visi</h2>
            <div class="bg-green-50 rounded-lg shadow-md p-8 border-l-4 border-green-600">
                {!! nl2br($profil->visi) !!}
            </div>
        </section>

        <!-- Misi -->
        <section class="mb-12">
            <h2 class="text-3xl font-bold mb-4 text-green-600">Misi</h2>
            <div class="bg-blue-50 rounded-lg shadow-md p-8 border-l-4 border-blue-600">
                @if(is_array($profil->misi))
                    <ul class="space-y-3">
                        @foreach($profil->misi as $m)
                            <li class="flex items-start">
                                <span class="text-green-600 font-bold mr-4">✓</span>
                                <span>{{ $m }}</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    {!! nl2br($profil->misi) !!}
                @endif
            </div>
        </section>

        <!-- Struktur Organisasi -->
        @if($profil->struktur_organisasi)
            <section class="mb-12">
                <h2 class="text-3xl font-bold mb-4 text-green-600">Struktur Organisasi</h2>
                <div class="bg-white rounded-lg shadow-md p-8">
                    {!! $profil->struktur_organisasi !!}
                </div>
            </section>
        @endif
    @else
        <div class="text-center py-12">
            <p class="text-gray-500 text-lg">Data profil organisasi belum tersedia</p>
        </div>
    @endif

    <!-- CTA -->
    <div class="mt-16 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-lg shadow-lg p-8 text-center">
        <h3 class="text-2xl font-bold mb-4">Ingin Bergabung?</h3>
        <p class="text-green-100 mb-6">Hubungi Rayon atau Korwil terdekat untuk informasi lebih lanjut</p>
        <a href="{{ route('about.rayon') }}" class="inline-block px-6 py-3 bg-white text-green-600 rounded-lg font-semibold hover:bg-gray-100">
            Lihat Kontak Rayon
        </a>
    </div>
</div>
@endsection
