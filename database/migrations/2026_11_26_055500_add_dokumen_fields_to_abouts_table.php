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
            $table->string('dokumen_file')->nullable()->after('video_file');
            $table->string('dokumen_nama')->nullable()->after('dokumen_file');
            $table->string('dokumen_link', 1000)->nullable()->after('dokumen_nama');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('abouts', function (Blueprint $table) {
            $table->dropColumn(['dokumen_file', 'dokumen_nama', 'dokumen_link']);
        });
    }
};
