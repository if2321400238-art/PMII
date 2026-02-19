<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            CategorySeeder::class,
            RayonSeeder::class,
            ProfilOrganisasiSeeder::class,
            BeritaDanGallerySeeder::class,
        ]);

        $roleIds = Role::whereIn('slug', ['admin', 'rayon'])
            ->pluck('id', 'slug');

        // Create Admin User
        User::firstOrCreate(
            ['email' => 'admin@PMII.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('password'),
                'role_id' => $roleIds->get('admin'),
                'email_verified_at' => now(),
            ]
        );

        // Create BPH Rayon User (assign ke Rayon pertama)
        $firstRayon = \App\Models\Rayon::first();
        User::firstOrCreate(
            ['email' => 'bphrayon@PMII.com'],
            [
                'name' => 'BPH Rayon',
                'password' => bcrypt('password'),
                'role_id' => $roleIds->get('rayon'),
                'email_verified_at' => now(),
            ]
        );
    }
}
