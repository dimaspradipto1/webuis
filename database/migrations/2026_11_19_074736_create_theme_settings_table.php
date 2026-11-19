<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('theme_settings', function (Blueprint $table) {
            $table->id();

            // 1. Global / Brand & Frontend Header Colors
            $table->string('primary_color', 20)->default('#046B26');
            $table->string('primary_dark_color', 20)->default('#03521d');
            $table->string('secondary_color', 20)->default('#FED802');
            $table->string('secondary_dark_color', 20)->default('#e5c302');

            $table->string('header_bg_color', 20)->default('#046B26');
            $table->string('header_text_color', 20)->default('#ffffff');
            $table->string('header_active_bg_color', 20)->default('#FED802');
            $table->string('header_active_text_color', 20)->default('#046B26');
            $table->string('header_pmb_bg_color', 20)->default('#FED802');
            $table->string('header_pmb_text_color', 20)->default('#046B26');
            $table->string('header_login_bg_color', 20)->default('#ffffff');
            $table->string('header_login_text_color', 20)->default('#046B26');
            $table->string('header_lang_bg_color', 20)->default('#03521d');
            $table->string('header_lang_text_color', 20)->default('#ffffff');
            $table->string('header_border_color', 20)->default('#FED802');
            $table->unsignedSmallInteger('header_height')->default(90);
            $table->boolean('header_is_sticky')->default(true);

            // Subpage Hero Banner Colors
            $table->string('hero_bg_color', 20)->default('#046B26');
            $table->string('hero_border_color', 20)->default('#FED802');

            // 2. Frontend Footer Colors
            $table->string('footer_bg_color', 20)->default('#03521d');
            $table->string('footer_text_color', 20)->default('#ffffff');
            $table->string('footer_heading_color', 20)->default('#FED802');
            $table->string('footer_border_top_color', 20)->default('#FED802');
            $table->string('footer_link_color', 20)->default('#ffffff');
            $table->string('footer_link_hover_color', 20)->default('#FED802');
            $table->string('footer_social_bg_color', 20)->default('#FED802');
            $table->string('footer_social_text_color', 20)->default('#046B26');

            // 3. Admin / Dashboard Colors
            $table->string('admin_primary_color', 20)->default('#046B26');
            $table->string('admin_accent_color', 20)->default('#FED802');
            $table->string('admin_header_bg_color', 20)->default('#046B26');
            $table->string('admin_header_text_color', 20)->default('#ffffff');
            $table->string('admin_header_brand_color', 20)->default('#FED802');
            $table->string('admin_header_border_color', 20)->default('#FED802');
            $table->unsignedSmallInteger('admin_header_height')->default(78);
            $table->string('admin_sidebar_bg_color', 20)->default('#ffffff');
            $table->string('admin_sidebar_text_color', 20)->default('#046B26');
            $table->string('admin_sidebar_active_bg_color', 20)->default('#eaf6ee');
            $table->string('admin_sidebar_active_text_color', 20)->default('#046B26');
            $table->string('admin_sidebar_hover_bg_color', 20)->default('#f8fcf9');
            $table->string('admin_sidebar_hover_text_color', 20)->default('#FED802');

            // 4. Section Order / Layout Beranda
            $table->json('sections_order')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('theme_settings');
    }
};
