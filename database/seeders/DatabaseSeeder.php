<?php

namespace Database\Seeders;

use App\Models\User;
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
            KorwilSeeder::class,
            RayonSeeder::class,
            ProfilOrganisasiSeeder::class,
        ]);

        // Create Admin User
        User::create([
            'name' => 'Admin',
            'email' => 'admin@iskab.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Create Editor User
        User::create([
            'name' => 'Editor',
            'email' => 'editor@iskab.com',
            'password' => bcrypt('password'),
            'role' => 'pb',
            'email_verified_at' => now(),
        ]);

        // Create BPH PB User
        User::create([
            'name' => 'BPH PB',
            'email' => 'bphpb@iskab.com',
            'password' => bcrypt('password'),
            'role' => 'pb',
            'email_verified_at' => now(),
        ]);

        // Create BPH Korwil User (assign ke Korwil pertama)
        $firstKorwil = \App\Models\Korwil::first();
        User::create([
            'name' => 'BPH Korwil',
            'email' => 'bphkorwil@iskab.com',
            'password' => bcrypt('password'),
            'role' => 'korwil_admin',
            'korwil_id' => $firstKorwil?->id,
            'email_verified_at' => now(),
        ]);

        // Create BPH Rayon User (assign ke Rayon pertama)
        $firstRayon = \App\Models\Rayon::first();
        User::create([
            'name' => 'BPH Rayon',
            'email' => 'bphrayon@iskab.com',
            'password' => bcrypt('password'),
            'role' => 'rayon_admin',
            'rayon_id' => $firstRayon?->id,
            'email_verified_at' => now(),
        ]);
    }
}
