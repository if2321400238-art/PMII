@extends('layouts.app')

@section('title', 'Beranda - ISKAB')

@section('content')
<!-- Hero Section Full Width dari Atas dengan Rounded Bottom -->
<section class="relative bg-gradient-to-r from-green-700 to-green-800 text-white overflow-hidden rounded-b-[2rem] md:rounded-b-[3rem] min-h-[500px] md:min-h-[600px] lg:min-h-[700px] pt-20 md:pt-24">
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
    <div class="relative z-10 flex flex-col items-center justify-center text-center px-4 sm:px-6 md:px-12 lg:px-20 pt-28 sm:pt-16 md:pt-20 lg:pt-32 pb-12 sm:pb-16 md:pb-20 lg:pb-32">
        <!-- Heading Besar -->
        <h1 class="text-2xl sm:text-3xl md:text-5xl lg:text-6xl xl:text-7xl font-bold mb-6 md:mb-10 leading-tight text-white">
            Website Resmi Ikatan Santri<br class="hidden sm:block"><span class="sm:hidden"> </span>Kalimantan Barat (ISKAB)
        </h1>

        <!-- Tombol CTA dengan Background Shape Masing-masing -->
        <div class="flex flex-row justify-center items-center gap-3 md:gap-4">
            <!-- Tombol Hijau dengan Background Shape -->
            <div class="relative w-auto">
                <div class="absolute inset-0 -inset-x-1 -inset-y-1 rounded-xl md:rounded-2xl" style="background-color: rgba(255, 255, 255, 0.15); backdrop-filter: blur(8px);"></div>
                <a href="{{ route('about.profil') }}"
                   class="relative block text-center px-3 sm:px-6 md:px-8 py-1.5 sm:py-2 md:py-3 bg-gradient-to-r from-green-500 to-green-700 text-white text-xs sm:text-sm md:text-base font-semibold rounded-lg md:rounded-xl hover:bg-green-600 transition-all duration-300 shadow-lg">
                    Tentang kami
                </a>
            </div>

            <!-- Tombol Putih dengan Background Shape -->
            <div class="relative w-auto">
                <div class="absolute inset-0 -inset-x-1 -inset-y-1 rounded-xl md:rounded-2xl" style="background-color: rgba(255, 255, 255, 0.15); backdrop-filter: blur(8px);"></div>
                <a href="{{ route('posts.berita') }}"
                   class="relative block text-center px-3 sm:px-6 md:px-8 py-1.5 sm:py-2 md:py-3 bg-white text-green-700 text-xs sm:text-sm md:text-base font-semibold rounded-lg md:rounded-xl hover:bg-gray-50 transition-all duration-300 shadow-lg">
                    Baca Berita
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ISKAB Dalam Angka Section -->
<section class="bg-white py-8 md:py-16" id="iskab-stats">
    <div class="max-w-7xl mx-auto px-6 sm:px-12 lg:px-40">
        <h2 class="text-3xl md:text-4xl font-bold text-center text-green-700 mb-8 md:mb-12">ISKAB dalam Angka</h2>
        <div class="grid grid-cols-3 sm:grid-cols-3 md:grid-cols-3 gap-6 md:gap-8">
            <div class="relative">
                <!-- Background Shape -->
                <div class="absolute -inset-x-1 -inset-y-1 bg-gray-200 rounded-2xl md:rounded-3xl"></div>
                <!-- Card Content -->
                <div class="relative bg-gradient-to-br from-[#48D853] to-[#26722C] rounded-2xl md:rounded-3xl p-6 md:p-8 text-center shadow-2xl transform hover:scale-105 transition">
                    <div class="text-5xl sm:text-6xl md:text-7xl font-bold text-white mb-2 counter" data-target="{{ $stats['korwil'] }}">0</div>
                    <div class="text-md md:text-xl font-semibold text-white text-center uppercase">KORWIL</div>
                </div>
            </div>

            <div class="relative">
                <!-- Background Shape -->
                <div class="absolute -inset-x-1 -inset-y-1 bg-gray-200 rounded-2xl md:rounded-3xl"></div>
                <!-- Card Content -->
                <div class="relative bg-gradient-to-br from-[#48D853] to-[#26722C] rounded-2xl md:rounded-3xl p-6 md:p-8 text-center shadow-2xl transform hover:scale-105 transition">
                    <div class="text-5xl sm:text-6xl md:text-7xl font-bold text-white mb-2 counter" data-target="{{ $stats['rayon'] }}">0</div>
                    <div class="text-md md:text-xl font-semibold text-white text-center uppercase">RAYON</div>
                </div>
            </div>
            <div class="relative sm:col-span-2 md:col-span-1">
                <!-- Background Shape -->
                <div class="absolute -inset-x-1 -inset-y-1 bg-gray-200 rounded-2xl md:rounded-3xl"></div>
                <!-- Card Content -->
                <div class="relative bg-gradient-to-br from-[#48D853] to-[#26722C] rounded-2xl md:rounded-3xl p-6 md:p-8 text-center shadow-2xl transform hover:scale-105 transition">
                    <div class="text-5xl sm:text-6xl md:text-7xl font-bold text-white mb-2 counter" data-target="{{ $stats['anggota'] }}">0</div>
                    <div class="text-md md:text-xl font-semibold text-white text-center uppercase">SANTRI</div>
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
            @else
                <p class="text-gray-700 leading-relaxed text-justify mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi. Proin porttitor, orci nec nonummy molestie, enim est eleifend mi, non fermentum diam nisl sit amet erat. Duis semper. Duis arcu massa, scelerisque vitae, consequat in, pretium a, enim. Pellentesque congue.</p>

                <p class="text-gray-700 leading-relaxed text-justify mb-4">Ut nisi nec eros. Suspendisse pulvinar tellus ac nisl. Pellentesque vitae lacus. Maecenas ullamcorper, diam vitae commodo placerat, sapien ipsum dictum eros, vel consequat massa orci vel felis. Curabitur aliquet ante vitae, consequat aliquet libero at, blandit fermentum diam. Integer quis metus vitae lobortis egestas. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vel erat non mauris convallis vehicula.</p>

                <p class="text-gray-700 leading-relaxed text-justify">Nulla at leo nec metus aliquam semper. Sed adipiscing ornare risus. Morbi est est, blandit sit amet, sagittis vel, euismod vel, velit. Pellentesque egestas sem. Suspendisse commodo ullamcorper magna. Ut aliquam sollicitudin leo. Cras iaculis ultricies nulla. Donec quis dui at dolor tempor interdum.</p>
            @endif
        </div>
    </div>
