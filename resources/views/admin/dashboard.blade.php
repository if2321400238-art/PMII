@extends('layouts.admin')

@section('title', 'Dashboard Admin - ISKAB')
@section('page_title', 'Dashboard')

@section('content')
@php
    $role = auth()->user()->role
        ?? (auth()->guard('korwil')->check() ? 'korwil_admin' : (auth()->guard('rayon')->check() ? 'rayon_admin' : null));
    $roleLabel = match ($role) {
        'admin' => 'Admin',
        'pb' => 'PB',
        'korwil_admin' => 'Korwil Admin',
        'rayon_admin' => 'Rayon Admin',
        default => 'User',
    };
@endphp
<section aria-labelledby="stats-heading">
    <h2 id="stats-heading" class="sr-only">Statistik Dashboard</h2>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-6 mb-8 md:mb-12">
        <!-- Stats Card -->
        <article class="bg-white rounded-lg shadow-md p-4 md:p-6 border-l-4 border-green-600">
            <h3 class="text-gray-600 text-xs md:text-sm font-semibold">Total Posts</h3>
            <p class="text-xl md:text-3xl font-bold text-green-600 mt-2" aria-label="Total Posts: {{ \App\Models\Post::count() }}">{{ \App\Models\Post::count() }}</p>
        </article>

        <article class="bg-white rounded-lg shadow-md p-4 md:p-6 border-l-4 border-green-600">
            <h3 class="text-gray-600 text-xs md:text-sm font-semibold">Total Anggota</h3>
            <p class="text-xl md:text-3xl font-bold text-green-600 mt-2" aria-label="Total Anggota: {{ \App\Models\Anggota::count() }}">{{ \App\Models\Anggota::count() }}</p>
        </article>

        <article class="bg-white rounded-lg shadow-md p-4 md:p-6 border-l-4 border-green-600">
            <h3 class="text-gray-600 text-xs md:text-sm font-semibold">Total Korwil</h3>
            <p class="text-xl md:text-3xl font-bold text-green-600 mt-2" aria-label="Total Korwil: {{ \App\Models\Korwil::count() }}">{{ \App\Models\Korwil::count() }}</p>
        </article>

        <article class="bg-white rounded-lg shadow-md p-4 md:p-6 border-l-4 border-green-600">
            <h3 class="text-gray-600 text-xs md:text-sm font-semibold">SK Pending</h3>
            <p class="text-xl md:text-3xl font-bold text-green-600 mt-2" aria-label="SK Pending: {{ \App\Models\SKPengajuan::where('status', 'pending')->count() }}">{{ \App\Models\SKPengajuan::where('status', 'pending')->count() }}</p>
        </article>
    </div>
</section>

<!-- Quick Actions -->
<section class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 md:mb-12" aria-labelledby="quick-actions-heading">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 id="quick-actions-heading" class="text-lg md:text-2xl font-bold mb-4">Quick Actions</h2>
        <nav class="space-y-2 md:space-y-3" aria-label="Aksi cepat">
            <a href="{{ route('admin.posts.create') }}" class="block px-4 py-2 md:py-3 bg-green-700 text-white rounded-lg hover:bg-green-800 focus:ring-2 focus:ring-green-500 focus:ring-offset-2 text-center font-semibold text-sm md:text-base">
                Buat Post Baru
            </a>
            <a href="{{ route('admin.anggota.create') }}" class="block px-4 py-2 md:py-3 bg-green-700 text-white rounded-lg hover:bg-green-800 focus:ring-2 focus:ring-green-500 focus:ring-offset-2 text-center font-semibold text-sm md:text-base">
                Tambah Anggota
            </a>
            <a href="{{ route('admin.gallery.create') }}" class="block px-4 py-2 md:py-3 bg-green-700 text-white rounded-lg hover:bg-green-800 focus:ring-2 focus:ring-green-500 focus:ring-offset-2 text-center font-semibold text-sm md:text-base">
                Upload Galeri
            </a>
        </nav>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-lg md:text-2xl font-bold mb-4">Informasi Sistem</h2>
        <dl class="space-y-2 text-xs md:text-sm text-gray-600">
            <div><dt class="inline font-bold">Role Anda:</dt> <dd class="inline">{{ $roleLabel }}</dd></div>
            <div><dt class="inline font-bold">Nama:</dt> <dd class="inline">{{ auth()->user()->name }}</dd></div>
            <div class="break-all"><dt class="inline font-bold">Email:</dt> <dd class="inline">{{ auth()->user()->email }}</dd></div>
            <div><dt class="inline font-bold">Bergabung:</dt> <dd class="inline"><time datetime="{{ auth()->user()->created_at->toIso8601String() }}">{{ auth()->user()->created_at->format('d F Y') }}</time></dd></div>
        </dl>
    </div>
</section>

<!-- Recent Activities -->
<section class="grid grid-cols-1 lg:grid-cols-2 gap-6" aria-labelledby="recent-activities-heading">
    <h2 id="recent-activities-heading" class="sr-only">Aktivitas Terbaru</h2>
    <article class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg md:text-2xl font-bold mb-4">Post Terbaru</h3>
        <ul class="space-y-4 list-none">
            @forelse(\App\Models\Post::latest()->take(5)->get() as $post)
                <li class="border-b pb-4 last:border-b-0">
                    <h4 class="font-semibold text-sm md:text-base text-gray-900">{{ $post->title }}</h4>
                    <p class="text-xs md:text-sm text-gray-600">Oleh: {{ $post->author?->name ?? 'Unknown' }}</p>
                    <time datetime="{{ $post->created_at->toIso8601String() }}" class="text-xs text-gray-500">{{ $post->created_at->format('d M Y H:i') }}</time>
                </li>
            @empty
                <li class="text-gray-500 text-sm">Belum ada posts</li>
            @endforelse
        </ul>
    </article>

    @if(in_array($role, ['admin', 'pb']))
        <article class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg md:text-2xl font-bold mb-4">SK Pengajuan Pending</h3>
            <ul class="space-y-4 list-none">
                @forelse(\App\Models\SKPengajuan::where('status', 'pending')->latest()->take(5)->get() as $sk)
                    <li class="border-b pb-4 last:border-b-0">
                        <h4 class="font-semibold text-sm md:text-base text-gray-900">{{ $sk->nama }}</h4>
                        <p class="text-xs md:text-sm text-gray-600">Tipe: {{ ucfirst($sk->tipe) }}</p>
                        <time datetime="{{ $sk->created_at->toIso8601String() }}" class="text-xs text-gray-500">{{ $sk->created_at->format('d M Y H:i') }}</time>
                        <a href="{{ route('admin.sk-pengajuan.show', $sk) }}" class="text-xs text-green-700 hover:text-green-800 focus:underline font-semibold mt-2 inline-block">
                            Review →
                        </a>
                    </li>
                @empty
                    <li class="text-gray-500 text-sm">Tidak ada SK pending</li>
                @endforelse
            </ul>
        </article>
    @endif
</section>
@endsection
