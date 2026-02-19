<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Gallery;
use App\Models\Category;
use App\Models\User;
use Carbon\Carbon;

class BeritaDanGallerySeeder extends Seeder
{
    public function run(): void
    {
        $author = User::firstOrCreate(
            ['email' => 'seeder@pmii.local'],
            [
                'name' => 'Seeder PMII',
                'password' => 'password',
            ]
        );

        $beritaCategory = Category::firstOrCreate(
            ['slug' => 'berita'],
            [
                'name' => 'Berita',
                'description' => 'Kategori berita otomatis',
            ]
        );

        for ($i = 1; $i <= 5; $i++) {
            Post::updateOrCreate([
                'slug' => "contoh-berita-$i",
            ], [
                'type' => 'berita',
                'title' => "Contoh Berita $i",
                'content' => "Ini isi berita ke-$i.",
                'category_id' => $beritaCategory->id,
                'author_id' => $author->id,
                'author_type' => 'App\\Models\\User',
                'is_popular' => true,
                'published_at' => Carbon::now()->subDays($i),
                'approval_status' => 'approved',
                'approved_by' => $author->id,
                'approved_at' => Carbon::now()->subDays($i),
            ]);
        }

        for ($i = 1; $i <= 5; $i++) {
            Gallery::updateOrCreate([
                'title' => "Galeri $i",
                'tahun' => 2026,
            ], [
                'type' => 'photo',
                'description' => "Deskripsi galeri $i.",
                'file_path' => "/images/gallery-$i.jpg",
                'approval_status' => 'approved',
                'approved_by' => $author->id,
                'approved_at' => Carbon::now()->subDays($i),
                'uploaded_by' => $author->id,
                'uploader_type' => 'App\\Models\\User',
            ]);
        }
    }
}
