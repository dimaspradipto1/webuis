<?php

namespace App\Support;

use App\Models\Contact;
use Illuminate\Support\Facades\Storage;

class WaAdminConfig
{
    private const FILE_PATH = 'settings/wa_admin.json';

    public static function get(): object
    {
        $contact = Contact::latest('id')->first();
        $defaultPhone = $contact?->no_wa ?: '6281270008899';

        $defaults = [
            'is_active' => true,
            'no_wa' => $defaultPhone,
            'label_tombol' => 'Chat WA Admin',
            'nama_admin' => 'Admin Universitas Ibnu Sina',
            'pesan_default' => 'Halo Admin Universitas Ibnu Sina, saya ingin bertanya mengenai informasi akademik dan pendaftaran mahasiswa baru.',
        ];

        try {
            if (Storage::disk('public')->exists(self::FILE_PATH)) {
                $raw = Storage::disk('public')->get(self::FILE_PATH);
                $decoded = json_decode($raw, true);
                if (is_array($decoded)) {
                    $defaults = array_merge($defaults, $decoded);
                }
            }
        } catch (\Throwable $e) {
            // Fallback to defaults
        }

        if (empty($defaults['no_wa']) && ! empty($contact?->no_wa)) {
            $defaults['no_wa'] = $contact->no_wa;
        }

        $cleanPhone = preg_replace('/[^0-9]/', '', (string) $defaults['no_wa']);
        if (str_starts_with($cleanPhone, '08')) {
            $cleanPhone = '628' . substr($cleanPhone, 2);
        } elseif (str_starts_with($cleanPhone, '8')) {
            $cleanPhone = '628' . substr($cleanPhone, 1);
        }

        $defaults['clean_wa'] = $cleanPhone;
        $defaults['wa_url'] = ! empty($cleanPhone)
            ? 'https://wa.me/' . $cleanPhone . '?text=' . rawurlencode((string) $defaults['pesan_default'])
            : '#';

        return (object) $defaults;
    }

    public static function save(array $data): object
    {
        $payload = [
            'is_active' => ! empty($data['is_active']),
            'no_wa' => trim((string) ($data['no_wa'] ?? '')),
            'label_tombol' => trim((string) ($data['label_tombol'] ?? 'Chat WA Admin')) ?: 'Chat WA Admin',
            'nama_admin' => trim((string) ($data['nama_admin'] ?? 'Admin Universitas Ibnu Sina')) ?: 'Admin Universitas Ibnu Sina',
            'pesan_default' => trim((string) ($data['pesan_default'] ?? '')),
            'updated_at' => now()->toIso8601String(),
        ];

        Storage::disk('public')->put(
            self::FILE_PATH,
            json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );

        // Sync phone number with Contact table so Contact & WA Admin remain consistent
        if (! empty($payload['no_wa'])) {
            $contact = Contact::latest('id')->first();
            if ($contact) {
                $contact->update(['no_wa' => $payload['no_wa']]);
            }
        }

        return self::get();
    }
}

