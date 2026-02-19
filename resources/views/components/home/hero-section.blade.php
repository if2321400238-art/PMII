<style>
    .hero-mobile-card {
        height: clamp(240px, 44vh, 380px);
    }

    @media (min-width: 768px) {
        .hero-mobile-card {
            height: auto;
            flex: 1 1 0%;
            min-height: 0;
        }
    }
</style>

<div class="bg-slate-50 overflow-hidden" style="height: calc(var(--app-vh, 1vh) * 100);">
    <div class="p-3 sm:p-4 md:p-6 h-full">
        <div class="bg-[#1e3a5f] rounded-3xl overflow-hidden h-full flex flex-col relative shadow-2xl shadow-[#0f172a]/40">
            @include('layouts.navigation')

            @php
                $heroImages = array_filter([
                    $profil->hero_image ?? null,
                    $profil->hero_image_2 ?? null,
                    $profil->hero_image_3 ?? null,
                ]);
            @endphp

            <div class="relative z-10 px-3 sm:px-4 md:px-6 pb-3 md:pb-4 flex-1 flex flex-col overflow-visible md:overflow-hidden">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 md:gap-4 mt-2 md:mt-6 flex-1 min-h-0">
                    <div class="lg:col-span-5 flex flex-col gap-3 md:gap-2 opacity-0-start animate-fade-in-left">
                        <div class="hero-mobile-card relative rounded-3xl overflow-hidden border border-white/20 shadow-xl shadow-black/30">
                            @if (count($heroImages) > 0)
                                <div class="hero-slider absolute inset-0">
                                    @foreach ($heroImages as $index => $heroImage)
                                        <div class="hero-slide absolute inset-0 transition-opacity duration-1000 {{ $index === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0' }}" data-index="{{ $index }}">
                                            <img src="{{ asset('storage/' . $heroImage) }}" alt="Hero PMII {{ $index + 1 }}" class="w-full h-full object-cover">
                                            <div class="absolute inset-0 bg-black/50"></div>
                                            <div class="absolute inset-0 bg-gradient-to-t from-[#1e3a5f] via-[#1e3a5f]/35 to-[#1e3a5f]/55"></div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="absolute inset-0 bg-gradient-to-br from-blue-700 to-blue-900"></div>
                            @endif

                            <div class="absolute inset-0 flex flex-col justify-between p-4 md:p-6 z-20">
                                <div class="flex items-center justify-between gap-3">
                                    <span class="inline-flex items-center rounded-full bg-white/15 border border-white/30 px-3 py-1 text-[11px] sm:text-xs uppercase tracking-wider text-white/95 backdrop-blur-sm">
                                        PMII UNUJA
                                    </span>
                                    <span class="inline-flex items-center rounded-full bg-yellow-400/90 px-2.5 py-1 text-[10px] sm:text-xs font-semibold text-[#0f172a]">
                                        Organisasi Mahasiswa
                                    </span>
                                </div>

                                <div>
                                    <h1 class="text-2xl sm:text-3xl md:text-2xl lg:text-3xl font-bold text-white leading-tight mb-2 drop-shadow-lg">
                                        Bergerak, Kritis, dan Berdaya
                                    </h1>
                                    <p class="text-sm text-white/85 leading-relaxed mb-4 max-w-sm">
                                        Wadah kaderisasi intelektual dan kepemimpinan mahasiswa Islam di Universitas Nurul Jadid.
                                    </p>
                                    <div class="flex flex-wrap gap-2.5">
                                        <a href="{{ route('posts.berita') }}" class="inline-flex min-h-11 items-center justify-center rounded-full bg-yellow-400 px-4 py-2 text-sm font-bold text-[#0f172a] hover:bg-yellow-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-yellow-300 focus-visible:ring-offset-2 focus-visible:ring-offset-[#1e3a5f] transition">
                                            Baca Berita
                                        </a>
                                        <a href="{{ route('about.profil') }}" class="inline-flex min-h-11 items-center justify-center rounded-full border border-white/50 bg-white/10 px-4 py-2 text-sm font-semibold text-white hover:bg-white/20 focus:outline-none focus-visible:ring-2 focus-visible:ring-white/80 focus-visible:ring-offset-2 focus-visible:ring-offset-[#1e3a5f] transition">
                                            Tentang PMII
                                        </a>
                                    </div>
                                </div>
                            </div>

                            @if (count($heroImages) > 1)
                                <div class="absolute bottom-4 right-4 z-20 flex gap-2" role="tablist" aria-label="Slide hero">
                                    @foreach ($heroImages as $index => $heroImage)
                                        <button
                                            class="hero-dot h-2.5 rounded-full {{ $index === 0 ? 'w-6 bg-white' : 'w-2.5 bg-white/40' }} transition-all duration-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-white"
                                            data-slide="{{ $index }}"
                                            aria-label="Tampilkan slide {{ $index + 1 }}"
                                        ></button>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div class="grid grid-cols-2 gap-2 md:hidden">
                            <div class="rounded-2xl bg-[#0f172a] border border-yellow-500/30 px-3 py-3 text-center shadow-lg">
                                <div class="text-lg font-bold text-yellow-300">{{ $stats['rayon'] }}</div>
                                <div class="text-[11px] uppercase tracking-wide text-white/75">Rayon Aktif</div>
                            </div>
                            <div class="rounded-2xl bg-[#0f172a] border border-yellow-500/30 px-3 py-3 text-center shadow-lg">
                                <div class="text-lg font-bold text-yellow-300">{{ $stats['anggota'] }}</div>
                                <div class="text-[11px] uppercase tracking-wide text-white/75">Kader</div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-2 md:hidden">
                            <a href="{{ route('gallery.index') }}" class="inline-flex min-h-11 items-center justify-center rounded-xl border border-white/20 bg-[#0f172a] px-3 py-2 text-sm font-semibold text-white hover:bg-blue-800 focus:outline-none focus-visible:ring-2 focus-visible:ring-white/80 transition">
                                Galeri
                            </a>
                            <a href="#" id="dataKader" class="inline-flex min-h-11 items-center justify-center rounded-xl border border-white/20 bg-[#0f172a] px-3 py-2 text-sm font-semibold text-white hover:bg-blue-800 focus:outline-none focus-visible:ring-2 focus-visible:ring-white/80 transition">
                                Data Kader
                            </a>
                        </div>

                        <div class="hidden md:flex gap-2 opacity-0-start animate-fade-in-up delay-300">
                            <a href="{{ route('gallery.index') }}" class="flex-1 py-2 bg-[#0f172a] border border-white/20 rounded-full text-white text-center text-sm font-medium hover:bg-blue-700 hover:scale-105 transition-all duration-300">GALERI</a>
                            <a href="#" id="dataKaderDesktop" class="flex-1 py-2 bg-[#0f172a] border border-white/20 rounded-full text-white text-center text-sm font-medium hover:bg-blue-700 hover:scale-105 transition-all duration-300">DATA KADER</a>
                        </div>
                    </div>

                    <div class="hidden md:flex lg:col-span-7 flex-col gap-2 opacity-0-start animate-fade-in-right delay-200">
                        <div class="flex items-center gap-4">
                            <div class="flex-1 relative">
                                <input type="text" id="searchInput" placeholder="Search........" class="w-full bg-[#0f172a] border border-white/20 rounded-full px-4 py-2 text-sm text-white placeholder-white/40 focus:outline-none focus:border-yellow-500 transition" />
                            </div>
                            <button id="cameraBtn" class="w-9 h-9 rounded-lg bg-black border border-white/20 flex items-center justify-center hover:bg-gray-900 transition text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </button>
                            <button id="micBtn" class="w-9 h-9 rounded-lg bg-black border border-white/20 flex items-center justify-center hover:bg-gray-900 transition text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                                </svg>
                            </button>
                        </div>

                        <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-4 md:p-5 flex-1 min-h-0 flex flex-col opacity-0-start animate-scale-in delay-300">
                            <h2 class="text-xl md:text-2xl lg:text-3xl font-bold text-white mb-3">Apa itu PMII?</h2>
                            <p class="text-white/80 text-sm leading-relaxed mb-4">
                                PMII adalah organisasi kemahasiswaan yang berafiliasi dengan Nahdlatul Ulama (NU). Didirikan pada 17 April 1960, PMII berkomitmen membentuk kader intelektual yang religius, kritis, dan aktif dalam pembangunan masyarakat Indonesia.
                            </p>

                            <div class="grid grid-cols-2 gap-3 mb-3 mt-auto">
                                <div class="bg-[#0f172a] border border-yellow-500/30 rounded-xl p-3 text-center hover:scale-105 transition-transform duration-300">
                                    <div class="text-xl md:text-2xl font-bold text-yellow-400 counter" data-target="{{ $stats['rayon'] }}">0</div>
                                    <div class="text-xs text-white/60 uppercase">Rayon</div>
                                </div>
                                <div class="bg-[#0f172a] border border-yellow-500/30 rounded-xl p-3 text-center hover:scale-105 transition-transform duration-300">
                                    <div class="text-xl md:text-2xl font-bold text-yellow-400 counter" data-target="{{ $stats['anggota'] }}">0</div>
                                    <div class="text-xs text-white/60 uppercase">Kader</div>
                                </div>
                            </div>

                            <div class="flex justify-end">
                                <a href="{{ route('about.profil') }}" class="w-9 h-9 rounded-full bg-yellow-500 border border-yellow-400 flex items-center justify-center hover:bg-yellow-400 hover:scale-110 transition-all duration-300 shadow-lg animate-float-p">
                                    <svg class="w-5 h-5 text-[#0f172a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 opacity-0-start animate-fade-in-up delay-400">
                            <a href="{{ route('about.rayon') }}" class="flex-1 py-2 bg-[#0f172a] border border-white/20 rounded-xl text-white text-center text-sm font-medium hover:bg-blue-700 hover:scale-105 transition-all duration-300">RAYON</a>
                            <div class="flex-1 flex justify-center">
                                <a href="#tentang-pmii" class="px-4 py-2 bg-white/5 border border-white/30 rounded-full text-white text-xs font-medium hover:bg-white/10 hover:scale-105 transition-all duration-300 flex items-center gap-2 animate-float">
                                    <span>SCROLL</span>
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const showDataKaderMessage = function (event) {
            event.preventDefault();
            alert('Fitur ini akan segera tersedia');
        };

        const dataKaderMobile = document.getElementById('dataKader');
        const dataKaderDesktop = document.getElementById('dataKaderDesktop');

        if (dataKaderMobile) {
            dataKaderMobile.addEventListener('click', showDataKaderMessage);
        }

        if (dataKaderDesktop) {
            dataKaderDesktop.addEventListener('click', showDataKaderMessage);
        }
    });
</script>
