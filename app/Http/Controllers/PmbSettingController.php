<?php

namespace App\Http\Controllers;

use App\Http\Requests\PmbSettingRequest;
use App\Models\PmbSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PmbSettingController extends Controller
{
    /**
     * Tampilkan formulir pengaturan Banner PMB.
     */
    public function index(): View
    {
        $pmb = PmbSetting::firstOrCreate([], [
            'badge_text' => 'PENERIMAAN MAHASISWA BARU (PMB) T.A. 2026/2027',
            'judul' => 'Daftar Sekarang & Raih Masa Depan Cerah Bersama Universitas Ibnu Sina (UIS)!',
            'deskripsi' => 'Tersedia berbagai jalur seleksi: Jalur Bebas Tes / Prestasi, Jalur Reguler, Jalur KIP-Kuliah, dan Jalur Alih Jenjang Karyawan.',
            'tombol_text_1' => 'Daftar PMB Sekarang',
            'tombol_link_1' => '/kontak',
            'tombol_text_2' => 'Konsultasi WhatsApp PMB',
            'tombol_link_2' => '',
            'gelombang_1' => 'Gelombang 1: Jan - Apr',
            'gelombang_2' => 'Gelombang 2: Mei - Jul',
            'gelombang_3' => 'Gelombang 3: Agu - Sep',
            'is_active' => true,
        ]);

        return view('pages.pmb-setting.index', compact('pmb'));
    }

    /**
     * Update data banner PMB.
     */
    public function update(PmbSettingRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $rawGelombang = $request->input('gelombang_list', []);
        $cleanGelombang = is_array($rawGelombang)
            ? array_values(array_filter($rawGelombang, fn ($item) => ! empty(trim($item ?? ''))))
            : [];

        $validated['gelombang_list'] = $cleanGelombang;
        $validated['gelombang_1'] = $cleanGelombang[0] ?? null;
        $validated['gelombang_2'] = $cleanGelombang[1] ?? null;
        $validated['gelombang_3'] = $cleanGelombang[2] ?? null;
        $validated['is_active'] = $request->has('is_active');

        $pmb = PmbSetting::first();
        if (! $pmb) {
            $pmb = PmbSetting::create($validated);
        } else {
            $pmb->update($validated);
        }

        return redirect()
            ->route('pmb-setting.index')
            ->with('success', 'Pengaturan Banner PMB & Jadwal Gelombang berhasil diperbarui!');
    }
}
