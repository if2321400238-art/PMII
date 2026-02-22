<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Gallery;
use App\Models\Rayon;
use App\Models\Anggota;
use App\Models\ProfilOrganisasi;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        $cacheTtl = now()->addMinutes(5);

        // Berita populer (jika tidak ada, ambil berita terkini)
        $beritaPopuler = Cache::remember('home:berita-populer', $cacheTtl, function () {
            $result = Post::berita()
                ->published()
                ->popular()
                ->latest('published_at')
                ->take(6)
                ->with(['author', 'category'])
                ->get();

            if ($result->isNotEmpty()) {
                return $result;
            }

            return Post::berita()
                ->published()
                ->latest('published_at')
                ->take(6)
                ->with(['author', 'category'])
                ->get();
        });

        $beritaTerkini = Cache::remember('home:berita-terkini', $cacheTtl, function () {
            return Post::berita()
                ->published()
                ->latest('published_at')
                ->take(6)
                ->with(['author', 'category'])
                ->get();
        });

        $galleryHighlight = Cache::remember('home:gallery-highlight', $cacheTtl, function () {
            return Gallery::approved()
                ->latest()
                ->take(5)
                ->get();
        });

        // Statistics untuk halaman home
        $stats = Cache::remember('home:stats', $cacheTtl, function () {
            return [
                'rayon' => Rayon::count(),
                'anggota' => Anggota::count(),
            ];
        });

        $profil = Cache::remember('home:profil-organisasi:first', $cacheTtl, function () {
            return ProfilOrganisasi::first();
        });

        return view('frontend.home', compact(
            'beritaPopuler',
            'beritaTerkini',
            'galleryHighlight',
            'stats',
            'profil'
        ));
    }
}
