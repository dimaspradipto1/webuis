<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeasiswaSetting extends Model
{
    use HasFactory;

    protected $table = 'beasiswa_settings';

    protected $fillable = [
        'hero_badge',
        'hero_judul',
        'hero_deskripsi',
        'tentang_judul',
        'tentang_deskripsi',
        'gambar',
        'link_daftar',
        'tombol_daftar_teks',
        'tombol_wa_teks',
        'link_wa',
        'show_wa',
        'is_active',
        'stats',
        'keunggulan_list',
        'jalur_list',
        'alur_list',
        'faq_list',
        'cta_data',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'show_wa' => 'boolean',
        'stats' => 'array',
        'keunggulan_list' => 'array',
        'jalur_list' => 'array',
        'alur_list' => 'array',
        'faq_list' => 'array',
        'cta_data' => 'array',
    ];

    public static function defaultStats(): array
    {
        return [
            ['icon' => 'bi-mortarboard-fill', 'nilai' => '6+', 'label' => 'Jalur Beasiswa'],
            ['icon' => 'bi-award-fill', 'nilai' => '100%', 'label' => 'Bebas SPP Penuh'],
            ['icon' => 'bi-people-fill', 'nilai' => 'Ratusan', 'label' => 'Kuota Tiap Tahun'],
            ['icon' => 'bi-buildings-fill', 'nilai' => '150+', 'label' => 'Mitra Kerjasama'],
        ];
    }

    public static function defaultKeunggulan(): array
    {
        return [
            'Pembebasan Biaya Kuliah: Subsidi SPP/UKT hingga 100% bebas biaya sampai lulus.',
            'Pembinaan Karakter & Akademik: Pelatihan kepemimpinan, riset terapan, dan sertifikasi kompetensi.',
            'Penyaluran Magang & Karir: Akses prioritas magang kerja di perusahaan mitra industri Batam.',
        ];
    }

    public static function defaultJalur(): array
    {
        return [
            [
                'id' => 'collapseKip',
                'judul' => 'Beasiswa KIP-Kuliah Merdeka (Kemendikbudristek)',
                'badge' => 'Bebas 100% SPP + Biaya Hidup',
                'icon' => 'bi-mortarboard-fill',
                'ringkasan' => 'Jalur bantuan biaya pendidikan dari Pemerintah RI untuk calon mahasiswa berprestasi dari keluarga prasejahtera.',
                'deskripsi' => 'Program Kartu Indonesia Pintar Kuliah (KIP-Kuliah) diselenggarakan bekerja sama dengan Pusat Pembiayaan Pendidikan Kemendikbudristek RI. Program ini ditujukan untuk menjamin keberlanjutan kuliah mahasiswa berprestasi tanpa terkendala ekonomi hingga wisuda.',
                'manfaat' => "Bebas 100% biaya pendaftaran dan uang pangkal.\nPembebasan seluruh biaya perkuliahan (SPP/UKT) selama 8 semester (S1).\nBantuan biaya hidup bulanan langsung disalurkan ke rekening bank mahasiswa.\nFasilitas bimbingan karir dan akses jejaring alumni nasional.",
                'syarat' => "Siswa SMA/SMK/MA sederajat yang lulus pada tahun berjalan atau maksimal 2 tahun sebelumnya.\nMemiliki Kartu KIP / KKS / Terdaftar di DTKS Kemensos RI.\nFotokopi Ijazah / Surat Keterangan Lulus (SKL) & Nilai Rapor Semester 1 s.d. 5.\nFotokopi Kartu Keluarga (KK), KTP calon mahasiswa, dan bukti rekening listrik/PBB.\nLulus seleksi administrasi dan wawancara internal tim verifikasi UIS.",
                'periode' => 'Mengikuti jadwal resmi SIM KIP-K Kemendikbudristek & PMB UIS',
            ],
            [
                'id' => 'collapseAkademik',
                'judul' => 'Beasiswa Prestasi Akademik (Juara Kelas & Nilai Rapor)',
                'badge' => 'Potongan 50% - 100% SPP',
                'icon' => 'bi-trophy-fill',
                'ringkasan' => 'Penghargaan universitas bagi calon mahasiswa yang berprestasi akademik unggul selama di bangku sekolah.',
                'deskripsi' => 'Universitas Ibnu Sina memberikan potongan biaya kuliah khusus bagi lulusan SMA/SMK/MA sederajat yang berhasil menduduki peringkat terbaik di kelas atau memiliki nilai rapor semester rata-rata di atas standar keunggulan.',
                'manfaat' => "Ranking 1 Sekolah: Bebas 100% SPP semester 1 & 2.\nRanking 2 - 3 Sekolah: Potongan 50% - 75% SPP semester 1.\nRata-rata Nilai Rapor ≥ 85: Potongan biaya kuliah awal s.d. 50%.\nDapat diperpanjang di semester berikutnya dengan menjaga IPK minimal 3.50.",
                'syarat' => "Surat Keterangan Ranking / Peringkat Kelas resmi dari Kepala Sekolah.\nFotokopi rapor semester 1 s.d. 5 yang telah dilegalisir basah sekolah.\nFotokopi Ijazah / SKL dan Kartu Identitas Siswa / KTP.\nPas foto terbaru ukuran 3x4 berwarna.",
                'periode' => 'Buka sepanjang Gelombang 1 & 2 PMB Universitas Ibnu Sina',
            ],
            [
                'id' => 'collapseNonAkademik',
                'judul' => 'Beasiswa Prestasi Non-Akademik (Olahraga, Seni, Budaya & Sains)',
                'badge' => 'Bebas SPP Berjenjang',
                'icon' => 'bi-award-fill',
                'ringkasan' => 'Dukungan penuh bagi atlet, seniman, inovator, dan talenta muda pemenang kejuaraan resmi.',
                'deskripsi' => 'Bagi siswa yang berprestasi dalam bidang keolahragaan (atlet PON, POPDA, Porprov), seni budaya, debat, robotika, karya ilmiah remaja, atau kejuaraan keagamaan, UIS memberikan beasiswa khusus agar potensi bakat terus berkembang di tingkat perguruan tinggi.',
                'manfaat' => "Tingkat Internasional / Nasional (Juara 1-3): Bebas SPP hingga 100%.\nTingkat Provinsi (Juara 1-3): Keringanan SPP 50% s.d. 75%.\nTingkat Kota / Kabupaten: Potongan biaya kuliah semester awal.\nDispensasi izin resmi kampus saat bertanding mewakili daerah atau universitas.",
                'syarat' => "Sertifikat / Piagam Kejuaraan asli dan fotokopi legalisir (maksimal 3 tahun terakhir).\nSurat rekomendasi dari Pengurus Cabang Olahraga / Lembaga Pembina terkait.\nSurat Keterangan Sehat dari fasilitas kesehatan (khusus cabang atletik).",
                'periode' => 'Kuota terbatas setiap semester untuk masing-masing cabang prestasi',
            ],
            [
                'id' => 'collapseTahfidz',
                'judul' => 'Beasiswa Tahfidz Al-Qur\'an (Hafiz & Hafizah)',
                'badge' => 'Bebas SPP s.d. 100% Full',
                'icon' => 'bi-book-half',
                'ringkasan' => 'Program apresiasi bagi penghafal Al-Qur\'an sebagai wujud nilai moralitas dan religiusitas kampus.',
                'deskripsi' => 'Universitas Ibnu Sina memberikan beasiswa istimewa bagi para penghafal Al-Qur\'an (Hafiz dan Hafizah). Kampus menyiapkan lingkungan akademik yang kondusif agar hafalan Al-Qur\'an tetap terjaga seraya menuntut ilmu di bidang sains, kesehatan, dan teknologi.',
                'manfaat' => "Hafal 30 Juz: Bebas 100% SPP & Uang Kuliah hingga lulus (8 Semester).\nHafal 20 Juz: Keringanan SPP 75%.\nHafal 10 Juz: Keringanan SPP 50%.\nHafal 5 Juz: Keringanan SPP 25%.",
                'syarat' => "Ijazah / Syahadah Tahfidz dari Pondok Pesantren / Rumah Tahfidz / Lembaga Resmi.\nMengikuti tes Tasmi' (Uji Hafalan) di hadapan tim penguji Lembaga Keislaman UIS.\nMenjaga muraja'ah hafalan dan berkelakuan baik selama menempuh studi di UIS.",
                'periode' => 'Uji tasmi\' dilaksanakan berkala sesuai jadwal penerimaan mahasiswa baru',
            ],
            [
                'id' => 'collapseIndustri',
                'judul' => 'Beasiswa Kemitraan Industri & CSR Perusahaan Batam',
                'badge' => 'Subsidi Kuliah + Penempatan Karir',
                'icon' => 'bi-buildings-fill',
                'ringkasan' => 'Sinergi antara UIS dengan dunia usaha, manufaktur, dan perbankan di Kawasan Industri Batam.',
                'deskripsi' => 'Sebagai kampus yang berakar di jantung industri Batam dan Kepulauan Riau, UIS menjalin kemitraan dengan puluhan perusahaan terkemuka untuk mendanai perkuliahan mahasiswa bertalenta sekaligus mempersiapkan calon tenaga profesional terampil.',
                'manfaat' => "Bantuan dana perkuliahan dari program CSR perusahaan mitra industri.\nPrioritas magang kerja bersertifikat industri (MBKM Industri Batam).\nPeluang rekrutmen kerja langsung setelah menyelesaikan studi sarjana.\nAkses mentor profesional dari kalangan praktisi industri.",
                'syarat' => "Diutamakan mahasiswa program studi bidang Teknik, Informatika, Sistem Informasi, dan Manajemen.\nLulus seleksi tes bakat skolastik & wawancara komitmen profesional.\nBersedia mengikuti ketentuan ikatan magang pada perusahaan mitra donor.",
                'periode' => 'Informasi mitra industri yang membuka kuota diumumkan setiap awal semester',
            ],
            [
                'id' => 'collapseAfirmasi',
                'judul' => 'Beasiswa Afirmasi Daerah & Rekomendasi Yayasan (YAPISNA)',
                'badge' => 'Dukungan Penuh Yayasan',
                'icon' => 'bi-heart-fill',
                'ringkasan' => 'Pemberdayaan putra-putri daerah 3T kepulauan terluar Kepri serta keluarga besar civitas akademika.',
                'deskripsi' => 'Program sosial Yayasan Pendidikan Ibnu Sina Batam (YAPISNA) untuk mendorong pemerataan pendidikan tinggi di pulau-pulau perbatasan dan daerah penyangga Kepulauan Riau, serta bentuk penghargaan bagi putra-putri tenaga pendidik dan alumni UIS.',
                'manfaat' => "Potongan biaya pengembangan institusi dan subsidi SPP semesteran.\nSkema pembayaran biaya kuliah yang fleksibel dan terjangkau.\nFasilitas asrama mahasiswa kampus bagi perantau pulau terluar (sesuai ketersediaan).",
                'syarat' => "KTP / Surat Keterangan Domisili wilayah kepulauan terluar / 3T Kepulauan Riau.\nSurat rekomendasi dari Kepala Desa / Tokoh Masyarakat / Pengurus Yayasan YAPISNA.\nSurat pernyataan komitmen menyelesaikan studi tepat waktu di UIS.",
                'periode' => 'Pendaftaran diproses melalui Panitia PMB UIS & Pengurus Yayasan',
            ],
        ];
    }

    public static function defaultAlur(): array
    {
        return [
            ['nomor' => 1, 'judul' => 'Registrasi Online PMB', 'deskripsi' => 'Buka portal PMB UIS, buat akun pendaftaran, dan pilih program studi yang diminati.'],
            ['nomor' => 2, 'judul' => 'Pilih Jalur & Upload Berkas', 'deskripsi' => 'Tentukan kategori beasiswa yang Anda inginkan dan unggah seluruh dokumen persyaratan resmi.'],
            ['nomor' => 3, 'judul' => 'Verifikasi & Seleksi', 'deskripsi' => 'Mengikuti proses verifikasi berkas, tes wawancara, atau uji tasmi\' hafalan Al-Qur\'an.'],
            ['nomor' => 4, 'judul' => 'Pengumuman & Kuliah', 'deskripsi' => 'Cek pengumuman kelulusan di portal PMB, lakukan registrasi ulang, dan resmi menjadi mahasiswa UIS!'],
        ];
    }

    public static function defaultFaq(): array
    {
        return [
            [
                'tanya' => 'Apakah pendaftaran beasiswa UIS dipungut biaya tambahan?',
                'jawab' => 'Tidak ada pungutan liar atau biaya seleksi tambahan di luar biaya registrasi resmi PMB UIS. Khusus penerima KIP-Kuliah, pendaftaran bahkan dibebaskan dari biaya seleksi sesuai aturan pemerintah.',
            ],
            [
                'tanya' => 'Bolehkah mendaftar lebih dari satu jalur beasiswa sekaligus?',
                'jawab' => 'Calon mahasiswa disarankan memilih satu jalur beasiswa utama yang paling sesuai dengan kualifikasi terbaik (misalnya KIP-K atau Tahfidz). Namun jika tidak lolos di jalur prioritas, Anda dapat dialihkan ke jalur prestasi akademik atau reguler.',
            ],
            [
                'tanya' => 'Bagaimana cara mempertahankan beasiswa di semester berikutnya?',
                'jawab' => 'Mahasiswa penerima beasiswa wajib mempertahankan prestasi akademik (IPK minimal 3.00 untuk KIP-K, dan 3.50 untuk jalur prestasi), aktif dalam kegiatan kemahasiswaan positif, serta mematuhi tata tertib kampus Universitas Ibnu Sina.',
            ],
        ];
    }

    public static function defaultCta(): array
    {
        return [
            'badge' => 'Jangan Lewatkan Kesempatan Ini',
            'judul' => 'Siap Meraih Beasiswa Impian Anda di Universitas Ibnu Sina?',
            'deskripsi' => 'Kuota terbatas untuk setiap gelombang pendaftaran. Segera persiapkan dokumen Anda dan bergabunglah bersama ribuan mahasiswa berprestasi UIS Batam!',
            'btn_text' => 'Daftar Online PMB',
        ];
    }

    public function getEffectiveStatsAttribute(): array
    {
        return (! empty($this->stats) && is_array($this->stats)) ? $this->stats : self::defaultStats();
    }

    public function getEffectiveKeunggulanAttribute(): array
    {
        return (! empty($this->keunggulan_list) && is_array($this->keunggulan_list)) ? $this->keunggulan_list : self::defaultKeunggulan();
    }

    public function getEffectiveJalurAttribute(): array
    {
        return (! empty($this->jalur_list) && is_array($this->jalur_list)) ? $this->jalur_list : self::defaultJalur();
    }

    public function getEffectiveAlurAttribute(): array
    {
        return (! empty($this->alur_list) && is_array($this->alur_list)) ? $this->alur_list : self::defaultAlur();
    }

    public function getEffectiveFaqAttribute(): array
    {
        return (! empty($this->faq_list) && is_array($this->faq_list)) ? $this->faq_list : self::defaultFaq();
    }

    public function getEffectiveCtaAttribute(): array
    {
        return (! empty($this->cta_data) && is_array($this->cta_data)) ? $this->cta_data : self::defaultCta();
    }
}
