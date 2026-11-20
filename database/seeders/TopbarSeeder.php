<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\Topbar;
use Illuminate\Database\Seeder;

class TopbarSeeder extends Seeder
{
    public function run(): void
    {
        Topbar::truncate();

        $contact = Contact::first();

        Topbar::create([
            'badge_text' => 'UNIVERSITAS IBNU SINA',
            'badge_icon' => 'bi-shield-check',
            'alamat' => $contact?->alamat ?? 'Lubuk Baja Kota, Kec. Lubuk Baja, Kota Batam, Kepulauan Riau 29444',
            'jam_operasional' => 'Senin - Sabtu: 08.00 - 17.00 WIB',
            'telepon' => $contact?->no_wa ?? '123456789',
            'email' => $contact?->email ?? 'admin@uis.ac.id',
            'social_media' => [
                [
                    'platform' => 'Instagram',
                    'icon' => 'bi-instagram',
                    'url' => 'https://instagram.com',
                ],
                [
                    'platform' => 'YouTube',
                    'icon' => 'bi-youtube',
                    'url' => 'https://youtube.com',
                ],
            ],
            'instagram_url' => 'https://instagram.com',
            'youtube_url' => 'https://youtube.com',
            'linkedin_url' => null,
            'facebook_url' => 'https://facebook.com',
            'tiktok_url' => null,
            'is_active' => true,
        ]);
    }
}
