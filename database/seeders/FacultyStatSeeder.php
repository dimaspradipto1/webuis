<?php

namespace Database\Seeders;

use App\Models\FacultyStat;
use Illuminate\Database\Seeder;

class FacultyStatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FacultyStat::truncate();

        FacultyStat::create([
            'title' => 'UIS Dalam Angka',
            'image' => 'faculty-stats/JKgC4vSssWEvmAyPdYIlazkOQ5Wch9xV8RiJxo2K.png',
            'jumlah_prodi' => 5,
            'total_mahasiswa' => 3450,
            'total_dosen' => 80,
            'total_alumni' => 6120,
            'is_active' => true,
        ]);
    }
}
