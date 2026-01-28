@extends('layouts.app')

@section('title', 'Beranda - ISKAB')

@section('content')
<!-- Hero Section Full Width dari Atas dengan Rounded Bottom -->
<section class="relative bg-gradient-to-r from-green-700 to-green-800 text-white overflow-hidden rounded-b-[3rem] h-96 md:h-[600px] lg:h-[700px] pt-20">
    <!-- Background Image dengan Overlay Hijau Gelap -->
    @if($profil && $profil->hero_image)
        <div class="absolute inset-0">
            <img src="{{ asset('storage/' . $profil->hero_image) }}" alt="Hero Background" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-green-900/75"></div>
        </div>
    @else
        <div class="absolute inset-0">
            <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=1200');"></div>
            <div class="absolute inset-0 bg-green-900/75"></div>
        </div>
    @endif

    <!-- Konten Hero - Centered -->
    <div class="relative z-10 flex flex-col items-center justify-center text-center px-6 sm:px-12 lg:px-20" style="min-height: 500px;">
        <!-- Heading Besar -->
        <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-bold mb-10 leading-tight text-white">
            Website Resmi Ikatan Santri<br>Kalimantan Barat (ISKAB)
        </h1>

        <!-- Tombol CTA dengan Background Shape Masing-masing -->
        <div class="flex flex-col sm:flex-row justify-center items-center gap-4">
            <!-- Tombol Hijau dengan Background Shape -->
            <div class="relative">
                <div class="absolute inset-0 -inset-x-1 -inset-y-1 rounded-2xl" style="background-color: rgba(255, 255, 255, 0.15); backdrop-filter: blur(8px);"></div>
                <a href="{{ route('about.profil') }}"
                   class="relative px-10 py-4 bg-green-500 text-white text-base font-semibold rounded-xl hover:bg-green-600 transition-all duration-300 shadow-lg inline-block">
                    Tentang kami
                </a>
            </div>

            <!-- Tombol Putih dengan Background Shape -->
            <div class="relative">
                <div class="absolute inset-0 -inset-x-1 -inset-y-1 rounded-2xl" style="background-color: rgba(255, 255, 255, 0.15); backdrop-filter: blur(8px);"></div>
                <a href="{{ route('posts.berita') }}"
                   class="relative px-10 py-4 bg-white text-green-700 text-base font-semibold rounded-xl hover:bg-gray-50 transition-all duration-300 shadow-lg inline-block">
                    Baca Berita
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ISKAB Dalam Angka Section -->
<section class="bg-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-28">
        <h2 class="text-3xl md:text-4xl font-bold text-center text-green-700 mb-12">ISKAB dalam Angka</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="relative">
                <!-- Background Shape -->
                <div class="absolute -inset-x-1 -inset-y-1 bg-gray-200 rounded-3xl"></div>
                <!-- Card Content -->
                <div class="relative bg-gradient-to-br from-[#48D853] to-[#26722C] rounded-3xl p-8 text-center shadow-2xl transform hover:scale-105 transition">
                    <div class="text-6xl md:text-7xl font-bold text-white mb-2">{{ $stats['korwil'] }}</div>
                    <div class="text-xl font-semibold text-white uppercase tracking-wider">KORWIL</div>
                </div>
            </div>
            <div class="relative">
                <!-- Background Shape -->
                <div class="absolute -inset-x-1 -inset-y-1 bg-gray-200 rounded-3xl"></div>
                <!-- Card Content -->
                <div class="relative bg-gradient-to-br from-[#48D853] to-[#26722C] rounded-3xl p-8 text-center shadow-2xl transform hover:scale-105 transition">
                    <div class="text-6xl md:text-7xl font-bold text-white mb-2">{{ $stats['rayon'] }}</div>
                    <div class="text-xl font-semibold text-white uppercase tracking-wider">RAYON</div>
                </div>
            </div>
            <div class="relative">
                <!-- Background Shape -->
                <div class="absolute -inset-x-1 -inset-y-1 bg-gray-200 rounded-3xl"></div>
                <!-- Card Content -->
                <div class="relative bg-gradient-to-br from-[#48D853] to-[#26722C] rounded-3xl p-8 text-center shadow-2xl transform hover:scale-105 transition">
                    <div class="text-6xl md:text-7xl font-bold text-white mb-2">{{ $stats['anggota'] }}</div>
                    <div class="text-xl font-semibold text-white uppercase tracking-wider">SANTRI</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Tentang ISKAB Section -->
