<?php

namespace App\Http\Controllers;

use App\Models\PimpinanManajemen;
use App\Models\ProfilPimpinan;
use App\Models\StrukturOrganisasi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class StrukturOrganisasiController extends Controller
{
    public const KATEGORI_MANAJEMEN = ['Rektorat', 'FEB', 'FST', 'FIKES'];

    public function index(Request $request): View
    {
        $struktur = StrukturOrganisasi::first();
        $pimpinans = ProfilPimpinan::orderBy('baris')->orderBy('urutan')->orderBy('id')->get();
        $pimpinansByBaris = $pimpinans->groupBy('baris');

        $activeKategori = $request->query('kategori', 'Rektorat');
        if (! in_array($activeKategori, self::KATEGORI_MANAJEMEN, true)) {
            $activeKategori = 'Rektorat';
        }

        $manajemensAll = PimpinanManajemen::orderBy('no_urut')->orderBy('id')->get()->groupBy('kategori');
        $kategoriList = self::KATEGORI_MANAJEMEN;

        return view('pages.struktur-organisasi.index', compact(
            'struktur',
            'pimpinans',
            'pimpinansByBaris',
            'manajemensAll',
            'kategoriList',
            'activeKategori'
        ));
    }

    public function create(Request $request): View
    {
        $selectedBaris = (int) $request->query('baris', 2);
        $nextUrutan = ((int) ProfilPimpinan::max('urutan')) + 1;

        return view('pages.struktur-organisasi.create', compact('selectedBaris', 'nextUrutan'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'jabatan' => ['required', 'string', 'max:255'],
            'baris' => ['required', 'integer', 'in:1,2,3'],
            'biografi' => ['nullable', 'string'],
            'urutan' => ['nullable', 'integer', 'min:1'],
            'foto' => ['nullable'],
            'foto.*' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:20480'],
        ], [
            'nama.required' => 'Nama Pimpinan wajib diisi.',
            'jabatan.required' => 'Jabatan Pimpinan wajib diisi.',
        ]);

        $uploadedPhotos = [];
        if ($request->hasFile('foto')) {
            $files = $request->file('foto');
            if (! is_array($files)) {
                $files = [$files];
            }
            foreach ($files as $file) {
                if ($file && $file->isValid()) {
                    $uploadedPhotos[] = $file->store('assets/pimpinan', 'public');
                }
            }
        }

        $pimpinan = ProfilPimpinan::create([
            'nama' => $validated['nama'],
            'slug' => $this->generateUniqueSlug($validated['nama']),
            'jabatan' => $validated['jabatan'],
            'baris' => (int) $validated['baris'],
            'foto' => $uploadedPhotos[0] ?? null,
            'galeri' => count($uploadedPhotos) > 0 ? $uploadedPhotos : null,
            'biografi' => $validated['biografi'] ?? null,
            'urutan' => $validated['urutan'] ?? (((int) ProfilPimpinan::max('urutan')) + 1),
            'is_active' => $request->boolean('is_active', true),
        ]);

        alert()->success('Berhasil!', 'Profil Pimpinan "'.$pimpinan->nama.'" berhasil ditambahkan.');

        return redirect()->route('struktur-organisasi.index');
    }

    public function edit($id): View
    {
        $pimpinan = ProfilPimpinan::findOrFail($id);
        $allPimpinans = ProfilPimpinan::orderBy('baris')->orderBy('urutan')->get();

        return view('pages.struktur-organisasi.edit', compact('pimpinan', 'allPimpinans'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $pimpinan = ProfilPimpinan::findOrFail($id);

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'jabatan' => ['required', 'string', 'max:255'],
            'baris' => ['required', 'integer', 'in:1,2,3'],
            'biografi' => ['nullable', 'string'],
            'urutan' => ['nullable', 'integer', 'min:1'],
            'foto' => ['nullable'],
            'foto.*' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:20480'],
        ]);

        $currentPhotos = $pimpinan->all_photos;
        $deletedPhotos = (array) $request->input('delete_photos', []);

        if (! empty($deletedPhotos)) {
            foreach ($deletedPhotos as $delPath) {
                if (! str_starts_with($delPath, 'http') && ! str_starts_with($delPath, 'assets/img/')) {
                    if (Storage::disk('public')->exists($delPath)) {
                        Storage::disk('public')->delete($delPath);
                    }
                }
            }
            $currentPhotos = array_values(array_filter($currentPhotos, fn ($p) => ! in_array($p, $deletedPhotos, true)));
        }

        if ($request->hasFile('foto')) {
            $files = $request->file('foto');
            if (! is_array($files)) {
                $files = [$files];
            }
            foreach ($files as $file) {
                if ($file && $file->isValid()) {
                    $currentPhotos[] = $file->store('assets/pimpinan', 'public');
                }
            }
        }

        $mainPhotoSelection = $request->input('main_photo');
        if (! empty($mainPhotoSelection) && in_array($mainPhotoSelection, $currentPhotos, true)) {
            $currentPhotos = array_values(array_diff($currentPhotos, [$mainPhotoSelection]));
            array_unshift($currentPhotos, $mainPhotoSelection);
        }

        $slug = $pimpinan->slug;
        if ($pimpinan->nama !== $validated['nama'] || empty($slug)) {
            $slug = $this->generateUniqueSlug($validated['nama'], $pimpinan->id);
        }

        $pimpinan->update([
            'nama' => $validated['nama'],
            'slug' => $slug,
            'jabatan' => $validated['jabatan'],
            'baris' => (int) $validated['baris'],
            'foto' => $currentPhotos[0] ?? null,
            'galeri' => count($currentPhotos) > 0 ? $currentPhotos : null,
            'biografi' => $validated['biografi'] ?? null,
            'urutan' => $validated['urutan'] ?? $pimpinan->urutan,
            'is_active' => $request->boolean('is_active'),
        ]);

        alert()->success('Berhasil!', 'Profil Pimpinan "'.$pimpinan->nama.'" berhasil diperbarui.');

        return redirect()->route('struktur-organisasi.index');
    }

    public function destroy($id): RedirectResponse
    {
        $pimpinan = ProfilPimpinan::findOrFail($id);

        foreach ($pimpinan->all_photos as $photo) {
            if (! str_starts_with($photo, 'http') && ! str_starts_with($photo, 'assets/img/')) {
                if (Storage::disk('public')->exists($photo)) {
                    Storage::disk('public')->delete($photo);
                }
            }
        }

        $pimpinan->delete();

        alert()->success('Berhasil!', 'Profil Pimpinan berhasil dihapus.');

        return redirect()->route('struktur-organisasi.index');
    }

    public function storeManajemen(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kategori' => ['required', 'string', 'in:Rektorat,FEB,FST,FIKES'],
            'no_urut' => ['nullable', 'integer', 'min:1'],
            'nama' => ['required', 'string', 'max:255'],
            'jabatan' => ['required', 'string', 'max:255'],
        ]);

        $nextNo = $validated['no_urut']
            ?: (((int) PimpinanManajemen::where('kategori', $validated['kategori'])->max('no_urut')) + 1);

        PimpinanManajemen::create([
            'kategori' => $validated['kategori'],
            'no_urut' => $nextNo,
            'nama' => $validated['nama'],
            'jabatan' => $validated['jabatan'],
            'is_active' => true,
        ]);

        alert()->success('Berhasil!', 'Data Pimpinan & Manajemen ('.$validated['kategori'].') berhasil ditambahkan.');

        return redirect()->route('struktur-organisasi.index', ['kategori' => $validated['kategori'], 'section' => 'manajemen']);
    }

    public function updateManajemen(Request $request, PimpinanManajemen $manajemen): RedirectResponse
    {
        $validated = $request->validate([
            'kategori' => ['required', 'string', 'in:Rektorat,FEB,FST,FIKES'],
            'no_urut' => ['required', 'integer', 'min:1'],
            'nama' => ['required', 'string', 'max:255'],
            'jabatan' => ['required', 'string', 'max:255'],
        ]);

        $manajemen->update($validated);

        alert()->success('Berhasil!', 'Data Pimpinan & Manajemen berhasil diperbarui.');

        return redirect()->route('struktur-organisasi.index', ['kategori' => $validated['kategori'], 'section' => 'manajemen']);
    }

    public function destroyManajemen(PimpinanManajemen $manajemen): RedirectResponse
    {
        $kat = $manajemen->kategori;
        $manajemen->delete();

        alert()->success('Berhasil!', 'Data Pimpinan & Manajemen berhasil dihapus.');

        return redirect()->route('struktur-organisasi.index', ['kategori' => $kat, 'section' => 'manajemen']);
    }

    public function storeBagan(Request $request): RedirectResponse
    {
        $request->validate([
            'url_struktur' => ['required', 'image', 'mimes:png,jpg,jpeg,webp', 'max:10240'],
        ]);

        $struktur = StrukturOrganisasi::first() ?? new StrukturOrganisasi;

        if ($request->hasFile('url_struktur')) {
            if ($struktur->url_struktur) {
                Storage::disk('public')->delete(str_replace('storage/', '', $struktur->url_struktur));
            }
            $path = $request->file('url_struktur')->store('struktur-organisasi', 'public');
            $struktur->url_struktur = 'storage/'.$path;
            $struktur->save();
        }

        alert()->success('Berhasil!', 'Bagan struktur organisasi berhasil diperbarui.');

        return redirect()->route('struktur-organisasi.index');
    }

    public function destroyBagan($id): RedirectResponse
    {
        $struktur = StrukturOrganisasi::findOrFail($id);
        if ($struktur->url_struktur) {
            Storage::disk('public')->delete(str_replace('storage/', '', $struktur->url_struktur));
        }
        $struktur->delete();

        alert()->success('Berhasil!', 'Bagan struktur organisasi berhasil dihapus.');

        return redirect()->route('struktur-organisasi.index');
    }

    private function generateUniqueSlug(string $nama, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($nama) ?: 'pimpinan';
        $slug = $baseSlug;
        $counter = 2;

        while (
            ProfilPimpinan::where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $baseSlug.'-'.$counter++;
        }

        return $slug;
    }
}
