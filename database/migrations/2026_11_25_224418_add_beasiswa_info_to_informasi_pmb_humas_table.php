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
        Schema::table('informasi_pmb_humas', function (Blueprint $table) {
            if (!Schema::hasColumn('informasi_pmb_humas', 'beasiswa_info')) {
                $table->text('beasiswa_info')->nullable()->after('persyaratan_info');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('informasi_pmb_humas', function (Blueprint $table) {
            if (Schema::hasColumn('informasi_pmb_humas', 'beasiswa_info')) {
                $table->dropColumn('beasiswa_info');
            }
        });
    }
};
