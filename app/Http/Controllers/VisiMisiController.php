<?php

namespace App\Http\Controllers;

use App\DataTables\VisiMisiDataTable;
use App\Http\Requests\VisiMisiRequest;
use App\Models\About;
use App\Models\Breadcrumb;
use App\Models\VisiMisi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class VisiMisiController extends Controller
{
    public function index(): View
    {
        $about = About::firstOrCreate(['id' => 1]);
        $breadcrumb = Breadcrumb::getForPage('visi-misi');

        return view('pages.visimisi.index', compact('about', 'breadcrumb'));
    }

    /**
     * Update konten teks Visi, Misi, Tata Nilai dan Upload Background Utama
     */
    public function updateContent(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'visimisi_background' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'visimisi_tagline_visi' => ['nullable', 'string', 'max:500'],
            'visimisi_misi_items' => ['nullable', 'string', 'max:5000'],
            'visimisi_tatanilai_judul' => ['nullable', 'string', 'max:255'],
            'visimisi_tatanilai_items' => ['nullable', 'string', 'max:5000'],
            'visimisi_badge_humas' => ['nullable', 'string', 'max:255'],
            'visimisi_footer_fb' => ['nullable', 'string', 'max:255'],
            'visimisi_footer_ig' => ['nullable', 'string', 'max:255'],
            'visimisi_footer_url' => ['nullable', 'string', 'max:255'],
        ]);

        $about = About::firstOrCreate(['id' => 1]);

        if ($request->hasFile('visimisi_background')) {
            if ($about->visimisi_background && Storage::disk('public')->exists($about->visimisi_background)) {
                Storage::disk('public')->delete($about->visimisi_background);
            }
            $validated['visimisi_background'] = $request->file('visimisi_background')->store('visi-misi', 'public');
        }

        // Simpan juga ke kolom visi dan misi standar About agar sinkron
        if (!empty($validated['visimisi_tagline_visi'])) {
            $validated['visi'] = $validated['visimisi_tagline_visi'];
        }
        if (!empty($validated['visimisi_misi_items'])) {
            $validated['misi'] = $validated['visimisi_misi_items'];
        }

        $about->update($validated);

        alert()->success('Berhasil!', 'Konten teks Visi, Misi, Tata Nilai dan background berhasil disimpan.');

        return redirect()->route('visimisi.index');
    }

    /**
     * Hapus background utama dan gunakan latar default sistem
     */
    public function deleteBackground(): RedirectResponse
    {
        $about = About::firstOrCreate(['id' => 1]);

        if ($about->visimisi_background && Storage::disk('public')->exists($about->visimisi_background)) {
            Storage::disk('public')->delete($about->visimisi_background);
        }

        $about->visimisi_background = null;
        $about->save();

        alert()->success('Berhasil!', 'Background utama visi misi berhasil direset ke latar standar.');

        return redirect()->route('visimisi.index');
    }

    public function updateHeader(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'visimisi_label' => ['nullable', 'string', 'max:255'],
            'visimisi_judul' => ['nullable', 'string', 'max:255'],
            'visimisi_deskripsi' => ['nullable', 'string', 'max:1000'],
        ]);

        $about = About::firstOrCreate(['id' => 1]);
        $about->update($validated);

        alert()->success('Berhasil!', 'Teks judul dan deskripsi halaman Visi & Misi berhasil diperbarui.');

        return redirect()->route('visimisi.index');
    }

    public function create(): View
    {
        $nextUrutan = (VisiMisi::max('urutan') ?? 0) + 1;
        return view('pages.visimisi.create', compact('nextUrutan'));
    }

    public function store(VisiMisiRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('visi-misi', 'public');
        }

        $data['is_active'] = $request->has('is_active');
        $data['urutan'] = $data['urutan'] ?? ((VisiMisi::max('urutan') ?? 0) + 1);

        VisiMisi::create($data);

        alert()->success('Berhasil!', 'Gambar Visi & Misi berhasil diunggah.');

        return redirect()->route('visimisi.index');
    }

    public function edit(VisiMisi $visimisi): View
    {
        return view('pages.visimisi.edit', ['visiMisi' => $visimisi]);
    }

    public function update(VisiMisiRequest $request, VisiMisi $visimisi): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('gambar')) {
            if ($visimisi->gambar && Storage::disk('public')->exists($visimisi->gambar)) {
                Storage::disk('public')->delete($visimisi->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('visi-misi', 'public');
        }

        $data['is_active'] = $request->has('is_active');

        $visimisi->update($data);

        alert()->success('Berhasil!', 'Data Gambar Visi & Misi berhasil diperbarui.');

        return redirect()->route('visimisi.index');
    }

    public function destroy(VisiMisi $visimisi): RedirectResponse
    {
        if ($visimisi->gambar && Storage::disk('public')->exists($visimisi->gambar)) {
            Storage::disk('public')->delete($visimisi->gambar);
        }

        $visimisi->delete();

        alert()->success('Berhasil!', 'Gambar Visi & Misi berhasil dihapus.');

        return redirect()->route('visimisi.index');
    }
}
