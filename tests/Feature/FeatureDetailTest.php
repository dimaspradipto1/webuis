<?php

namespace Tests\Feature;

use App\Models\FacultyStat;
use App\Models\Feature;
use Tests\TestCase;

class FeatureDetailTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config([
            'database.default' => 'sqlite',
            'database.connections.sqlite.database' => ':memory:',
        ]);
        \DB::purge('sqlite');
        $this->artisan('migrate', ['--database' => 'sqlite']);
    }

    public function test_program_studi_feature_card_opens_program_studi_page(): void
    {
        $feature = Feature::create([
            'icon' => Feature::packIconAndBadge('bi-layers', 'TERAKREDITASI'),
            'judul' => 'Program Studi',
            'deskripsi' => 'Kurikulum berbasis industri',
            'detail' => 'Informasi lengkap program studi.',
            'urutan' => 1,
        ]);
        FacultyStat::create(['is_active' => true]);

        $this->get(route('homepage'))
            ->assertOk()
            ->assertSee(route('homepage.program-studi'));

        $this->assertStringContainsString(route('homepage.program-studi'), $this->get(route('homepage'))->getContent());
        $this->assertStringNotContainsString(route('homepage.feature.detail', $feature), $this->get(route('homepage'))->getContent());
    }

    public function test_other_feature_cards_still_open_their_detail_page(): void
    {
        $feature = Feature::create([
            'icon' => Feature::packIconAndBadge('bi-award', 'BUKA 2025'),
            'judul' => 'Program Beasiswa',
            'deskripsi' => 'Jalur beasiswa prestasi',
            'detail' => 'Detail program beasiswa.',
            'urutan' => 2,
        ]);

        $this->get(route('homepage.feature.detail', $feature))
            ->assertOk()
            ->assertSee('Program Beasiswa')
            ->assertSee('Detail program beasiswa.');
    }
}
