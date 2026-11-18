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
            $table->string('visimisi_label')->nullable()->after('visi_icon');
            $table->string('visimisi_judul')->nullable()->after('visimisi_label');
            $table->text('visimisi_deskripsi')->nullable()->after('visimisi_judul');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('abouts', function (Blueprint $table) {
            $table->dropColumn(['visimisi_label', 'visimisi_judul', 'visimisi_deskripsi']);
        });
    }
};
