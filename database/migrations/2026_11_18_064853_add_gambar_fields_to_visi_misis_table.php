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
        Schema::table('visi_misis', function (Blueprint $table) {
            $table->string('gambar')->nullable()->after('id');
            $table->string('judul')->nullable()->after('gambar');
            $table->text('keterangan')->nullable()->after('judul');
            $table->boolean('is_active')->default(true)->after('urutan');
            $table->string('tipe')->nullable()->change();
            $table->text('isi')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('visi_misis', function (Blueprint $table) {
            $table->dropColumn(['gambar', 'judul', 'keterangan', 'is_active']);
            $table->string('tipe')->nullable(false)->change();
            $table->text('isi')->nullable(false)->change();
        });
    }
};
