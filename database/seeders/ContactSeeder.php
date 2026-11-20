<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Contact::truncate();

        Contact::create([
            'latitude' => '1.144177',
            'longitude' => '104.015112',
            'map' => '<iframe src="https://www.google.com/maps?q=Universitas+Ibnu+Sina+Batam&output=embed" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>',
            'no_wa' => '6281234567890',
            'email' => 'info@uis.ac.id',
            'alamat' => 'Kampus Terpadu Universitas Ibnu Sina, Jl. Teuku Umar, Lubuk Baja, Kota Batam, Kepulauan Riau',
        ]);
    }
}
