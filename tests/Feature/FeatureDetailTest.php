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

    public function test_feature_card_opens_its_detail_page(): void
    {
        $feature = Feature::create([
            'icon' => Feature::packIconAndBadge('bi-layers', 'TERAKREDITASI'),
            'judul' => 'Program Studi',
            'deskripsi' => 'Kurikulum berbasis industri',
            'detail' => 'Informasi lengkap program studi.',
            'urutan' => 1,
        ]);
        FacultyStat::create(['is_active' => true]);

        $this->get(route('homepage.feature.detail', $feature))
            ->assertOk()
            ->assertSee('Program Studi')
            ->assertSee('Informasi lengkap program studi.');

        $this->get(route('homepage'))
            ->assertOk()
            ->assertSee(route('homepage.feature.detail', $feature));
    }
}
