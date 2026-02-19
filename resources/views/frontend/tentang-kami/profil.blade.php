@extends('layouts.app')

@section('title', 'Profil Organisasi - PMII Komisariat UNUJA')

@section('content')
    <div class="">
        @if ($profil)
            <!-- Logo & Nama -->
            <div class="text-center mb-12">
                <div class="flex justify-center items-center mb-8">
                    <img src="{{ asset('images/logo-pmii.png') }}" alt="Logo PMII"
                        style="width: 100px; height: 100px; border-radius: 9999px; object-fit: cover; border: 4px solid #facc15; box-shadow: 0 0 30px rgba(234, 179, 8, 0.6), inset 0 0 20px rgba(234, 179, 8, 0.2), 0 25px 50px -12px rgba(0, 0, 0, 0.25);" class="mx-auto">
                </div>
                <h1 class="text-4xl font-bold">{{ $profil->nama_organisasi }}</h1>
            </div>

            <!-- Sejarah -->
            <section class="mb-12">
                <h2 class="text-3xl font-bold mb-4 text-blue-600">Sejarah</h2>
                <div class="bg-white rounded-lg shadow-md p-8">
                    {!! nl2br($profil->sejarah) !!}
                </div>
            </section>

            <!-- Visi -->
            <section class="mb-12">
                <h2 class="text-3xl font-bold mb-4 text-blue-600">Visi</h2>
                <div class="bg-emerald-50 rounded-lg shadow-md p-8 border-l-4 border-blue-600">
                    {!! nl2br($profil->visi) !!}
                </div>
            </section>

            <!-- Misi -->
            <section class="mb-12">
                <h2 class="text-3xl font-bold mb-4 text-blue-600">Misi</h2>
                <div class="bg-blue-50 rounded-lg shadow-md p-8 border-l-4 border-blue-600">
                    @if (is_array($profil->misi))
                        <ul class="space-y-3">
                            @foreach ($profil->misi as $m)
                                <li class="flex items-start">
                                    <span class="text-blue-600 font-bold mr-4">✓</span>
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
            @if ($profil->struktur_organisasi)
                <section class="mb-12">
                    <h2 class="text-3xl font-bold mb-4 text-blue-600">Struktur Organisasi</h2>
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
        <div class="mt-16 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg shadow-lg p-8 text-center">
            <h3 class="text-2xl font-bold mb-4">Ingin Bergabung?</h3>
            <p class="text-emerald-100 mb-6">Hubungi Rayon terdekat untuk informasi lebih lanjut</p>
            <a href="{{ route('about.rayon') }}"
                class="inline-block px-6 py-3 bg-white text-blue-600 rounded-lg font-semibold hover:bg-gray-100">
                Lihat Kontak Rayon
            </a>
        </div>
    </div>
@endsection
