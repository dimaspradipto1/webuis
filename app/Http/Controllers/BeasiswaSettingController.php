<?php

namespace App\Http\Controllers;

use App\Models\BeasiswaSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class BeasiswaSettingController extends Controller
{
    /**
     * Tampilkan formulir pengaturan Program Beasiswa.
     */
    public function index(): View
    {
        $beasiswa = BeasiswaSetting::firstOrCreate([], [
            'hero_badge' => 'PENDAFTARAN BEASISWA T.A. 2026/2027 TELAH DIBUKA',
            'hero_judul' => 'Raih Impian & Masa Depan Bersama Program Beasiswa Universitas Ibnu Sina',
            'hero_deskripsi' => "Universitas Ibnu Sina (UIS) Batam berkomitmen memberikan akses pendidikan tinggi bermutu melalui berbagai skema beasiswa penuh (100% Bebas SPP) maupun beasiswa potongan biaya pendidikan bagi calon mahasiswa berprestasi, tahfidz Al-Qur'an, dan mitra industri.",
            'tentang_judul' => 'Membuka Akses Pendidikan Tinggi Unggul Tanpa Kendala Biaya',
            'tentang_deskripsi' => "Sebagai institusi pendidikan tinggi terkemuka di Kota Batam yang berlandaskan nilai-nilai Iman, Ilmu, dan Amal, Universitas Ibnu Sina meyakini bahwa keterbatasan finansial tidak boleh menjadi penghalang bagi putra-putri bangsa untuk meraih gelar Sarjana (S1) maupun Magister (S2).\n\nProgram Beasiswa UIS dirancang secara komprehensif bersama Kementerian Pendidikan, Pemerintah Daerah, Yayasan Pendidikan Ibnu Sina Batam (YAPISNA), serta asosiasi industri multinasional.",
            'link_daftar' => '',
            'is_active' => true,
        ]);

        return view('pages.beasiswa-setting.index', compact('beasiswa'));
    }

    /**
     * Update data pengaturan Program Beasiswa.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'hero_badge' => 'nullable|string|max:255',
            'hero_judul' => 'required|string|max:255',
            'hero_deskripsi' => 'nullable|string|max:5000',
            'tentang_judul' => 'nullable|string|max:255',
            'tentang_deskripsi' => 'nullable|string|max:10000',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'link_daftar' => 'nullable|string|max:500',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $beasiswa = BeasiswaSetting::first() ?? new BeasiswaSetting();

        if ($request->hasFile('gambar')) {
            if ($beasiswa->gambar && Storage::disk('public')->exists($beasiswa->gambar)) {
                Storage::disk('public')->delete($beasiswa->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('beasiswa', 'public');
        }

        $beasiswa->fill($validated);
        $beasiswa->save();

        alert()->success('Berhasil!', 'Pengaturan Program Beasiswa berhasil diperbarui.');

        return redirect()->route('beasiswa.admin');
    }
}
