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
                'kegiatan' => 'Ujian Tengah Semester (UTS) Ganjil',
                'tanggal_mulai' => '2026-10-19',
                'tanggal_selesai' => '2026-10-31',
                'kategori' => 'Ujian',
                'keterangan' => 'Pelaksanaan UTS terjadwal',
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
                'kegiatan' => 'Ujian Tengah Semester (UTS) Genap',
                'tanggal_mulai' => '2027-04-05',
                'tanggal_selesai' => '2027-04-17',
                'kategori' => 'Ujian',
                'keterangan' => 'Ujian terjadwal',
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
