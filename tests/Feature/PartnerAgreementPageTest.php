<?php

namespace Tests\Feature;

use App\Models\Partner;
use App\Models\PartnerAgreement;
use Tests\TestCase;

class PartnerAgreementPageTest extends TestCase
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

    public function test_kerjasama_page_shows_published_agreements_grouped_by_type(): void
    {
        $partner = Partner::create([
            'nama' => 'Mitra Universitas Uji',
            'aktif' => true,
        ]);

        foreach (['MOU', 'MOA', 'IA'] as $type) {
            PartnerAgreement::create([
                'partner_id' => $partner->id,
                'jenis' => $type,
                'judul' => "Dokumen {$type} Uji",
                'aktif' => true,
            ]);
        }

        PartnerAgreement::create([
            'partner_id' => $partner->id,
            'jenis' => 'MOU',
            'judul' => 'Dokumen Draft Uji',
            'aktif' => false,
        ]);

        $this->get(route('homepage.kerjasama'))
            ->assertOk()
            ->assertSee('Mitra Universitas Uji')
            ->assertSee('Dokumen MOU Uji')
            ->assertSee('Dokumen MOA Uji')
            ->assertSee('Dokumen IA Uji')
            ->assertDontSee('Dokumen Draft Uji');
    }
}
