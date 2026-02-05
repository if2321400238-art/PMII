<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Admin',
                'slug' => 'admin',
                'description' => 'Administrator dengan akses penuh ke seluruh sistem',
            ],
            [
                'name' => 'Pengurus Besar',
                'slug' => 'pb',
                'description' => 'Pengurus Besar - Mengelola dan approve SK pengajuan',
            ],
            [
                'name' => 'Korwil',
                'slug' => 'korwil',
                'description' => 'Koordinator Wilayah - Mengelola rayon dan anggota di wilayahnya',
            ],
            [
                'name' => 'Rayon',
                'slug' => 'rayon',
                'description' => 'Pengurus Rayon - Mengelola anggota di rayonnya',
            ],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['slug' => $role['slug']], $role);
        }
    }
}
