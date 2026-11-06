<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profil_pimpinans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('slug')->unique();
            $table->string('jabatan');
            $table->integer('baris')->default(2); // 1: Yayasan & Rektor, 2: Wakil Rektor, 3: Dekan Fakultas
            $table->string('foto')->nullable();
            $table->json('galeri')->nullable();
            $table->longText('biografi')->nullable();
            $table->integer('urutan')->default(1);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('pimpinan_manajemens', function (Blueprint $table) {
            $table->id();
            $table->string('kategori', 50)->default('Rektorat'); // Rektorat, FEB, FST, FIKES
            $table->integer('no_urut')->default(1);
            $table->string('nama');
            $table->string('jabatan');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        $now = now();
        $leaders = array (
  0 => 
  array (
    'nama' => 'drg. Andi Tenri Ummu, MM.',
    'slug' => 'profil-andi-tenri-ummu',
    'jabatan' => 'Ketua Yayasan Pendidikan Ibnu Sina Batam (YAPISTA)',
    'baris' => 1,
    'foto' => 'assets/img/pimpinan/andi-tenri-ummu.png',
    'biografi' => 'drg. Andi Tenri Ummu, M.M., C.Ht. lahir di Batam pada tahun 1986. Sebagai Ketua Yayasan Pendidikan Ibnu Sina Batam (YAPISTA), beliau memimpin pengembangan lembaga pendidikan yang menaungi jenjang pendidikan mulai dari Taman Kanak-Kanak, Sekolah Dasar, Sekolah Menengah Pertama, Sekolah Menengah Kejuruan, Universitas Ibnu Sina, Sekolah Tinggi Agama Islam Ibnu Sina, hingga Klinik Ibnu Sina. Kepemimpinannya diarahkan untuk membangun ekosistem pendidikan yang terpadu, berkualitas, dan memberikan manfaat nyata bagi masyarakat.

Memiliki latar belakang keilmuan di bidang Kesehatan Gigi, beliau menyelesaikan pendidikan Sarjana dan Profesi Dokter Gigi di Fakultas Kedokteran Gigi Universitas Prof. Dr. Moestopo (Beragama), kemudian melanjutkan studi Magister Manajemen di Universitas Ibnu Sina. Perpaduan pengalaman di bidang kesehatan dan manajemen menjadi bekal dalam mengembangkan tata kelola pendidikan yang profesional, adaptif, dan berorientasi pada masa depan.

Aktivitasnya di berbagai organisasi menunjukkan komitmen dalam membangun jejaring pendidikan dan profesi. Beliau aktif sebagai pengurus Badan Musyawarah Perguruan Swasta (BMPS) Kota Batam, Aliansi Penyelenggara Perguruan Tinggi Indonesia (APPERTI), Himpunan Pimpinan Pendidikan, Pelatihan, dan Kewirausahaan Indonesia (HP3KI), Pengurus Besar Persatuan Dokter Gigi Indonesia (PB PDGI), Ikatan Wanita Sulawesi Selatan (IWSS) Kota Batam, serta Persatuan Dokter Gigi Indonesia (PDGI) Kota Batam.

Di bawah kepemimpinan Yayasan, Universitas Ibnu Sina diarahkan menjadi perguruan tinggi yang adaptif terhadap perubahan global, berlandaskan nilai-nilai Islam, serta mampu menghasilkan lulusan yang unggul, profesional, dan berdaya saing internasional. Visi tersebut diwujudkan melalui tujuh pilar pengembangan strategis.

Smart Digital University menjadi fondasi transformasi kampus melalui penerapan kecerdasan buatan (Artificial Intelligence), Smart Classroom, pembelajaran hibrida, perpustakaan digital, sistem akademik terintegrasi, dan tata kelola berbasis data untuk meningkatkan efektivitas layanan pendidikan.

Pada aspek Academic Excellence, Universitas Ibnu Sina terus menyempurnakan kurikulum berbasis Outcome-Based Education (OBE) yang selaras dengan kebutuhan industri global. Pembelajaran diperkuat melalui sertifikasi kompetensi, program bilingual, kehadiran dosen praktisi, serta kolaborasi dengan profesor tamu dari berbagai perguruan tinggi dunia.

Di bidang Innovation and Research, universitas mendorong lahirnya pusat-pusat inovasi seperti riset kecerdasan buatan, teknologi kesehatan, logistik cerdas, kemaritiman, teknologi hijau, serta inkubator bisnis mahasiswa agar hasil penelitian dapat memberikan manfaat nyata bagi masyarakat dan dunia industri.

Melalui International Networking, Universitas Ibnu Sina memperluas kemitraan dengan perguruan tinggi luar negeri melalui program pertukaran mahasiswa, double degree, penelitian bersama, visiting professor, konferensi internasional, dan program magang global sebagai upaya meningkatkan daya saing lulusan di tingkat internasional.

Pada pilar Industry Collaboration, kampus memperkuat hubungan dengan dunia usaha dan dunia industri melalui Teaching Factory, Corporate Class, magang bersertifikat, Career Center, hingga penyelenggaraan Job Fair yang membuka akses lebih luas bagi mahasiswa dan alumni.

Semangat Entrepreneurial University diwujudkan dengan pengembangan Startup Center, inkubator bisnis, pendanaan inovasi, kompetisi kewirausahaan, serta hilirisasi hasil penelitian menjadi produk dan layanan yang bernilai ekonomi.

Seluruh pengembangan tersebut berpijak pada identitas Universitas Ibnu Sina sebagai Islamic Global University, yaitu perguruan tinggi yang mengintegrasikan ilmu pengetahuan, teknologi, inovasi, dan nilai-nilai Islam dalam membentuk lulusan yang profesional, berintegritas, berakhlak mulia, serta memiliki kepedulian terhadap masyarakat.

Assalamu’alaikum warahmatullahi wabarakatuh.

Alhamdulillahi rabbil ‘alamin, segala puji bagi Allah SWT atas limpahan rahmat dan karunia-Nya. Shalawat serta salam semoga senantiasa tercurah kepada Nabi Muhammad SAW, teladan terbaik dalam membangun peradaban melalui ilmu pengetahuan, akhlak, dan keteladanan.

Yayasan Pendidikan Ibnu Sina Batam lahir dengan keyakinan bahwa pendidikan merupakan investasi terbaik dalam membangun manusia dan masa depan bangsa. Sejak didirikan oleh almarhum H. Andi Ibrahim, yayasan ini berpegang teguh pada pesan yang terus kami jaga hingga hari ini: “Memanusiakan manusia melalui pendidikan ilmu pengetahuan dan ilmu agama.” Nilai tersebut menjadi ruh dalam setiap langkah pengembangan seluruh lembaga pendidikan di bawah naungan YAPISTA.

Saat ini, YAPISTA membina satu ekosistem pendidikan yang berkesinambungan, mulai dari pendidikan anak usia dini hingga pendidikan tinggi, serta didukung layanan kesehatan melalui Klinik Ibnu Sina. Kami percaya bahwa pendidikan yang utuh tidak hanya membentuk kecerdasan intelektual, tetapi juga membangun karakter, spiritualitas, kepedulian sosial, dan kemampuan menghadapi tantangan zaman.

Di tengah pesatnya perkembangan teknologi dan dinamika global, Universitas Ibnu Sina terus melakukan transformasi menuju perguruan tinggi modern yang memanfaatkan kecerdasan buatan, teknologi digital, dan inovasi sebagai bagian dari proses pembelajaran serta tata kelola. Namun, kemajuan teknologi harus selalu berjalan seiring dengan penguatan nilai-nilai integritas, etika, dan akhlak mulia.

Kami ingin menghadirkan lingkungan akademik yang melahirkan lulusan yang tidak hanya siap bekerja, tetapi juga mampu menciptakan lapangan pekerjaan, menjadi pemimpin yang visioner, serta memberikan solusi bagi masyarakat. Karena itu, kolaborasi dengan dunia usaha, dunia industri, pemerintah, organisasi profesi, dan perguruan tinggi di dalam maupun luar negeri akan terus diperkuat sebagai bagian dari upaya meningkatkan kualitas pendidikan.

Kepada seluruh mahasiswa, jadikan masa kuliah sebagai waktu terbaik untuk membangun kompetensi, memperluas wawasan, mengasah kepemimpinan, serta melahirkan inovasi yang bermanfaat. Kesuksesan bukan hanya ditentukan oleh kecerdasan akademik, tetapi juga oleh integritas, karakter, kemampuan beradaptasi, dan kemauan untuk terus belajar sepanjang hayat.

Kami juga menyampaikan penghargaan kepada seluruh dosen, tenaga kependidikan, alumni, orang tua, pemerintah, mitra, dan masyarakat yang telah menjadi bagian dari perjalanan Universitas Ibnu Sina. Dukungan dan kepercayaan yang diberikan merupakan energi bagi kami untuk terus meningkatkan mutu pendidikan dan memberikan kontribusi terbaik bagi daerah, bangsa, dan dunia.

Dengan semangat kolaborasi, inovasi, dan pengabdian, kami optimistis Universitas Ibnu Sina akan terus tumbuh menjadi perguruan tinggi yang unggul, berdaya saing global, serta menjadi pusat lahirnya generasi profesional yang berakhlak mulia dan mampu memberi manfaat bagi umat manusia.

“Pendidikan bukan sekadar membangun kecerdasan, tetapi membentuk karakter, melahirkan kepemimpinan, dan menyiapkan generasi yang mampu memberi manfaat bagi sesama.”

Wassalamu’alaikum warahmatullahi wabarakatuh',
    'urutan' => 1,
    'is_active' => true,
  ),
  1 => 
  array (
    'nama' => 'Assoc. Prof. Dr. Ir. Larisang, S.T., M.T., IPU.',
    'slug' => 'profil-larisang',
    'jabatan' => 'Rektor Universitas Ibnu Sina (UIS)',
    'baris' => 1,
    'foto' => 'assets/img/pimpinan/larisang.png',
    'biografi' => 'Assoc. Prof. Dr. Ir. Larisang, S.T., M.T., IPU. adalah Rektor Universitas Ibnu Sina (UIS) Batam. Beliau merupakan akademisi dan praktisi di bidang Teknik Industri yang menyandang gelar Insinyur Profesional Utama (IPU).

Dalam kepemimpinannya sebagai Rektor Universitas Ibnu Sina, beliau berfokus pada penguatan tata kelola perguruan tinggi yang unggul, bermartabat, bereputasi nasional dan internasional, serta pengembangan budaya akademik dan kewirausahaan (entrepreneurship) yang berlandaskan Iman dan Taqwa (Imtaq).

Beliau juga aktif dalam berbagai organisasi profesi keinsinyuran, kolaborasi riset industri, peningkatan mutu tridharma perguruan tinggi, serta perluasan jejaring kemitraan strategis dengan dunia usaha, industri, dan perguruan tinggi di dalam maupun luar negeri.',
    'urutan' => 2,
    'is_active' => true,
  ),
  2 => 
  array (
    'nama' => 'Dr. Fitri Sari Dewi, SKM., M.KKK.',
    'slug' => 'profil-fitri-sari-dewi',
    'jabatan' => 'Wakil Rektor I Universitas Ibnu Sina (UIS)',
    'baris' => 2,
    'foto' => 'assets/img/pimpinan/fitri-sari-dewi.png',
    'biografi' => 'Dr. Fitri Sari Dewi, SKM., M.KKK. menjabat sebagai Wakil Rektor I Bidang Akademik Universitas Ibnu Sina (UIS) Batam. Beliau memiliki latar belakang keilmuan di bidang Kesehatan Masyarakat serta Keselamatan dan Kesehatan Kerja (K3).

Sebagai Wakil Rektor I, beliau bertanggung jawab dalam memimpin pelaksanaan dan pengembangan pendidikan, pengajaran, kurikulum berbasis Outcome-Based Education (OBE), serta peningkatan mutu akademik dan akreditasi program studi di lingkungan Universitas Ibnu Sina.

Beliau aktif dalam berbagai kegiatan penelitian, publikasi ilmiah, serta pengabdian kepada masyarakat khususnya dalam bidang keselamatan dan kesehatan kerja industri.',
    'urutan' => 3,
    'is_active' => true,
  ),
  3 => 
  array (
    'nama' => 'Dr. Andi Auliya Ramadhany, SE., M.Ak.',
    'slug' => 'profil-andi-auliya-ramadhany',
    'jabatan' => 'Wakil Rektor II Universitas Ibnu Sina (UIS)',
    'baris' => 2,
    'foto' => 'assets/img/pimpinan/andi-auliya-ramadhany.png',
    'biografi' => 'Dr. Andi Auliya Ramadhany, S.E., M.Ak. lahir di Batam pada 25 Maret 1991. Sebagai Wakil Rektor II, beliau bertanggung jawab dalam pengelolaan sumber daya, keuangan, serta pengembangan tata kelola institusi yang efektif, akuntabel, dan berkelanjutan untuk mendukung kemajuan Universitas Ibnu Sina.

Memiliki kepakaran di bidang Forensic Accounting, beliau aktif mengembangkan tata kelola yang berlandaskan prinsip transparansi, akuntabilitas, dan profesionalisme. Keahliannya diperkuat dengan keterlibatan sebagai anggota aktif Ikatan Akuntan Indonesia (IAI), yang menjadi wadah untuk terus mengikuti perkembangan profesi sekaligus berkontribusi dalam penguatan dunia akuntansi di Indonesia.

Sebagai representasi generasi akademisi muda, Dr. Andi meyakini bahwa usia muda bukanlah penghalang untuk melahirkan perubahan. Dengan semangat inovasi dan integritas, beliau mendorong terciptanya tata kelola kampus yang adaptif terhadap perkembangan zaman, mampu memanfaatkan teknologi, serta berorientasi pada peningkatan kualitas layanan bagi seluruh sivitas akademika.

Dalam pandangannya, Universitas Ibnu Sina merupakan kampus profesional muda yang berintegritas. Nilai tersebut menjadi fondasi dalam membangun budaya kerja yang menjunjung tinggi kejujuran, tanggung jawab, kompetensi, dan semangat untuk terus berkembang di tengah tantangan dunia pendidikan yang semakin dinamis.

Beliau juga percaya bahwa setiap individu memiliki potensi untuk berkembang, terlepas dari berbagai keterbatasan yang dimiliki. Bagi Dr. Andi, keberhasilan lahir dari kemauan untuk belajar, bekerja keras, dan menjadikan setiap tantangan sebagai peluang untuk bertumbuh.

Terinspirasi dari kisah Thomas Alva Edison, yang semasa kecil pernah dianggap mengalami kesulitan belajar namun kemudian menjadi salah satu ilmuwan paling berpengaruh di dunia, beliau mengajak seluruh mahasiswa untuk tidak menjadikan keterbatasan sebagai alasan untuk menyerah.

“Jangan jadikan kekurangan sebagai kelemahan. Jadikanlah setiap kekurangan sebagai motivasi untuk menjadi lebih baik. Tidak ada keberhasilan yang lahir tanpa proses, kerja keras, dan ketekunan. Teruslah belajar, berani mencoba, serta yakin bahwa setiap tantangan adalah kesempatan untuk menunjukkan kemampuan terbaik yang kita miliki.”katanya',
    'urutan' => 4,
    'is_active' => true,
  ),
  4 => 
  array (
    'nama' => 'Assoc. Prof. Dr. Sumardin, SE., M.Si.',
    'slug' => 'profil-sumardin',
    'jabatan' => 'Wakil Rektor III Universitas Ibnu Sina (UIS)',
    'baris' => 2,
    'foto' => 'assets/img/pimpinan/sumardin.png',
    'biografi' => 'Lahir di Wagola pada 4 Oktober 1975, Dr. Sumardin, S.E., M.Si. mengemban amanah sebagai Wakil Rektor III dengan fokus pada pengembangan kemahasiswaan, kerja sama, dan penguatan tata kelola yang mendukung peningkatan mutu Universitas Ibnu Sina.

Di bidang akademik, beliau dipercaya sebagai Asesor Nasional Beban Kerja Dosen (BKD), yang menunjukkan kompetensi dan pengakuan profesional dalam menjaga kualitas pelaksanaan Tri Dharma Perguruan Tinggi.

Kontribusinya juga terlihat melalui keterlibatan aktif dalam berbagai organisasi profesi dan pendidikan, di antaranya sebagai Pengurus APTISI Kepulauan Riau, Pengurus ADI Kepulauan Riau, Pengurus ISEI Kota Batam, Pengurus BAPOMI Kepulauan Riau, serta Ketua BPSMI Kepulauan Riau. Jejaring tersebut menjadi modal penting dalam memperluas kolaborasi dan memperkuat posisi Universitas Ibnu Sina di tingkat regional maupun nasional.

Dalam arah pengembangan institusi, Dr. Sumardin menempatkan pencapaian kampus unggul sebagai tujuan utama. Menurutnya, keberhasilan sebuah perguruan tinggi tidak hanya ditentukan oleh kebijakan pimpinan, tetapi juga oleh keterlibatan seluruh sivitas akademika dalam membangun budaya kerja yang produktif, inovatif, dan kolaboratif.

Beliau menekankan bahwa setiap unsur di lingkungan kampus memiliki peran strategis. Dosen, tenaga kependidikan, dan mahasiswa perlu bekerja bersama, saling mendukung, serta menghadirkan gagasan dan inovasi yang mampu meningkatkan kualitas pendidikan, penelitian, pengabdian kepada masyarakat, dan prestasi mahasiswa.

Dosen harus memperoleh ruang yang luas untuk mengembangkan kompetensi, melaksanakan penelitian yang berdampak, serta memberikan pengabdian yang memberikan manfaat nyata bagi masyarakat. Sementara itu, mahasiswa didorong untuk aktif mengembangkan potensi akademik maupun nonakademik agar mampu bersaing di tingkat nasional maupun internasional.

Selain penguatan sumber daya manusia, beliau juga memandang kemitraan sebagai faktor penting dalam percepatan kemajuan kampus. Kerja sama dengan pemerintah, dunia usaha, dunia industri, organisasi profesi, dan berbagai institusi pendidikan menjadi langkah strategis untuk memperluas peluang belajar, riset, inovasi, dan pengembangan karier bagi sivitas akademika.

“Mewujudkan kampus unggul adalah tanggung jawab bersama. Dengan semangat kolaborasi, integritas, dan inovasi, saya yakin Universitas Ibnu Sina akan terus berkembang menjadi perguruan tinggi yang berkualitas, berdaya saing, serta memberikan kontribusi nyata bagi masyarakat dan pembangunan bangsa.” Katanya.',
    'urutan' => 5,
    'is_active' => true,
  ),
  5 => 
  array (
    'nama' => 'Dr. Sabri, SE., MM.',
    'slug' => 'profil-sabri',
    'jabatan' => 'Dekan Fakultas Ekonomi dan Bisnis (FEB)',
    'baris' => 3,
    'foto' => 'assets/img/pimpinan/sabri.png',
    'biografi' => 'Dr. Sabri, S.E., M.M. lahir di Cimpu pada 4 Mei 1969. Sebagai Dekan Fakultas Ekonomi dan Bisnis Universitas Ibnu Sina, beliau mengemban amanah untuk membangun fakultas yang adaptif terhadap perubahan, unggul dalam tata kelola akademik, serta mampu menghasilkan lulusan yang profesional, berintegritas, dan memiliki daya saing global.

Sebagai akademisi dengan jabatan fungsional Lektor Kepala pada Program Studi Magister Manajemen Universitas Ibnu Sina, Dr. Sabri memiliki rekam jejak yang kuat dalam bidang manajemen sumber daya manusia. Kiprahnya tercermin melalui berbagai hibah penelitian, baik internal maupun eksternal, publikasi ilmiah pada jurnal nasional dan internasional bereputasi, penulisan buku ajar, perolehan Hak Kekayaan Intelektual (HKI), serta berbagai kegiatan pengabdian kepada masyarakat yang memberikan kontribusi nyata bagi pengembangan ilmu pengetahuan dan dunia praktik.

Kepakaran beliau berada pada bidang Sustainable Human Resources, sebuah pendekatan strategis dalam pengelolaan sumber daya manusia yang menempatkan manusia sebagai aset utama organisasi sekaligus faktor penentu keberlanjutan. Pendekatan ini mengintegrasikan dimensi ekonomi, sosial, dan lingkungan untuk membangun organisasi yang tangguh, adaptif, serta mampu menciptakan nilai jangka panjang.

Melalui berbagai penelitian dan karya ilmiah, Dr. Sabri mengembangkan kajian mengenai pengembangan sumber daya manusia, kepemimpinan berkelanjutan, budaya organisasi, pengelolaan talenta, employee engagement, kesejahteraan karyawan, keseimbangan kehidupan kerja, hingga peningkatan kinerja organisasi. Fokus tersebut menjadi landasan dalam mendorong organisasi agar mampu menghadapi transformasi digital, perubahan dunia kerja, dan tuntutan pembangunan berkelanjutan (Sustainable Development Goals).

Di bawah kepemimpinannya, Fakultas Ekonomi dan Bisnis Universitas Ibnu Sina diarahkan menjadi fakultas yang unggul dalam pendidikan, penelitian, dan pengabdian kepada masyarakat dengan mengedepankan tata kelola yang profesional, inovatif, dan berorientasi pada mutu.

Pengembangan fakultas difokuskan pada peningkatan kualitas sumber daya manusia, penguatan budaya akademik yang produktif, pengembangan riset yang memberikan solusi bagi dunia usaha dan industri, serta peningkatan publikasi ilmiah yang bereputasi. Di saat yang sama, fakultas terus memperluas kemitraan dengan pemerintah, dunia usaha, dunia industri, organisasi profesi, dan perguruan tinggi, baik di tingkat nasional maupun internasional.

Transformasi digital juga menjadi bagian penting dalam pengembangan fakultas, melalui pemanfaatan teknologi dalam proses pembelajaran, penelitian, pelayanan akademik, dan tata kelola institusi. Seluruh langkah tersebut diarahkan untuk menghasilkan lulusan yang memiliki kompetensi profesional, kepemimpinan, kemampuan beradaptasi, serta karakter yang mampu menjawab tantangan dunia kerja yang terus berkembang.

Bagi Dr. Sabri, kemajuan sebuah perguruan tinggi sangat bergantung pada kualitas manusianya. Gedung yang megah dan teknologi yang canggih tidak akan memberikan dampak berarti tanpa dosen, tenaga kependidikan, dan mahasiswa yang terus belajar, berinovasi, serta memiliki integritas dalam setiap karya dan pengabdiannya.

Beliau meyakini bahwa pendidikan tinggi harus menjadi ruang lahirnya pemimpin masa depan yang tidak hanya unggul secara akademik, tetapi juga mampu membangun organisasi yang sehat, adaptif, dan berkelanjutan. Karena itu, pengembangan sumber daya manusia harus menjadi investasi utama dalam membangun perguruan tinggi yang mampu bersaing di tingkat nasional maupun internasional.

“Keunggulan sebuah institusi tidak semata-mata diukur dari capaian akademiknya, tetapi dari kualitas manusia yang dibentuknya. Ketika ilmu pengetahuan dipadukan dengan integritas, kepemimpinan, dan semangat untuk terus belajar, maka akan lahir generasi yang mampu menciptakan perubahan dan memberikan manfaat bagi masyarakat, bangsa, serta dunia.”',
    'urutan' => 6,
    'is_active' => true,
  ),
  6 => 
  array (
    'nama' => 'Ir. Sanusi, ST., M.Eng., Ph.D., IPM.',
    'slug' => 'profil-sanusi',
    'jabatan' => 'Dekan Fakultas Sains dan Teknologi (FST)',
    'baris' => 3,
    'foto' => 'assets/img/pimpinan/sanusi.png',
    'biografi' => 'Ir. Sanusi, ST., M.Eng., Ph.D., IPM. menjabat sebagai Dekan Fakultas Sains dan Teknologi (FST) Universitas Ibnu Sina (UIS) Batam. Beliau menyelesaikan pendidikan doktoral (Ph.D.) di bidang teknik serta menyandang gelar Insinyur Profesional Madya (IPM).

Di bawah kepemimpinan beliau, Fakultas Sains dan Teknologi Universitas Ibnu Sina terus mengembangkan lima program studi unggulan yakni S1 Teknik Industri, S1 Teknik Informatika, S1 Sistem Informasi, S1 Teknik Logistik, dan S1 Teknik Perkapalan.

Beliau berkomitmen mendorong riset terapan, inovasi teknologi, serta kolaborasi erat antara fakultas dengan dunia usaha dan industri manufaktur, maritim, serta teknologi informasi di tingkat nasional maupun internasional.',
    'urutan' => 7,
    'is_active' => true,
  ),
  7 => 
  array (
    'nama' => 'Dr. Hengky Oktarizal, SKM., MKM.',
    'slug' => 'profil-hengky-oktarizal',
    'jabatan' => 'Dekan Fakultas Ilmu Kesehatan (FIKES)',
    'baris' => 3,
    'foto' => 'assets/img/pimpinan/hengky-oktarizal.png',
    'biografi' => 'Dr. Hengky Oktarizal, S.KM., M.KM. lahir di Dabo Singkep pada tahun 1990. Sebagai Dekan Fakultas Ilmu Kesehatan Universitas Ibnu Sina, beliau mengemban tanggung jawab dalam mengembangkan pendidikan kesehatan yang adaptif terhadap perubahan zaman, berorientasi pada mutu, serta mampu menjawab kebutuhan masyarakat, khususnya di wilayah industri, kepulauan, dan perbatasan.

Memiliki kepakaran di bidang Kesehatan Masyarakat, beliau aktif berkontribusi dalam pengembangan profesi sebagai Majelis Pakar Pengurus Pusat Himpunan Ahli Kesehatan Lingkungan Indonesia (HAKLI). Keterlibatan tersebut memperkuat jejaring akademik sekaligus membuka ruang kolaborasi dalam pengembangan pendidikan, penelitian, dan pengabdian kepada masyarakat.

Di bawah kepemimpinannya, Fakultas Ilmu Kesehatan diarahkan menjadi fakultas yang unggul, berintegritas, inovatif, dan berjiwa entrepreneur, dengan keunggulan pada isu-isu kesehatan wilayah industri, kepulauan, dan perbatasan. Arah pengembangan tersebut diwujudkan melalui penguatan mutu akademik berbasis Outcome-Based Education (OBE), peningkatan kualitas riset dan inovasi, transformasi digital dalam tata kelola fakultas, penguatan budaya mutu, serta perluasan kerja sama nasional dan internasional.

Beliau juga menaruh perhatian besar pada pengembangan sumber daya manusia, peningkatan kompetensi lulusan, serta pembentukan karakter mahasiswa. Menurutnya, lulusan Fakultas Ilmu Kesehatan tidak hanya dituntut memiliki kemampuan akademik dan profesional, tetapi juga kepemimpinan, integritas, kepedulian sosial, kemampuan beradaptasi, dan semangat kewirausahaan agar mampu memberikan solusi atas berbagai tantangan di bidang kesehatan.

Selain memperkuat program studi yang telah ada, Fakultas Ilmu Kesehatan terus mengembangkan inovasi pembelajaran, penelitian yang berdampak, serta pengabdian kepada masyarakat berbasis kebutuhan nyata. Seluruh upaya tersebut diarahkan untuk mendukung pembangunan kesehatan yang berkelanjutan sekaligus meningkatkan daya saing lulusan di tingkat nasional maupun internasional.

Bismillahirrahmanirrahim.

Assalamu’alaikum warahmatullahi wabarakatuh.

Fakultas Ilmu Kesehatan Universitas Ibnu Sina hadir untuk menyiapkan tenaga kesehatan yang tidak hanya unggul dalam ilmu pengetahuan, tetapi juga memiliki integritas, kepedulian, dan kemampuan menghadapi perubahan yang terus berkembang. Dunia kesehatan membutuhkan sumber daya manusia yang mampu berpikir kritis, bekerja secara profesional, dan memberikan solusi bagi masyarakat.

Karena itu, kami terus membangun lingkungan akademik yang mendorong lahirnya inovasi, memperkuat budaya riset, meningkatkan kualitas pembelajaran, serta memperluas kolaborasi dengan berbagai mitra. Kami percaya bahwa pendidikan yang berkualitas harus mampu menghasilkan lulusan yang siap berkarya sekaligus memberikan manfaat bagi masyarakat.

Saya mengajak seluruh dosen, tenaga kependidikan, mahasiswa, dan mitra untuk menjadikan integritas sebagai landasan dalam setiap aktivitas akademik. Kejujuran, disiplin, tanggung jawab, dan profesionalisme merupakan nilai yang akan menentukan kualitas diri maupun kualitas institusi.

Kepada para mahasiswa, manfaatkan setiap kesempatan selama menempuh pendidikan untuk mengembangkan kompetensi, memperluas pengalaman, serta membangun karakter kepemimpinan. Jadilah insan kesehatan yang tidak hanya menguasai ilmu, tetapi juga memiliki empati, semangat melayani, dan kepedulian terhadap persoalan yang dihadapi masyarakat.

Keberhasilan fakultas merupakan hasil kerja bersama. Dengan semangat kolaborasi, inovasi, dan perbaikan berkelanjutan, saya yakin Fakultas Ilmu Kesehatan Universitas Ibnu Sina akan terus berkembang menjadi pusat pendidikan kesehatan yang unggul dan memberikan kontribusi nyata bagi pembangunan kesehatan Indonesia.

“Ilmu menjadikan kita cerdas, integritas menjadikan kita dipercaya, dan pengabdian menjadikan kita bermakna.”

Wassalamu’alaikum warahmatullahi wabarakatuh.',
    'urutan' => 8,
    'is_active' => true,
  ),
);
        foreach ($leaders as &$row) {
            $row['created_at'] = $now;
            $row['updated_at'] = $now;
        }
        DB::table('profil_pimpinans')->insert($leaders);

        $manajemen = array (
  0 => 
  array (
    'kategori' => 'Rektorat',
    'no_urut' => 1,
    'nama' => 'Dr. Sudianto, SE., M.Si',
    'jabatan' => 'Ka. Senat Universitas Ibnu Sina',
    'is_active' => true,
  ),
  1 => 
  array (
    'kategori' => 'Rektorat',
    'no_urut' => 2,
    'nama' => 'Ir. Hanafi, S.Kom., M.Kom',
    'jabatan' => 'Sekretaris Senat UIS',
    'is_active' => true,
  ),
  2 => 
  array (
    'kategori' => 'Rektorat',
    'no_urut' => 3,
    'nama' => 'Leni Utami, S.Si., M.KM',
    'jabatan' => 'Ka. BAAK',
    'is_active' => true,
  ),
  3 => 
  array (
    'kategori' => 'Rektorat',
    'no_urut' => 4,
    'nama' => 'Andi Hidayatul Fadlilah, SE., M.Si., AK',
    'jabatan' => 'Ka. BAUK',
    'is_active' => true,
  ),
  4 => 
  array (
    'kategori' => 'Rektorat',
    'no_urut' => 5,
    'nama' => 'dr. Hj. Elsusi Martha, MKM',
    'jabatan' => 'Ka. BKAK',
    'is_active' => true,
  ),
  5 => 
  array (
    'kategori' => 'Rektorat',
    'no_urut' => 6,
    'nama' => 'Muhammad Fadli Luran, SE., MM',
    'jabatan' => 'Kabid Akademik',
    'is_active' => true,
  ),
  6 => 
  array (
    'kategori' => 'Rektorat',
    'no_urut' => 7,
    'nama' => 'Muhamad Albar, S.Kom',
    'jabatan' => 'Staf Akademik',
    'is_active' => true,
  ),
  7 => 
  array (
    'kategori' => 'Rektorat',
    'no_urut' => 8,
    'nama' => 'Meta Nila Sari',
    'jabatan' => 'Staf Akademik',
    'is_active' => true,
  ),
  8 => 
  array (
    'kategori' => 'Rektorat',
    'no_urut' => 9,
    'nama' => 'Adnan, SE., MM',
    'jabatan' => 'Kabid Adm dan Layanan Kemahasiswaan',
    'is_active' => true,
  ),
  9 => 
  array (
    'kategori' => 'Rektorat',
    'no_urut' => 10,
    'nama' => 'Andi Ricky Hamur. SE',
    'jabatan' => 'Staf-Support Layanan Ijazah',
    'is_active' => true,
  ),
  10 => 
  array (
    'kategori' => 'Rektorat',
    'no_urut' => 11,
    'nama' => 'Andi Amin Suryawan, SE',
    'jabatan' => 'Staf-Support Layanan Nilai dan Perkuliahan',
    'is_active' => true,
  ),
  11 => 
  array (
    'kategori' => 'Rektorat',
    'no_urut' => 12,
    'nama' => 'Hasan Husen, S.IP',
    'jabatan' => 'Kepala Perpustakaan',
    'is_active' => true,
  ),
  12 => 
  array (
    'kategori' => 'Rektorat',
    'no_urut' => 13,
    'nama' => 'Fitra Ayu Kusuma, S.Hum',
    'jabatan' => 'Pustakawan',
    'is_active' => true,
  ),
  13 => 
  array (
    'kategori' => 'Rektorat',
    'no_urut' => 14,
    'nama' => 'Nishfu Nurbayanti',
    'jabatan' => 'Pustakawan',
    'is_active' => true,
  ),
  14 => 
  array (
    'kategori' => 'Rektorat',
    'no_urut' => 15,
    'nama' => 'Maisyita Risma Suryani, SKL',
    'jabatan' => 'Kabid Keuangan',
    'is_active' => true,
  ),
  15 => 
  array (
    'kategori' => 'Rektorat',
    'no_urut' => 16,
    'nama' => 'Andi Saidah, SE., MM',
    'jabatan' => 'Kasir Rektorat',
    'is_active' => true,
  ),
  16 => 
  array (
    'kategori' => 'Rektorat',
    'no_urut' => 17,
    'nama' => 'Shinta Wahyuni, SE., MM',
    'jabatan' => 'Staf Keuangan- FEB',
    'is_active' => true,
  ),
  17 => 
  array (
    'kategori' => 'Rektorat',
    'no_urut' => 18,
    'nama' => 'Zhalfa Putri Elisa, SE, MM',
    'jabatan' => 'Staf Keuangan- FEB',
    'is_active' => true,
  ),
  18 => 
  array (
    'kategori' => 'Rektorat',
    'no_urut' => 19,
    'nama' => 'Andi Humaimah, S.Kes',
    'jabatan' => 'Staf Keuangan- FST',
    'is_active' => true,
  ),
  19 => 
  array (
    'kategori' => 'Rektorat',
    'no_urut' => 20,
    'nama' => 'Maisarah Pertiwi, S.M',
    'jabatan' => 'Staf Keuangan- FST',
    'is_active' => true,
  ),
  20 => 
  array (
    'kategori' => 'Rektorat',
    'no_urut' => 21,
    'nama' => 'Andi Aulia Vitrizky, Amd., Ak',
    'jabatan' => 'Staf Keuangan- FIKes',
    'is_active' => true,
  ),
  21 => 
  array (
    'kategori' => 'Rektorat',
    'no_urut' => 22,
    'nama' => 'Salsabila Rivania, S.Ak',
    'jabatan' => 'Staf Keuangan- FIKes',
    'is_active' => true,
  ),
  22 => 
  array (
    'kategori' => 'Rektorat',
    'no_urut' => 23,
    'nama' => 'Nurmayunita, SE., MM',
    'jabatan' => 'Kabid Kepegawaian',
    'is_active' => true,
  ),
  23 => 
  array (
    'kategori' => 'Rektorat',
    'no_urut' => 24,
    'nama' => 'Ishak, SE.,MM',
    'jabatan' => 'Staf Kepegawaian Pengurusan Tenaga Pendidik',
    'is_active' => true,
  ),
  24 => 
  array (
    'kategori' => 'Rektorat',
    'no_urut' => 25,
    'nama' => 'Rosalina, SE',
    'jabatan' => 'Staf Kepegawaian Pengurusan Tenaga Kependidikan',
    'is_active' => true,
  ),
  25 => 
  array (
    'kategori' => 'Rektorat',
    'no_urut' => 26,
    'nama' => 'dr. Andi Khairunnisa',
    'jabatan' => 'Kabid Sarana Prasarana',
    'is_active' => true,
  ),
  26 => 
  array (
    'kategori' => 'Rektorat',
    'no_urut' => 27,
    'nama' => 'Choirul Anam, S.Kom',
    'jabatan' => 'Admin Umum Sarana Prasarana',
    'is_active' => true,
  ),
  27 => 
  array (
    'kategori' => 'Rektorat',
    'no_urut' => 28,
    'nama' => 'Andi Taher, SE., MM',
    'jabatan' => 'Staf Sarana Prasarana',
    'is_active' => true,
  ),
  28 => 
  array (
    'kategori' => 'Rektorat',
    'no_urut' => 29,
    'nama' => 'Apriyadi',
    'jabatan' => 'Staf Sarana Prasarana',
    'is_active' => true,
  ),
  29 => 
  array (
    'kategori' => 'Rektorat',
    'no_urut' => 30,
    'nama' => 'Andi Awaluddin, S.Kom',
    'jabatan' => 'Kepala Tata Usaha Rektorat',
    'is_active' => true,
  ),
  30 => 
  array (
    'kategori' => 'Rektorat',
    'no_urut' => 31,
    'nama' => 'Dr. Muhammad Ropianto, S.Kom., M.Kom',
    'jabatan' => 'Ka. Lembaga Pengembangan Teknologi Informasi',
    'is_active' => true,
  ),
  31 => 
  array (
    'kategori' => 'Rektorat',
    'no_urut' => 32,
    'nama' => 'Andi Muamar, S.Kom,M.Kom',
    'jabatan' => 'Staf Pengembangan Sistem Informasi dan Aplikasi',
    'is_active' => true,
  ),
  32 => 
  array (
    'kategori' => 'Rektorat',
    'no_urut' => 33,
    'nama' => 'Dicky Ashrul Ibrahim, S.Kom',
    'jabatan' => 'Staf LPTI-Infrastruktur, Jaringan, dan Layanan Troubleshooting',
    'is_active' => true,
  ),
  33 => 
  array (
    'kategori' => 'Rektorat',
    'no_urut' => 34,
    'nama' => 'Dimas Pradipto, S.Kom, M.Kom',
    'jabatan' => 'Programmer - LPTI',
    'is_active' => true,
  ),
  34 => 
  array (
    'kategori' => 'Rektorat',
    'no_urut' => 35,
    'nama' => 'Rusdiyanto, S.Kom',
    'jabatan' => 'Staff and support - LPTI',
    'is_active' => true,
  ),
  35 => 
  array (
    'kategori' => 'Rektorat',
    'no_urut' => 36,
    'nama' => 'Andi Akbar, SE., MM',
    'jabatan' => 'Kabid Humas dan Publikasi',
    'is_active' => true,
  ),
  36 => 
  array (
    'kategori' => 'Rektorat',
    'no_urut' => 37,
    'nama' => 'Nopan Aswandi, S.Kom, M.Kom',
    'jabatan' => 'Staf Desain dan Photography',
    'is_active' => true,
  ),
  37 => 
  array (
    'kategori' => 'Rektorat',
    'no_urut' => 38,
    'nama' => 'Raga Prasandi, SE',
    'jabatan' => 'Staf Humas UIS',
    'is_active' => true,
  ),
  38 => 
  array (
    'kategori' => 'Rektorat',
    'no_urut' => 39,
    'nama' => 'Taslimahudin, S.Sos., M.C.S',
    'jabatan' => 'Staf Website UIS',
    'is_active' => true,
  ),
  39 => 
  array (
    'kategori' => 'Rektorat',
    'no_urut' => 40,
    'nama' => 'Habib Armanda,S.Kom',
    'jabatan' => 'Staf Desain dan Photography',
    'is_active' => true,
  ),
  40 => 
  array (
    'kategori' => 'Rektorat',
    'no_urut' => 41,
    'nama' => 'Amirullah, S.Kom., MM',
    'jabatan' => 'Kabid Kerjasama UIS',
    'is_active' => true,
  ),
  41 => 
  array (
    'kategori' => 'Rektorat',
    'no_urut' => 42,
    'nama' => 'Agus Sutiandi, S.Ak',
    'jabatan' => 'Staf Kerjasama-Internasional',
    'is_active' => true,
  ),
  42 => 
  array (
    'kategori' => 'Rektorat',
    'no_urut' => 43,
    'nama' => 'Marda Lisa, S.Ak',
    'jabatan' => 'Staf Kerjasama-Nasional',
    'is_active' => true,
  ),
  43 => 
  array (
    'kategori' => 'Rektorat',
    'no_urut' => 44,
    'nama' => 'Andi Ruslan, SE., MM',
    'jabatan' => 'Staf Kerjasama-Nasional',
    'is_active' => true,
  ),
  44 => 
  array (
    'kategori' => 'Rektorat',
    'no_urut' => 45,
    'nama' => 'Dr. Ir. Abdul Rohmad Basar, S.Kom., M.Kom',
    'jabatan' => 'Kabid Kemahasiswaan',
    'is_active' => true,
  ),
  45 => 
  array (
    'kategori' => 'Rektorat',
    'no_urut' => 46,
    'nama' => 'Rasmin Nur Jading, S.KM., M.Kes',
    'jabatan' => 'Staf Kemahasiswaan-Ormawa dan Pengelola Beasiswa Mahasiswa',
    'is_active' => true,
  ),
  46 => 
  array (
    'kategori' => 'Rektorat',
    'no_urut' => 47,
    'nama' => 'Andi Mahdi Syahraini,SM',
    'jabatan' => 'Staf Kemahasiswaan-Prestasi Olahraga',
    'is_active' => true,
  ),
  47 => 
  array (
    'kategori' => 'Rektorat',
    'no_urut' => 49,
    'nama' => 'Azmil Fauzi Fariska, SH., MH',
    'jabatan' => 'Staf Kemahasiswaan-Prestasi Seni',
    'is_active' => true,
  ),
  48 => 
  array (
    'kategori' => 'Rektorat',
    'no_urut' => 50,
    'nama' => 'Dr. Ahmadi, M.Kes',
    'jabatan' => 'Kabid Pusat Karir, Alumni dan Kewirausahaan',
    'is_active' => true,
  ),
  49 => 
  array (
    'kategori' => 'Rektorat',
    'no_urut' => 51,
    'nama' => 'Lailatul Qadry, S.Kom',
    'jabatan' => 'Staf Pusat Karir, Alumni dan Kewirausahaan',
    'is_active' => true,
  ),
  50 => 
  array (
    'kategori' => 'Rektorat',
    'no_urut' => 52,
    'nama' => 'Agus Suryadi, M.Kom',
    'jabatan' => 'Kabid Perencanaan dan Pengembangan',
    'is_active' => true,
  ),
  51 => 
  array (
    'kategori' => 'Rektorat',
    'no_urut' => 53,
    'nama' => 'Dr. Ice Irawati, SKM., M.Kes',
    'jabatan' => 'Ka. LPPM',
    'is_active' => true,
  ),
  52 => 
  array (
    'kategori' => 'Rektorat',
    'no_urut' => 54,
    'nama' => 'Yandra Rivaldo, SE.,MM',
    'jabatan' => 'Kabid Penelitian',
    'is_active' => true,
  ),
  53 => 
  array (
    'kategori' => 'Rektorat',
    'no_urut' => 55,
    'nama' => 'Khoerun Nisa Safitri, ST.,MT',
    'jabatan' => 'Kabid Pengabdian Kepada Masyarakat',
    'is_active' => true,
  ),
  54 => 
  array (
    'kategori' => 'Rektorat',
    'no_urut' => 56,
    'nama' => 'Marlina Umar, S.Kom',
    'jabatan' => 'Staf Adm Penelitian dan Pengabdian Kepada Masyarakat',
    'is_active' => true,
  ),
  55 => 
  array (
    'kategori' => 'Rektorat',
    'no_urut' => 57,
    'nama' => 'Nanda Jarti, M.Kom',
    'jabatan' => 'Kabid Haki dan Publikasi',
    'is_active' => true,
  ),
  56 => 
  array (
    'kategori' => 'Rektorat',
    'no_urut' => 58,
    'nama' => 'Roni Saputra, S.Si., M.Si',
    'jabatan' => 'Ka. LPMI',
    'is_active' => true,
  ),
  57 => 
  array (
    'kategori' => 'Rektorat',
    'no_urut' => 59,
    'nama' => 'Dr.Novi Hendri Adi, S.Pd., M.Pd.T',
    'jabatan' => 'Kabid Pengembangan SPMI dan pegawai SPMI',
    'is_active' => true,
  ),
  58 => 
  array (
    'kategori' => 'Rektorat',
    'no_urut' => 60,
    'nama' => 'Ir. Indah Kusuma Dewi, S.Kom., M.Kom',
    'jabatan' => 'Kabid Dokumentasi Mutu dan Akreditasi',
    'is_active' => true,
  ),
  59 => 
  array (
    'kategori' => 'Rektorat',
    'no_urut' => 61,
    'nama' => 'Chinta Yolanda Sari, SKM., M.KM',
    'jabatan' => 'Kabid Monitoring dan Evaluasi',
    'is_active' => true,
  ),
  60 => 
  array (
    'kategori' => 'Rektorat',
    'no_urut' => 62,
    'nama' => 'Wan Intan Parisma, S.ST., M.KM',
    'jabatan' => 'Kabid Audit Mutu Internal',
    'is_active' => true,
  ),
  61 => 
  array (
    'kategori' => 'FEB',
    'no_urut' => 1,
    'nama' => 'M. Aras, SE.,MM',
    'jabatan' => 'Ketua Senat Fakultas Ekonomi dan Bisnis',
    'is_active' => true,
  ),
  62 => 
  array (
    'kategori' => 'FEB',
    'no_urut' => 2,
    'nama' => 'Samad, SS.,M.Pd',
    'jabatan' => 'Sekretaris Senat Fakultas Ekonomi dan Bisnis',
    'is_active' => true,
  ),
  63 => 
  array (
    'kategori' => 'FEB',
    'no_urut' => 3,
    'nama' => 'Dr. Sabri, SE., MM',
    'jabatan' => 'Dekan Fakultas Ekonomi dan Bisnis',
    'is_active' => true,
  ),
  64 => 
  array (
    'kategori' => 'FEB',
    'no_urut' => 4,
    'nama' => 'Dr. Mulyadi, SE., MM',
    'jabatan' => 'Wakil Dekan I FEB',
    'is_active' => true,
  ),
  65 => 
  array (
    'kategori' => 'FEB',
    'no_urut' => 5,
    'nama' => 'Dr.Ita Mustika, SE., M.Ak',
    'jabatan' => 'Wakil Dekan II FEB',
    'is_active' => true,
  ),
  66 => 
  array (
    'kategori' => 'FEB',
    'no_urut' => 6,
    'nama' => 'Septa Diana Nabella, SE., MM',
    'jabatan' => 'Ka. Prodi S1 Manajemen',
    'is_active' => true,
  ),
  67 => 
  array (
    'kategori' => 'FEB',
    'no_urut' => 7,
    'nama' => 'Ina Kurniati, SE., MM',
    'jabatan' => 'Sekretaris Prodi S1 Manajemen',
    'is_active' => true,
  ),
  68 => 
  array (
    'kategori' => 'FEB',
    'no_urut' => 8,
    'nama' => 'Maya Richmayati, SE., M.Ak',
    'jabatan' => 'Ka. Prodi S1 Akutansi',
    'is_active' => true,
  ),
  69 => 
  array (
    'kategori' => 'FEB',
    'no_urut' => 9,
    'nama' => 'Khadijah, SE., M.Ak',
    'jabatan' => 'Sekretaris Prodi S1 Akutansi',
    'is_active' => true,
  ),
  70 => 
  array (
    'kategori' => 'FEB',
    'no_urut' => 10,
    'nama' => 'Dr. Hendri Herman, SE., M.Si',
    'jabatan' => 'Ka. Prodi Pascasarjana Magister Of Management',
    'is_active' => true,
  ),
  71 => 
  array (
    'kategori' => 'FEB',
    'no_urut' => 11,
    'nama' => 'Dr.Dewi Permata Sari, SE.,MM',
    'jabatan' => 'Ka. UPMI FEB',
    'is_active' => true,
  ),
  72 => 
  array (
    'kategori' => 'FEB',
    'no_urut' => 12,
    'nama' => 'Dr. Andika Prasetya Nugraha, SE., MM',
    'jabatan' => 'Ka. UPPM FEB',
    'is_active' => true,
  ),
  73 => 
  array (
    'kategori' => 'FEB',
    'no_urut' => 13,
    'nama' => 'Mohammad Firnanda, ST',
    'jabatan' => 'Humas dan Publikasi Web UIS',
    'is_active' => true,
  ),
  74 => 
  array (
    'kategori' => 'FEB',
    'no_urut' => 14,
    'nama' => 'M.Tarmizi S.E.,M.M',
    'jabatan' => 'Tata Usaha Pascasarjana',
    'is_active' => true,
  ),
  75 => 
  array (
    'kategori' => 'FEB',
    'no_urut' => 15,
    'nama' => 'Rahman Syahputra, S.Sos., M.Si',
    'jabatan' => 'Tata Usaha Sarjana',
    'is_active' => true,
  ),
  76 => 
  array (
    'kategori' => 'FST',
    'no_urut' => 1,
    'nama' => 'Sabtu, S.Kom.,M.Pdt',
    'jabatan' => 'Ketua Senat Fakultas Sains dan Teknologi',
    'is_active' => true,
  ),
  77 => 
  array (
    'kategori' => 'FST',
    'no_urut' => 2,
    'nama' => 'Ir. Sanusi, ST., M.Eng., Ph.D., IPM',
    'jabatan' => 'Dekan Fakultas Sains dan Teknologi',
    'is_active' => true,
  ),
  78 => 
  array (
    'kategori' => 'FST',
    'no_urut' => 3,
    'nama' => 'Dr. Okta Vesa, S.Kom., M.Kom',
    'jabatan' => 'Wakil Dekan I Sains dan Teknologi',
    'is_active' => true,
  ),
  79 => 
  array (
    'kategori' => 'FST',
    'no_urut' => 4,
    'nama' => 'Andi Hepy Susanti, SE., MM',
    'jabatan' => 'Wakil Dekan II Sains dan Teknologi',
    'is_active' => true,
  ),
  80 => 
  array (
    'kategori' => 'FST',
    'no_urut' => 5,
    'nama' => 'Ir. Herman, ST., MT',
    'jabatan' => 'Ka. Prodi Teknik Industri',
    'is_active' => true,
  ),
  81 => 
  array (
    'kategori' => 'FST',
    'no_urut' => 6,
    'nama' => 'Rizki Prakasa Hasibuan, ST.,MT',
    'jabatan' => 'Sekretaris Prodi Teknik Industri',
    'is_active' => true,
  ),
  82 => 
  array (
    'kategori' => 'FST',
    'no_urut' => 7,
    'nama' => 'Dr.Army Trilidia Devega, S.Kom., M.Pd',
    'jabatan' => 'Ka. Prodi T Informatika dan Prodi Sistem Informasi',
    'is_active' => true,
  ),
  83 => 
  array (
    'kategori' => 'FST',
    'no_urut' => 8,
    'nama' => 'Atman Lucky F, S.Kom., M.Kom',
    'jabatan' => 'Sekretaris Prodi T Informatika dan Prodi Sistem Informasi',
    'is_active' => true,
  ),
  84 => 
  array (
    'kategori' => 'FST',
    'no_urut' => 9,
    'nama' => 'Dr.Albertus Laurensius Setyabudhi, ST., M.MT., IPM',
    'jabatan' => 'Ka. prodi Teknik Logistik dan Perkapalan',
    'is_active' => true,
  ),
  85 => 
  array (
    'kategori' => 'FST',
    'no_urut' => 10,
    'nama' => 'Amelia Rachmi Nasution, S.T., M.T',
    'jabatan' => 'Sekretaris prodi Teknik Logistik dan Perkapalan',
    'is_active' => true,
  ),
  86 => 
  array (
    'kategori' => 'FST',
    'no_urut' => 11,
    'nama' => 'Afrina, S.Kom., M.SI',
    'jabatan' => 'Ka. UPMI FST',
    'is_active' => true,
  ),
  87 => 
  array (
    'kategori' => 'FST',
    'no_urut' => 12,
    'nama' => 'Ir. Ery Sugito, ST.,MT',
    'jabatan' => 'Ka. UPPM FST',
    'is_active' => true,
  ),
  88 => 
  array (
    'kategori' => 'FST',
    'no_urut' => 13,
    'nama' => 'Nofri Yudi, S.Kom., M.Kom',
    'jabatan' => 'Staf UPPM FST',
    'is_active' => true,
  ),
  89 => 
  array (
    'kategori' => 'FST',
    'no_urut' => 14,
    'nama' => 'Lutfia, ST',
    'jabatan' => 'Staf Lab Teknik Industri',
    'is_active' => true,
  ),
  90 => 
  array (
    'kategori' => 'FST',
    'no_urut' => 15,
    'nama' => 'Mardinur, S.Kom',
    'jabatan' => 'Staf Lab Teknik Informatika',
    'is_active' => true,
  ),
  91 => 
  array (
    'kategori' => 'FST',
    'no_urut' => 16,
    'nama' => 'M.Isra Nur Abdullah Yuzul, ST',
    'jabatan' => 'Staf Lab Teknik Proses Produksi',
    'is_active' => true,
  ),
  92 => 
  array (
    'kategori' => 'FST',
    'no_urut' => 17,
    'nama' => 'Mutiara Ayu Mawaddah, S.Kom',
    'jabatan' => 'Humas dan Publikasi FST',
    'is_active' => true,
  ),
  93 => 
  array (
    'kategori' => 'FST',
    'no_urut' => 18,
    'nama' => 'Andi Amin Amirul Mukminin, S.Kom,M.Kom',
    'jabatan' => 'Humas dan Publikasi FST',
    'is_active' => true,
  ),
  94 => 
  array (
    'kategori' => 'FST',
    'no_urut' => 19,
    'nama' => 'Muhammad Ansar SE.,MM',
    'jabatan' => 'Tata usaha FST',
    'is_active' => true,
  ),
  95 => 
  array (
    'kategori' => 'FIKES',
    'no_urut' => 1,
    'nama' => 'drg. Candra Rizal, M.Si',
    'jabatan' => 'Ketua Senat FIKes',
    'is_active' => true,
  ),
  96 => 
  array (
    'kategori' => 'FIKES',
    'no_urut' => 2,
    'nama' => 'Dr. Hengky Oktarizal, SKM., MKM',
    'jabatan' => 'Dekan FIKes',
    'is_active' => true,
  ),
  97 => 
  array (
    'kategori' => 'FIKES',
    'no_urut' => 3,
    'nama' => 'Dr. Herdianti, S.KM., M.Kes',
    'jabatan' => 'Wakil Dekan I FIKES',
    'is_active' => true,
  ),
  98 => 
  array (
    'kategori' => 'FIKES',
    'no_urut' => 4,
    'nama' => 'Rizqi Ulla Amaliah, SKM., MKKK',
    'jabatan' => 'Wakil Dekan II FIKES',
    'is_active' => true,
  ),
  99 => 
  array (
    'kategori' => 'FIKES',
    'no_urut' => 5,
    'nama' => 'Trisna Dewita, SKM., M.Kes',
    'jabatan' => 'Ka. Prodi K3',
    'is_active' => true,
  ),
  100 => 
  array (
    'kategori' => 'FIKES',
    'no_urut' => 6,
    'nama' => 'Trisna Jayati, M.KM',
    'jabatan' => 'Sekretaris Prodi K3',
    'is_active' => true,
  ),
  101 => 
  array (
    'kategori' => 'FIKES',
    'no_urut' => 7,
    'nama' => 'M.Kafit, SKM., M.Kes',
    'jabatan' => 'Ka. Prodi KESLING',
    'is_active' => true,
  ),
  102 => 
  array (
    'kategori' => 'FIKES',
    'no_urut' => 8,
    'nama' => 'Al Hafez Husein, SKM.,M.KL',
    'jabatan' => 'Sekretaris Prodi KESLING',
    'is_active' => true,
  ),
  103 => 
  array (
    'kategori' => 'FIKES',
    'no_urut' => 10,
    'nama' => 'Juhanda Kartika Wijaya, S.KL.,M.KM',
    'jabatan' => 'Sekretaris Prodi S2 KESMAS',
    'is_active' => true,
  ),
  104 => 
  array (
    'kategori' => 'FIKES',
    'no_urut' => 11,
    'nama' => 'Novela Sari, SKM., M.Kes',
    'jabatan' => 'Ka. UPMI',
    'is_active' => true,
  ),
  105 => 
  array (
    'kategori' => 'FIKES',
    'no_urut' => 12,
    'nama' => 'Fajar, SKM., M.Kes',
    'jabatan' => 'GKM FIKes',
    'is_active' => true,
  ),
  106 => 
  array (
    'kategori' => 'FIKES',
    'no_urut' => 13,
    'nama' => 'Anita Pramawati, SKM., M.Si',
    'jabatan' => 'Ka. UPPM',
    'is_active' => true,
  ),
  107 => 
  array (
    'kategori' => 'FIKES',
    'no_urut' => 14,
    'nama' => 'Jamal, S.KL.,M.KM',
    'jabatan' => 'Kepala Laboratorium FIKes',
    'is_active' => true,
  ),
  108 => 
  array (
    'kategori' => 'FIKES',
    'no_urut' => 15,
    'nama' => 'Ujang Amir Hamzah,S.Tr.Kom',
    'jabatan' => 'Humas dan Publikasi Web FIKes',
    'is_active' => true,
  ),
  109 => 
  array (
    'kategori' => 'FIKES',
    'no_urut' => 16,
    'nama' => 'Perawaty Selfia Nasution, S.KL',
    'jabatan' => 'Tata Usaha FIKes',
    'is_active' => true,
  ),
);
        foreach ($manajemen as &$mRow) {
            $mRow['created_at'] = $now;
            $mRow['updated_at'] = $now;
        }
        foreach (array_chunk($manajemen, 50) as $chunk) {
            DB::table('pimpinan_manajemens')->insert($chunk);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('pimpinan_manajemens');
        Schema::dropIfExists('profil_pimpinans');
    }
};