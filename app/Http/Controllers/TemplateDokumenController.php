<?php

namespace App\Http\Controllers;

use App\Http\Requests\TemplateDokumenRequest;
use App\Http\Requests\TemplateDokumenSettingRequest;
use App\Models\Breadcrumb;
use App\Models\TemplateDokumen;
use App\Models\TemplateDokumenSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class TemplateDokumenController extends Controller
{
    /**
     * Tampilkan daftar template dokumen dan form pengaturan seksi.
     */
    public function index(): View
    {
        $templates = TemplateDokumen::orderBy('urutan')->get();
        $setting = TemplateDokumenSetting::firstOrCreate(
            ['id' => 1],
            [
                'judul_seksi' => 'TEMPLAT DOKUMEN',
                'deskripsi_seksi' => 'Kami menyediakan Templat untuk Desain, Ms. Power Point, Ms. Word dan berbagai format lainnya. Guna menyeragamkan tampilan desain di lingkungan universitas.',
            ]
        );

        $breadcrumb = Breadcrumb::getForPage('template-dokumen');

        return view('pages.template-dokumen.index', compact('templates', 'setting', 'breadcrumb'));
    }

    /**
     * Update judul dan deskripsi seksi template dokumen.
     */
    public function updateSetting(TemplateDokumenSettingRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $setting = TemplateDokumenSetting::firstOrCreate(['id' => 1]);
        $setting->update($validated);

        alert()->success('Berhasil!', 'Pengaturan Teks Seksi Template Dokumen berhasil diperbarui.');

        return redirect()->route('template-dokumen.index');
    }

    /**
     * Tampilkan form tambah template baru.
     */
    public function create(): View
    {
        $nextUrutan = (TemplateDokumen::max('urutan') ?? 0) + 1;

        return view('pages.template-dokumen.create', compact('nextUrutan'));
    }

    /**
     * Simpan template dokumen baru.
     */
    public function store(TemplateDokumenRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $customIconPath = null;
        if ($request->hasFile('custom_icon')) {
            $customIconPath = $request->file('custom_icon')->store('template-dokumen', 'public');
        }

        $linkDrive = trim($validated['link_drive']);
        if (! str_starts_with($linkDrive, 'http://') && ! str_starts_with($linkDrive, 'https://')) {
            $linkDrive = 'https://'.$linkDrive;
        }

        TemplateDokumen::create([
            'judul' => $validated['judul'],
            'tipe_file' => $validated['tipe_file'] ?? null,
            'link_drive' => $linkDrive,
            'icon_preset' => $validated['icon_preset'],
            'custom_icon' => $customIconPath,
            'urutan' => $validated['urutan'] ?? ((TemplateDokumen::max('urutan') ?? 0) + 1),
            'is_active' => $request->has('is_active'),
        ]);

        alert()->success('Berhasil!', 'Template dokumen baru berhasil ditambahkan.');

        return redirect()->route('template-dokumen.index');
    }

    /**
     * Tampilkan form edit template dokumen.
     */
    public function edit(TemplateDokumen $templateDokumen): View
    {
        return view('pages.template-dokumen.edit', compact('templateDokumen'));
    }

    /**
     * Perbarui data template dokumen.
     */
    public function update(TemplateDokumenRequest $request, TemplateDokumen $templateDokumen): RedirectResponse
    {
        $validated = $request->validated();

        $linkDrive = trim($validated['link_drive']);
        if (! str_starts_with($linkDrive, 'http://') && ! str_starts_with($linkDrive, 'https://')) {
            $linkDrive = 'https://'.$linkDrive;
        }

        $data = [
            'judul' => $validated['judul'],
            'tipe_file' => $validated['tipe_file'] ?? null,
            'link_drive' => $linkDrive,
            'icon_preset' => $validated['icon_preset'],
            'urutan' => $validated['urutan'] ?? $templateDokumen->urutan,
            'is_active' => $request->has('is_active'),
        ];

        if ($request->hasFile('custom_icon')) {
            if ($templateDokumen->custom_icon && Storage::disk('public')->exists($templateDokumen->custom_icon)) {
                Storage::disk('public')->delete($templateDokumen->custom_icon);
            }
            $data['custom_icon'] = $request->file('custom_icon')->store('template-dokumen', 'public');
        }

        $templateDokumen->update($data);

        alert()->success('Berhasil!', 'Data template dokumen berhasil diperbarui.');

        return redirect()->route('template-dokumen.index');
    }

    /**
     * Hapus template dokumen.
     */
    public function destroy(TemplateDokumen $templateDokumen): RedirectResponse
    {
        if ($templateDokumen->custom_icon && Storage::disk('public')->exists($templateDokumen->custom_icon)) {
            Storage::disk('public')->delete($templateDokumen->custom_icon);
        }

        $templateDokumen->delete();

        alert()->success('Berhasil!', 'Template dokumen berhasil dihapus.');

        return redirect()->route('template-dokumen.index');
    }
}
