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
        Schema::create('breadcrumbs', function (Blueprint $table) {
            $table->id();
            $table->string('page_key')->unique();
            $table->string('menu_name');
            $table->string('kategori_menu')->default('Lainnya');
            $table->string('badge_text')->nullable();
            $table->string('judul');
            $table->text('subjudul')->nullable();
            $table->string('breadcrumb_item_1')->default('Beranda');
            $table->string('breadcrumb_url_1')->nullable();
            $table->string('breadcrumb_item_2')->nullable();
            $table->string('breadcrumb_url_2')->nullable();
            $table->string('breadcrumb_active');
            $table->string('background_image')->nullable();
            $table->integer('urutan')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('breadcrumbs');
    }
};
