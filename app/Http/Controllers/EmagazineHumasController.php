<?php

namespace App\Http\Controllers;

use App\Models\EmagazineHumas;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class EmagazineHumasController extends Controller
{
    /**
     * Tampilkan form pengaturan E-Magazine & Buku Saku Profil Kampus.
     */
    public function index(): View
    {
        $emagazine = EmagazineHumas::firstOrCreate(
            ['id' => 1],
            [
                'judul_seksi' => 'E-Magazine Profil Universitas',
                'is_active' => true,

                'tab_1_label' => 'E-Magazine',
                'tab_1_badge_text' => 'PROFIL 2026',
                'tab_1_judul' => 'E-Magazine Edisi Eksklusif Profil Kampus',
                'tab_1_deskripsi' => 'Jelajahi informasi lengkap mengenai fasilitas laboratorium, profil fakultas, program beasiswa, dan prestasi mahasiswa.',
                'tab_1_btn_preview_text' => 'Pratinjau Interaktif',
                'tab_1_btn_preview_url' => '/frontend/img/gedung-uis.jpg',
                'tab_1_btn_download_text' => 'Unduh Dokumen',
                'tab_1_download_url' => '/tentang',

                'tab_2_label' => 'Buku Saku',
                'tab_2_badge_text' => 'BUKU SAKU',
                'tab_2_judul' => 'Buku Saku Panduan Mahasiswa & Akademik',
                'tab_2_deskripsi' => 'Panduan ringkas dan praktis mengenai kehidupan kampus, tata tertib, hak & kewajiban, serta informasi penting perkuliahan di UIS.',
                'tab_2_btn_preview_text' => 'Pratinjau Interaktif',
                'tab_2_btn_preview_url' => '/frontend/img/gedung-uis.jpg',
                'tab_2_btn_download_text' => 'Unduh Dokumen',
                'tab_2_download_url' => '/tentang',
            ]
        );

        return view('pages.emagazine-humas.index', compact('emagazine'));
    }

    /**
     * Update pengaturan E-Magazine & Buku Saku Profil Kampus.
     */
    public function update(Request $request): RedirectResponse
    {
        $emagazine = EmagazineHumas::firstOrCreate(['id' => 1]);

        $validated = $request->validate([
            'judul_seksi' => ['required', 'string', 'max:255'],
            'is_active' => ['nullable'],

            // Tab 1: E-Magazine
            'tab_1_label' => ['required', 'string', 'max:100'],
            'tab_1_badge_text' => ['nullable', 'string', 'max:50'],
            'tab_1_cover_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:20480'],
            'tab_1_judul' => ['required', 'string', 'max:255'],
            'tab_1_deskripsi' => ['nullable', 'string'],
            'tab_1_btn_preview_text' => ['nullable', 'string', 'max:100'],
            'tab_1_btn_preview_url' => ['nullable', 'string', 'max:1000'],
            'tab_1_btn_download_text' => ['nullable', 'string', 'max:100'],
            'tab_1_file_download' => ['nullable', 'file', 'mimes:pdf,docx,zip', 'max:102400'],
            'tab_1_download_url' => ['nullable', 'string', 'max:1000'],

            // Tab 2: Buku Saku
            'tab_2_label' => ['required', 'string', 'max:100'],
            'tab_2_badge_text' => ['nullable', 'string', 'max:50'],
            'tab_2_cover_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:20480'],
            'tab_2_judul' => ['required', 'string', 'max:255'],
            'tab_2_deskripsi' => ['nullable', 'string'],
            'tab_2_btn_preview_text' => ['nullable', 'string', 'max:100'],
            'tab_2_btn_preview_url' => ['nullable', 'string', 'max:1000'],
            'tab_2_btn_download_text' => ['nullable', 'string', 'max:100'],
            'tab_2_file_download' => ['nullable', 'file', 'mimes:pdf,docx,zip', 'max:102400'],
            'tab_2_download_url' => ['nullable', 'string', 'max:1000'],
        ]);

        $data = [
            'judul_seksi' => $validated['judul_seksi'],
            'is_active' => $request->has('is_active'),

            // Tab 1
            'tab_1_label' => $validated['tab_1_label'],
            'tab_1_badge_text' => $validated['tab_1_badge_text'] ?? 'PROFIL 2026',
            'tab_1_judul' => $validated['tab_1_judul'],
            'tab_1_deskripsi' => $validated['tab_1_deskripsi'] ?? null,
            'tab_1_btn_preview_text' => $validated['tab_1_btn_preview_text'] ?: 'Pratinjau Interaktif',
            'tab_1_btn_preview_url' => $validated['tab_1_btn_preview_url'] ?? null,
            'tab_1_btn_download_text' => $validated['tab_1_btn_download_text'] ?: 'Unduh Dokumen',
            'tab_1_download_url' => $validated['tab_1_download_url'] ?? null,

            // Tab 2
            'tab_2_label' => $validated['tab_2_label'],
            'tab_2_badge_text' => $validated['tab_2_badge_text'] ?? 'BUKU SAKU',
            'tab_2_judul' => $validated['tab_2_judul'],
            'tab_2_deskripsi' => $validated['tab_2_deskripsi'] ?? null,
            'tab_2_btn_preview_text' => $validated['tab_2_btn_preview_text'] ?: 'Pratinjau Interaktif',
            'tab_2_btn_preview_url' => $validated['tab_2_btn_preview_url'] ?? null,
            'tab_2_btn_download_text' => $validated['tab_2_btn_download_text'] ?: 'Unduh Dokumen',
            'tab_2_download_url' => $validated['tab_2_download_url'] ?? null,
        ];

        // Format preview & download URL
        foreach (['tab_1_btn_preview_url', 'tab_1_download_url', 'tab_2_btn_preview_url', 'tab_2_download_url'] as $key) {
            $u = trim($data[$key] ?? '');
            if (! empty($u) && ! str_starts_with($u, 'http://') && ! str_starts_with($u, 'https://') && ! str_starts_with($u, '/') && ! str_starts_with($u, '#')) {
                $data[$key] = 'https://'.$u;
            }
        }

        // Upload Cover Tab 1
        if ($request->hasFile('tab_1_cover_image')) {
            if ($emagazine->tab_1_cover_image && Storage::disk('public')->exists($emagazine->tab_1_cover_image)) {
                Storage::disk('public')->delete($emagazine->tab_1_cover_image);
            }
            $data['tab_1_cover_image'] = $request->file('tab_1_cover_image')->store('emagazine-humas', 'public');
        } elseif ($request->has('hapus_cover_tab_1') && $emagazine->tab_1_cover_image) {
            Storage::disk('public')->delete($emagazine->tab_1_cover_image);
            $data['tab_1_cover_image'] = null;
        }

        // Upload File Download Tab 1
        if ($request->hasFile('tab_1_file_download')) {
            if ($emagazine->tab_1_file_download && Storage::disk('public')->exists($emagazine->tab_1_file_download)) {
                Storage::disk('public')->delete($emagazine->tab_1_file_download);
            }
            $data['tab_1_file_download'] = $request->file('tab_1_file_download')->store('emagazine-humas', 'public');
        } elseif ($request->has('hapus_file_tab_1') && $emagazine->tab_1_file_download) {
            Storage::disk('public')->delete($emagazine->tab_1_file_download);
            $data['tab_1_file_download'] = null;
        }

        // Upload Cover Tab 2
        if ($request->hasFile('tab_2_cover_image')) {
            if ($emagazine->tab_2_cover_image && Storage::disk('public')->exists($emagazine->tab_2_cover_image)) {
                Storage::disk('public')->delete($emagazine->tab_2_cover_image);
            }
            $data['tab_2_cover_image'] = $request->file('tab_2_cover_image')->store('emagazine-humas', 'public');
        } elseif ($request->has('hapus_cover_tab_2') && $emagazine->tab_2_cover_image) {
            Storage::disk('public')->delete($emagazine->tab_2_cover_image);
            $data['tab_2_cover_image'] = null;
        }

        // Upload File Download Tab 2
        if ($request->hasFile('tab_2_file_download')) {
            if ($emagazine->tab_2_file_download && Storage::disk('public')->exists($emagazine->tab_2_file_download)) {
                Storage::disk('public')->delete($emagazine->tab_2_file_download);
            }
            $data['tab_2_file_download'] = $request->file('tab_2_file_download')->store('emagazine-humas', 'public');
        } elseif ($request->has('hapus_file_tab_2') && $emagazine->tab_2_file_download) {
            Storage::disk('public')->delete($emagazine->tab_2_file_download);
            $data['tab_2_file_download'] = null;
        }

        $emagazine->update($data);

        alert()->success('Berhasil!', 'Pengaturan E-Magazine & Buku Saku Profil Kampus berhasil disimpan.');

        return redirect()->route('emagazine-humas.index');
    }
}
