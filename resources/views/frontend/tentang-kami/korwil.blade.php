@extends('layouts.app')

@section('title', 'Korwil - ISKAB')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 pt-28 md:pt-32">
    <h1 class="text-4xl font-bold mb-4">Koordinator Wilayah (Korwil)</h1>
    <!-- Pencarian -->
    <form method="GET" class="mb-10">
        <div class="flex flex-col sm:flex-row gap-4">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama korwil, wilayah, atau nomor SK"
                class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
            <div class="flex gap-3">
                <button type="submit" class="px-5 py-3 bg-orange-600 text-white rounded-lg hover:bg-orange-700">Cari</button>
                @if(request()->filled('q'))
                    <a href="{{ route('about.korwil') }}" class="px-5 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Reset</a>
                @endif
            </div>
        </div>
    </form>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        @forelse($korwils as $korwil)
            <div class="bg-white rounded-lg shadow-md p-8 border-t-4 border-green-600 hover:shadow-lg transition">
                <div class="flex items-center justify-between gap-3 mb-2">
                    <h2 class="text-2xl font-bold text-green-600">{{ $korwil->name }}</h2>
                    <div class="flex flex-wrap gap-2">
                        @if(!$korwil->nomor_sk)
                            <span class="px-3 py-1 text-xs font-semibold bg-red-100 text-red-700 rounded-full">Belum ada SK</span>
                        @else
                            <span class="px-3 py-1 text-xs font-semibold bg-green-100 text-green-700 rounded-full">Sudah SK</span>
                        @endif
                        @php
                            $incomplete = !$korwil->wilayah || !$korwil->tanggal_sk || !$korwil->contact;
                        @endphp
                        @if($incomplete)
                            <span class="px-3 py-1 text-xs font-semibold bg-yellow-100 text-yellow-800 rounded-full">Data belum lengkap</span>
                        @endif
                    </div>
                </div>

                <div class="space-y-4 mb-6">
                    <div>
                        <p class="text-sm text-gray-600 font-semibold">Wilayah</p>
                        <p class="text-lg text-gray-900">{{ $korwil->wilayah }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-600 font-semibold">Nomor SK</p>
                        <p class="text-lg font-mono text-gray-900">{{ $korwil->nomor_sk ?? 'Belum ditetapkan' }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-600 font-semibold">Tanggal SK</p>
                        <p class="text-lg text-gray-900">{{ $korwil->tanggal_sk?->format('d F Y') ?? 'Belum ditetapkan' }}</p>
                    </div>

                    @if($korwil->contact)
                        <div>
                            <p class="text-sm text-gray-600 font-semibold">Kontak</p>
                            <p class="text-lg text-gray-900">📞 {{ $korwil->contact }}</p>
                        </div>
                    @endif

                    @if($korwil->description)
                        <div>
                            <p class="text-sm text-gray-600 font-semibold">Deskripsi</p>
                            <p class="text-gray-700">{{ $korwil->description }}</p>
                        </div>
                    @endif
                </div>

                <div class="border-t pt-6">
                    <div class="flex items-center justify-between mb-3">
                        <p class="font-semibold text-gray-900">Rayon di Wilayah Ini</p>
                        <span class="text-sm text-gray-600">{{ $korwil->rayons->count() }} rayon</span>
                    </div>
                    @if($korwil->rayons->count() > 0)
                        <ul class="space-y-2">
                            @foreach($korwil->rayons as $rayon)
                                <li class="flex items-start text-sm text-gray-700">
                                    <span class="text-green-600 mr-2">✓</span>
                                    <span>
                                        <strong>{{ $rayon->name }}</strong>
                                        <span class="text-xs text-gray-600 ml-2">{{ $rayon->nomor_sk ? 'SK: ' . $rayon->nomor_sk : 'Belum SK' }}</span>
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-sm text-gray-500">Belum ada data rayon.</p>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <p class="text-gray-500 text-lg">Belum ada data Korwil</p>
            </div>
        @endforelse
    </div>

    <div class="mt-12 flex justify-center">
        {{ $korwils->links() }}
    </div>
</div>
@endsection
