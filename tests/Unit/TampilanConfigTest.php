<?php

namespace Tests\Unit;

use App\Support\TampilanConfig;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class TampilanConfigTest extends TestCase
{
    public function test_language_button_settings_have_brand_aligned_defaults_and_persist(): void
    {
        Storage::fake('public');

        $defaults = TampilanConfig::defaults()['header'];

        $this->assertTrue($defaults['lang_visible']);
        $this->assertSame('#2e743b', $defaults['lang_bg']);
        $this->assertSame('#ffffff', $defaults['lang_text']);
        $this->assertSame('#d6bd36', $defaults['lang_border']);

        Storage::disk('public')->put('settings/tampilan.json', json_encode([
            'header' => ['judul' => 'Konfigurasi Lama'],
        ]));
        $legacy = TampilanConfig::all()['header'];

        $this->assertTrue($legacy['lang_visible']);
        $this->assertSame('#2e743b', $legacy['lang_bg']);

        TampilanConfig::save('header', [
            'lang_visible' => false,
            'lang_bg' => '#174b2b',
            'lang_text' => '#ffffff',
            'lang_border' => '#e7c65a',
        ]);

        $saved = TampilanConfig::all()['header'];

        $this->assertFalse($saved['lang_visible']);
        $this->assertSame('#174b2b', $saved['lang_bg']);
        $this->assertSame('#ffffff', $saved['lang_text']);
        $this->assertSame('#e7c65a', $saved['lang_border']);

        TampilanConfig::reset('header');
    }

    public function test_each_color_preset_includes_language_button_colors(): void
    {
        foreach (TampilanConfig::presets() as $preset) {
            $this->assertArrayHasKey('lang_visible', $preset['header']);
            $this->assertArrayHasKey('lang_bg', $preset['header']);
            $this->assertArrayHasKey('lang_text', $preset['header']);
            $this->assertArrayHasKey('lang_border', $preset['header']);
        }
    }
}
