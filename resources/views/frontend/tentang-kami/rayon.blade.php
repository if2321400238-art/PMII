@extends('layouts.app')

@section('title', 'Rayon - PMII Komisariat UNUJA')

@section('content')
<div class="">
    <h1 class="text-4xl font-bold mb-4">Daftar Rayon</h1>
    <p class="text-gray-600 text-lg mb-6">Daftar Rayon di bawah Komisariat Universitas Nurul Jadid</p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        @forelse($rayons as $rayon)
            @php
                $instagram = trim((string) $rayon->instagram);
                $tiktok = trim((string) $rayon->tiktok);

                $instagramUrl = $instagram
                    ? (str_starts_with($instagram, 'http://') || str_starts_with($instagram, 'https://')
                        ? $instagram
                        : 'https://instagram.com/' . ltrim($instagram, '@/'))
                    : null;

                $tiktokUrl = $tiktok
                    ? (str_starts_with($tiktok, 'http://') || str_starts_with($tiktok, 'https://')
                        ? $tiktok
                        : 'https://tiktok.com/@' . ltrim($tiktok, '@/'))
                    : null;
            @endphp
            <div class="bg-white rounded-lg shadow-md p-8 border-t-4 border-blue-600 hover:shadow-lg transition">
               <div class="mb-4 flex items-center gap-3">
                    @if($rayon->logo_path)
                        <img src="{{ asset('storage/' . $rayon->logo_path) }}" alt="Logo {{ $rayon->name }}" class="w-14 h-14 rounded-lg object-contain border border-gray-200 p-1 bg-white">
                    @endif
                    <h2 class="text-2xl font-bold text-blue-600">{{ $rayon->name }}</h2>
                </div>

                <div class="space-y-4 mb-6">
                    @if($rayon->contact)
                        <div>
                            <p class="text-sm text-gray-600 font-semibold">Kontak</p>
                            <p class="text-lg text-gray-900">📞 {{ $rayon->contact }}</p>
                        </div>
                    @endif

                    @if($rayon->description)
                        <div>
                            <p class="text-sm text-gray-600 font-semibold">Deskripsi</p>
                            <p class="text-gray-700">{{ $rayon->description }}</p>
                        </div>
                    @endif

                    @if($instagramUrl || $tiktokUrl)
                        <div>
                            <p class="text-sm text-gray-600 font-semibold">Media Sosial</p>
                            <div class="mt-2 flex items-center gap-2">
                                @if($instagramUrl)
                                    <a href="{{ $instagramUrl }}" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-lg bg-[#0f172a] border border-white/20 flex items-center justify-center hover:bg-blue-700 transition group" aria-label="Instagram {{ $rayon->name }}" title="Instagram">
                                        <svg class="w-4 h-4 text-white/70 group-hover:text-white" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                        </svg>
                                    </a>
                                @endif
                                @if($tiktokUrl)
                                    <a href="{{ $tiktokUrl }}" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-lg bg-[#0f172a] border border-white/20 flex items-center justify-center hover:bg-blue-700 transition group" aria-label="TikTok {{ $rayon->name }}" title="TikTok">
                                        <svg class="w-4 h-4 text-white/70 group-hover:text-white" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-5.2 1.74 2.89 2.89 0 012.31-4.64 2.93 2.93 0 01.88.13V9.4a6.84 6.84 0 00-1-.05A6.33 6.33 0 005 20.1a6.34 6.34 0 0010.86-4.43v-7a8.16 8.16 0 004.77 1.52v-3.4a4.85 4.85 0 01-1-.1z"/>
                                        </svg>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <p class="text-gray-500 text-lg">Belum ada data Rayon</p>
            </div>
        @endforelse
    </div>

    <div class="mt-12 flex justify-center">
        {{ $rayons->links() }}
    </div>
</div>
@endsection
