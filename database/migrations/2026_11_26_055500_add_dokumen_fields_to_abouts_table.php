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
            if (! Schema::hasColumn('abouts', 'dokumen_file')) {
                $table->string('dokumen_file')->nullable()->after('video_file');
            }
            if (! Schema::hasColumn('abouts', 'dokumen_nama')) {
                $table->string('dokumen_nama')->nullable()->after('dokumen_file');
            }
            if (! Schema::hasColumn('abouts', 'dokumen_link')) {
                $table->string('dokumen_link', 1000)->nullable()->after('dokumen_nama');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('abouts', function (Blueprint $table) {
            $columnsToDrop = [];
            if (Schema::hasColumn('abouts', 'dokumen_file')) {
                $columnsToDrop[] = 'dokumen_file';
            }
            if (Schema::hasColumn('abouts', 'dokumen_nama')) {
                $columnsToDrop[] = 'dokumen_nama';
            }
            if (Schema::hasColumn('abouts', 'dokumen_link')) {
                $columnsToDrop[] = 'dokumen_link';
            }
            if (! empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }
};
