<?php

namespace Database\Seeders;

use App\Models\LayananTerkait;
use App\Models\LayananTerkaitSetting;
use Illuminate\Database\Seeder;

class LayananTerkaitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Setting Header
        LayananTerkaitSetting::updateOrCreate(
            ['id' => 1],
            [
                'judul_seksi' => 'LAYANAN TERKAIT',
                'subjudul_seksi' => 'Akses cepat ke berbagai sistem dan layanan digital Universitas Ibnu Sina untuk mendukung kegiatan akademik, administrasi, dan kemahasiswaan.',
            ]
        );

        // 2. Data Link & Kartu Layanan
        $services = [
            [
                'nama' => 'E-ARSIP UIS',
                'deskripsi' => 'Sistem Informasi Tata Naskah & Pengarsipan Digital Surat Menyurat Universitas Ibnu Sina',
                'url' => 'https://e-arsip.uis.ac.id/',
                'logo' => 'assets/img/layanan-terkait/uis.svg',
                'icon' => 'bi-archive-fill',
                'urutan' => 1,
                'is_active' => true,
            ],
            [
                'nama' => 'SIAKAD UIS',
                'deskripsi' => 'Sistem Informasi Akademik Terpadu Mahasiswa dan Dosen Universitas Ibnu Sina',
                'url' => 'https://siakad.uis.ac.id/',
                'logo' => 'assets/img/layanan-terkait/siakad.svg',
                'icon' => 'bi-mortarboard-fill',
                'urutan' => 2,
                'is_active' => true,
            ],
            [
                'nama' => 'EDLINK',
                'deskripsi' => 'Learning Management System (LMS) & Ruang Diskusi Digital Perkuliahan',
                'url' => 'https://edlink.id/',
                'logo' => 'assets/img/layanan-terkait/edlink.svg',
                'icon' => 'bi-laptop',
                'urutan' => 3,
                'is_active' => true,
            ],
            [
                'nama' => 'SISTER',
                'deskripsi' => 'Sistem Informasi Sumberdaya Terintegrasi Pendidik & Tenaga Kependidikan Kemendikbudristek',
                'url' => 'https://sister.kemdikbud.go.id/',
                'logo' => 'assets/img/layanan-terkait/kemdikbud.svg',
                'icon' => 'bi-person-badge',
                'urutan' => 4,
                'is_active' => true,
            ],
            [
                'nama' => 'SINTA',
                'deskripsi' => 'Science and Technology Index Publikasi & Riset Dosen Nasional',
                'url' => 'https://sinta.kemdikbud.go.id/',
                'logo' => 'assets/img/layanan-terkait/sinta.svg',
                'icon' => 'bi-journal-bookmark-fill',
                'urutan' => 5,
                'is_active' => true,
            ],
            [
                'nama' => 'LLDIKTI XVII',
                'deskripsi' => 'Lembaga Layanan Pendidikan Tinggi Wilayah XVII Riau & Kepulauan Riau',
                'url' => 'https://lldikti17.kemdikbud.go.id/',
                'logo' => 'assets/img/layanan-terkait/kemdikbud.svg',
                'icon' => 'bi-building',
                'urutan' => 6,
                'is_active' => true,
            ],
            [
                'nama' => 'BIMA',
                'deskripsi' => 'Basis Informasi Penelitian & Pengabdian kepada Masyarakat Kemdiktisaintek',
                'url' => 'https://bima.kemdikbud.go.id/',
                'logo' => 'assets/img/layanan-terkait/bima.svg',
                'icon' => 'bi-search',
                'urutan' => 7,
                'is_active' => true,
            ],
            [
                'nama' => 'DIKTISAINTEK BERDAMPAK',
                'deskripsi' => 'Portal Program Prioritas & Inovasi Diktisaintek Berdampak',
                'url' => 'https://diktisaintek.kemdikbud.go.id/',
                'logo' => 'assets/img/layanan-terkait/diktisaintek.svg',
                'icon' => 'bi-award-fill',
                'urutan' => 8,
                'is_active' => true,
            ],
        ];

        foreach ($services as $service) {
            LayananTerkait::updateOrCreate(
                ['nama' => $service['nama']],
                $service
            );
        }
    }
}
