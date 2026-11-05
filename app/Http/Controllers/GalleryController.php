<?php

namespace App\Http\Controllers;

use App\DataTables\GalleryDataTable;
use App\Http\Requests\GalleryRequest;
use App\Models\Gallery;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class GalleryController extends Controller
{
    /**
     * Tampilkan daftar galeri via DataTables.
     */
    public function index(GalleryDataTable $dataTables)
    {
        return $dataTables->render('pages.gallery.index');
    }

    /**
     * Tampilkan form tambah foto.
     */
    public function create(): View
    {
        return view('pages.gallery.create');
    }

    /**
     * Simpan foto baru (mendukung multi-upload) ke storage dan database.
     */
    public function store(GalleryRequest $request): RedirectResponse
    {
        $uploadedPaths = [];

        if ($request->hasFile('foto')) {
            $files = is_array($request->file('foto')) ? $request->file('foto') : [$request->file('foto')];
            foreach ($files as $file) {
                $uploadedPaths[] = $file->store('gallery', 'public');
            }
        }

        if ($request->hasFile('galeri')) {
            foreach ($request->file('galeri') as $file) {
                $uploadedPaths[] = $file->store('gallery', 'public');
            }
        }

        $mode = $request->input('mode_upload', 'album');

        if ($mode === 'terpisah' && count($uploadedPaths) > 1) {
            foreach ($uploadedPaths as $idx => $path) {
                $judulItem = $request->judul
                    ? ($idx === 0 ? $request->judul : $request->judul . ' (' . ($idx + 1) . ')')
                    : null;

                Gallery::create([
                    'judul' => $judulItem,
                    'kategori' => $request->kategori ?? 'universitas',
                    'deskripsi' => $request->deskripsi,
                    'url' => $path,
                    'galeri' => [$path],
                ]);
            }
        } else {
            $mainPath = $uploadedPaths[0] ?? null;

            Gallery::create([
                'judul' => $request->judul,
                'kategori' => $request->kategori ?? 'universitas',
                'deskripsi' => $request->deskripsi,
                'url' => $mainPath,
                'galeri' => ! empty($uploadedPaths) ? $uploadedPaths : null,
            ]);
        }

        alert()->success('Berhasil!', count($uploadedPaths) . ' foto galeri berhasil diunggah dan disimpan.');

        return redirect()->route('gallery.index');
    }

    /**
     * Tampilkan form edit foto.
     */
    public function edit(Gallery $gallery): View
    {
        return view('pages.gallery.edit', compact('gallery'));
    }

    /**
     * Update data galeri (mendukung tambah multi-foto dan hapus foto tertentu).
     */
    public function update(GalleryRequest $request, Gallery $gallery): RedirectResponse
    {
        $existingGaleri = is_array($gallery->galeri) ? $gallery->galeri : [];
        if (empty($existingGaleri) && ! empty($gallery->url)) {
            $existingGaleri = [$gallery->url];
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

        // Tambah foto baru dari input foto[] atau galeri[]
        $newPaths = [];
        if ($request->hasFile('foto')) {
            $files = is_array($request->file('foto')) ? $request->file('foto') : [$request->file('foto')];
            foreach ($files as $file) {
                $newPaths[] = $file->store('gallery', 'public');
            }
        }
        if ($request->hasFile('galeri')) {
            foreach ($request->file('galeri') as $file) {
                $newPaths[] = $file->store('gallery', 'public');
            }
        }

        $mergedGaleri = array_values(array_unique(array_merge($existingGaleri, $newPaths)));

        // Tentukan foto sampul utama (url)
        $mainUrl = $gallery->url;
        if (! empty($toDelete) && in_array($mainUrl, $toDelete, true)) {
            $mainUrl = $mergedGaleri[0] ?? null;
        }
        if ($request->filled('set_main_photo') && in_array($request->input('set_main_photo'), $mergedGaleri, true)) {
            $mainUrl = $request->input('set_main_photo');
        } elseif (empty($mainUrl) && ! empty($mergedGaleri)) {
            $mainUrl = $mergedGaleri[0];
        }

        $gallery->update([
            'judul' => $request->judul,
            'kategori' => $request->kategori ?? 'universitas',
            'deskripsi' => $request->deskripsi,
            'url' => $mainUrl,
            'galeri' => ! empty($mergedGaleri) ? $mergedGaleri : null,
        ]);

        alert()->success('Berhasil!', 'Data dan foto galeri berhasil diperbarui.');

        return redirect()->route('gallery.index');
    }

    /**
     * Hapus foto dari storage dan database.
     */
    public function destroy(Gallery $gallery): RedirectResponse
    {
        if ($gallery->url && Storage::disk('public')->exists($gallery->url)) {
            Storage::disk('public')->delete($gallery->url);
        }

        if (! empty($gallery->galeri) && is_array($gallery->galeri)) {
            foreach ($gallery->galeri as $gPath) {
                if ($gPath && Storage::disk('public')->exists($gPath)) {
                    Storage::disk('public')->delete($gPath);
                }
            }
        }

        $gallery->delete();

        alert()->success('Berhasil!', 'Foto galeri berhasil dihapus.');

        return redirect()->route('gallery.index');
    }
}