<section class="bg-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl md:text-4xl font-bold text-center text-green-700 mb-8">Tentang ISKAB</h2>
        <div class="max-w-5xl mx-auto">
            @if($profil)
                <p class="text-gray-700 leading-relaxed text-justify mb-4">{{ $profil->sejarah ?? 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi. Proin porttitor, orci nec nonummy molestie, enim est eleifend mi, non fermentum diam nisl sit amet erat. Duis semper. Duis arcu massa, scelerisque vitae, consequat in, pretium a, enim. Pellentesque congue.' }}</p>

                <p class="text-gray-700 leading-relaxed text-justify mb-4">{{ $profil->visi ?? 'Ut nisi nec eros. Suspendisse pulvinar tellus ac nisl. Pellentesque vitae lacus. Maecenas ullamcorper, diam vitae commodo placerat, sapien ipsum dictum eros, vel consequat massa orci vel felis. Curabitur aliquet ante vitae, consequat aliquet libero at, blandit fermentum diam. Integer quis metus vitae lobortis egestas. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vel erat non mauris convallis vehicula.' }}</p>

                <p class="text-gray-700 leading-relaxed text-justify">{{ $profil->misi ?? 'Nulla at leo nec metus aliquam semper. Sed adipiscing ornare risus. Morbi est est, blandit sit amet, sagittis vel, euismod vel, velit. Pellentesque egestas sem. Suspendisse commodo ullamcorper magna. Ut aliquam sollicitudin leo. Cras iaculis ultricies nulla. Donec quis dui at dolor tempor interdum.' }}</p>
            @else
                <p class="text-gray-700 leading-relaxed text-justify mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi. Proin porttitor, orci nec nonummy molestie, enim est eleifend mi, non fermentum diam nisl sit amet erat. Duis semper. Duis arcu massa, scelerisque vitae, consequat in, pretium a, enim. Pellentesque congue.</p>

                <p class="text-gray-700 leading-relaxed text-justify mb-4">Ut nisi nec eros. Suspendisse pulvinar tellus ac nisl. Pellentesque vitae lacus. Maecenas ullamcorper, diam vitae commodo placerat, sapien ipsum dictum eros, vel consequat massa orci vel felis. Curabitur aliquet ante vitae, consequat aliquet libero at, blandit fermentum diam. Integer quis metus vitae lobortis egestas. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vel erat non mauris convallis vehicula.</p>

                <p class="text-gray-700 leading-relaxed text-justify">Nulla at leo nec metus aliquam semper. Sed adipiscing ornare risus. Morbi est est, blandit sit amet, sagittis vel, euismod vel, velit. Pellentesque egestas sem. Suspendisse commodo ullamcorper magna. Ut aliquam sollicitudin leo. Cras iaculis ultricies nulla. Donec quis dui at dolor tempor interdum.</p>
            @endif
        </div>
    </div>
</section>

<!-- Berita Populer -->
<section class="bg-gradient-to-b from-green-600 to-green-700 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl md:text-4xl font-bold text-center text-white mb-12">Berita Populer</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse($beritaPopuler->take(3) as $post)
                <article class="bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition transform hover:-translate-y-1">
                    @if($post->thumbnail)
                        <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gradient-to-br from-green-400 to-green-600"></div>
                    @endif
                    <div class="p-6">
                        <div class="inline-block bg-green-100 text-green-700 text-xs font-semibold px-3 py-1 rounded-full mb-3">Berita ISKAB</div>
                        <h3 class="text-lg font-bold mb-2 line-clamp-2 text-gray-800">
                            <a href="{{ route('posts.show', $post->slug) }}" class="hover:text-green-600">{{ $post->title }}</a>
                        </h3>
                        <p class="text-gray-600 text-sm line-clamp-2">{{ strip_tags($post->content) }}</p>
                    </div>
                </article>
            @empty
                <div class="col-span-3 text-center">
                    <p class="text-white text-lg">Belum ada berita populer</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Pena Santri -->
<section class="bg-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl md:text-4xl font-bold text-center text-green-700 mb-12">Pena Santri</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
            @forelse($penaSantriHighlight as $index => $post)
                @if($index === 0)
                    <!-- Artikel Utama -->
                    <article class="md:col-span-2 md:row-span-2 bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition transform hover:-translate-y-1 relative">
                        @if($post->thumbnail)
                            <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-green-400 to-green-600"></div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                            <div class="inline-block bg-green-500 text-white text-xs font-semibold px-3 py-1 rounded-full mb-3">Pena Santri</div>
                            <h3 class="text-2xl font-bold mb-2">
                                <a href="{{ route('posts.show', $post->slug) }}" class="hover:text-green-300">{{ $post->title }}</a>
                            </h3>
                            <p class="text-gray-200 text-sm line-clamp-2">{{ strip_tags($post->content) }}</p>
                        </div>
                    </article>
                @else
                    <!-- Artikel Kecil -->
                    <article class="md:col-span-1 bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition transform hover:-translate-y-1 relative h-64">
                        @if($post->thumbnail)
                            <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-green-400 to-green-600"></div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-4 text-white">
                            <div class="inline-block bg-green-500 text-white text-xs font-semibold px-2 py-1 rounded-full mb-2">Pena Santri</div>
                            <h3 class="text-base font-bold line-clamp-2">
                                <a href="{{ route('posts.show', $post->slug) }}" class="hover:text-green-300">{{ $post->title }}</a>
                            </h3>
                            <p class="text-gray-200 text-xs line-clamp-1">{{ strip_tags($post->content) }}</p>
                        </div>
                    </article>
                @endif
            @empty
                <div class="col-span-5 text-center">
                    <p class="text-gray-500 text-lg">Belum ada artikel pena santri</p>
                </div>
            @endforelse

            @if($penaSantriHighlight->count() < 5)
                @for($i = $penaSantriHighlight->count(); $i < 5; $i++)
                    @if($i === 0)
                        <!-- Artikel Utama Placeholder -->
                        <article class="md:col-span-2 md:row-span-2 bg-white rounded-2xl shadow-xl overflow-hidden relative">
                            <div class="w-full h-full bg-gradient-to-br from-gray-300 to-gray-400"></div>
                            <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent"></div>
                            <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                                <div class="inline-block bg-green-500 text-white text-xs font-semibold px-3 py-1 rounded-full mb-3">Pena Santri</div>
                                <h3 class="text-2xl font-bold mb-2">Lorem ipsum dolor consectetur</h3>
                                <p class="text-gray-200 text-sm line-clamp-2">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                            </div>
                        </article>
                    @else
                        <!-- Artikel Kecil Placeholder -->
                        <article class="md:col-span-1 bg-white rounded-2xl shadow-xl overflow-hidden relative h-64">
                            <div class="w-full h-full bg-gradient-to-br from-gray-300 to-gray-400"></div>
                            <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent"></div>
                            <div class="absolute bottom-0 left-0 right-0 p-4 text-white">
                                <div class="inline-block bg-green-500 text-white text-xs font-semibold px-2 py-1 rounded-full mb-2">Pena Santri</div>
                                <h3 class="text-base font-bold line-clamp-2">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h3>
                                <p class="text-gray-200 text-xs line-clamp-1">Lorem ipsum dolor sit amet.</p>
                            </div>
                        </article>
                    @endif
                @endfor
            @endif
        </div>
    </div>
</section>
@endsection
