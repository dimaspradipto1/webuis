<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Faq::truncate();

        $faqs = [
            // Akademik & Program Studi
            [
                'question' => 'Apa saja fakultas dan program studi yang tersedia di Universitas Ibnu Sina (UIS)?',
                'answer' => 'Universitas Ibnu Sina (UIS) menyelenggarakan berbagai program studi unggulan jenjang Sarjana (S1) dan Pascasarjana (S2) yang terbagi dalam Fakultas Teknik (Teknik Industri, Teknik Informatika, Sistem Informasi, Teknik Logistik, Teknik Perkapalan), Fakultas Ekonomi & Bisnis (Manajemen, Akuntansi), Fakultas Ilmu Kesehatan (K3, Kesehatan Lingkungan), serta Program Pascasarjana (Magister Manajemen, Magister Kesehatan Masyarakat).',
                'category' => 'akademik',
            ],
            [
                'question' => 'Bagaimana status akreditasi program studi di Universitas Ibnu Sina (UIS)?',
                'answer' => 'Seluruh program studi di Universitas Ibnu Sina (UIS) telah terakreditasi resmi oleh Badan Akreditasi Nasional Perguruan Tinggi (BAN-PT) serta Lembaga Akreditasi Mandiri terkait (LAM-PTKes, LAM INFOKOM, dan LAMEMBA) dengan peringkat Baik Sekali dan Baik.',
                'category' => 'akademik',
            ],
            [
                'question' => 'Apakah Universitas Ibnu Sina (UIS) menyediakan kelas karyawan / perkuliahan malam?',
                'answer' => 'Ya, Universitas Ibnu Sina (UIS) menyediakan program kelas reguler pagi serta kelas karyawan / kelas malam dan akhir pekan yang fleksibel bagi mahasiswa yang sedang bekerja atau berwirausaha.',
                'category' => 'akademik',
            ],

            // Pendaftaran & Penerimaan Mahasiswa Baru
            [
                'question' => 'Bagaimana alur pendaftaran mahasiswa baru di Universitas Ibnu Sina (UIS)?',
                'answer' => 'Pendaftaran dapat dilakukan secara online melalui portal resmi PMB UIS (pmb.uis.ac.id) atau datang langsung ke Sekretariat PMB di Gedung Rektorat Kampus Terpadu Universitas Ibnu Sina, Batam dengan membawa berkas persyaratan.',
                'category' => 'pendaftaran',
            ],
            [
                'question' => 'Jalur penerimaan mahasiswa baru apa saja yang dibuka di UIS?',
                'answer' => 'UIS membuka berbagai jalur penerimaan, antara lain Jalur Reguler, Jalur Prestasi Akademik & Minat Bakat, Jalur Alih Jenjang / Transfer, dan Jalur Rekognisi Pembelajaran Lampau (RPL) bagi praktisi industri.',
                'category' => 'pendaftaran',
            ],
            [
                'question' => 'Apakah tersedia program beasiswa di Universitas Ibnu Sina (UIS)?',
                'answer' => 'Tersedia berbagai pilihan beasiswa, antara lain KIP-Kuliah, Beasiswa Prestasi Akademik/Non-Akademik, Beasiswa Yayasan Pendidikan Ibnu Sina Batam, dan Beasiswa Kemitraan Perusahaan & Pemerintah Daerah.',
                'category' => 'pendaftaran',
            ],

            // Fasilitas & Praktek Kerja
            [
                'question' => 'Bagaimana kerja sama industri dan peluang kerja bagi lulusan UIS?',
                'answer' => 'Universitas Ibnu Sina berlokasi strategis di kawasan industri Kota Batam dan menjalin kemitraan erat dengan ratusan perusahaan multinasional, BUMN, instansi pemerintahan, rumah sakit, dan asosiasi profesi untuk program magang industri dan penyerapan kerja lulusan.',
                'category' => 'fasilitas',
            ],
            [
                'question' => 'Fasilitas apa saja yang disediakan di Kampus Terpadu Universitas Ibnu Sina (UIS)?',
                'answer' => 'Kampus Terpadu UIS dilengkapi laboratorium komputer & rekayasa software terpadu, lab teknik & simulasi industri, lab K3 & kesehatan lingkungan, perpustakaan digital, sarana olahraga, aula serbaguna, masjid kampus, serta area hotspot wifi terintegrasi.',
                'category' => 'fasilitas',
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }
    }
}
