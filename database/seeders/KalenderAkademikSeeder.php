<?php

namespace Database\Seeders;

use App\Models\Akademik;
use App\Services\KalenderParserService;
use Illuminate\Database\Seeder;

class KalenderAkademikSeeder extends Seeder
{
    public function run(): void
    {
        $parser = app(KalenderParserService::class);
        $defaultEvents = $parser->getDefaultAcademicEvents();

        $kalender = Akademik::firstOrCreate(['tipe' => 'kalender'], [
            'judul' => 'Kalender Akademik Tahun Akademik 2026/2027',
            'subjudul' => 'Jadwal perkuliahan, registrasi, UTS, UAS, dan kegiatan akademik fakultas.',
            'deskripsi' => '<p>Kalender Akademik memuat seluruh linimasa kegiatan perkuliahan Semester Ganjil dan Genap, termasuk masa registrasi ulang, pengisian KRS, bimbingan akademik, hingga yudisium dan wisuda.</p>',
            'link_url' => '',
            'is_active' => true,
        ]);

        $kalender->agenda_items = $defaultEvents;
        $kalender->is_active = true;
        $kalender->save();
    }
}
