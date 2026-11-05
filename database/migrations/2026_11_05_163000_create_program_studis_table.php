<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('program_studis', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('slug')->unique();
            $table->string('jenjang', 20)->default('S1'); // S1, S2
            $table->string('fakultas')->default('Fakultas Sains dan Teknologi');
            $table->string('icon', 100)->default('bi-mortarboard-fill');
            $table->string('akreditasi', 100)->nullable();
            $table->string('gelar', 100)->nullable();
            $table->text('deskripsi_singkat')->nullable();
            $table->longText('deskripsi')->nullable();
            $table->text('visi')->nullable();
            $table->longText('misi')->nullable();
            $table->longText('prospek_karir')->nullable();
            $table->string('foto')->nullable();
            $table->json('galeri')->nullable();
            $table->string('link_website', 500)->nullable();
            $table->integer('urutan')->default(1);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        $now = now();
        $defaults = [
            // PASCASARJANA (S2)
            [
                'nama' => 'S2 Magister Manajemen',
                'slug' => 's2-magister-manajemen',
                'jenjang' => 'S2',
                'fakultas' => 'Program Pascasarjana',
                'icon' => 'bi-briefcase-fill',
                'akreditasi' => 'Baik Sekali',
                'gelar' => 'M.M.',
                'deskripsi_singkat' => 'Program Pascasarjana Magister Manajemen yang berfokus pada kepemimpinan strategis, manajemen bisnis modern, dan pengambilan keputusan manajerial di era global.',
                'deskripsi' => "Program Studi S2 Magister Manajemen Universitas Ibnu Sina (UIS) dirancang untuk mencetak pemimpin bisnis, eksekutif, akademisi, dan wirausahawan yang mampu merumuskan strategi manajerial yang inovatif dan adaptif.\n\nDengan dukungan dosen berpengalaman akademik dan praktisi industri, mahasiswa dibekali kemampuan analisis mendalam di bidang manajemen pemasaran, manajemen sumber daya manusia, manajemen keuangan, serta manajemen operasional strategis.",
                'visi' => 'Menjadi Program Studi Magister Manajemen yang unggul, bermartabat, bereputasi nasional dan internasional serta berjiwa entrepreneur berbasis Imtaq.',
                'misi' => "Menyelenggarakan pendidikan pascasarjana di bidang manajemen yang berkualitas dan relevan dengan kebutuhan industri global.\nMelaksanakan penelitian ilmiah dan terapan dalam bidang ilmu manajemen yang inovatif.\nMelaksanakan pengabdian kepada masyarakat melalui konsultasi dan pemberdayaan manajerial bagi dunia usaha dan instansi.",
                'prospek_karir' => "Eksekutif & Manajer Puncak (CEO / General Manager)\nKonsultan Bisnis & Manajemen Strategis\nManajer SDM, Pemasaran, atau Keuangan Korporasi\nDosen & Peneliti Bidang Manajemen\nEntrepreneur & Pengembang Bisnis",
                'link_website' => null,
                'urutan' => 1,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama' => 'S2 Kesehatan Masyarakat',
                'slug' => 's2-kesehatan-masyarakat',
                'jenjang' => 'S2',
                'fakultas' => 'Program Pascasarjana',
                'icon' => 'bi-heart-pulse-fill',
                'akreditasi' => 'Baik Sekali',
                'gelar' => 'M.K.M.',
                'deskripsi_singkat' => 'Program Pascasarjana Kesehatan Masyarakat yang berfokus pada manajemen kebijakan kesehatan, epidemiologi terapan, serta keselamatan dan kesehatan kerja lanjut.',
                'deskripsi' => "Program Studi S2 Kesehatan Masyarakat Universitas Ibnu Sina (UIS) menyiapkan tenaga ahli dan pemimpin di bidang kesehatan masyarakat yang mampu menganalisis serta memecahkan permasalahan kesehatan komunitas, industri, dan lingkungan secara komprehensif.\n\nKurikulum dirancang selaras dengan perkembangan layanan kesehatan modern, manajemen rumah sakit, kebijakan kesehatan publik, serta kesehatan kerja industri.",
                'visi' => 'Menjadi Program Studi Magister Kesehatan Masyarakat yang unggul dan bereputasi di tingkat nasional maupun internasional berbasis Imtaq.',
                'misi' => "Menyelenggarakan pendidikan magister kesehatan masyarakat yang berbasis bukti ilmiah dan teknologi tepat guna.\nMengembangkan riset epidemiologi, manajemen pelayanan kesehatan, dan kesehatan kerja.\nMeningkatkan derajat kesehatan masyarakat melalui kemitraan strategis dengan pemerintah, rumah sakit, dan industri.",
                'prospek_karir' => "Manajer Rumah Sakit & Fasilitas Layanan Kesehatan\nAnalis Kebijakan Kesehatan Publik\nKonsultan Senior K3 & Kesehatan Lingkungan Industri\nEpidemiolog & Peneliti Kesehatan\nDosen & Akademisi Bidang Kesehatan Masyarakat",
                'link_website' => null,
                'urutan' => 2,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // SARJANA (S1) — FAKULTAS EKONOMI DAN BISNIS
            [
                'nama' => 'S1 Manajemen',
                'slug' => 's1-manajemen',
                'jenjang' => 'S1',
                'fakultas' => 'Fakultas Ekonomi dan Bisnis',
                'icon' => 'bi-graph-up-arrow',
                'akreditasi' => 'Baik Sekali',
                'gelar' => 'S.M.',
                'deskripsi_singkat' => 'Mendidik sarjana manajemen yang profesional, adaptif terhadap transformasi bisnis digital, dan berjiwa wirausaha (entrepreneur) berbasis Imtaq.',
                'deskripsi' => "Program Studi S1 Manajemen Fakultas Ekonomi dan Bisnis Universitas Ibnu Sina (UIS) membekali mahasiswa dengan kompetensi tata kelola bisnis modern meliputi manajemen sumber daya manusia, pemasaran digital, manajemen keuangan, dan operasional.\n\nLulusan dipersiapkan untuk siap terjun ke dunia korporasi, perbankan, industri manufaktur maupun membangun usaha mandiri yang berdaya saing tinggi.",
                'visi' => 'Menjadi Program Studi S1 Manajemen yang unggul, berjiwa entrepreneur, dan bereputasi nasional serta internasional berbasis Imtaq.',
                'misi' => "Menyelenggarakan pendidikan manajemen yang relevan dengan perkembangan industri dan teknologi bisnis.\nMelaksanakan penelitian di bidang manajemen dan kewirausahaan.\nMelaksanakan pengabdian kepada masyarakat melalui pendampingan UMKM dan kewirausahaan.",
                'prospek_karir' => "Manajer Pemasaran & Digital Marketing Specialist\nHuman Resources Development (HRD) Specialist\nAnalis Keuangan & Perbankan\nBusiness Development Officer\nWirausahawan (Entrepreneur)",
                'link_website' => 'https://feb.uis.ac.id/',
                'urutan' => 3,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama' => 'S1 Akuntansi',
                'slug' => 's1-akuntansi',
                'jenjang' => 'S1',
                'fakultas' => 'Fakultas Ekonomi dan Bisnis',
                'icon' => 'bi-calculator-fill',
                'akreditasi' => 'Baik Sekali',
                'gelar' => 'S.Ak.',
                'deskripsi_singkat' => 'Menghasilkan sarjana akuntansi yang menguasai audit, perpajakan, sistem informasi akuntansi, dan pelaporan keuangan berstandar nasional maupun internasional.',
                'deskripsi' => "Program Studi S1 Akuntansi Fakultas Ekonomi dan Bisnis Universitas Ibnu Sina (UIS) dirancang untuk menghasilkan akuntan profesional yang berintegritas tinggi serta menguasai teknologi akuntansi terkini.\n\nMahasiswa mempelajari akuntansi keuangan, akuntansi manajemen, pengauditan (auditing), perpajakan, serta sistem informasi akuntansi berbasis komputer.",
                'visi' => 'Menjadi Program Studi S1 Akuntansi yang unggul, profesional, dan berdaya saing di tingkat nasional maupun internasional berbasis Imtaq.',
                'misi' => "Menyelenggarakan pendidikan akuntansi berkualitas tinggi yang adaptif terhadap perkembangan standar akuntansi dan teknologi informasi.\nMengembangkan penelitian di bidang akuntansi, audit, dan perpajakan.\nMemberikan layanan edukasi dan konsultasi tata kelola keuangan bagi masyarakat dan dunia usaha.",
                'prospek_karir' => "Akuntan Publik & Auditor Internal/Eksternal\nKonsultan Pajak & Perencana Keuangan\nAnalis Keuangan Perusahaan & Perbankan\nAkuntan Sektor Publik / Pemerintahan\nSystem Analyst Bidang Keuangan",
                'link_website' => 'https://feb.uis.ac.id/',
                'urutan' => 4,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // SARJANA (S1) — FAKULTAS SAINS DAN TEKNOLOGI
            [
                'nama' => 'S1 Teknik Industri',
                'slug' => 's1-teknik-industri',
                'jenjang' => 'S1',
                'fakultas' => 'Fakultas Sains dan Teknologi',
                'icon' => 'bi-gear-wide-connected',
                'akreditasi' => 'Baik Sekali',
                'gelar' => 'S.T.',
                'deskripsi_singkat' => 'Berfokus pada perancangan, peningkatan, dan instalasi sistem terintegrasi yang melibatkan manusia, material, informasi, peralatan, dan energi di dunia industri.',
                'deskripsi' => "Program Studi S1 Teknik Industri Fakultas Sains dan Teknologi Universitas Ibnu Sina (UIS) mengintegrasikan ilmu keteknikan dan manajemen industri untuk mengoptimalkan sistem produksi, kualitas, ergonomi, serta rantai pasok.\n\nSangat relevan dengan ekosistem kawasan industri manufaktur, galangan kapal, dan elektronika di Batam serta kawasan regional.",
                'visi' => 'Menjadi Program Studi S1 Teknik Industri yang unggul dalam rekayasa sistem industri dan berjiwa entrepreneur berbasis Imtaq.',
                'misi' => "Menyelenggarakan pendidikan tinggi teknik industri yang selaras dengan perkembangan Industri 4.0.\nMelaksanakan riset terapan di bidang optimasi sistem produksi, pengendalian mutu, dan ergonomi industri.\nMenerapkan keilmuan teknik industri bagi peningkatan produktivitas industri dan masyarakat.",
                'prospek_karir' => "Production Planning & Inventory Control (PPIC) Engineer\nQuality Assurance / Quality Control (QA/QC) Engineer\nSupply Chain & Procurement Specialist\nIndustrial Process Improvement Analyst\nHealth, Safety, and Environment (HSE) Engineer",
                'link_website' => 'https://fst.uis.ac.id/',
                'urutan' => 5,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama' => 'S1 Teknik Informatika',
                'slug' => 's1-teknik-informatika',
                'jenjang' => 'S1',
                'fakultas' => 'Fakultas Sains dan Teknologi',
                'icon' => 'bi-code-slash',
                'akreditasi' => 'Baik Sekali',
                'gelar' => 'S.Kom.',
                'deskripsi_singkat' => 'Mengembangkan kompetensi rekayasa perangkat lunak (software engineering), kecerdasan buatan (AI), keamanan siber, serta jaringan komputer modern.',
                'deskripsi' => "Program Studi S1 Teknik Informatika Fakultas Sains dan Teknologi Universitas Ibnu Sina (UIS) membekali mahasiswa dengan keahlian pemrograman tingkat lanjut, arsitektur perangkat lunak, aplikasi mobile & web, kecerdasan buatan (Artificial Intelligence), serta jaringan dan keamanan siber.\n\nDidukung laboratorium komputer dan praktikum berbasis proyek industri nyata.",
                'visi' => 'Menjadi Program Studi S1 Teknik Informatika yang unggul dalam inovasi teknologi komputasi dan berjiwa technopreneur berbasis Imtaq.',
                'misi' => "Menyelenggarakan pendidikan informatika yang mutakhir sesuai standar kompetensi industri teknologi informasi.\nMengembangkan penelitian inovatif di bidang rekayasa perangkat lunak, jaringan, dan kecerdasan buatan.\nMelaksanakan pengabdian masyarakat melalui penerapan solusi teknologi informasi tepat guna.",
                'prospek_karir' => "Software Engineer / Full-Stack Developer\nMobile Application Developer (Android & iOS)\nData Scientist & AI Engineer\nNetwork & Cyber Security Specialist\nIT Consultant & Technopreneur",
                'link_website' => 'https://fst.uis.ac.id/',
                'urutan' => 6,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama' => 'S1 Sistem Informasi',
                'slug' => 's1-sistem-informasi',
                'jenjang' => 'S1',
                'fakultas' => 'Fakultas Sains dan Teknologi',
                'icon' => 'bi-hdd-network-fill',
                'akreditasi' => 'Baik Sekali',
                'gelar' => 'S.Kom.',
                'deskripsi_singkat' => 'Menjembatani teknologi informasi dengan proses bisnis organisasi melalui analisis sistem, tata kelola IT (IT Governance), dan manajemen basis data enterprise.',
                'deskripsi' => "Program Studi S1 Sistem Informasi Fakultas Sains dan Teknologi Universitas Ibnu Sina (UIS) memadukan ilmu komputer dengan manajemen dan proses bisnis.\n\nMahasiswa dilatih untuk merancang, menganalisis, dan mengelola sistem informasi enterprise (ERP), analisis data bisnis (Business Intelligence), serta transformasi digital di berbagai sektor industri.",
                'visi' => 'Menjadi Program Studi S1 Sistem Informasi yang unggul dalam pengembangan solusi sistem informasi bisnis berbasis Imtaq.',
                'misi' => "Menyelenggarakan pendidikan sistem informasi yang mengintegrasikan teknologi informasi dan manajemen proses bisnis.\nMelaksanakan penelitian di bidang enterprise system, tata kelola TI, dan analisis data.\nMemberikan kontribusi nyata melalui digitalisasi sistem layanan pada masyarakat dan dunia usaha.",
                'prospek_karir' => "System Analyst & Business Analyst\nEnterprise Resource Planning (ERP) Consultant\nDatabase Administrator\nIT Project Manager\nUI/UX Designer & Product Manager",
                'link_website' => 'https://fst.uis.ac.id/',
                'urutan' => 7,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama' => 'S1 Teknik Logistik',
                'slug' => 's1-teknik-logistik',
                'jenjang' => 'S1',
                'fakultas' => 'Fakultas Sains dan Teknologi',
                'icon' => 'bi-truck',
                'akreditasi' => 'Baik',
                'gelar' => 'S.T.',
                'deskripsi_singkat' => 'Mempelajari rekayasa sistem distribusi, manajemen pergudangan, transportasi multimoda, kepabeanan (ekspor-impor), dan rantai pasok global.',
                'deskripsi' => "Program Studi S1 Teknik Logistik Fakultas Sains dan Teknologi Universitas Ibnu Sina (UIS) hadir menjawab kebutuhan strategis Kota Batam sebagai pusat pelabuhan bebas dan jalur perdagangan internasional.\n\nMahasiswa mempelajari perancangan jaringan logistik, manajemen pelabuhan & pergudangan modern, sistem distribusi pintar, serta regulasi ekspor-impor.",
                'visi' => 'Menjadi Program Studi S1 Teknik Logistik yang unggul dalam rekayasa sistem logistik dan rantai pasok maritim serta industri berbasis Imtaq.',
                'misi' => "Menyelenggarakan pendidikan teknik logistik yang aplikatif dan sesuai dengan kebutuhan industri logistik nasional maupun global.\nMengembangkan penelitian di bidang optimasi distribusi, transportasi, dan manajemen rantai pasok.\nMelaksanakan pengabdian kepada masyarakat dalam peningkatan efisiensi logistik daerah.",
                'prospek_karir' => "Logistics & Supply Chain Engineer\nWarehouse & Distribution Center Manager\nExport-Import & Customs Specialist\nPort & Maritime Logistics Coordinator\nProcurement & Fleet Management Analyst",
                'link_website' => 'https://fst.uis.ac.id/',
                'urutan' => 8,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama' => 'S1 Teknik Perkapalan',
                'slug' => 's1-teknik-perkapalan',
                'jenjang' => 'S1',
                'fakultas' => 'Fakultas Sains dan Teknologi',
                'icon' => 'bi-tsunami',
                'akreditasi' => 'Baik',
                'gelar' => 'S.T.',
                'deskripsi_singkat' => 'Mendidik sarjana teknik perkapalan yang ahli dalam perancangan kapal, konstruksi bangunan laut (offshore), teknologi galangan, serta pemeliharaan armada maritim.',
                'deskripsi' => "Program Studi S1 Teknik Perkapalan Fakultas Sains dan Teknologi Universitas Ibnu Sina (UIS) dirancang khusus untuk mendukung industri maritim dan galangan kapal (shipyard) yang menjadi tulang punggung industri di Batam dan Kepulauan Riau.\n\nMahasiswa dibekali keahlian desain kapal, hidrodinamika, kekuatan konstruksi kapal, teknologi pengelasan & produksi kapal, serta manajemen proyek galangan.",
                'visi' => 'Menjadi Program Studi S1 Teknik Perkapalan yang unggul di bidang teknologi rancang bangun dan produksi perkapalan berbasis Imtaq.',
                'misi' => "Menyelenggarakan pendidikan teknik perkapalan yang berorientasi pada kebutuhan industri galangan kapal dan kemaritiman.\nMelakukan penelitian terapan di bidang desain kapal, struktur bangunan laut, dan teknologi perkapalan.\nMenjalin kerjasama kemitraan dengan industri shipyard dan maritim dalam serta luar negeri.",
                'prospek_karir' => "Naval Architect & Marine Engineer\nShipyard Production & Project Engineer\nMarine Surveyor & Classification Inspector\nOffshore Structure Engineer\nQA/QC Welding & Hull Inspector",
                'link_website' => 'https://fst.uis.ac.id/',
                'urutan' => 9,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // SARJANA (S1) — FAKULTAS ILMU KESEHATAN
            [
                'nama' => 'S1 Kesehatan dan Keselamatan Kerja (K3)',
                'slug' => 's1-kesehatan-dan-keselamatan-kerja-k3',
                'jenjang' => 'S1',
                'fakultas' => 'Fakultas Ilmu Kesehatan',
                'icon' => 'bi-shield-check',
                'akreditasi' => 'Baik Sekali',
                'gelar' => 'S.K.K.K.',
                'deskripsi_singkat' => 'Menghasilkan tenaga ahli K3 yang kompeten dalam manajemen risiko kerja, higiene industri, ergonomi, keselamatan konstruksi, dan penerapan SMK3.',
                'deskripsi' => "Program Studi S1 Kesehatan dan Keselamatan Kerja (K3) Fakultas Ilmu Kesehatan Universitas Ibnu Sina (UIS) mempersiapkan lulusan yang terampil dalam pencegahan kecelakaan kerja dan penyakit akibat kerja di berbagai sektor industri.\n\nKurikulum mencakup identifikasi bahaya dan penilaian risiko (HIRADC), toksikologi industri, ergonomi kerja, tanggap darurat, serta audit Sistem Manajemen K3 (SMK3).",
                'visi' => 'Menjadi Program Studi S1 Kesehatan dan Keselamatan Kerja (K3) yang unggul dan berdaya saing di kawasan industri nasional maupun internasional berbasis Imtaq.',
                'misi' => "Menyelenggarakan pendidikan akademik dan praktikum K3 yang sesuai standar kompetensi nasional dan internasional.\nMelaksanakan penelitian di bidang keselamatan kerja, higiene perusahaan, dan kesehatan kerja.\nMelaksanakan pembinaan budaya K3 pada masyarakat pekerja dan dunia industri.",
                'prospek_karir' => "HSE (Health, Safety, and Environment) Officer / Manager\nSafety Inspector & Auditor SMK3\nIndustrial Hygienist\nFire & Emergency Response Specialist\nKonsultan & Trainer K3 Industri",
                'link_website' => 'https://fikes.uis.ac.id/',
                'urutan' => 10,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama' => 'S1 Kesehatan Lingkungan',
                'slug' => 's1-kesehatan-lingkungan',
                'jenjang' => 'S1',
                'fakultas' => 'Fakultas Ilmu Kesehatan',
                'icon' => 'bi-tree-fill',
                'akreditasi' => 'Baik Sekali',
                'gelar' => 'S.K.L.',
                'deskripsi_singkat' => 'Mendidik sarjana kesehatan lingkungan yang ahli dalam analisis dampak lingkungan (AMDAL), pengelolaan limbah B3 industri, pengendalian vektor, dan sanitasi.',
                'deskripsi' => "Program Studi S1 Kesehatan Lingkungan Fakultas Ilmu Kesehatan Universitas Ibnu Sina (UIS) berfokus pada upaya pengendalian faktor risiko lingkungan fisik, kimia, dan biologi guna mewujudkan kualitas lingkungan yang sehat dan berkelanjutan.\n\nMahasiswa mempelajari pengelolaan limbah cair, padat, dan B3, penyehatan air dan udara, keamanan pangan, AMDAL, serta sanitasi industri dan tempat umum.",
                'visi' => 'Menjadi Program Studi S1 Kesehatan Lingkungan yang unggul dalam pengelolaan kesehatan lingkungan industri dan perkotaan berbasis Imtaq.',
                'misi' => "Menyelenggarakan pendidikan kesehatan lingkungan yang berkualitas dan berbasis praktikum laboratorium.\nMelaksanakan penelitian inovatif dalam pengendalian pencemaran dan penyehatan lingkungan.\nMeningkatkan kesadaran dan kualitas sanitasi masyarakat melalui pengabdian berkelanjutan.",
                'prospek_karir' => "Environmental Engineer / Environmental Officer Industri\nKonsultan Penyusun Dokumen AMDAL & UKL-UPL\nСпеsialis Pengelolaan Limbah B3 & IPAL\nSanitarian Rumah Sakit & Instansi Kesehatan\nPengawas Kualitas Lingkungan Pemerintah / Swasta",
                'link_website' => 'https://fikes.uis.ac.id/',
                'urutan' => 11,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('program_studis')->insert($defaults);
    }

    public function down(): void
    {
        Schema::dropIfExists('program_studis');
    }
};

