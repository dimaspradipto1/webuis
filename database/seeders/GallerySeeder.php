<?php

namespace Database\Seeders;

use App\Models\Gallery;
use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'judul' => 'Praktikum Uji Higiene Industri & Deteksi Kebisingan',
                'deskripsi' => 'Mahasiswa Program Studi S1 K3 melakukan pengukuran intensitas kebisingan dan lux meter di laboratorium terpadu.',
                'url' => 'news/gallery/Efovwdh2GyB9NOLgACPf218cw7N7MeDXFAUDBnih.jpg',
            ],
            [
                'judul' => 'Studi Lapangan & Pengambilan Sampel Air Limbah Pesisir',
                'deskripsi' => 'Kegiatan lapangan mahasiswa S1 Kesehatan Lingkungan dalam analisis parameter BOD/COD di perairan industri Batam.',
                'url' => 'news/gallery/HFKUfCcjAxO1drsegABwhs8L3G5zH3LX4G7CpUS5.jpg',
            ],
            [
                'judul' => 'Seminar Nasional Kebijakan Kesehatan Masyarakat & Epidemiologi',
                'deskripsi' => 'Kuliah pakar dan diseminasi riset mahasiswa Magister (S2) Kesehatan Masyarakat bersama narasumber Kemenkes.',
                'url' => 'news/gallery/Efovwdh2GyB9NOLgACPf218cw7N7MeDXFAUDBnih.jpg',
            ],
            [
                'judul' => 'Pelatihan Tanggap Darurat & Simulasi Pemadam Kebakaran',
                'deskripsi' => 'Workshop simulasi keselamatan kerja dan evakuasi kebakaran bersertifikasi bagi mahasiswa Universitas Ibnu Sina (UIS).',
                'url' => 'news/gallery/HFKUfCcjAxO1drsegABwhs8L3G5zH3LX4G7CpUS5.jpg',
            ],
            [
                'judul' => 'Bakti Sosial & Pemeriksaan Kesehatan Gratis Masyarakat',
                'deskripsi' => 'Pengabdian kepada masyarakat oleh BEM dan civitas akademika UIS di kawasan pemukiman nelayan Pulau Batam.',
                'url' => 'news/gallery/Efovwdh2GyB9NOLgACPf218cw7N7MeDXFAUDBnih.jpg',
            ],
            [
                'judul' => 'Kunjungan Industri & Audit K3 di Galangan Kapal Terkemuka',
                'deskripsi' => 'Field trip terpadu mahasiswa K3 dalam mengobservasi implementasi SMK3 dan inspeksi keselamatan kerja galangan.',
                'url' => 'news/gallery/HFKUfCcjAxO1drsegABwhs8L3G5zH3LX4G7CpUS5.jpg',
            ],
        ];

        foreach ($data as $item) {
            Gallery::updateOrCreate(
                ['judul' => $item['judul']],
                $item
            );
        }
    }
}
