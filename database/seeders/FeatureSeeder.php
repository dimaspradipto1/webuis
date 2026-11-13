<?php

namespace Database\Seeders;

use App\Models\Feature;
use Illuminate\Database\Seeder;

class FeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Feature::truncate();

        $features = [
            [
                'icon' => Feature::packIconAndBadge('bi-layers', 'TERAKREDITASI'),
                'judul' => 'Program Studi',
                'deskripsi' => 'Terakreditasi BAN-PT dengan kurikulum berbasis industri',
                'urutan' => 1,
            ],
            [
                'icon' => Feature::packIconAndBadge('bi-house-door', 'AKTIF 2024'),
                'judul' => 'Kampus Berdampak',
                'deskripsi' => 'Mendorong inovasi dan kontribusi nyata bagi masyarakat',
                'urutan' => 2,
            ],
            [
                'icon' => Feature::packIconAndBadge('bi-people', 'MOU AKTIF'),
                'judul' => 'Kerjasama',
                'deskripsi' => 'Mitra industri dan institusi nasional & internasional',
                'urutan' => 3,
            ],
            [
                'icon' => Feature::packIconAndBadge('bi-award', 'BUKA 2025'),
                'judul' => 'Program Beasiswa',
                'deskripsi' => 'Jalur beasiswa prestasi, ekonomi, dan afirmasi daerah',
                'urutan' => 4,
            ],
        ];

        foreach ($features as $f) {
            Feature::create($f);
        }
    }
}
