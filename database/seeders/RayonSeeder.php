<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rayon;

class RayonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rayons = [
            // Rayon di bawah Komisariat Universitas Nurul Jadid
            [
                'name' => 'Rayon Nusantara',
                'description' => 'Rayon Nusantara - PMII Komisariat Universitas Nurul Jadid',
                'contact' => '085234567890',
                'email' => 'nusantara@pmii-unuja.ac.id',
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'Rayon Ibnu Firnas',
                'description' => 'Rayon Ibnu Firnas - PMII Komisariat Universitas Nurul Jadid',
                'contact' => '085245678901',
                'email' => 'ibnufirnas@pmii-unuja.ac.id',
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'Rayon Asghar Ali Engineer',
                'description' => 'Rayon Asghar Ali Engineer - PMII Komisariat Universitas Nurul Jadid',
                'contact' => '085256789012',
                'email' => 'asghar@pmii-unuja.ac.id',
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'Rayon Ibnu Khaldun',
                'description' => 'Rayon Ibnu Khaldun - PMII Komisariat Universitas Nurul Jadid',
                'contact' => '085267890123',
                'email' => 'ibnukhaldun@pmii-unuja.ac.id',
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'Rayon Al-Wahid',
                'description' => 'Rayon Al-Wahid - PMII Komisariat Universitas Nurul Jadid',
                'contact' => '085278901234',
                'email' => 'alwahid@pmii-unuja.ac.id',
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'Rayon Avicena',
                'description' => 'Rayon Avicena - PMII Komisariat Universitas Nurul Jadid',
                'contact' => '085289012345',
                'email' => 'avicena@pmii-unuja.ac.id',
                'password' => bcrypt('password'),
            ],
        ];

        foreach ($rayons as $rayon) {
            Rayon::updateOrCreate(
                ['email' => $rayon['email']],
                $rayon
            );
        }
    }
}
