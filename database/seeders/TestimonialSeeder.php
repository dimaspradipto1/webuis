<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Testimonial::truncate();

        $testimonials = [
            [
                'nama' => 'Ahmad Fauzi, S.Kom',
                'pekerjaan' => 'Alumni Teknik Informatika (Software Engineer di Perusahaan Teknologi Batam)',
                'kategori' => 'Alumni',
                'bintang' => 5,
                'pesan' => 'Kuliah di Universitas Ibnu Sina (UIS) memberikan fondasi komputasi dan rekayasa perangkat lunak yang sangat kuat. Kurikulum adaptif serta dukungan laboratorium terpadu sangat membantu percepatan karier saya di industri teknologi.',
                'aktif' => true,
            ],
            [
                'nama' => 'Nurul Aisyah, S.M.',
                'pekerjaan' => 'Alumni Manajemen (Financial Analyst di Korporasi Multinasional)',
                'kategori' => 'Alumni',
                'bintang' => 5,
                'pesan' => 'Dosen-dosen di Universitas Ibnu Sina (UIS) sangat membimbing dan penuh dedikasi. Bekal tata kelola bisnis, kepemimpinan, dan etika profesional berbasis imtaq memudahkan saya bersaing di dunia perbankan dan industri.',
                'aktif' => true,
            ],
            [
                'nama' => 'Ns. Siti Nurhaliza, S.Kep',
                'pekerjaan' => 'Alumni Keperawatan (Perawat di RSUD)',
                'kategori' => 'Alumni',
                'bintang' => 5,
                'pesan' => 'Pengalaman akademik dan praktikum di Universitas Ibnu Sina (UIS) luar biasa. Laboratorium simulasi klinis dan gawat daruratnya sangat representatif dengan kondisi nyata di fasilitas kesehatan.',
                'aktif' => true,
            ],
            [
                'nama' => 'Ir. Hendra Wijaya, M.T.',
                'pekerjaan' => 'Direktur Operasional PT Mitra Industri Batam',
                'kategori' => 'Mitra Industri',
                'bintang' => 5,
                'pesan' => 'Lulusan Universitas Ibnu Sina (UIS) memiliki etos kerja yang tinggi, terampil, dan cepat beradaptasi dengan standar industri modern. UIS selalu menjadi mitra strategis kampus pilihan kami.',
                'aktif' => true,
            ],
            [
                'nama' => 'Muhammad Fajar',
                'pekerjaan' => 'Mahasiswa Tingkat Akhir Teknik Industri UIS',
                'kategori' => 'Mahasiswa',
                'bintang' => 5,
                'pesan' => 'Belajar di Universitas Ibnu Sina (UIS) sangat menyenangkan. Fasilitas laboratorium lengkap, dosen yang suportif, dan program magang industri nyata membuka peluang karir sejak bangku kuliah.',
                'aktif' => true,
            ],
        ];

        foreach ($testimonials as $t) {
            Testimonial::create($t);
        }
    }
}
