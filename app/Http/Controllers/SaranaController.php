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
     * Tampilkan daftar sarana via DataTables & Kartu Visual.
     */
    public function index(SaranaDataTable $dataTables)
    {
        $selectedKategori = request('kategori', '');
        $allSaranas = Sarana::orderBy('urutan')->get();

        $saranas = $selectedKategori
            ? $allSaranas->where('kategori', $selectedKategori)->values()
            : $allSaranas;

        return $dataTables->render('pages.sarana.index', compact('saranas', 'allSaranas', 'selectedKategori'));
    }

    /**
     * Tampilkan form tambah sarana.
     */
    public function create(): View
    {
        return view('pages.sarana.create');
    }

    /**
     * Simpan data sarana baru (mendukung multi-upload foto).
     */
    public function store(SaranaRequest $request): RedirectResponse
    {
        $allUploaded = [];

        if ($request->hasFile('foto')) {
            $files = is_array($request->file('foto')) ? $request->file('foto') : [$request->file('foto')];
            foreach ($files as $file) {
                $allUploaded[] = $file->store('sarana', 'public');
            }
        }

        if ($request->hasFile('galeri')) {
            foreach ($request->file('galeri') as $file) {
                $allUploaded[] = $file->store('sarana/galeri', 'public');
            }
        }

        $mainFoto = $allUploaded[0] ?? null;

        Sarana::create([
            'icon' => $request->icon,
            'nama' => $request->nama,
            'kategori' => $request->kategori ?: 'Fasilitas Kampus',
            'deskripsi' => $request->deskripsi,
            'foto' => $mainFoto,
            'galeri' => ! empty($allUploaded) ? $allUploaded : null,
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
     * Update data sarana (mendukung multi-upload foto & hapus foto tertentu).
     */
    public function update(SaranaRequest $request, Sarana $sarana): RedirectResponse
    {
        $existingGaleri = is_array($sarana->galeri) ? $sarana->galeri : [];
        if (! empty($sarana->foto) && ! in_array($sarana->foto, $existingGaleri, true)) {
            array_unshift($existingGaleri, $sarana->foto);
        }

        // Hapus foto yang dicentang untuk dihapus
        $toDelete = $request->input('hapus_galeri', []);
        if (! empty($toDelete) && is_array($toDelete)) {
            foreach ($toDelete as $delPath) {
                if (Storage::disk('public')->exists($delPath)) {
                    Storage::disk('public')->delete($delPath);
                }
                $existingGaleri = array_values(array_filter($existingGaleri, fn ($p) => $p !== $delPath));
            }
        }

        // Upload foto baru (bisa lebih dari 1 dari input foto[] maupun galeri[])
        $newPhotos = [];
        if ($request->hasFile('foto')) {
            $files = is_array($request->file('foto')) ? $request->file('foto') : [$request->file('foto')];
            foreach ($files as $file) {
                $newPhotos[] = $file->store('sarana', 'public');
            }
        }
        if ($request->hasFile('galeri')) {
            foreach ($request->file('galeri') as $file) {
                $newPhotos[] = $file->store('sarana/galeri', 'public');
            }
        }

        $mergedGaleri = array_values(array_unique(array_merge($existingGaleri, $newPhotos)));

        // Tentukan foto sampul utama
        $mainFoto = $sarana->foto;
        if (! empty($toDelete) && in_array($mainFoto, $toDelete, true)) {
            $mainFoto = $mergedGaleri[0] ?? null;
        }
        if ($request->filled('set_main_photo') && in_array($request->input('set_main_photo'), $mergedGaleri, true)) {
            $mainFoto = $request->input('set_main_photo');
        } elseif (empty($mainFoto) && ! empty($mergedGaleri)) {
            $mainFoto = $mergedGaleri[0];
        }

        $sarana->update([
            'icon' => $request->icon,
            'nama' => $request->nama,
            'kategori' => $request->kategori ?: 'Fasilitas Kampus',
            'deskripsi' => $request->deskripsi,
            'foto' => $mainFoto,
            'galeri' => ! empty($mergedGaleri) ? $mergedGaleri : null,
            'konten_detail' => $request->konten_detail,
            'lokasi' => $request->lokasi,
            'kapasitas' => $request->kapasitas,
            'jam_operasional' => $request->jam_operasional,
            'penanggung_jawab' => $request->penanggung_jawab,
            'spesifikasi' => $request->spesifikasi,
            'urutan' => $request->urutan ?? 0,
            'is_active' => $request->boolean('is_active'),
        ]);

        alert()->success('Berhasil!', 'Data dan foto fasilitas / laboratorium berhasil diperbarui.');

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
        if (! empty($sarana->galeri) && is_array($sarana->galeri)) {
            foreach ($sarana->galeri as $gImg) {
                if ($gImg && Storage::disk('public')->exists($gImg)) {
                    Storage::disk('public')->delete($gImg);
                }
            }
        }

        $sarana->delete();

        alert()->success('Berhasil!', 'Fasilitas / Laboratorium berhasil dihapus.');

        return redirect()->route('sarana.index');
    }
}
