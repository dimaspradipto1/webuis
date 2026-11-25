<?php

namespace App\Http\Controllers;

use App\Models\InformasiPmbHumas;
use App\Models\PmbSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminPmbController extends Controller
{
    /**
     * Dapatkan atau buat model PMB default.
     */
    private function getPmbData(): InformasiPmbHumas
    {
        return InformasiPmbHumas::firstOrCreate(
            ['id' => 1],
            [
                'judul' => 'Informasi Khusus Penerimaan Mahasiswa Baru',
                'subjudul' => 'Tahun Akademik 2026/2027 — Universitas Ibnu Sina',
                'badge_text' => 'PMB TA 2026/2027',
                'deskripsi_singkat' => 'Biro Hubungan Masyarakat dan Protokoler Universitas Ibnu Sina menyajikan informasi resmi dan panduan lengkap Penerimaan Mahasiswa Baru (PMB) untuk jenjang Sarjana (S1) dan Pascasarjana (S2). Unduh buku panduan dan simak brosur infografis pendaftaran di bawah ini.',
                'link_pendaftaran' => 'https://pmb.uis.ac.id',
                'no_wa_pmb' => '082283958644',
                'gelombang_info' => "• Gelombang I : Januari - Maret 2026\n• Gelombang II : April - Juni 2026\n• Gelombang III: Juli - September 2026",
                'persyaratan_info' => "1. Salinan Ijazah/SKL SMA/SMK/MA/Sederajat yang dilegalisir (2 lembar)\n2. Salinan Kartu Keluarga (KK) dan KTP (2 lembar)\n3. Pas foto berwarna ukuran 3x4 (3 lembar)\n4. Mengisi formulir pendaftaran daring di portal resmi PMB UIS",
                'is_active' => true,
            ]
        );
    }

    /**
     * 1. Halaman Informasi PMB (Identitas & Pengumuman)
     */
    public function index(): View
    {
        $pmb = $this->getPmbData();
        return view('pages.pmb.informasi', compact('pmb'));
    }

    public function updateInformasi(Request $request): RedirectResponse
    {
        $pmb = $this->getPmbData();

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'subjudul' => 'nullable|string|max:255',
            'badge_text' => 'nullable|string|max:100',
            'deskripsi_singkat' => 'nullable|string',
            'no_wa_pmb' => 'nullable|string|max:50',
            'gelombang_info' => 'nullable|string',
            'persyaratan_info' => 'nullable|string',
            'beasiswa_info' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $pmb->update([
            'judul' => $validated['judul'],
            'subjudul' => $validated['subjudul'] ?? null,
            'badge_text' => $validated['badge_text'] ?? null,
            'deskripsi_singkat' => $validated['deskripsi_singkat'] ?? null,
            'no_wa_pmb' => $validated['no_wa_pmb'] ?? null,
            'gelombang_info' => $validated['gelombang_info'] ?? $pmb->gelombang_info,
            'persyaratan_info' => $validated['persyaratan_info'] ?? $pmb->persyaratan_info,
            'beasiswa_info' => $validated['beasiswa_info'] ?? null,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->back()->with('success', 'Informasi PMB (termasuk Jadwal Gelombang, Syarat, dan Beasiswa) berhasil diperbarui!');
    }

    /**
     * 2. Halaman Jadwal Gelombang
     */
    public function gelombang(): View
    {
        $pmb = $this->getPmbData();
        return view('pages.pmb.gelombang', compact('pmb'));
    }

    public function updateGelombang(Request $request): RedirectResponse
    {
        $pmb = $this->getPmbData();

        $validated = $request->validate([
            'gelombang_info' => 'required|string',
        ]);

        $pmb->update([
            'gelombang_info' => $validated['gelombang_info'],
        ]);

        return redirect()->back()->with('success', 'Jadwal Gelombang PMB berhasil diperbarui!');
    }

    /**
     * 3. Halaman Syarat Pendaftaran
     */
    public function syarat(): View
    {
        $pmb = $this->getPmbData();
        return view('pages.pmb.syarat', compact('pmb'));
    }

    public function updateSyarat(Request $request): RedirectResponse
    {
        $pmb = $this->getPmbData();

        $validated = $request->validate([
            'persyaratan_info' => 'required|string',
        ]);

        $pmb->update([
            'persyaratan_info' => $validated['persyaratan_info'],
        ]);

        return redirect()->back()->with('success', 'Persyaratan Pendaftaran PMB berhasil diperbarui!');
    }

    /**
     * 5. Halaman Brosur & Poster PMB
     */
    public function brosur(): View
    {
        $pmb = $this->getPmbData();
        return view('pages.pmb.brosur', compact('pmb'));
    }

    public function updateBrosur(Request $request): RedirectResponse
    {
        $pmb = $this->getPmbData();

        $request->validate([
            'gambar_brosur' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'gambar_brosur_2' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
        ]);

        // Upload Brosur 1
        if ($request->hasFile('gambar_brosur')) {
            if ($pmb->gambar_brosur && Storage::disk('public')->exists($pmb->gambar_brosur)) {
                Storage::disk('public')->delete($pmb->gambar_brosur);
            }
            $file = $request->file('gambar_brosur');
            $pmb->gambar_brosur = $file->store('informasi-pmb', 'public');
        } elseif ($request->boolean('hapus_brosur_1') && $pmb->gambar_brosur) {
            if (Storage::disk('public')->exists($pmb->gambar_brosur)) {
                Storage::disk('public')->delete($pmb->gambar_brosur);
            }
            $pmb->gambar_brosur = null;
        }

        // Upload Brosur 2
        if ($request->hasFile('gambar_brosur_2')) {
            if ($pmb->gambar_brosur_2 && Storage::disk('public')->exists($pmb->gambar_brosur_2)) {
                Storage::disk('public')->delete($pmb->gambar_brosur_2);
            }
            $file2 = $request->file('gambar_brosur_2');
            $pmb->gambar_brosur_2 = $file2->store('informasi-pmb', 'public');
        } elseif ($request->boolean('hapus_brosur_2') && $pmb->gambar_brosur_2) {
            if (Storage::disk('public')->exists($pmb->gambar_brosur_2)) {
                Storage::disk('public')->delete($pmb->gambar_brosur_2);
            }
            $pmb->gambar_brosur_2 = null;
        }

        $pmb->save();

        return redirect()->back()->with('success', 'Brosur & Poster PMB berhasil disimpan!');
    }

    /**
     * 6. Halaman Dokumen Panduan PMB (PDF / Link Google Drive)
     */
    public function dokumen(): View
    {
        $pmb = $this->getPmbData();
        return view('pages.pmb.dokumen', compact('pmb'));
    }

    public function updateDokumen(Request $request): RedirectResponse
    {
        $pmb = $this->getPmbData();

        $request->validate([
            'file_pdf_nama' => 'nullable|string|max:255',
            'link_gdrive' => 'nullable|url|max:1000',
            'file_pdf' => 'nullable|file|mimes:pdf|max:51200',
        ], [
            'link_gdrive.url' => 'Format tautan Google Drive harus valid (https://...).',
            'file_pdf.mimes' => 'Format file dokumen harus PDF.',
            'file_pdf.max' => 'Ukuran file PDF maksimal 50 MB.',
        ]);

        $pmb->file_pdf_nama = $request->input('file_pdf_nama') ?: ($pmb->file_pdf_nama ?: 'Buku Panduan PMB.pdf');

        // Jika mengisi link Google Drive
        if ($request->filled('link_gdrive')) {
            $pmb->file_pdf = $request->input('link_gdrive');
        } elseif ($request->hasFile('file_pdf')) {
            if ($pmb->file_pdf && !str_starts_with($pmb->file_pdf, 'http') && Storage::disk('public')->exists($pmb->file_pdf)) {
                Storage::disk('public')->delete($pmb->file_pdf);
            }
            $file = $request->file('file_pdf');
            $pmb->file_pdf = $file->store('informasi-pmb', 'public');
            if (!$request->filled('file_pdf_nama')) {
                $pmb->file_pdf_nama = $file->getClientOriginalName();
            }
        } elseif ($request->boolean('hapus_pdf')) {
            if ($pmb->file_pdf && !str_starts_with($pmb->file_pdf, 'http') && Storage::disk('public')->exists($pmb->file_pdf)) {
                Storage::disk('public')->delete($pmb->file_pdf);
            }
            $pmb->file_pdf = null;
            $pmb->file_pdf_nama = null;
        }

        $pmb->save();

        return redirect()->back()->with('success', 'Dokumen Panduan PMB berhasil diperbarui!');
    }

    /**
     * 7. Halaman Daftar Online (Submit Link PMB Online)
     */
    public function linkDaftar(): View
    {
        $pmb = $this->getPmbData();
        $pmbSetting = PmbSetting::first();
        return view('pages.pmb.link-daftar', compact('pmb', 'pmbSetting'));
    }

    public function updateLinkDaftar(Request $request): RedirectResponse
    {
        $pmb = $this->getPmbData();

        $validated = $request->validate([
            'link_pendaftaran' => 'required|url|max:1000',
        ], [
            'link_pendaftaran.required' => 'Tautan pendaftaran PMB online wajib diisi.',
            'link_pendaftaran.url' => 'Tautan harus diawali dengan http:// atau https:// (format URL valid).',
        ]);

        $link = trim($validated['link_pendaftaran']);

        // Update di InformasiPmbHumas
        $pmb->update([
            'link_pendaftaran' => $link,
        ]);

        // Sinkronisasi juga ke PmbSetting untuk tombol beranda jika ada
        $pmbSetting = PmbSetting::first();
        if ($pmbSetting) {
            $pmbSetting->update([
                'tombol_link_1' => $link,
            ]);
        }

        return redirect()->back()->with('success', 'Tautan Portal Pendaftaran PMB Online berhasil diperbarui dan disinkronkan ke seluruh sistem!');
    }
}
