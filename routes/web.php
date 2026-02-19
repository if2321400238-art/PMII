<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\AnggotaController;
use App\Http\Controllers\Admin\RayonController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController;
use App\Http\Controllers\Admin\DownloadController as AdminDownloadController;
use App\Http\Controllers\Admin\AdController as AdminAdController;
use App\Http\Controllers\Admin\ProfilOrganisasiController;
use App\Http\Controllers\Admin\UserController;

use App\Http\Controllers\ProfileController;

// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Rubrik Routes
Route::get('/rubrik/berita', [PostController::class, 'indexBerita'])->name('posts.berita');

Route::get('/post/{post:slug}', [PostController::class, 'show'])->name('posts.show');

// Tentang Kami Routes
Route::prefix('tentang-kami')->group(function () {
    Route::get('/profil', [AboutController::class, 'profil'])->name('about.profil');
    Route::get('/rayon', [AboutController::class, 'rayon'])->name('about.rayon');
});

// Galeri Routes
Route::get('/galeri', [GalleryController::class, 'index'])->name('gallery.index');
Route::get('/galeri/{gallery}', [GalleryController::class, 'show'])->name('gallery.show');

// Download Routes
Route::get('/download', [DownloadController::class, 'index'])->name('download.index');
Route::get('/download/{download}', [DownloadController::class, 'show'])->name('download.show');
Route::post('/download/{download}/file', [DownloadController::class, 'download'])->name('download.file');

// Data Routes
Route::get('/data', [DataController::class, 'index'])->name('data.index');

// KTA Verification Route (public - for QR code scanning)
Route::get('/verify/anggota/{nomor_anggota}', function ($nomor_anggota) {
    $anggota = \App\Models\Anggota::with(['rayon'])
        ->where('nomor_anggota', $nomor_anggota)
        ->first();

    if (!$anggota) {
        return view('verify.not-found', ['nomor_anggota' => $nomor_anggota]);
    }

    return view('verify.anggota', ['anggota' => $anggota]);
})->name('verify.anggota');

// Debug Routes (temporary)
Route::get('/debug-posts-all', function () {
    $allPosts = \App\Models\Post::all();
    $beritaPublished = \App\Models\Post::berita()->published()->get();
    $penaSantriPublished = \App\Models\Post::penaSantri()->published()->get();

    return response()->json([
        'all_posts' => $allPosts->map(fn($p) => [
            'id' => $p->id,
            'title' => $p->title,
            'type' => $p->type,
            'published_at' => $p->published_at?->format('Y-m-d H:i:s'),
            'is_past' => $p->published_at ? $p->published_at <= now() : false,
        ]),
        'berita_published' => $beritaPublished->map(fn($p) => [
            'id' => $p->id,
            'title' => $p->title,
            'published_at' => $p->published_at->format('Y-m-d H:i:s'),
        ]),
        'pena_santri_published' => $penaSantriPublished->map(fn($p) => [
            'id' => $p->id,
            'title' => $p->title,
            'published_at' => $p->published_at->format('Y-m-d H:i:s'),
        ]),
        'now' => now()->format('Y-m-d H:i:s'),
    ]);
});

Route::get('/debug-home-data', function () {
    \Cache::forget('home.berita_populer');
    \Cache::forget('home.berita_terkini');
    \Cache::forget('home.pena_santri');

    $beritaPopuler = \App\Models\Post::berita()
        ->published()
        ->popular()
        ->latest('published_at')
        ->take(6)
        ->get();

    $penaSantriHighlight = \App\Models\Post::penaSantri()
        ->published()
        ->latest('published_at')
        ->take(5)
        ->get();

    return response()->json([
        'berita_populer_count' => $beritaPopuler->count(),
        'berita_populer' => $beritaPopuler->map(fn($p) => [
            'id' => $p->id,
            'title' => $p->title,
            'is_popular' => $p->is_popular,
        ]),
        'pena_santri_count' => $penaSantriHighlight->count(),
        'pena_santri' => $penaSantriHighlight->map(fn($p) => [
            'id' => $p->id,
            'title' => $p->title,
        ]),
    ]);
});

// Profile Routes (Breeze) - Support all guards (admin, rayon)
Route::middleware('auth.any')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Breeze default dashboard route -> redirect ke admin dashboard
Route::middleware(['auth.any'])->get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->name('dashboard');

// Admin Routes
Route::middleware(['auth.any'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Posts Management (Admin, Rayon Admin)
    Route::middleware('role:admin,rayon_admin')->group(function () {
        Route::resource('posts', AdminPostController::class);
        Route::post('/posts/{post}/approve', [AdminPostController::class, 'approve'])->name('posts.approve');
        Route::post('/posts/{post}/reject', [AdminPostController::class, 'reject'])->name('posts.reject');
        Route::post('/posts/{post}/publish', [AdminPostController::class, 'publish'])->name('posts.publish');
    });

    // Anggota Management (Admin, Rayon Admin)
    Route::middleware('role:admin,rayon_admin')->group(function () {
        Route::resource('anggota', AnggotaController::class);
        Route::get('/anggota/{anggota}/download-kta', [AnggotaController::class, 'downloadKTA'])->name('anggota.download-kta');
    });

    // Rayon Management (Admin only)
    Route::middleware('role:admin')->resource('rayon', RayonController::class);

    // Gallery Management (Admin, Rayon Admin)
    Route::middleware('role:admin,rayon_admin')->group(function () {
        Route::resource('gallery', AdminGalleryController::class);
        Route::post('/gallery/{gallery}/approve', [AdminGalleryController::class, 'approve'])->name('gallery.approve');
        Route::post('/gallery/{gallery}/reject', [AdminGalleryController::class, 'reject'])->name('gallery.reject');
    });

    // Download Management (Admin only)
    Route::middleware('role:admin')->group(function () {
        Route::resource('download', AdminDownloadController::class);
        Route::resource('ads', AdminAdController::class)->except(['show']);
    });

    // Profil Organisasi (Admin only)
    Route::middleware('role:admin')->group(function () {
        Route::get('/profil-organisasi', [ProfilOrganisasiController::class, 'edit'])->name('profil-organisasi.edit');
        Route::put('/profil-organisasi', [ProfilOrganisasiController::class, 'update'])->name('profil-organisasi.update');

        // User Management (Admin only)
        Route::resource('user', UserController::class);
    });
});

require __DIR__.'/auth.php';
