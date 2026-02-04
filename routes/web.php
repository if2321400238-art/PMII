<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\SKPengajuanController;
use App\Http\Controllers\Admin\AnggotaController;
use App\Http\Controllers\Admin\KorwilController;
use App\Http\Controllers\Admin\RayonController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController;
use App\Http\Controllers\Admin\DownloadController as AdminDownloadController;
use App\Http\Controllers\Admin\ProfilOrganisasiController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;

// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Rubrik Routes
Route::get('/rubrik/berita', [PostController::class, 'indexBerita'])->name('posts.berita');
Route::get('/rubrik/pena-santri', [PostController::class, 'indexPenaSantri'])->name('posts.pena-santri');
Route::get('/post/{post:slug}', [PostController::class, 'show'])->name('posts.show');

// Tentang Kami Routes
Route::prefix('tentang-kami')->group(function () {
    Route::get('/profil', [AboutController::class, 'profil'])->name('about.profil');
    Route::get('/korwil', [AboutController::class, 'korwil'])->name('about.korwil');
    Route::get('/rayon', [AboutController::class, 'rayon'])->name('about.rayon');
});

// Galeri Routes
Route::get('/galeri', [GalleryController::class, 'index'])->name('gallery.index');
Route::get('/galeri/{gallery}', [GalleryController::class, 'show'])->name('gallery.show');

// Download Routes
Route::get('/download', [DownloadController::class, 'index'])->name('download.index');
Route::get('/download/{download}', [DownloadController::class, 'download'])->name('download.file');

// Data Routes
Route::get('/data', [DataController::class, 'index'])->name('data.index');

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

// Profile Routes (Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Breeze default dashboard route -> redirect ke admin dashboard
Route::middleware(['auth', 'verified'])->get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->name('dashboard');

// Admin Routes
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Posts Management (Editor & Admin)
    Route::middleware('role:editor,admin')->resource('posts', AdminPostController::class);

    // SK Pengajuan Management
    // Korwil & Rayon bisa create & view sendiri, BPH PB bisa approve/revise/reject semua
    Route::middleware('role:bph_korwil,bph_rayon,bph_pb')->group(function () {
        Route::get('/sk-pengajuan', [SKPengajuanController::class, 'index'])->name('sk-pengajuan.index');
        Route::get('/sk-pengajuan/create', [SKPengajuanController::class, 'create'])->name('sk-pengajuan.create');
        Route::post('/sk-pengajuan', [SKPengajuanController::class, 'store'])->name('sk-pengajuan.store');
        Route::get('/sk-pengajuan/{pengajuan}', [SKPengajuanController::class, 'show'])->name('sk-pengajuan.show');

        // Only BPH PB can approve/revise/reject
        Route::middleware('role:bph_pb')->group(function () {
            Route::post('/sk-pengajuan/{pengajuan}/approve', [SKPengajuanController::class, 'approve'])->name('sk-pengajuan.approve');
            Route::post('/sk-pengajuan/{pengajuan}/revise', [SKPengajuanController::class, 'revise'])->name('sk-pengajuan.revise');
            Route::post('/sk-pengajuan/{pengajuan}/reject', [SKPengajuanController::class, 'reject'])->name('sk-pengajuan.reject');
        });
    });

    // Anggota Management (BPH Korwil & BPH Rayon)
    Route::middleware('role:bph_korwil')->resource('anggota', AnggotaController::class);
    Route::get('/anggota/{anggota}/download-kta', [AnggotaController::class, 'downloadKTA'])->name('anggota.download-kta');

    // Korwil Management (Admin only)
    Route::middleware('role:admin')->resource('korwil', KorwilController::class);

    // Rayon Management (Admin & BPH Korwil)
    Route::middleware('role:bph_korwil')->group(function () {
        Route::resource('rayon', RayonController::class);
        Route::get('/rayon/by-korwil/{korwil}', [RayonController::class, 'listByKorwil'])->name('rayon.by-korwil');
    });

    // Gallery Management (Editor & Admin)
    Route::middleware('role:editor,admin')->resource('gallery', AdminGalleryController::class);

    // Download Management (Admin only)
    Route::middleware('role:admin')->resource('download', AdminDownloadController::class);

    // Profil Organisasi (Admin only)
    Route::middleware('role:admin')->group(function () {
        Route::get('/profil-organisasi', [ProfilOrganisasiController::class, 'edit'])->name('profil-organisasi.edit');
        Route::put('/profil-organisasi', [ProfilOrganisasiController::class, 'update'])->name('profil-organisasi.update');

        // User Management (Admin only)
        Route::resource('users', UserController::class);
    });
});

require __DIR__.'/auth.php';
