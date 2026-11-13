<?php

namespace App\Http\Controllers;

use App\DataTables\FeatureDataTable;
use App\Http\Requests\FeatureRequest;
use App\Models\Feature;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FeatureController extends Controller
{
    /**
     * Tampilkan daftar kartu keunggulan beranda via DataTables.
     */
    public function index(FeatureDataTable $dataTables)
    {
        return $dataTables->render('pages.feature.index');
    }

    /**
     * Tampilkan form tambah kartu keunggulan beranda.
     */
    public function create(): View
    {
        return view('pages.feature.create');
    }

    /**
     * Simpan data kartu keunggulan baru.
     */
    public function store(FeatureRequest $request): RedirectResponse
    {
        Feature::create([
            'icon' => Feature::packIconAndBadge($request->icon, $request->badge),
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'detail' => $request->detail,
            'urutan' => $request->urutan ?? 0,
        ]);

        alert()->success('Berhasil!', 'Kartu keunggulan beranda berhasil ditambahkan.');

        return redirect()->route('feature.index');
    }

    /**
     * Tampilkan form edit kartu keunggulan beranda.
     */
    public function edit(Feature $feature): View
    {
        return view('pages.feature.edit', compact('feature'));
    }

    /**
     * Update data kartu keunggulan beranda.
     */
    public function update(FeatureRequest $request, Feature $feature): RedirectResponse
    {
        $feature->update([
            'icon' => Feature::packIconAndBadge($request->icon, $request->badge),
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'detail' => $request->detail,
            'urutan' => $request->urutan ?? 0,
        ]);

        alert()->success('Berhasil!', 'Kartu keunggulan beranda berhasil diperbarui.');

        return redirect()->route('feature.index');
    }

    /**
     * Hapus data kartu keunggulan beranda.
     */
    public function destroy(Feature $feature): RedirectResponse
    {
        $feature->delete();

        alert()->success('Berhasil!', 'Kartu keunggulan beranda berhasil dihapus.');

        return redirect()->route('feature.index');
    }
}
