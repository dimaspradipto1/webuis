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
        Schema::table('abouts', function (Blueprint $table) {
            $table->string('visimisi_background')->nullable()->after('visimisi_deskripsi');
            $table->text('visimisi_tagline_visi')->nullable()->after('visimisi_background');
            $table->text('visimisi_misi_items')->nullable()->after('visimisi_tagline_visi');
            $table->string('visimisi_tatanilai_judul')->nullable()->after('visimisi_misi_items');
            $table->text('visimisi_tatanilai_items')->nullable()->after('visimisi_tatanilai_judul');
            $table->string('visimisi_badge_humas')->nullable()->after('visimisi_tatanilai_items');
            $table->string('visimisi_footer_fb')->nullable()->after('visimisi_badge_humas');
            $table->string('visimisi_footer_ig')->nullable()->after('visimisi_footer_fb');
            $table->string('visimisi_footer_url')->nullable()->after('visimisi_footer_ig');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('abouts', function (Blueprint $table) {
            $table->dropColumn([
                'visimisi_background',
                'visimisi_tagline_visi',
                'visimisi_misi_items',
                'visimisi_tatanilai_judul',
                'visimisi_tatanilai_items',
                'visimisi_badge_humas',
                'visimisi_footer_fb',
                'visimisi_footer_ig',
                'visimisi_footer_url',
            ]);
        });
    }
};
