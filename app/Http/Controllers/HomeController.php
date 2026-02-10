<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Gallery;
use App\Models\Rayon;
use App\Models\Anggota;
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

        $galleryHighlight = Gallery::latest()
            ->take(5)
            ->get();

        // Statistics untuk halaman home
        $stats = [
            'rayon' => Rayon::count(),
            'anggota' => Anggota::count(),
        ];

        $profil = ProfilOrganisasi::first();

        return view('frontend.home', compact(
            'beritaPopuler',
            'beritaTerkini',
            'galleryHighlight',
            'stats',
            'profil'
        ));
    }
}