</section>

<!-- Berita Terkini -->
<section class="bg-gradient-to-b from-green-600 to-green-700 py-12 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl md:text-4xl font-bold text-center text-white mb-8">Berita Terkini</h2>

        <!-- Carousel Container -->
        <div class="relative">
            <!-- Tombol Panah Kiri -->
            <button id="prevBerita" class="absolute left-0 top-1/2 -translate-y-1/2 z-20 bg-white hover:bg-gray-50 text-green-700 rounded-full p-2 md:p-3 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-110">
                <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>

            <!-- Tombol Panah Kanan -->
            <button id="nextBerita" class="absolute right-0 top-1/2 -translate-y-1/2 z-20 bg-white hover:bg-gray-50 text-green-700 rounded-full p-2 md:p-3 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-110">
                <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>

            <!-- Carousel Wrapper - Fixed Pages -->
            <div class="relative overflow-x-auto overflow-y-hidden scroll-smooth scrollbar-hide mx-8">
                <div id="beritaCarousel">
                    <div id="beritaContainer" class="flex gap-4 lg:gap-6 py-2">
                        @forelse($beritaTerkini as $post)
                            <!-- Artikel - 1 card per slide di mobile, 3 cards per slide di desktop -->
                            <article class="flex-none w-full lg:w-[calc(33.333%-1rem)] bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition transform hover:-translate-y-1 relative h-64">
                                @if($post->thumbnail)
                                    <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-green-400 to-green-600"></div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-green-900 via-transparent to-transparent"></div>
                                <div class="absolute bottom-0 left-0 right-0 p-4 text-white">
                                    <div class="inline-block bg-gradient-to-l from-green-500 to-green-700 text-white text-xs font-semibold px-2 py-1 rounded-full mb-2">Berita ISKAB</div>
                                    <h3 class="text-sm md:text-base font-bold line-clamp-2">
                                        <a href="{{ route('posts.show', $post->slug) }}" class="hover:text-green-300">{{ $post->title }}</a>
                                    </h3>
                                    <p class="text-gray-200 text-xs line-clamp-1">{{ strip_tags($post->content) }}</p>
                                </div>
                            </article>
                        @empty
                            <div class="w-full text-center py-8">
                                <p class="text-white text-lg">Belum ada berita terkini</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Dots Indicators -->
        <div id="beritaDots" class="flex justify-center gap-2 mt-6"></div>
    </div>
