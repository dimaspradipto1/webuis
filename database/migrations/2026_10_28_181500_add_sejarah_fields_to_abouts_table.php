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
            $table->string('sejarah_label')->nullable();
            $table->string('sejarah_judul')->nullable();
            $table->string('sejarah_judul_highlight')->nullable();
            $table->text('sejarah_deskripsi_1')->nullable();
            $table->text('sejarah_deskripsi_2')->nullable();
            $table->string('sejarah_card_judul')->nullable();
            $table->string('sejarah_card_subjudul')->nullable();
            $table->text('sejarah_card_narasi')->nullable();
            $table->string('sejarah_pilar_1')->nullable();
            $table->string('sejarah_pilar_2')->nullable();
            $table->string('sejarah_pilar_3')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('abouts', function (Blueprint $table) {
            $table->dropColumn([
                'sejarah_label',
                'sejarah_judul',
                'sejarah_judul_highlight',
                'sejarah_deskripsi_1',
                'sejarah_deskripsi_2',
                'sejarah_card_judul',
                'sejarah_card_subjudul',
                'sejarah_card_narasi',
                'sejarah_pilar_1',
                'sejarah_pilar_2',
                'sejarah_pilar_3',
            ]);
        });
    }
};

