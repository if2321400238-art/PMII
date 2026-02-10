<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProfilOrganisasi;

class ProfilOrganisasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProfilOrganisasi::firstOrCreate(['id' => 1], [
            'nama_organisasi' => 'PMII Komisariat Universitas Nurul Jadid',
            'logo_path' => null,
            'sejarah' => 'Pergerakan Mahasiswa Islam Indonesia (PMII) Komisariat Universitas Nurul Jadid merupakan organisasi mahasiswa Islam yang berafiliasi dengan Nahdlatul Ulama (NU). PMII didirikan pada 17 April 1960 di Surabaya sebagai wadah pembinaan dan pengembangan mahasiswa yang berasaskan Islam Ahlusunnah Wal Jamaah. PMII Komisariat Universitas Nurul Jadid berdiri sebagai representasi gerakan mahasiswa Islam di lingkungan kampus Universitas Nurul Jadid, dengan komitmen untuk membentuk kader-kader intelektual yang religius, kritis, dan berjiwa pemimpin.',
            'visi' => 'Terwujudnya PMII Komisariat Universitas Nurul Jadid sebagai organisasi mahasiswa Islam yang kokoh dalam keilmuan, militan dalam perjuangan, dan istiqomah dalam pengabdian.',
            'misi' => json_encode([
                'Membina dan mengembangkan kader PMII yang berilmu, berakhlak mulia, dan berjiwa kepemimpinan',
                'Memperkuat nilai-nilai Aswaja (Ahlusunnah Wal Jamaah) di kalangan mahasiswa',
                'Mengembangkan tradisi keilmuan dan intelektualitas mahasiswa berbasis nilai-nilai keislaman',
                'Melakukan advokasi dan pemberdayaan masyarakat berdasarkan nilai-nilai keadilan sosial',
                'Membangun ukhuwah islamiyah dan networking dengan organisasi mahasiswa Islam lainnya',
            ]),
            'struktur_organisasi' => null,
        ]);
    }
}
