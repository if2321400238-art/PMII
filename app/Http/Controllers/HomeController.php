<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Gallery;
use App\Models\Korwil;
use App\Models\Rayon;
use App\Models\Anggota;
use App\Models\SKPengajuan;
use App\Models\ProfilOrganisasi;

class HomeController extends Controller
{
    public function index()
    {
        // Berita populer (jika tidak ada, ambil berita terkini)
        $beritaPopuler = Post::berita()
            ->published()
            ->popular()
            ->latest('published_at')
            ->take(6)
            ->with(['author', 'category'])
            ->get();
        
        if ($beritaPopuler->isEmpty()) {
            $beritaPopuler = Post::berita()
                ->published()
                ->latest('published_at')
                ->take(6)
                ->with(['author', 'category'])
                ->get();
        }

        $beritaTerkini = Post::berita()
            ->published()
            ->latest('published_at')
            ->take(6)
            ->with(['author', 'category'])
            ->get();

        $penaSantriHighlight = Post::penaSantri()
            ->published()
            ->latest('published_at')
            ->take(5)
            ->with(['author', 'category'])
            ->get();

        $dokumentasi = Gallery::latest()
            ->take(8)
            ->get();

        // Statistics untuk halaman home
        $stats = [
            'korwil' => Korwil::count(),
            'rayon' => Rayon::count(),
            'anggota' => Anggota::count(),
            'sk_approved' => SKPengajuan::where('status', 'approved')->count(),
        ];

        $profil = ProfilOrganisasi::first();

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
