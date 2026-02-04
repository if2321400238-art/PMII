@extends('layouts.app')

@section('title', 'Rayon - ISKAB')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 pt-28 md:pt-32">
    <h1 class="text-4xl font-bold mb-4">Rayon</h1>
    <p class="text-gray-600 text-lg mb-6">Daftar Rayon beserta status SK dan kelengkapan data</p>

    <!-- Pencarian -->
    <form method="GET" class="mb-10">
        <div class="flex flex-col sm:flex-row gap-4">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama rayon, korwil, atau nomor SK"
                class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <div class="flex gap-3">
                <button type="submit" class="px-5 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Cari</button>
                @if(request()->filled('q'))
                    <a href="{{ route('about.rayon') }}" class="px-5 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Reset</a>
                @endif
            </div>
        </div>
    </form>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        @forelse($rayons as $rayon)
            <div class="bg-white rounded-lg shadow-md p-8 border-t-4 border-blue-600 hover:shadow-lg transition">
                <div class="flex items-center justify-between gap-3 mb-2">
                    <h2 class="text-2xl font-bold text-blue-600">{{ $rayon->name }}</h2>
                    <div class="flex flex-wrap gap-2">
                        @if(!$rayon->nomor_sk)
                            <span class="px-3 py-1 text-xs font-semibold bg-red-100 text-red-700 rounded-full">Belum ada SK</span>
                        @else
                            <span class="px-3 py-1 text-xs font-semibold bg-green-100 text-green-700 rounded-full">Sudah SK</span>
                        @endif
                        @php
                            $incomplete = !$rayon->nomor_sk || !$rayon->tanggal_sk || !$rayon->contact;
                        @endphp
                        @if($incomplete)
                            <span class="px-3 py-1 text-xs font-semibold bg-yellow-100 text-yellow-800 rounded-full">Data belum lengkap</span>
                        @endif
                    </div>
                </div>

                <div class="space-y-4 mb-6">
                    <div>
                        <p class="text-sm text-gray-600 font-semibold">Korwil</p>
                        <p class="text-lg text-gray-900">{{ $rayon->korwil->name }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-600 font-semibold">Wilayah</p>
                        <p class="text-lg text-gray-900">{{ $rayon->korwil->wilayah }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-600 font-semibold">Nomor SK</p>
                        <p class="text-lg font-mono text-gray-900">{{ $rayon->nomor_sk ?? 'Belum ditetapkan' }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-600 font-semibold">Tanggal SK</p>
                        <p class="text-lg text-gray-900">{{ $rayon->tanggal_sk?->format('d F Y') ?? 'Belum ditetapkan' }}</p>
                    </div>

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
