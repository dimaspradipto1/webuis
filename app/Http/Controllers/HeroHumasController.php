<?php

namespace App\Http\Controllers;

use App\Http\Requests\HeroHumasRequest;
use App\Models\HeroHumas;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class HeroHumasController extends Controller
{
    public function index(): View
    {
        $hero = HeroHumas::first();
        if (! $hero) {
            $hero = HeroHumas::create([
                'judul' => 'Selamat Datang',
                'subjudul' => 'di Biro Hubungan Masyarakat dan Protokoler Universitas Ibnu Sina',
                'badge_text' => 'Layanan',
                'background_image' => 'frontend/img/gedung-uis.jpg',
                'pill_text_1' => 'Informasi Khusus PMB TA 2026/2027',
                'pill_url_1' => null,
                'pill_text_2' => 'Pengumuman Prestasi & Kejuaraan Kampus',
                'pill_url_2' => null,
                'pill_text_3' => 'Live Chat Layanan Humas',
                'pill_url_3' => null,
                'is_active' => true,
            ]);
        }

        return view('pages.hero-humas.index', compact('hero'));
    }

    public function update(HeroHumasRequest $request): RedirectResponse
    {
        $hero = HeroHumas::first();
        if (! $hero) {
            $hero = new HeroHumas;
        }

        $validated = $request->validated();

        if ($request->hasFile('background_image')) {
            if ($hero->background_image && ! str_starts_with($hero->background_image, 'assets/') && ! str_starts_with($hero->background_image, 'frontend/')) {
                if (Storage::disk('public')->exists($hero->background_image)) {
                    Storage::disk('public')->delete($hero->background_image);
                }
            }
            $validated['background_image'] = $request->file('background_image')->store('hero-humas', 'public');
        }

        // Hapus background jika diminta (kembalikan ke default gedung-uis.jpg)
        if ($request->boolean('hapus_background')) {
            if ($hero->background_image && ! str_starts_with($hero->background_image, 'assets/') && ! str_starts_with($hero->background_image, 'frontend/')) {
                if (Storage::disk('public')->exists($hero->background_image)) {
                    Storage::disk('public')->delete($hero->background_image);
                }
            }
            $validated['background_image'] = 'frontend/img/gedung-uis.jpg';
        }

        $validated['is_active'] = $request->has('is_active');

        $hero->fill($validated);
        $hero->save();

        return redirect()
            ->route('hero-humas.index')
            ->with('success', 'Pengaturan Hero dan Background Homepage Humas berhasil diperbarui.');
    }
}
