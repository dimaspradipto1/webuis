<?php

namespace App\Http\Controllers;

use App\Models\InformasiPmbHumas;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class InformasiPmbHumasController extends Controller
{
    /**
     * Tampilkan form pengaturan halaman Informasi Khusus PMB Humas di Admin.
     */
    public function index(): View
    {
        $pmb = InformasiPmbHumas::firstOrCreate(
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

        return view('pages.informasi-pmb-humas.index', compact('pmb'));
    }

    /**
     * Simpan pembaruan data Informasi Khusus PMB Humas.
     */
    public function update(Request $request): RedirectResponse
    {
        $pmb = InformasiPmbHumas::firstOrCreate(['id' => 1]);

        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'subjudul' => ['nullable', 'string', 'max:255'],
            'badge_text' => ['nullable', 'string', 'max:100'],
            'deskripsi_singkat' => ['nullable', 'string'],
            'file_pdf' => ['nullable', 'file', 'mimes:pdf', 'max:51200'], // max 50MB
            'file_pdf_nama' => ['nullable', 'string', 'max:255'],
            'gambar_brosur' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:10240'], // max 10MB
            'gambar_brosur_2' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:10240'],
            'link_pendaftaran' => ['nullable', 'string', 'max:1000'],
            'no_wa_pmb' => ['nullable', 'string', 'max:50'],
            'gelombang_info' => ['nullable', 'string'],
            'persyaratan_info' => ['nullable', 'string'],
            'is_active' => ['nullable'],
        ], [
            'file_pdf.mimes' => 'File dokumen panduan harus berformat PDF.',
            'file_pdf.max' => 'Ukuran file PDF maksimal 50 MB.',
            'gambar_brosur.image' => 'File brosur utama harus berupa gambar.',
            'gambar_brosur_2.image' => 'File brosur kedua harus berupa gambar.',
        ]);

        $data = [
            'judul' => $validated['judul'],
            'subjudul' => $validated['subjudul'] ?? null,
            'badge_text' => $validated['badge_text'] ?? null,
            'deskripsi_singkat' => $validated['deskripsi_singkat'] ?? null,
            'file_pdf_nama' => $validated['file_pdf_nama'] ?? $pmb->file_pdf_nama,
            'link_pendaftaran' => $validated['link_pendaftaran'] ?? 'https://pmb.uis.ac.id',
            'no_wa_pmb' => $validated['no_wa_pmb'] ?? null,
            'gelombang_info' => $validated['gelombang_info'] ?? null,
            'persyaratan_info' => $validated['persyaratan_info'] ?? null,
            'is_active' => $request->has('is_active'),
        ];

        // Format Link Pendaftaran
        if (! empty($data['link_pendaftaran']) && ! str_starts_with($data['link_pendaftaran'], 'http://') && ! str_starts_with($data['link_pendaftaran'], 'https://')) {
            $data['link_pendaftaran'] = 'https://' . $data['link_pendaftaran'];
        }

        // Hapus PDF lama jika dicentang
        if ($request->boolean('hapus_pdf') && $pmb->file_pdf) {
            if (Storage::disk('public')->exists($pmb->file_pdf)) {
                Storage::disk('public')->delete($pmb->file_pdf);
            }
            $data['file_pdf'] = null;
            $data['file_pdf_nama'] = null;
        }

        // Upload PDF baru
        if ($request->hasFile('file_pdf')) {
            if ($pmb->file_pdf && Storage::disk('public')->exists($pmb->file_pdf)) {
                Storage::disk('public')->delete($pmb->file_pdf);
            }
            $file = $request->file('file_pdf');
            $data['file_pdf'] = $file->store('informasi-pmb', 'public');
            if (empty($data['file_pdf_nama'])) {
                $data['file_pdf_nama'] = $file->getClientOriginalName();
            }
        }

        // Hapus Gambar 1 jika dicentang
        if ($request->boolean('hapus_gambar_brosur') && $pmb->gambar_brosur) {
            if (Storage::disk('public')->exists($pmb->gambar_brosur)) {
                Storage::disk('public')->delete($pmb->gambar_brosur);
            }
            $data['gambar_brosur'] = null;
        }

        // Upload Gambar 1 baru
        if ($request->hasFile('gambar_brosur')) {
            if ($pmb->gambar_brosur && Storage::disk('public')->exists($pmb->gambar_brosur)) {
                Storage::disk('public')->delete($pmb->gambar_brosur);
            }
            $data['gambar_brosur'] = $request->file('gambar_brosur')->store('informasi-pmb', 'public');
        }

        // Hapus Gambar 2 jika dicentang
        if ($request->boolean('hapus_gambar_brosur_2') && $pmb->gambar_brosur_2) {
            if (Storage::disk('public')->exists($pmb->gambar_brosur_2)) {
                Storage::disk('public')->delete($pmb->gambar_brosur_2);
            }
            $data['gambar_brosur_2'] = null;
        }

        // Upload Gambar 2 baru
        if ($request->hasFile('gambar_brosur_2')) {
            if ($pmb->gambar_brosur_2 && Storage::disk('public')->exists($pmb->gambar_brosur_2)) {
                Storage::disk('public')->delete($pmb->gambar_brosur_2);
            }
            $data['gambar_brosur_2'] = $request->file('gambar_brosur_2')->store('informasi-pmb', 'public');
        }

        $pmb->update($data);

        alert()->success('Berhasil!', 'Pengaturan Informasi Khusus PMB berhasil diperbarui.');

        return redirect()->route('informasi-pmb-humas.index');
    }
}
