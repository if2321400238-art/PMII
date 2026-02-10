@extends('layouts.app')

@section('title', 'Rayon - PMII Komisariat UNUJA')

@section('content')
<div class="">
    <h1 class="text-4xl font-bold mb-4">Daftar Rayon</h1>
    <p class="text-gray-600 text-lg mb-6">Daftar Rayon di bawah Komisariat Universitas Nurul Jadid</p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        @forelse($rayons as $rayon)
            <div class="bg-white rounded-lg shadow-md p-8 border-t-4 border-blue-600 hover:shadow-lg transition">
               <div class="mb-4">
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