</section>

<style>
    .scrollbar-hide::-webkit-scrollbar { display: none; }
    .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
</style>

<!-- Pena Santri -->
<section class="bg-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-20">
        <h2 class="text-3xl md:text-4xl font-bold text-center text-green-700 mb-8">Pena Santri</h2>

        <!-- Mobile: Carousel with arrows -->
        <div class="lg:hidden relative">
            <!-- Tombol Panah Kiri Mobile -->
            <button id="prevPenaSantri" class="absolute left-0 top-1/2 -translate-y-1/2 z-20 bg-green-700 hover:bg-green-800 text-white rounded-full p-2 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-110">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>

            <!-- Tombol Panah Kanan Mobile -->
            <button id="nextPenaSantri" class="absolute right-0 top-1/2 -translate-y-1/2 z-20 bg-green-700 hover:bg-green-800 text-white rounded-full p-2 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-110">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>

            <!-- Carousel Mobile -->
            <div id="penaSantriCarousel" class="overflow-x-auto overflow-y-hidden scroll-smooth scrollbar-hide mx-8">
                <div class="flex gap-4 py-2">
                    @forelse($penaSantriHighlight as $post)
                        <article class="flex-none w-full bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition transform hover:-translate-y-1 relative h-72">
                            @if($post->thumbnail)
                                <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-green-400 to-green-600"></div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-green-900 via-transparent to-transparent"></div>
                            <div class="absolute bottom-0 left-0 right-0 p-5 text-white">
                                <div class="inline-block bg-gradient-to-r from-green-500 to-green-700 text-white text-xs font-semibold px-3 py-1 rounded-full mb-3">Pena Santri</div>
                                <h3 class="text-lg font-bold mb-2 line-clamp-2">
                                    <a href="{{ route('posts.show', $post->slug) }}" class="hover:text-green-300">{{ $post->title }}</a>
                                </h3>
                                <p class="text-gray-200 text-sm line-clamp-2">{{ strip_tags($post->content) }}</p>
                            </div>
                        </article>
                    @empty
                        <div class="w-full text-center py-8">
                            <p class="text-gray-500 text-lg">Belum ada artikel pena santri</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Dots Indicators Mobile -->
            <div id="penaSantriDots" class="flex justify-center gap-2 mt-6"></div>
        </div>

        <!-- Desktop: Grid Layout -->
        <div class="hidden lg:grid grid-cols-3 gap-6">
            @forelse($penaSantriHighlight as $index => $post)
                @if($index === 0)
                    <!-- Artikel Utama -->
                    <article class="col-span-1 row-span-2 bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition transform hover:-translate-y-1 relative min-h-[320px]">
                        @if($post->thumbnail)
                            <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-green-400 to-green-600"></div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-green-900 via-transparent to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                            <div class="inline-block bg-gradient-to-r from-green-500 to-green-700 text-white text-xs font-semibold px-3 py-1 rounded-full mb-3">Pena Santri</div>
                            <h3 class="text-2xl font-bold mb-2">
                                <a href="{{ route('posts.show', $post->slug) }}" class="hover:text-green-300">{{ $post->title }}</a>
                            </h3>
                            <p class="text-gray-200 text-sm line-clamp-2">{{ strip_tags($post->content) }}</p>
                        </div>
                    </article>
                @else
                    <!-- Artikel Kecil -->
                    <article class="bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition transform hover:-translate-y-1 relative h-48">
                        @if($post->thumbnail)
                            <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-green-400 to-green-600"></div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-green-900 via-transparent to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-4 text-white">
                            <div class="inline-block bg-gradient-to-l from-green-500 to-green-700 text-white text-xs font-semibold px-2 py-1 rounded-full mb-2">Pena Santri</div>
                            <h3 class="text-base font-bold line-clamp-2">
                                <a href="{{ route('posts.show', $post->slug) }}" class="hover:text-green-300">{{ $post->title }}</a>
                            </h3>
                            <p class="text-gray-200 text-xs line-clamp-1">{{ strip_tags($post->content) }}</p>
                        </div>
                    </article>
                @endif
            @empty
                <div class="col-span-3 text-center">
                    <p class="text-gray-500 text-lg">Belum ada artikel pena santri</p>
                </div>
            @endforelse

            @if($penaSantriHighlight->count() < 5)
                @for($i = $penaSantriHighlight->count(); $i < 5; $i++)
                    @if($i === 0)
                        <!-- Artikel Utama Placeholder -->
                        <article class="col-span-1 row-span-2 bg-white rounded-2xl shadow-xl overflow-hidden relative min-h-[320px]">
                            <div class="w-full h-full bg-gradient-to-br from-green-300 to-green-400"></div>
                            <div class="absolute inset-0 bg-gradient-to-t from-green-900 via-transparent to-transparent"></div>
                            <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                                <div class="inline-block bg-gradient-to-l from-green-500 to-green-700 text-white text-xs font-semibold px-3 py-1 rounded-full mb-3">Pena Santri</div>
                                <h3 class="text-2xl font-bold mb-2">Lorem ipsum dolor consectetur</h3>
                                <p class="text-gray-200 text-sm line-clamp-2">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                            </div>
                        </article>
                    @else
                        <!-- Artikel Kecil Placeholder -->
                        <article class="bg-white rounded-2xl shadow-xl overflow-hidden relative h-48">
                            <div class="w-full h-full bg-gradient-to-br from-gray-300 to-gray-400"></div>
                            <div class="absolute inset-0 bg-gradient-to-t from-green-900 via-transparent to-transparent"></div>
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

