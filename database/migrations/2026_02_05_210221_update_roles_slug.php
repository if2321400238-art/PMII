<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Update role slugs dari yang lama ke yang baru
        DB::table('roles')->where('slug', 'bph_pb')->update([
            'name' => 'Pengurus Besar',
            'slug' => 'pb',
            'description' => 'Pengurus Besar - Mengelola dan approve SK pengajuan'
        ]);

        DB::table('roles')->where('slug', 'bph_korwil')->update([
            'name' => 'Korwil',
            'slug' => 'korwil',
            'description' => 'Koordinator Wilayah - Mengelola rayon dan anggota di wilayahnya'
        ]);

        DB::table('roles')->where('slug', 'bph_rayon')->update([
            'name' => 'Rayon',
            'slug' => 'rayon',
            'description' => 'Pengurus Rayon - Mengelola anggota di rayonnya'
        ]);

        // Hapus role editor jika ada
        DB::table('roles')->where('slug', 'editor')->delete();
    }

    public function down(): void
    {
        // Rollback ke role lama
        DB::table('roles')->where('slug', 'pb')->update([
            'name' => 'BPH PB',
            'slug' => 'bph_pb',
            'description' => 'BPH Pusat Besar - Approve/Tolak/Revisi SK'
        ]);

        DB::table('roles')->where('slug', 'korwil')->update([
            'name' => 'BPH Korwil',
            'slug' => 'bph_korwil',
            'description' => 'BPH Koordinator Wilayah - Input Rayon & Anggota'
        ]);

        DB::table('roles')->where('slug', 'rayon')->update([
            'name' => 'BPH Rayon',
            'slug' => 'bph_rayon',
            'description' => 'BPH Rayon - Input Anggota'
        ]);

        // Restore role editor
        DB::table('roles')->insert([
            'name' => 'Editor',
            'slug' => 'editor',
            'description' => 'Editor Berita & Pena Santri',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
};
