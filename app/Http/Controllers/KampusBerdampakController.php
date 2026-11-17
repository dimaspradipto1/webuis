<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use App\Models\KampusBerdampak;
use App\Models\KampusBerdampakProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KampusBerdampakController extends Controller
{
    public function index()
    {
        $setting = KampusBerdampak::first();
        if (!$setting) {
            $setting = KampusBerdampak::create([
                'judul_section' => 'Tentang Kampus Berdampak',
                'tagline' => 'Menciptakan Perubahan Nyata untuk Masa Depan',
                'deskripsi' => 'Merdeka Belajar Kampus Merdeka (MBKM) digaungkan sebagai upaya peningkatan pemahaman mahasiswa yang lebih teknis. Bekerjasama UIS dan Industry, Lembaga Pendidikan lainnya guna menciptakan program-program magang dan praktek kerja, yang membantu lulusan memperoleh pengalaman praktis dan memahami dunia kerja. Dari semua itu, tentu tujuannya untuk meningkatkan kompetensi lulusan, baik soft skills maupun hard skills, agar lebih siap dan relevan dengan kebutuhan zaman.',
                'tombol_teks' => 'Download Panduan MBKM',
                'badge_status' => 'AKTIF 2024',
                'is_active' => true,
            ]);
        }

        $programs = KampusBerdampakProgram::orderBy('urutan')->orderBy('id')->get();

        return view('pages.kampus-berdampak.index', compact('setting', 'programs'));
    }

    public function updateSetting(Request $request)
    {
        $setting = KampusBerdampak::firstOrCreate([]);

        $validated = $request->validate([
            'judul_section' => 'required|string|max:255',
            'tagline' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'tombol_teks' => 'nullable|string|max:100',
            'badge_status' => 'nullable|string|max:50',
            'file_panduan_url' => 'nullable|string|max:255',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'file_panduan' => 'nullable|file|mimes:pdf,doc,docx,zip|max:20480',
        ]);

        if ($request->hasFile('poster')) {
            if ($setting->poster && Storage::disk('public')->exists($setting->poster)) {
                Storage::disk('public')->delete($setting->poster);
            }
            $validated['poster'] = $request->file('poster')->store('kampus-berdampak', 'public');
        }

        if ($request->hasFile('file_panduan')) {
            if ($setting->file_panduan && Storage::disk('public')->exists($setting->file_panduan)) {
                Storage::disk('public')->delete($setting->file_panduan);
            }
            $validated['file_panduan'] = $request->file('file_panduan')->store('kampus-berdampak/panduan', 'public');
        }

        $setting->update($validated);

        // Sinkronisasi badge / deskripsi ke kartu Feature di beranda
        $feature = Feature::where('judul', 'like', '%berdampak%')->first();
        if ($feature) {
            $feature->update([
                'badge' => $setting->badge_status ?: 'AKTIF 2024',
            ]);
        }

        return redirect()->route('kampus-berdampak.index')->with('success', 'Pengaturan Kampus Berdampak berhasil diperbarui!');
    }

    public function storeProgram(Request $request)
    {
        $validated = $request->validate([
            'nama_program' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'urutan' => 'nullable|integer',
        ]);

        $validated['urutan'] = $validated['urutan'] ?? ((KampusBerdampakProgram::max('urutan') ?? 0) + 1);
        $validated['is_active'] = $request->has('is_active');

        KampusBerdampakProgram::create($validated);

        return redirect()->route('kampus-berdampak.index')->with('success', 'Program Pilihan baru berhasil ditambahkan!');
    }

    public function updateProgram(Request $request, KampusBerdampakProgram $program)
    {
        $validated = $request->validate([
            'nama_program' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'urutan' => 'nullable|integer',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $program->update($validated);

        return redirect()->route('kampus-berdampak.index')->with('success', 'Program Pilihan berhasil diperbarui!');
    }

    public function destroyProgram(KampusBerdampakProgram $program)
    {
        $program->delete();

        return redirect()->route('kampus-berdampak.index')->with('success', 'Program Pilihan berhasil dihapus!');
    }
}
