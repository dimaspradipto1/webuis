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
        Schema::table('akademiks', function (Blueprint $table) {
            if (!Schema::hasColumn('akademiks', 'agenda_items')) {
                $table->longText('agenda_items')->nullable()->after('deskripsi');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('akademiks', function (Blueprint $table) {
            if (Schema::hasColumn('akademiks', 'agenda_items')) {
                $table->dropColumn('agenda_items');
            }
        });
    }
};
