<!-- Navigation Header - Modern Blue-Yellow PMII Design -->
<style>
    .navbar-sticky {
        border-bottom-left-radius: 1.5rem !important;
        border-bottom-right-radius: 1.5rem !important;
        border-bottom: 4px solid rgba(255, 255, 255, 0.2) !important;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3), 0 10px 10px -5px rgba(0, 0, 0, 0.2) !important;
    }
</style>
@php
    $isHomePage = request()->routeIs('home');
@endphp

<!-- Navbar Wrapper -->
<div id="navbarWrapper" class="{{ $isHomePage ? '' : 'p-3 md:p-4' }}">

<header class="relative text-white {{ $isHomePage ? '' : 'bg-[#1e3a5f]/95 backdrop-blur-md rounded-2xl shadow-2xl shadow-black/40 border border-white/10' }}"
        x-data="{ open: false }"
        id="mainNavbar">
    @php
        $profil = \App\Models\ProfilOrganisasi::first();
    @endphp

    <!-- Top Navigation -->
    <nav class="flex items-center justify-between px-6 py-3 border-b border-white/10 gap-6">
        <!-- Logo -->
        <div class="flex-shrink-0">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <img src="{{ asset('images/logo-pmii.png') }}" alt="Logo PMII" class="w-10 h-10 rounded-full object-cover animate-pulse-glow">
                <p class="hidden lg:block font-bold text-lg animate-pulse-glow-text">PMII UNUJA</p>
            </a>
        </div>

        <!-- Nav Links Center (Desktop Only) -->
        <ul class="hidden md:flex items-center gap-6 text-sm font-medium flex-1 justify-center">
            <li>
                <a href="{{ route('home') }}"
                   class="{{ request()->routeIs('home') ? 'underline underline-offset-4 decoration-2' : 'hover:text-yellow-400 transition' }}">
                    Beranda
                </a>
            </li>

            <!-- Profil Dropdown -->
            <li class="relative" x-data="{ dropOpen: false }">
                <button @mouseenter="dropOpen = true"
                        @mouseleave="dropOpen = false"
                        class="flex items-center gap-1 {{ request()->routeIs('about.*') ? 'underline underline-offset-4 decoration-2' : 'hover:text-yellow-400 transition' }}">
                    Profil
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
                <div x-show="dropOpen"
                     @mouseenter="dropOpen = true"
                     @mouseleave="dropOpen = false"
                     x-transition
                     class="absolute left-0 mt-2 w-44 bg-[#0f172a] border border-white/20 rounded-lg shadow-xl overflow-hidden z-50">
                    <a href="{{ route('about.profil') }}" class="block px-4 py-2.5 text-sm hover:bg-blue-800 transition">Profil Organisasi</a>
                    <a href="{{ route('about.rayon') }}" class="block px-4 py-2.5 text-sm hover:bg-blue-800 transition">Rayon</a>
                </div>
            </li>

            <li>
                <a href="{{ route('posts.berita') }}"
                   class="{{ request()->routeIs('posts.berita') ? 'underline underline-offset-4 decoration-2' : 'hover:text-yellow-400 transition' }}">
                    Berita
                </a>
            </li>

            <li>
                <a href="{{ route('gallery.index') }}"
                   class="{{ request()->routeIs('gallery.*') ? 'underline underline-offset-4 decoration-2' : 'hover:text-yellow-400 transition' }}">
                    Galeri
                </a>
            </li>
            <li>
                <a href="{{ route('download.index') }}"
                   class="{{ request()->routeIs('download.*') ? 'underline underline-offset-4 decoration-2' : 'hover:text-yellow-400 transition' }}">
                    Download
                </a>
            </li>
        </ul>

        <!-- Mobile Menu Button + User Info -->
        <div class="flex items-center gap-4 ml-auto">
            <!-- Mobile Menu Button (Only Mobile) -->
            <button @click="open = !open" class="md:hidden p-2 hover:bg-blue-800 rounded-lg transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- User Info -->
            @auth
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 hover:opacity-80 transition">
                    <div class="w-9 h-9 rounded-full bg-blue-700 flex items-center justify-center text-sm font-bold">
                        {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                    </div>
                    <div class="hidden sm:block text-xs leading-tight">
                        <p class="font-semibold">{{ Str::limit(auth()->user()->name ?? 'User', 12) }}</p>
                        <p class="text-white/60 text-[10px] uppercase">{{ auth()->user()->role->name ?? 'Member' }}</p>
                    </div>
                </a>
            @else
                <a href="{{ route('login') }}" class="flex items-center gap-3 hover:opacity-80 transition">
                    <div class="w-9 h-9 rounded-full bg-blue-700 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div class="hidden sm:block text-xs leading-tight">
                        <p class="font-semibold">Guest</p>
                        <p class="text-white/60 text-[10px] uppercase">Login</p>
                    </div>
                </a>
            @endauth
        </div>
    </nav>


    <!-- Mobile Menu -->
    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         @click.outside="open = false"
         class="md:hidden bg-[#0f172a] border-t border-white/10 px-4 py-4">

        <div class="space-y-1">
            <a href="{{ route('home') }}"
               class="block px-4 py-3 rounded-lg transition {{ request()->routeIs('home') ? 'bg-blue-800 text-white' : 'text-white/80 hover:bg-blue-800/50' }}">
                Beranda
            </a>

            <!-- Profil Accordion -->
            <div x-data="{ subOpen: false }">
                <button @click="subOpen = !subOpen"
                        class="w-full flex items-center justify-between px-4 py-3 rounded-lg transition {{ request()->routeIs('about.*') ? 'bg-blue-800 text-white' : 'text-white/80 hover:bg-blue-800/50' }}">
                    <span>Profil</span>
                    <svg class="w-4 h-4 transition-transform" :class="subOpen && 'rotate-180'" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
                <div x-show="subOpen"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-2"
                     class="ml-4 mt-1 space-y-1">
                    <a href="{{ route('about.profil') }}" class="block px-4 py-2 text-sm text-white/70 hover:text-white hover:bg-blue-800/30 rounded-lg transition">Profil Organisasi</a>
                    <a href="{{ route('about.rayon') }}" class="block px-4 py-2 text-sm text-white/70 hover:text-white hover:bg-blue-800/30 rounded-lg transition">Rayon</a>
                </div>
            </div>

            <a href="{{ route('posts.berita') }}"
               class="block px-4 py-3 rounded-lg transition {{ request()->routeIs('posts.*') ? 'bg-blue-800 text-white' : 'text-white/80 hover:bg-blue-800/50' }}">
                Berita
            </a>

            <a href="{{ route('gallery.index') }}"
               class="block px-4 py-3 rounded-lg transition {{ request()->routeIs('gallery.*') ? 'bg-blue-800 text-white' : 'text-white/80 hover:bg-blue-800/50' }}">
                Galeri
            </a>

            <a href="{{ route('download.index') }}"
               class="block px-4 py-3 rounded-lg transition {{ request()->routeIs('download.*') ? 'bg-blue-800 text-white' : 'text-white/80 hover:bg-blue-800/50' }}">
                Download
            </a>

            

            <!-- Account -->
            <div class="pt-3 mt-3 border-t border-white/10">
                @auth
                    <a href="{{ route('admin.dashboard') }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-800/50 transition">
                        <div class="w-10 h-10 rounded-full bg-blue-700 flex items-center justify-center text-sm font-bold">
                            {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                        </div>
                        <div>
                            <p class="font-semibold">{{ auth()->user()->name ?? 'User' }}</p>
                            <p class="text-xs text-white/60">Dashboard</p>
                        </div>
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-800/50 transition">
                        <div class="w-10 h-10 rounded-full bg-blue-700 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold">Guest</p>
                            <p class="text-xs text-white/60">Login</p>
                        </div>
                    </a>
                @endauth
            </div>
        </div>
    </div>
</header>

</div>
<!-- Spacer Placeholder -->
<div id="navbarPlaceholder" style="display: none;"></div>

<!-- Sticky Navbar on Scroll Script (All Pages) -->
<script>
    const isHomePage = {{ $isHomePage ? 'true' : 'false' }};
    const navbar = document.getElementById('mainNavbar');
    const navbarWrapper = document.getElementById('navbarWrapper');
    const placeholder = document.getElementById('navbarPlaceholder');
    let isSticky = false;

    // Set initial navbar height for placeholder
    window.addEventListener('load', function() {
        const wrapperHeight = navbarWrapper.offsetHeight;
        placeholder.style.height = wrapperHeight + 'px';
    });

    window.addEventListener('scroll', function() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

        if (scrollTop > 50 && !isSticky) {
            // Make navbar sticky
            isSticky = true;
            navbarWrapper.classList.add('fixed');
            navbarWrapper.classList.add('top-0');
            navbarWrapper.classList.add('left-0');
            navbarWrapper.classList.add('right-0');
            navbarWrapper.classList.add('z-50');

            // Add rounded bottom with custom class
            navbar.classList.add('navbar-sticky');

            if (isHomePage) {
                // Homepage: add background when sticky
                navbar.classList.add('bg-[#1e3a5f]/95');
                navbar.classList.add('backdrop-blur-md');
                navbar.classList.add('shadow-black/40');
            } else {
                // Non-homepage: remove padding, keep rounded bottom
                navbarWrapper.style.padding = '0';
                navbar.classList.remove('rounded-2xl');
                navbar.classList.remove('border');
                navbar.classList.remove('border-white/10');
            }

            placeholder.style.display = 'block';
        } else if (scrollTop <= 50 && isSticky) {
            // Return to original state
            isSticky = false;
            navbarWrapper.classList.remove('fixed');
            navbarWrapper.classList.remove('top-0');
            navbarWrapper.classList.remove('left-0');
            navbarWrapper.classList.remove('right-0');
            navbarWrapper.classList.remove('z-50');

            // Remove rounded bottom
            navbar.classList.remove('navbar-sticky');

            if (isHomePage) {
                // Homepage: remove background
                navbar.classList.remove('bg-[#1e3a5f]/95');
                navbar.classList.remove('backdrop-blur-md');
                navbar.classList.remove('shadow-black/40');
            } else {
                // Non-homepage: restore padding, rounded
                navbarWrapper.style.padding = '';
                navbar.classList.add('rounded-2xl');
                navbar.classList.add('border');
                navbar.classList.add('border-white/10');
            }

            placeholder.style.display = 'none';
        }
    });
</script>
