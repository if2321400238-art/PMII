<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - ISKAB')</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-900 text-white overflow-y-auto">
            <div class="p-6">
                <h1 class="text-2xl font-bold">ISKAB Admin</h1>
            </div>

            <nav class="mt-8">
                <a href="{{ route('admin.dashboard') }}" class="block px-6 py-3 text-gray-300 hover:bg-green-700 hover:text-white {{ request()->routeIs('admin.dashboard') ? 'bg-green-600 text-white' : '' }}">
                    Dashboard
                </a>

                {{-- Konten - Hanya Admin & Editor --}}
                @if(in_array(auth()->user()->role?->slug, ['admin', 'editor']))
                    <div class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Konten</div>
                    <a href="{{ route('admin.posts.index') }}" class="block px-6 py-3 text-gray-300 hover:bg-green-700 hover:text-white {{ request()->routeIs('admin.posts.*') ? 'bg-green-600 text-white' : '' }}">
                        Posts
                    </a>
                    <a href="{{ route('admin.gallery.index') }}" class="block px-6 py-3 text-gray-300 hover:bg-green-700 hover:text-white {{ request()->routeIs('admin.gallery.*') ? 'bg-green-600 text-white' : '' }}">
                        Galeri
                    </a>
                    <a href="{{ route('admin.download.index') }}" class="block px-6 py-3 text-gray-300 hover:bg-green-700 hover:text-white {{ request()->routeIs('admin.download.*') ? 'bg-green-600 text-white' : '' }}">
                        Download
                    </a>
                @endif

                {{-- Organisasi --}}
                <div class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider mt-6">Organisasi</div>

                {{-- Profil Organisasi - Hanya Admin --}}
                @if(auth()->user()->role?->slug === 'admin')
                    <a href="{{ route('admin.profil-organisasi.edit') }}" class="block px-6 py-3 text-gray-300 hover:bg-green-700 hover:text-white {{ request()->routeIs('admin.profil-organisasi.*') ? 'bg-green-600 text-white' : '' }}">
                        Profil Organisasi
                    </a>
                @endif

                {{-- Korwil - Admin & BPH PB --}}
                @if(in_array(auth()->user()->role?->slug, ['admin', 'bph_pb']))
                    <a href="{{ route('admin.korwil.index') }}" class="block px-6 py-3 text-gray-300 hover:bg-green-700 hover:text-white {{ request()->routeIs('admin.korwil.*') ? 'bg-green-600 text-white' : '' }}">
                        Korwil
                    </a>
                @endif

                {{-- Rayon - Admin, BPH PB, & BPH Korwil --}}
                @if(in_array(auth()->user()->role?->slug, ['admin', 'bph_pb', 'bph_korwil']))
                    <a href="{{ route('admin.rayon.index') }}" class="block px-6 py-3 text-gray-300 hover:bg-green-700 hover:text-white {{ request()->routeIs('admin.rayon.*') ? 'bg-green-600 text-white' : '' }}">
                        Rayon
                    </a>
                @endif

                {{-- Anggota - Admin, BPH Korwil, & BPH Rayon --}}
                @if(in_array(auth()->user()->role?->slug, ['admin', 'bph_korwil', 'bph_rayon']))
                    <a href="{{ route('admin.anggota.index') }}" class="block px-6 py-3 text-gray-300 hover:bg-green-700 hover:text-white {{ request()->routeIs('admin.anggota.*') ? 'bg-green-600 text-white' : '' }}">
                        Anggota
                    </a>
                @endif

                {{-- SK Pengajuan - Semua Role kecuali Editor --}}
                @if(auth()->user()->role?->slug !== 'editor')
                    <div class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider mt-6">SK Pengajuan</div>
                    <a href="{{ route('admin.sk-pengajuan.index') }}" class="block px-6 py-3 text-gray-300 hover:bg-green-700 hover:text-white {{ request()->routeIs('admin.sk-pengajuan.*') ? 'bg-green-600 text-white' : '' }}">
                        @if(auth()->user()->role?->slug === 'bph_pb')
                            Approval SK
                        @else
                            SK Saya
                        @endif
                    </a>
                @endif

                {{-- User Management - Admin only --}}
                @if(auth()->user()->role?->slug === 'admin')
                    <div class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider mt-6">Sistem</div>
                    <a href="{{ route('admin.users.index') }}" class="block px-6 py-3 text-gray-300 hover:bg-green-700 hover:text-white {{ request()->routeIs('admin.users.*') ? 'bg-green-600 text-white' : '' }}">
                        Kelola User
                    </a>
                @endif
            </nav>


        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-auto">
            <!-- Top Bar -->
            <header class="bg-white shadow-md p-6 flex justify-between items-center">
                <h1 class="text-3xl font-bold text-gray-900">@yield('page_title', 'Admin')</h1>
                <div class="flex items-center gap-4">
                    <div class="relative" x-data="{ profileOpen: false }">
                        <button @click="profileOpen = !profileOpen" class="flex items-center gap-2 px-4 py-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg">
                            Profile
                        </button>
                        <div x-show="profileOpen" @click.outside="profileOpen = false" class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg z-50">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-t-lg">
                                Edit Profil
                            </a>
                            <hr class="my-1">
                            <form method="POST" action="{{ route('logout') }}" class="block">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded-b-lg">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <div class="p-8">
                @if($errors->any())
                    <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                        <h4 class="font-bold mb-2">Terjadi Kesalahan:</h4>
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(session('success'))
                    <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
