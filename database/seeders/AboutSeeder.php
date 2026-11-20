<?php

namespace Database\Seeders;

use App\Models\About;
use Illuminate\Database\Seeder;

class AboutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        About::truncate();

        About::create([
            // Profil Universitas
            'judul_profil' => 'Pusat Keunggulan Pendidikan Tinggi & Kewirausahaan Berbasis Imtaq',
            'deskripsi_profil_1' => 'Universitas Ibnu Sina (UIS) Batam berdedikasi menyelenggarakan pendidikan tinggi berkualitas dengan kurikulum adaptif berbasis Outcome-Based Education (OBE), riset inovatif, dan pengabdian kepada masyarakat yang berakar kuat pada nilai-nilai keislaman dan daya saing global.',
            'deskripsi_profil_2' => 'Universitas Ibnu Sina (UIS) didukung oleh dosen dan tenaga pendidik berkualifikasi Magister dan Doktor, sarana laboratorium terpadu berstandar modern, serta jejaring kemitraan strategis dengan dunia usaha, industri, dan instansi pemerintahan.',

            // Visi
            'visi_judul' => 'Visi Kami',
            'visi_icon' => 'bi-eye',
            'visi' => 'Menjadi Universitas yang unggul, bermartabat, berjiwa entrepreneur, dan bereputasi internasional berlandaskan Iman dan Taqwa (Imtaq) pada tahun 2029.',

            // Misi
            'misi_judul' => 'Misi Kami',
            'misi_icon' => 'bi-rocket-takeoff',
            'misi' => "Menyelenggarakan pendidikan akademik dan profesional yang adaptif, inovatif, dan berstandar mutu internasional.\nMengembangkan penelitian terapan dan hilirisasi iptek yang bermanfaat bagi masyarakat dan industri.\nMelaksanakan pengabdian kepada masyarakat secara berkelanjutan demi mendorong kesejahteraan sosial dan ekonomi.\nMenjalin kemitraan strategis dengan dunia usaha, industri, perguruan tinggi terkemuka, dan jejaring internasional.",

            // Nilai Budaya Civitas
            'judul_nilai' => 'Nilai Budaya Civitas',
            'deskripsi_nilai' => 'Prinsip dasar yang melandasi seluruh proses pendidikan, riset ilmiah, dan pengabdian kepada masyarakat di lingkungan Universitas Ibnu Sina (UIS) dengan menjunjung tinggi integritas dan imtaq.',

            // Nilai 1 — Integritas
            'nilai_1_judul' => 'Integritas',
            'nilai_1_deskripsi' => 'Menjunjung tinggi etika profesi, moralitas luhur, dan kejujuran akademik dalam setiap pengajaran dan riset.',
            'nilai_1_icon' => 'bi-shield-fill-check',

            // Nilai 2 — Keunggulan
            'nilai_2_judul' => 'Keunggulan',
            'nilai_2_deskripsi' => 'Senantiasa meningkatkan standar mutu akademik demi mencetak lulusan tenaga kesehatan berkualifikasi unggul.',
            'nilai_2_icon' => 'bi-award-fill',

            // Nilai 3 — Humanis
            'nilai_3_judul' => 'Humanis',
            'nilai_3_deskripsi' => 'Mengedepankan rasa empati, kasih sayang, dan kepedulian tulus terhadap pasien dan masyarakat.',
            'nilai_3_icon' => 'bi-heart-fill',

            // Nilai 4 — Inovatif
            'nilai_4_judul' => 'Inovatif',
            'nilai_4_deskripsi' => 'Adaptif terhadap perkembangan sains dan teknologi kesehatan terkini dalam pendidikan dan riset terapan.',
            'nilai_4_icon' => 'bi-lightning-charge-fill',
        ]);
    }
}
