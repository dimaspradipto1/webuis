<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('beasiswa_settings', function (Blueprint $table) {
            $table->string('tombol_daftar_teks')->nullable()->default('Daftar Jalur Beasiswa')->after('link_daftar');
            $table->string('tombol_wa_teks')->nullable()->default('Konsultasi via WhatsApp')->after('tombol_daftar_teks');
            $table->string('link_wa')->nullable()->after('tombol_wa_teks');
            $table->boolean('show_wa')->default(true)->after('link_wa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('beasiswa_settings', function (Blueprint $table) {
            $table->dropColumn(['tombol_daftar_teks', 'tombol_wa_teks', 'link_wa', 'show_wa']);
        });
    }
};