<style>
    .scrollbar-hide::-webkit-scrollbar { display: none; }
    .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // ==================== Counter Animation ====================
    const counters = document.querySelectorAll('.counter');
    let animated = false;

    const animateCounter = (counter) => {
        const target = parseInt(counter.getAttribute('data-target'));
        const duration = 2000;
        const increment = target / (duration / 16);
        let current = 0;

        const updateCounter = () => {
            current += increment;
            if (current < target) {
                counter.textContent = Math.floor(current);
                requestAnimationFrame(updateCounter);
            } else {
                counter.textContent = target;
            }
        };

        updateCounter();
    };

    const observerOptions = {
        threshold: 0.5,
        rootMargin: '0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting && !animated) {
                animated = true;
                counters.forEach(counter => {
                    animateCounter(counter);
                });
            }
        });
    }, observerOptions);

    const statsSection = document.getElementById('iskab-stats');
    if (statsSection) {
        observer.observe(statsSection);
    }

    // ==================== Carousel Utility ====================
    function initCarousel(config) {
        const { carouselId, prevBtnId, nextBtnId, dotsId, getCardsPerPage, dotActiveClass, dotInactiveClass } = config;

        const carousel = document.getElementById(carouselId);
        const prevBtn = document.getElementById(prevBtnId);
        const nextBtn = document.getElementById(nextBtnId);
        const dotsContainer = document.getElementById(dotsId);

        if (!carousel || !prevBtn || !nextBtn) return;

        const articles = Array.from(carousel.querySelectorAll('article'));
        const totalArticles = articles.length;
        let currentPage = 0;

        const getTotalPages = () => Math.ceil(totalArticles / getCardsPerPage());

        const createDots = () => {
            dotsContainer.innerHTML = '';
            const totalPages = getTotalPages();

            for (let i = 0; i < totalPages; i++) {
                const dot = document.createElement('button');
                dot.className = 'w-2.5 h-2.5 rounded-full transition-all duration-300';
                dot.onclick = () => goToPage(i);
                dotsContainer.appendChild(dot);
            }
            updateDots();
        };

        const updateDots = () => {
            const dots = dotsContainer.querySelectorAll('button');
            dots.forEach((dot, index) => {
                dot.className = index === currentPage ? dotActiveClass : dotInactiveClass;
            });
        };

        const goToPage = (page) => {
            const totalPages = getTotalPages();
            currentPage = Math.max(0, Math.min(page, totalPages - 1));

            const cardsPerPage = getCardsPerPage();
            const cardIndex = currentPage * cardsPerPage;
            const targetCard = articles[cardIndex];

            if (targetCard) {
                targetCard.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'start' });
            }

            setTimeout(() => {
                updateDots();
                updateButtons();
            }, 100);
        };

        const updateButtons = () => {
            const totalPages = getTotalPages();

            prevBtn.style.opacity = currentPage === 0 ? '0.5' : '1';
            prevBtn.style.cursor = currentPage === 0 ? 'not-allowed' : 'pointer';
            nextBtn.style.opacity = currentPage >= totalPages - 1 ? '0.5' : '1';
            nextBtn.style.cursor = currentPage >= totalPages - 1 ? 'not-allowed' : 'pointer';
        };

        const updateCurrentPage = () => {
            const scrollLeft = carousel.scrollLeft;
            const cardsPerPage = getCardsPerPage();
            let closestIndex = 0;
            let minDistance = Infinity;

            articles.forEach((article, index) => {
                const cardLeft = article.offsetLeft - carousel.offsetLeft;
                const distance = Math.abs(scrollLeft - cardLeft);

                if (distance < minDistance) {
                    minDistance = distance;
                    closestIndex = index;
                }
            });

            const newPage = Math.floor(closestIndex / cardsPerPage);

            if (newPage !== currentPage) {
                currentPage = newPage;
                updateDots();
                updateButtons();
            }
        };

        prevBtn.addEventListener('click', (e) => {
            e.preventDefault();
            if (currentPage > 0) goToPage(currentPage - 1);
        });

        nextBtn.addEventListener('click', (e) => {
            e.preventDefault();
            const totalPages = getTotalPages();
            if (currentPage < totalPages - 1) goToPage(currentPage + 1);
        });

        let scrollTimeout;
        carousel.addEventListener('scroll', () => {
            clearTimeout(scrollTimeout);
            scrollTimeout = setTimeout(updateCurrentPage, 150);
        });

        let resizeTimer;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(() => {
                currentPage = 0;
                carousel.scrollLeft = 0;
                createDots();
                updateButtons();
            }, 250);
        });

        createDots();
        updateButtons();
    }

    // ==================== Initialize Carousels ====================
    // Berita Terkini
    initCarousel({
        carouselId: 'beritaCarousel',
        prevBtnId: 'prevBerita',
        nextBtnId: 'nextBerita',
        dotsId: 'beritaDots',
        getCardsPerPage: () => window.innerWidth >= 1024 ? 3 : 1,
        dotActiveClass: 'w-8 h-2.5 rounded-full bg-white transition-all duration-300',
        dotInactiveClass: 'w-2.5 h-2.5 rounded-full bg-white/40 hover:bg-white/60 transition-all duration-300'
    });

    // Pena Santri (Mobile only)
    if (window.innerWidth < 1024) {
        initCarousel({
            carouselId: 'penaSantriCarousel',
            prevBtnId: 'prevPenaSantri',
            nextBtnId: 'nextPenaSantri',
            dotsId: 'penaSantriDots',
            getCardsPerPage: () => 1,
            dotActiveClass: 'w-8 h-2.5 rounded-full bg-green-700 transition-all duration-300',
            dotInactiveClass: 'w-2.5 h-2.5 rounded-full bg-gray-300 hover:bg-gray-400 transition-all duration-300'
        });
    }
});
</script>

@endsection
