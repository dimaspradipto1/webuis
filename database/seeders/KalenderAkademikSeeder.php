<?php

namespace Database\Seeders;

use App\Models\Akademik;
use Illuminate\Database\Seeder;

class KalenderAkademikSeeder extends Seeder
{
    public function run(): void
    {
        $kalender = Akademik::firstOrCreate(['tipe' => 'kalender'], [
            'judul' => 'Kalender Akademik Tahun Akademik 2026/2027',
            'subjudul' => 'Jadwal perkuliahan, registrasi, UTS, UAS, dan kegiatan akademik fakultas.',
            'deskripsi' => '<p>Kalender Akademik memuat seluruh linimasa kegiatan perkuliahan Semester Ganjil dan Genap, termasuk masa registrasi ulang, pengisian KRS, bimbingan akademik, hingga yudisium dan wisuda.</p>',
            'link_url' => '',
            'is_active' => true,
        ]);

        $kalender->agenda_items = [
            // --- SEMESTER GANJIL 2026/2027 ---
            [
                'semester' => 'Ganjil',
                'kegiatan' => 'Pembayaran Biaya Kuliah & Registrasi Ulang Mahasiswa',
                'tanggal_mulai' => '2026-08-03',
                'tanggal_selesai' => '2026-08-22',
                'kategori' => 'Registrasi',
                'keterangan' => 'Melalui Bank Mitra / Virtual Account SIAKAD',
            ],
            [
                'semester' => 'Ganjil',
                'kegiatan' => 'Konsultasi Dosen PA & Pengisian Kartu Rencana Studi (KRS)',
                'tanggal_mulai' => '2026-08-10',
                'tanggal_selesai' => '2026-08-28',
                'kategori' => 'Akademik',
                'keterangan' => 'Pengisian daring via Portal SIAKAD',
            ],
            [
                'semester' => 'Ganjil',
                'kegiatan' => 'Pengenalan Kehidupan Kampus Mahasiswa Baru (PKKMB)',
                'tanggal_mulai' => '2026-08-24',
                'tanggal_selesai' => '2026-08-28',
                'kategori' => 'Kemahasiswaan',
                'keterangan' => 'Diikuti seluruh mahasiswa baru UIS',
            ],
            [
                'semester' => 'Ganjil',
                'kegiatan' => 'Awal Perkuliahan & Praktikum Semester Ganjil TA 2026/2027',
                'tanggal_mulai' => '2026-09-01',
                'tanggal_selesai' => '2026-09-01',
                'kategori' => 'Perkuliahan',
                'keterangan' => 'Minggu ke-1 perkuliahan aktif',
            ],
            [
                'semester' => 'Ganjil',
                'kegiatan' => 'Masa Revisi / Perubahan Kartu Rencana Studi (KRS)',
                'tanggal_mulai' => '2026-09-07',
                'tanggal_selesai' => '2026-09-12',
                'kategori' => 'Akademik',
                'keterangan' => 'Batas akhir pembatalan dan tambah mata kuliah',
            ],
            [
                'semester' => 'Ganjil',
                'kegiatan' => 'Ujian Tengah Semester (UTS) Ganjil',
                'tanggal_mulai' => '2026-10-19',
                'tanggal_selesai' => '2026-10-31',
                'kategori' => 'Ujian',
                'keterangan' => 'Pelaksanaan UTS terjadwal',
            ],
            [
                'semester' => 'Ganjil',
                'kegiatan' => 'Perkuliahan Efektif Tengah Semester & Bimbingan Skripsi/Tesis',
                'tanggal_mulai' => '2026-11-02',
                'tanggal_selesai' => '2026-11-21',
                'kategori' => 'Perkuliahan',
                'keterangan' => 'Perkuliahan sesi paruh kedua semester ganjil',
            ],
            [
                'semester' => 'Ganjil',
                'kegiatan' => 'Batas Penginputan Nilai UTS ke SIAKAD & Verifikasi Dosen',
                'tanggal_mulai' => '2026-11-23',
                'tanggal_selesai' => '2026-11-28',
                'kategori' => 'Akademik',
                'keterangan' => 'Penginputan nilai UTS oleh dosen pengampu',
            ],
            [
                'semester' => 'Ganjil',
                'kegiatan' => 'Batas Akhir Perkuliahan Tatap Muka Semester Ganjil',
                'tanggal_mulai' => '2026-12-12',
                'tanggal_selesai' => '2026-12-12',
                'kategori' => 'Perkuliahan',
                'keterangan' => 'Evaluasi presensi mahasiswa minimal 75%',
            ],
            [
                'semester' => 'Ganjil',
                'kegiatan' => 'Ujian Akhir Semester (UAS) Ganjil',
                'tanggal_mulai' => '2026-12-14',
                'tanggal_selesai' => '2026-12-26',
                'kategori' => 'Ujian',
                'keterangan' => 'Pelaksanaan UAS terpadu',
            ],
            [
                'semester' => 'Ganjil',
                'kegiatan' => 'Libur Semester Ganjil & Penginputan KHS Dosen',
                'tanggal_mulai' => '2026-12-28',
                'tanggal_selesai' => '2027-01-09',
                'kategori' => 'Libur',
                'keterangan' => 'Batas penginputan nilai ke PD-DIKTI',
            ],
            [
                'semester' => 'Ganjil',
                'kegiatan' => 'Yudisium Kelulusan Periode Ganjil',
                'tanggal_mulai' => '2027-01-16',
                'tanggal_selesai' => '2027-01-16',
                'kategori' => 'Wisuda',
                'keterangan' => 'Sidang Yudisium Fakultas',
            ],

            // --- SEMESTER GENAP 2026/2027 ---
            [
                'semester' => 'Genap',
                'kegiatan' => 'Pembayaran Biaya Kuliah & Registrasi Ulang Semester Genap',
                'tanggal_mulai' => '2027-01-11',
                'tanggal_selesai' => '2027-01-23',
                'kategori' => 'Registrasi',
                'keterangan' => 'Registrasi mahasiswa aktif',
            ],
            [
                'semester' => 'Genap',
                'kegiatan' => 'Konsultasi PA & Pengisian KRS Semester Genap',
                'tanggal_mulai' => '2027-01-18',
                'tanggal_selesai' => '2027-01-30',
                'kategori' => 'Akademik',
                'keterangan' => 'SIAKAD Online',
            ],
            [
                'semester' => 'Genap',
                'kegiatan' => 'Awal Perkuliahan Semester Genap TA 2026/2027',
                'tanggal_mulai' => '2027-02-08',
                'tanggal_selesai' => '2027-02-08',
                'kategori' => 'Perkuliahan',
                'keterangan' => 'Awal perkuliahan genap aktif',
            ],
            [
                'semester' => 'Genap',
                'kegiatan' => 'Masa Revisi / Batal Tambah Mata Kuliah Semester Genap',
                'tanggal_mulai' => '2027-02-15',
                'tanggal_selesai' => '2027-02-20',
                'kategori' => 'Akademik',
                'keterangan' => 'Penyesuaian KRS semester genap',
            ],
            [
                'semester' => 'Genap',
                'kegiatan' => 'Ujian Tengah Semester (UTS) Genap',
                'tanggal_mulai' => '2027-04-05',
                'tanggal_selesai' => '2027-04-17',
                'kategori' => 'Ujian',
                'keterangan' => 'Ujian terjadwal',
            ],
            [
                'semester' => 'Genap',
                'kegiatan' => 'Batas Akhir Perkuliahan Semester Genap',
                'tanggal_mulai' => '2027-05-29',
                'tanggal_selesai' => '2027-05-29',
                'kategori' => 'Perkuliahan',
                'keterangan' => 'Penutupan perkuliahan genap',
            ],
            [
                'semester' => 'Genap',
                'kegiatan' => 'Ujian Akhir Semester (UAS) Genap',
                'tanggal_mulai' => '2027-05-31',
                'tanggal_selesai' => '2027-06-12',
                'kategori' => 'Ujian',
                'keterangan' => 'Ujian Akhir Genap',
            ],
            [
                'semester' => 'Genap',
                'kegiatan' => 'Libur Semester Genap & Program KKN / Magang Industri',
                'tanggal_mulai' => '2027-06-14',
                'tanggal_selesai' => '2027-07-31',
                'kategori' => 'Libur',
                'keterangan' => 'Pelaksanaan KKN dan MBKM',
            ],
            [
                'semester' => 'Genap',
                'kegiatan' => 'Wisuda & Yudisium Sarjana & Pascasarjana',
                'tanggal_mulai' => '2027-08-21',
                'tanggal_selesai' => '2027-08-21',
                'kategori' => 'Wisuda',
                'keterangan' => 'Sidang Senat Terbuka Wisuda UIS',
            ],
        ];

        $kalender->save();
    }
}
