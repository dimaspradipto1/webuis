<?php

namespace Database\Seeders;

use App\Models\Akreditasi;
use App\Models\ProgramStudi;
use Illuminate\Database\Seeder;

class AkreditasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Akreditasi Institusi / Universitas
        Akreditasi::updateOrCreate(
            ['tingkat' => 'universitas', 'nama' => 'Universitas Ibnu Sina (UIS)'],
            [
                'kategori_label' => 'Institusi',
                'jenjang' => 'Institusi',
                'lembaga' => 'BAN-PT',
                'peringkat' => 'Baik Sekali',
                'nomor_sk' => '198/SK/BAN-PT/Ak/PT/III/2023',
                'tahun_sk' => '2023',
                'masa_berlaku' => '15 Maret 2023 - 15 Maret 2028',
                'link_gdrive' => 'https://drive.google.com/drive/folders/1uis-akreditasi-institusi-resmi',
                'urutan' => 1,
                'is_active' => true,
            ]
        );

        // 2. Akreditasi Tingkat Fakultas
        $fakultasData = [
            [
                'nama' => 'Program Pascasarjana',
                'kategori_label' => 'Program Pascasarjana',
                'lembaga' => 'BAN-PT',
                'peringkat' => 'Baik Sekali',
                'nomor_sk' => '312/SK/BAN-PT/Ak/Fak/VI/2023',
                'tahun_sk' => '2023',
                'masa_berlaku' => '2023 - 2028',
                'urutan' => 1,
            ],
            [
                'nama' => 'Fakultas Ekonomi dan Bisnis (FEB)',
                'kategori_label' => 'Fakultas Ekonomi dan Bisnis',
                'lembaga' => 'LAMEMBA',
                'peringkat' => 'Baik Sekali',
                'nomor_sk' => '455/SK/LAMEMBA/Ak/VII/2023',
                'tahun_sk' => '2023',
                'masa_berlaku' => '2023 - 2028',
                'urutan' => 2,
            ],
            [
                'nama' => 'Fakultas Sains dan Teknologi (FST)',
                'kategori_label' => 'Fakultas Sains dan Teknologi',
                'lembaga' => 'LAM-INFOKOM',
                'peringkat' => 'Baik Sekali',
                'nomor_sk' => '567/SK/LAM-INFOKOM/Ak/VIII/2023',
                'tahun_sk' => '2023',
                'masa_berlaku' => '2023 - 2028',
                'urutan' => 3,
            ],
            [
                'nama' => 'Fakultas Ilmu Kesehatan (FIKES)',
                'kategori_label' => 'Fakultas Ilmu Kesehatan',
                'lembaga' => 'LAM-PTKes',
                'peringkat' => 'Baik Sekali',
                'nomor_sk' => '678/SK/LAM-PTKes/Ak/IX/2023',
                'tahun_sk' => '2023',
                'masa_berlaku' => '2023 - 2028',
                'urutan' => 4,
            ],
        ];

        foreach ($fakultasData as $fak) {
            Akreditasi::updateOrCreate(
                ['tingkat' => 'fakultas', 'nama' => $fak['nama']],
                [
                    'kategori_label' => $fak['kategori_label'],
                    'jenjang' => 'Fakultas',
                    'lembaga' => $fak['lembaga'],
                    'peringkat' => $fak['peringkat'],
                    'nomor_sk' => $fak['nomor_sk'],
                    'tahun_sk' => $fak['tahun_sk'],
                    'masa_berlaku' => $fak['masa_berlaku'],
                    'link_gdrive' => 'https://drive.google.com/drive/folders/1uis-akreditasi-' . \Illuminate\Support\Str::slug($fak['nama']),
                    'urutan' => $fak['urutan'],
                    'is_active' => true,
                ]
            );
        }

        // 3. Akreditasi Seluruh Program Studi (Sync dari table Program Studi)
        $prodis = ProgramStudi::all();
        $urutanProdi = 1;

        $lembagaMapping = [
            'Program Pascasarjana' => 'BAN-PT',
            'Fakultas Ekonomi dan Bisnis' => 'LAMEMBA',
            'Fakultas Sains dan Teknologi' => 'LAM-INFOKOM',
            'Fakultas Ilmu Kesehatan' => 'LAM-PTKes',
        ];

        foreach ($prodis as $p) {
            $lembaga = $lembagaMapping[$p->fakultas] ?? 'BAN-PT';
            if (str_contains($p->nama, 'Teknik Industri') || str_contains($p->nama, 'Teknik Perkapalan') || str_contains($p->nama, 'Teknik Logistik')) {
                $lembaga = 'LAM Teknik';
            }

            Akreditasi::updateOrCreate(
                ['tingkat' => 'prodi', 'nama' => $p->nama],
                [
                    'kategori_label' => $p->fakultas ?? 'Program Studi',
                    'jenjang' => $p->jenjang ?? 'S1',
                    'lembaga' => $lembaga,
                    'peringkat' => $p->akreditasi ?: 'Baik Sekali',
                    'nomor_sk' => ($p->id * 112) . '/SK/' . str_replace(' ', '-', $lembaga) . '/Ak/' . ($p->jenjang ?: 'S1') . '/2023',
                    'tahun_sk' => '2023',
                    'masa_berlaku' => '2023 - 2028',
                    'link_gdrive' => 'https://drive.google.com/drive/folders/1uis-akreditasi-' . \Illuminate\Support\Str::slug($p->nama),
                    'urutan' => $urutanProdi++,
                    'is_active' => true,
                ]
            );
        }
    }
}
