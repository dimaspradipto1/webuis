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
    public function index(VisiMisiDataTable $dataTable)
    {
        $about = About::first() ?? new About();
        $totalGambar = VisiMisi::whereNotNull('gambar')->count();
        $breadcrumb = Breadcrumb::getForPage('visi-misi');

        return $dataTable->render('pages.visimisi.index', compact('about', 'totalGambar', 'breadcrumb'));
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
