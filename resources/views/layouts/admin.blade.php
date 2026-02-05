<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - ISKAB')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Sidebar styles */
        #sidebar { 
            transition: transform 0.3s ease-in-out;
            transform: translateX(-100%);
        }
        /* Desktop: sidebar selalu tampil */
        @media (min-width: 1024px) {
            #sidebar { 
                transform: translateX(0) !important; 
            }
            #mainContent { 
                margin-left: 16rem !important; 
            }
        }
        /* Mobile: toggle dengan class */
        @media (max-width: 1023px) {
            #sidebar.open { transform: translateX(0) !important; }
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <!-- Overlay untuk mobile -->
        <div id="overlay" class="fixed inset-0 z-30 bg-black bg-opacity-50 lg:hidden" style="display: none;"></div>

        <!-- Sidebar -->
        <aside id="sidebar" class="fixed top-0 bottom-0 left-0 z-40 w-64 bg-gray-900 text-white overflow-y-auto" style="height: 100vh; min-height: 100%;">
            <!-- Sidebar Header dengan Close Button -->
            <div class="flex items-center justify-between p-4 border-b border-gray-800">
                <h1 class="text-xl font-bold">ISKAB Admin</h1>
                <button id="closeBtn" type="button" class="p-2 rounded hover:bg-gray-800 lg:hidden">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            @php
                $role = auth()->user()->role
                    ?? (auth()->guard('korwil')->check() ? 'korwil_admin' : (auth()->guard('rayon')->check() ? 'rayon_admin' : null));
            @endphp

            <!-- Sidebar Menu -->
            <nav class="p-3 space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm {{ request()->routeIs('admin.dashboard') ? 'bg-green-600 text-white' : 'text-gray-300 hover:bg-gray-800' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Dashboard
                </a>

                <!-- Dropdown Konten -->
                <div class="dropdown-menu">
                    <button type="button" onclick="toggleDropdown('kontenMenu')" class="flex items-center justify-between w-full px-3 py-2 rounded-lg text-sm text-gray-300 hover:bg-gray-800 {{ request()->routeIs('admin.posts.*') || request()->routeIs('admin.gallery.*') || request()->routeIs('admin.download.*') ? 'bg-gray-800' : '' }}">
                        <span class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            Konten
                        </span>
                        <svg class="w-4 h-4 transition-transform" id="kontenMenuArrow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div id="kontenMenu" class="hidden pl-4 mt-1 space-y-1">
                        <a href="{{ route('admin.posts.index') }}" class="block px-3 py-2 rounded-lg text-sm {{ request()->routeIs('admin.posts.*') ? 'bg-green-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">Posts</a>
                        <a href="{{ route('admin.gallery.index') }}" class="block px-3 py-2 rounded-lg text-sm {{ request()->routeIs('admin.gallery.*') ? 'bg-green-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">Galeri</a>
                        @if(in_array($role, ['admin', 'pb']))
                        <a href="{{ route('admin.download.index') }}" class="block px-3 py-2 rounded-lg text-sm {{ request()->routeIs('admin.download.*') ? 'bg-green-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">Download</a>
                        @endif
                    </div>
                </div>

                <!-- Dropdown Organisasi -->
                <div class="dropdown-menu">
                    <button type="button" onclick="toggleDropdown('orgMenu')" class="flex items-center justify-between w-full px-3 py-2 rounded-lg text-sm text-gray-300 hover:bg-gray-800 {{ request()->routeIs('admin.profil-organisasi.*') || request()->routeIs('admin.korwil.*') || request()->routeIs('admin.rayon.*') || request()->routeIs('admin.anggota.*') ? 'bg-gray-800' : '' }}">
                        <span class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Organisasi
                        </span>
                        <svg class="w-4 h-4 transition-transform" id="orgMenuArrow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div id="orgMenu" class="hidden pl-4 mt-1 space-y-1">
                        @if(in_array($role, ['admin', 'pb']))
                        <a href="{{ route('admin.profil-organisasi.edit') }}" class="block px-3 py-2 rounded-lg text-sm {{ request()->routeIs('admin.profil-organisasi.*') ? 'bg-green-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">Profil</a>
                        <a href="{{ route('admin.korwil.index') }}" class="block px-3 py-2 rounded-lg text-sm {{ request()->routeIs('admin.korwil.*') ? 'bg-green-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">Korwil</a>
                        @endif
                        @if(in_array($role, ['admin', 'korwil_admin']))
                        <a href="{{ route('admin.rayon.index') }}" class="block px-3 py-2 rounded-lg text-sm {{ request()->routeIs('admin.rayon.*') ? 'bg-green-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">Rayon</a>
                        @endif
                        <a href="{{ route('admin.anggota.index') }}" class="block px-3 py-2 rounded-lg text-sm {{ request()->routeIs('admin.anggota.*') ? 'bg-green-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">Anggota</a>
                    </div>
                </div>

                <!-- SK Pengajuan -->
                <a href="{{ route('admin.sk-pengajuan.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm {{ request()->routeIs('admin.sk-pengajuan.*') ? 'bg-green-600 text-white' : 'text-gray-300 hover:bg-gray-800' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    @if(in_array($role, ['admin', 'pb'])) Approval SK @else SK Saya @endif
                </a>

                @if(in_array($role, ['admin', 'pb']))
                <!-- Kelola User -->
                <a href="{{ route('admin.user.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm {{ request()->routeIs('admin.user.*') ? 'bg-green-600 text-white' : 'text-gray-300 hover:bg-gray-800' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    Kelola User
                </a>
                @endif
            </nav>
        </aside>

        <!-- Main Content -->
        <div id="mainContent" class="min-h-screen transition-all duration-300" style="margin-left: 0;">
            <!-- Top Header -->
            <header class="sticky top-0 z-20 bg-white shadow-sm">
                <div class="flex items-center justify-between p-4">
                    <!-- Hamburger Menu untuk Mobile -->
                    <div class="flex items-center gap-4">
                        <button id="menuBtn" type="button" class="p-2 rounded-lg hover:bg-gray-100 lg:hidden">
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                        <h1 class="text-xl font-bold text-gray-900 lg:text-2xl">@yield('page_title', 'Admin')</h1>
                    </div>

                    <!-- Profile Dropdown -->
                    <div class="relative">
                        <button id="profileBtn" type="button" class="flex items-center gap-2 p-2 rounded-lg hover:bg-gray-100">
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span class="hidden md:inline text-sm font-medium text-gray-700">Profile</span>
                        </button>
                        <div id="profileMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-50">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 rounded-t-lg">
                                Edit Profil
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-3 text-sm text-red-600 hover:bg-red-50 rounded-b-lg">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-4 md:p-6">
                @if($errors->any())
                    <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700">
                        <h4 class="font-bold mb-2">Terjadi Kesalahan:</h4>
                        <ul class="list-disc list-inside space-y-1 text-sm">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700">
                        {{ session('success') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>


    <script>
    // Jalankan setelah DOM ready
    // Toggle dropdown menu di sidebar
    function toggleDropdown(menuId) {
        var menu = document.getElementById(menuId);
        var arrow = document.getElementById(menuId + 'Arrow');
        if (menu) {
            menu.classList.toggle('hidden');
            if (arrow) {
                arrow.style.transform = menu.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(180deg)';
            }
        }
    }

    // Auto-open dropdown jika submenu aktif
    document.addEventListener('DOMContentLoaded', function() {
        // Buka dropdown jika ada menu aktif di dalamnya
        var kontenMenu = document.getElementById('kontenMenu');
        var orgMenu = document.getElementById('orgMenu');
        
        if (kontenMenu && kontenMenu.querySelector('.bg-green-600')) {
            kontenMenu.classList.remove('hidden');
            var arrow = document.getElementById('kontenMenuArrow');
            if (arrow) arrow.style.transform = 'rotate(180deg)';
        }
        if (orgMenu && orgMenu.querySelector('.bg-green-600')) {
            orgMenu.classList.remove('hidden');
            var arrow = document.getElementById('orgMenuArrow');
            if (arrow) arrow.style.transform = 'rotate(180deg)';
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        var sidebar = document.getElementById('sidebar');
        var overlay = document.getElementById('overlay');
        var menuBtn = document.getElementById('menuBtn');
        var closeBtn = document.getElementById('closeBtn');
        var mainContent = document.getElementById('mainContent');
        var profileBtn = document.getElementById('profileBtn');
        var profileMenu = document.getElementById('profileMenu');

        // Cek apakah desktop
        function isDesktop() {
            return window.innerWidth >= 1024;
        }

        // Buka sidebar (mobile)
        function openSidebar() {
            if (!sidebar || !overlay) return;
            sidebar.classList.remove('closed');
            sidebar.classList.add('open');
            sidebar.style.transform = 'translateX(0)';
            overlay.style.display = 'block';
        }

        // Tutup sidebar (mobile)
        function closeSidebar() {
            if (!sidebar || !overlay) return;
            if (isDesktop()) return; // Jangan tutup di desktop
            sidebar.classList.remove('open');
            sidebar.classList.add('closed');
            sidebar.style.transform = 'translateX(-100%)';
            overlay.style.display = 'none';
        }

        // Handle resize
        function handleResize() {
            if (isDesktop()) {
                // Desktop: sidebar selalu tampil, main content geser
                sidebar.style.transform = 'translateX(0)';
                overlay.style.display = 'none';
                mainContent.style.marginLeft = '16rem';
            } else {
                // Mobile: sidebar tersembunyi
                sidebar.style.transform = 'translateX(-100%)';
                overlay.style.display = 'none';
                mainContent.style.marginLeft = '0';
            }
        }

        // Event: tombol hamburger
        if (menuBtn) {
            menuBtn.onclick = function(e) {
                e.preventDefault();
                openSidebar();
            };
        }

        // Event: tombol close di sidebar
        if (closeBtn) {
            closeBtn.onclick = function(e) {
                e.preventDefault();
                closeSidebar();
            };
        }

        // Event: klik overlay tutup sidebar
        if (overlay) {
            overlay.onclick = function(e) {
                e.preventDefault();
                closeSidebar();
            };
        }

        // Event: profile dropdown
        if (profileBtn && profileMenu) {
            profileBtn.onclick = function(e) {
                e.stopPropagation();
                if (profileMenu.classList.contains('hidden')) {
                    profileMenu.classList.remove('hidden');
                } else {
                    profileMenu.classList.add('hidden');
                }
            };

            document.onclick = function(e) {
                if (!profileBtn.contains(e.target) && !profileMenu.contains(e.target)) {
                    profileMenu.classList.add('hidden');
                }
            };
        }

        // Event: ESC key
        document.onkeydown = function(e) {
            if (e.key === 'Escape') {
                closeSidebar();
                if (profileMenu) profileMenu.classList.add('hidden');
            }
        };

        // Event: resize window
        window.onresize = handleResize;

        // Initial setup
        handleResize();

        console.log('ISKAB Admin Layout V3 loaded');
    });
    </script>
</body>
</html>
