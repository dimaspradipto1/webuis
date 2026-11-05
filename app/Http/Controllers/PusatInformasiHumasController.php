<?php

namespace App\Http\Controllers;

use App\Models\PusatInformasiHumas;
use App\Models\PusatInformasiHumasSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PusatInformasiHumasController extends Controller
{
    /**
     * Tampilkan daftar kartu Hubungi Kami & Pusat Informasi.
     */
    public function index(): View
    {
        $cards = PusatInformasiHumas::orderBy('urutan')->get();
        $setting = PusatInformasiHumasSetting::firstOrCreate(
            ['id' => 1],
            ['judul_seksi' => 'Hubungi Kami & Pusat Informasi']
        );

        return view('pages.pusat-informasi.index', compact('cards', 'setting'));
    }

    /**
     * Update judul seksi Hubungi Kami & Pusat Informasi.
     */
    public function updateSetting(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'judul_seksi' => ['required', 'string', 'max:255'],
        ], [
            'judul_seksi.required' => 'Judul seksi wajib diisi.',
        ]);

        $setting = PusatInformasiHumasSetting::firstOrCreate(['id' => 1]);
        $setting->update($validated);

        alert()->success('Berhasil!', 'Judul Seksi berhasil diperbarui.');

        return redirect()->route('pusat-informasi.index');
    }

    /**
     * Tampilkan form tambah kartu baru.
     */
    public function create(): View
    {
        $nextUrutan = (PusatInformasiHumas::max('urutan') ?? 0) + 1;

        return view('pages.pusat-informasi.create', compact('nextUrutan'));
    }

    /**
     * Simpan kartu baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'judul' => ['nullable', 'string', 'max:255'],
            'gambar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:20480'],
            'link_drive' => ['nullable', 'string', 'max:1000'],
            'button_text' => ['required', 'string', 'max:50'],
            'button_url' => ['nullable', 'string', 'max:1000'],
            'target_blank' => ['nullable'],
            'urutan' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable'],
        ], [
            'button_text.required' => 'Teks tombol wajib diisi (contoh: Lihat / Buka / Akses).',
            'gambar.image' => 'File background harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus jpeg, png, jpg, webp, atau svg.',
            'gambar.max' => 'Ukuran file gambar maksimal 20 MB.',
        ]);

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('hubungi-informasi', 'public');
        }

        $buttonUrl = trim($validated['button_url'] ?? '');
        if (! empty($buttonUrl) && ! str_starts_with($buttonUrl, 'http://') && ! str_starts_with($buttonUrl, 'https://') && ! str_starts_with($buttonUrl, '/') && ! str_starts_with($buttonUrl, '#')) {
            $buttonUrl = 'https://'.$buttonUrl;
        }

        PusatInformasiHumas::create([
            'judul' => $validated['judul'] ?? null,
            'gambar' => $gambarPath,
            'link_drive' => $validated['link_drive'] ?? null,
            'button_text' => $validated['button_text'],
            'button_url' => ! empty($buttonUrl) ? $buttonUrl : null,
            'target_blank' => $request->has('target_blank'),
            'urutan' => $validated['urutan'] ?? ((PusatInformasiHumas::max('urutan') ?? 0) + 1),
            'is_active' => $request->has('is_active'),
        ]);

        alert()->success('Berhasil!', 'Kartu Pusat Informasi baru berhasil ditambahkan.');

        return redirect()->route('pusat-informasi.index');
    }

    /**
     * Tampilkan form edit kartu.
     */
    public function edit(PusatInformasiHumas $pusatInformasi): View
    {
        return view('pages.pusat-informasi.edit', compact('pusatInformasi'));
    }

    /**
     * Update kartu yang ada.
     */
    public function update(Request $request, PusatInformasiHumas $pusatInformasi): RedirectResponse
    {
        $validated = $request->validate([
            'judul' => ['nullable', 'string', 'max:255'],
            'gambar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:20480'],
            'link_drive' => ['nullable', 'string', 'max:1000'],
            'button_text' => ['required', 'string', 'max:50'],
            'button_url' => ['nullable', 'string', 'max:1000'],
            'target_blank' => ['nullable'],
            'urutan' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable'],
        ], [
            'button_text.required' => 'Teks tombol wajib diisi (contoh: Lihat / Buka / Akses).',
            'gambar.image' => 'File background harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus jpeg, png, jpg, webp, atau svg.',
            'gambar.max' => 'Ukuran file gambar maksimal 20 MB.',
        ]);

        $buttonUrl = trim($validated['button_url'] ?? '');
        if (! empty($buttonUrl) && ! str_starts_with($buttonUrl, 'http://') && ! str_starts_with($buttonUrl, 'https://') && ! str_starts_with($buttonUrl, '/') && ! str_starts_with($buttonUrl, '#')) {
            $buttonUrl = 'https://'.$buttonUrl;
        }

        $data = [
            'judul' => $validated['judul'] ?? null,
            'link_drive' => $validated['link_drive'] ?? null,
            'button_text' => $validated['button_text'],
            'button_url' => ! empty($buttonUrl) ? $buttonUrl : null,
            'target_blank' => $request->has('target_blank'),
            'urutan' => $validated['urutan'] ?? $pusatInformasi->urutan,
            'is_active' => $request->has('is_active'),
        ];

        if ($request->hasFile('gambar')) {
            if ($pusatInformasi->gambar && Storage::disk('public')->exists($pusatInformasi->gambar)) {
                Storage::disk('public')->delete($pusatInformasi->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('hubungi-informasi', 'public');
        }

        $pusatInformasi->update($data);

        alert()->success('Berhasil!', 'Data Kartu Pusat Informasi berhasil diperbarui.');

        return redirect()->route('pusat-informasi.index');
    }

    /**
     * Hapus kartu.
     */
    public function destroy(PusatInformasiHumas $pusatInformasi): RedirectResponse
    {
        if ($pusatInformasi->gambar && Storage::disk('public')->exists($pusatInformasi->gambar)) {
            Storage::disk('public')->delete($pusatInformasi->gambar);
        }

        $pusatInformasi->delete();

        alert()->success('Berhasil!', 'Kartu Pusat Informasi berhasil dihapus.');

        return redirect()->route('pusat-informasi.index');
    }
}
