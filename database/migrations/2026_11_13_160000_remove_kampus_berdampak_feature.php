<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('features')->where('judul', 'Kampus Berdampak')->delete();
    }

    public function down(): void
    {
        DB::table('features')->insert([
            'icon' => 'bi-house-door|AKTIF 2024',
            'judul' => 'Kampus Berdampak',
            'deskripsi' => 'Mendorong inovasi dan kontribusi nyata bagi masyarakat',
            'urutan' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
};
