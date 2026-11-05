<?php

namespace App\Http\Controllers;

use App\DataTables\SaranaDataTable;
use App\Http\Requests\SaranaRequest;
use App\Models\Sarana;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SaranaController extends Controller
{
    /**
     * Tampilkan daftar sarana via DataTables.
     */
    public function index(SaranaDataTable $dataTables)
    {
        return $dataTables->render('pages.sarana.index');
    }

    /**
     * Tampilkan form tambah sarana.
     */
    public function create(): View
    {
        return view('pages.sarana.create');
    }

    /**
     * Simpan data sarana baru.
     */
    public function store(SaranaRequest $request): RedirectResponse
    {
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('sarana', 'public');
        }

        $galeriPaths = [];
        if ($request->hasFile('galeri')) {
            foreach ($request->file('galeri') as $file) {
                $galeriPaths[] = $file->store('sarana/galeri', 'public');
            }
        }

        Sarana::create([
            'icon' => $request->icon,
            'nama' => $request->nama,
            'kategori' => $request->kategori ?: 'Fasilitas Kampus',
            'deskripsi' => $request->deskripsi,
            'foto' => $fotoPath,
            'galeri' => ! empty($galeriPaths) ? $galeriPaths : null,
            'konten_detail' => $request->konten_detail,
            'lokasi' => $request->lokasi,
            'kapasitas' => $request->kapasitas,
            'jam_operasional' => $request->jam_operasional,
            'penanggung_jawab' => $request->penanggung_jawab,
            'spesifikasi' => $request->spesifikasi,
            'urutan' => $request->urutan ?? 0,
            'is_active' => $request->boolean('is_active', true),
        ]);

        alert()->success('Berhasil!', 'Fasilitas / Laboratorium berhasil ditambahkan.');

        return redirect()->route('sarana.index');
    }

    /**
     * Tampilkan form edit sarana.
     */
    public function edit(Sarana $sarana): View
    {
        return view('pages.sarana.edit', compact('sarana'));
    }

    /**
     * Update data sarana.
     */
    public function update(SaranaRequest $request, Sarana $sarana): RedirectResponse
    {
        $fotoPath = $sarana->foto;
        if ($request->hasFile('foto')) {
            if ($fotoPath && Storage::disk('public')->exists($fotoPath)) {
                Storage::disk('public')->delete($fotoPath);
            }
            $fotoPath = $request->file('foto')->store('sarana', 'public');
        }

        $galeriPaths = $sarana->galeri ?? [];
        if ($request->hasFile('galeri')) {
            foreach ($request->file('galeri') as $file) {
                $galeriPaths[] = $file->store('sarana/galeri', 'public');
            }
        }

        $sarana->update([
            'icon' => $request->icon,
            'nama' => $request->nama,
            'kategori' => $request->kategori ?: 'Fasilitas Kampus',
            'deskripsi' => $request->deskripsi,
            'foto' => $fotoPath,
            'galeri' => ! empty($galeriPaths) ? array_values($galeriPaths) : null,
            'konten_detail' => $request->konten_detail,
            'lokasi' => $request->lokasi,
            'kapasitas' => $request->kapasitas,
            'jam_operasional' => $request->jam_operasional,
            'penanggung_jawab' => $request->penanggung_jawab,
            'spesifikasi' => $request->spesifikasi,
            'urutan' => $request->urutan ?? 0,
            'is_active' => $request->boolean('is_active', true),
        ]);

        alert()->success('Berhasil!', 'Fasilitas / Laboratorium berhasil diperbarui.');

        return redirect()->route('sarana.index');
    }

    /**
     * Hapus data sarana.
     */
    public function destroy(Sarana $sarana): RedirectResponse
    {
        if ($sarana->foto && Storage::disk('public')->exists($sarana->foto)) {
            Storage::disk('public')->delete($sarana->foto);
        }
        if (is_array($sarana->galeri)) {
            foreach ($sarana->galeri as $g) {
                if ($g && Storage::disk('public')->exists($g)) {
                    Storage::disk('public')->delete($g);
                }
            }
        }

        $sarana->delete();

        alert()->success('Berhasil!', 'Fasilitas / Laboratorium berhasil dihapus.');

        return redirect()->route('sarana.index');
    }
}
