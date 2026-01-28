<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Gallery;
use App\Models\Korwil;
use App\Models\Rayon;
use App\Models\Anggota;
use App\Models\SKPengajuan;
use App\Models\ProfilOrganisasi;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        // Cache ringan selama 5 menit untuk homepage agar respon lebih cepat
        // Untuk development, gunakan waktu cache yang lebih pendek (30 detik)
        $cacheTime = config('app.env') === 'local' ? 30 : 300;

        $beritaPopuler = Cache::remember('home.berita_populer', $cacheTime, function () {
            return Post::berita()
                ->published()
                ->popular()
                ->latest('published_at')
                ->take(6)
                ->with(['author', 'category'])
                ->get();
        });

        $beritaTerkini = Cache::remember('home.berita_terkini', $cacheTime, function () {
            return Post::berita()
                ->published()
                ->latest('published_at')
                ->take(6)
                ->with(['author', 'category'])
                ->get();
        });

        $penaSantriHighlight = Cache::remember('home.pena_santri', $cacheTime, function () {
            return Post::penaSantri()
                ->published()
                ->latest('published_at')
                ->take(5)
                ->with(['author', 'category'])
                ->get();
        });

        $dokumentasi = Cache::remember('home.dokumentasi', $cacheTime, function () {
            return Gallery::latest()
                ->take(8)
                ->get();
        });

        // Statistics untuk halaman home (otomatis update)
        $stats = Cache::remember('home.stats', $cacheTime, function () {
            return [
                'korwil' => Korwil::count(),
                'rayon' => Rayon::count(),
                'anggota' => Anggota::count(),
                'sk_approved' => SKPengajuan::where('status', 'approved')->count(),
            ];
        });

        $profil = Cache::remember('home.profil', $cacheTime, fn () => ProfilOrganisasi::first());

        return view('frontend.home', compact(
            'beritaPopuler',
            'beritaTerkini',
            'penaSantriHighlight',
            'dokumentasi',
            'stats',
            'profil'
        ));
    }
}
