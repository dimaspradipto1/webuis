<?php

namespace App\Http\Controllers;

use App\Support\WaAdminConfig;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WaAdminController extends Controller
{
    public function index(): View
    {
        $setting = WaAdminConfig::get();

        return view('pages.wa-admin.index', compact('setting'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'no_wa' => ['required', 'string', 'max:35'],
            'label_tombol' => ['required', 'string', 'max:60'],
            'nama_admin' => ['nullable', 'string', 'max:100'],
            'pesan_default' => ['nullable', 'string', 'max:500'],
            'is_active' => ['nullable'],
        ], [
            'no_wa.required' => 'Nomor WhatsApp Admin wajib diisi.',
            'label_tombol.required' => 'Label tombol chat wajib diisi.',
        ]);

        WaAdminConfig::save([
            'is_active' => $request->boolean('is_active'),
            'no_wa' => $validated['no_wa'],
            'label_tombol' => $validated['label_tombol'],
            'nama_admin' => $validated['nama_admin'] ?? 'Admin Universitas Ibnu Sina',
            'pesan_default' => $validated['pesan_default'] ?? '',
        ]);

        alert()->success('Berhasil!', 'Pengaturan WhatsApp Admin berhasil disimpan.');

        return redirect()->route('wa-admin.index');
    }
}

