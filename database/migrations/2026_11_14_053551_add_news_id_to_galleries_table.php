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
        Schema::table('galleries', function (Blueprint $table) {
            if (! Schema::hasColumn('galleries', 'news_id')) {
                $table->foreignId('news_id')->nullable()->after('id')->constrained('news')->nullOnDelete();
            }
            if (! Schema::hasColumn('galleries', 'kategori_berita')) {
                $table->string('kategori_berita')->nullable()->after('kategori');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            if (Schema::hasColumn('galleries', 'news_id')) {
                $table->dropForeign(['news_id']);
                $table->dropColumn('news_id');
            }
            if (Schema::hasColumn('galleries', 'kategori_berita')) {
                $table->dropColumn('kategori_berita');
            }
        });
    }
};
