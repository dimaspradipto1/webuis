<?php

namespace Database\Seeders;

use App\Models\Partner;
use App\Models\PartnerAgreement;
use Illuminate\Database\Seeder;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PartnerAgreement::query()->delete();
        Partner::query()->delete();

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
