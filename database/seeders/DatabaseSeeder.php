<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            FaqSeeder::class,
            AboutSeeder::class,
            VisiMisiSeeder::class,
            NilaiPerusahaanSeeder::class,
            MilestoneSeeder::class,
            ContactSeeder::class,
            BannerSeeder::class,
            FeatureSeeder::class,
            SaranaSeeder::class,
            TriDharmaSeeder::class,
            LayananSeeder::class,
            TenagaPendidikSeeder::class,
            GallerySeeder::class,
            FacultyStatSeeder::class,
            StrukturOrganisasiSeeder::class,
            PartnerSeeder::class,
            TestimonialSeeder::class,
            LayananTerkaitSeeder::class,
            BreadcrumbSeeder::class,
        ]);
    }
}
