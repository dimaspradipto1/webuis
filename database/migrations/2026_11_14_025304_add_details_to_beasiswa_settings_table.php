<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('beasiswa_settings', function (Blueprint $table) {
            $table->json('stats')->nullable();
            $table->json('keunggulan_list')->nullable();
            $table->json('jalur_list')->nullable();
            $table->json('alur_list')->nullable();
            $table->json('faq_list')->nullable();
            $table->json('cta_data')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('beasiswa_settings', function (Blueprint $table) {
            $table->dropColumn(['stats', 'keunggulan_list', 'jalur_list', 'alur_list', 'faq_list', 'cta_data']);
        });
    }
};
