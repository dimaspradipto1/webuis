<?php

namespace Database\Seeders;

use App\Models\Partner;
use Illuminate\Database\Seeder;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Partner::truncate();

        for ($index = 1; $index <= 10; $index++) {
            Partner::create([
                'nama' => '#',
                'logo' => null,
                'urutan' => $index,
                'aktif' => true,
            ]);
        }
    }
}
