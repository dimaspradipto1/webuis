<?php

namespace App\Http\Controllers;

use App\Models\ProgramStudi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProgramStudiController extends Controller
{
    public const FAKULTAS_LIST = [
        'Program Pascasarjana',
        'Fakultas Ekonomi dan Bisnis',
        'Fakultas Sains dan Teknologi',
        'Fakultas Ilmu Kesehatan',
    ];

    public function index(Request $request): View
    {
        $fakultas = $request->query('fakultas');
        $jenjang = $request->query('jenjang');

        $query = ProgramStudi::query()->orderBy('urutan')->orderBy('id');

        if (! empty($fakultas)) {
            $query->where('fakultas', $fakultas);
        }
        if (! empty($jenjang)) {
            $query->where('jenjang', $jenjang);
        }

        $prodis = $query->get();
        $allProdis = ProgramStudi::orderBy('urutan')->get();
        $fakultasList = self::FAKULTAS_LIST;

        return view('pages.program-studi.index', compact('prodis', 'allProdis', 'fakultas', 'jenjang', 'fakultasList'));
    }

    public function create(Request $request): View
    {
        $fakultasList = self::FAKULTAS_LIST;
        $selectedFakultas = $request->query('fakultas', 'Fakultas Sains dan Teknologi');
        $nextUrutan = ((int) ProgramStudi::max('urutan')) + 1;

        return view('pages.program-studi.create', compact('fakultasList', 'selectedFakultas', 'nextUrutan'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'jenjang' => ['required', 'string', 'max:20'],
            'fakultas' => ['required', 'string', 'max:255'],
            'icon' => ['nullable', 'string', 'max:100'],
            'akreditasi' => ['nullable', 'string', 'max:100'],
            'gelar' => ['nullable', 'string', 'max:100'],
            'deskripsi_singkat' => ['nullable', 'string'],
            'deskripsi' => ['nullable', 'string'],
            'visi' => ['nullable', 'string'],
            'misi' => ['nullable', 'string'],
            'prospek_karir' => ['nullable', 'string'],
            'link_website' => ['nullable', 'string', 'max:500'],
            'urutan' => ['nullable', 'integer', 'min:1'],
            'foto' => ['nullable'],
            'foto.*' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:20480'],
        ], [
            'nama.required' => 'Nama Program Studi wajib diisi.',
            'jenjang.required' => 'Jenjang pendidikan wajib dipilih.',
            'fakultas.required' => 'Fakultas wajib dipilih.',
        ]);

        $uploadedPhotos = [];
        if ($request->hasFile('foto')) {
            $files = $request->file('foto');
            if (! is_array($files)) {
                $files = [$files];
            }
            foreach ($files as $file) {
                if ($file && $file->isValid()) {
                    $uploadedPhotos[] = $file->store('assets/prodi', 'public');
                }
            }
        }

        $linkWebsite = trim($validated['link_website'] ?? '');
        if (! empty($linkWebsite) && ! str_starts_with($linkWebsite, 'http://') && ! str_starts_with($linkWebsite, 'https://') && ! str_starts_with($linkWebsite, '/')) {
            $linkWebsite = 'https://'.$linkWebsite;
        }

        $prodi = ProgramStudi::create([
            'nama' => $validated['nama'],
            'slug' => $this->generateUniqueSlug($validated['nama']),
            'jenjang' => $validated['jenjang'],
            'fakultas' => $validated['fakultas'],
            'icon' => $validated['icon'] ?: 'bi-mortarboard-fill',
            'akreditasi' => $validated['akreditasi'] ?? null,
            'gelar' => $validated['gelar'] ?? null,
            'deskripsi_singkat' => $validated['deskripsi_singkat'] ?? null,
            'deskripsi' => $validated['deskripsi'] ?? null,
            'visi' => $validated['visi'] ?? null,
            'misi' => $validated['misi'] ?? null,
            'prospek_karir' => $validated['prospek_karir'] ?? null,
            'foto' => $uploadedPhotos[0] ?? null,
            'galeri' => count($uploadedPhotos) > 0 ? $uploadedPhotos : null,
            'link_website' => $linkWebsite ?: null,
            'urutan' => $validated['urutan'] ?? (((int) ProgramStudi::max('urutan')) + 1),
            'is_active' => $request->boolean('is_active', true),
        ]);

        alert()->success('Berhasil!', 'Program Studi "'.$prodi->nama.'" berhasil ditambahkan.');

        return redirect()->route('program-studi.index');
    }

    public function edit(ProgramStudi $programStudi): View
    {
        $fakultasList = self::FAKULTAS_LIST;
        $allProdis = ProgramStudi::orderBy('urutan')->get();

        return view('pages.program-studi.edit', compact('programStudi', 'fakultasList', 'allProdis'));
    }

    public function update(Request $request, ProgramStudi $programStudi): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'jenjang' => ['required', 'string', 'max:20'],
            'fakultas' => ['required', 'string', 'max:255'],
            'icon' => ['nullable', 'string', 'max:100'],
            'akreditasi' => ['nullable', 'string', 'max:100'],
            'gelar' => ['nullable', 'string', 'max:100'],
            'deskripsi_singkat' => ['nullable', 'string'],
            'deskripsi' => ['nullable', 'string'],
            'visi' => ['nullable', 'string'],
            'misi' => ['nullable', 'string'],
            'prospek_karir' => ['nullable', 'string'],
            'link_website' => ['nullable', 'string', 'max:500'],
            'urutan' => ['nullable', 'integer', 'min:1'],
            'foto' => ['nullable'],
            'foto.*' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:20480'],
        ]);

        // Existing photos management
        $currentPhotos = $programStudi->all_photos;
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

        // Upload new photos
        if ($request->hasFile('foto')) {
            $files = $request->file('foto');
            if (! is_array($files)) {
                $files = [$files];
            }
            foreach ($files as $file) {
                if ($file && $file->isValid()) {
                    $currentPhotos[] = $file->store('assets/prodi', 'public');
                }
            }
        }

        // Set cover photo if selected
        $mainPhotoSelection = $request->input('main_photo');
        if (! empty($mainPhotoSelection) && in_array($mainPhotoSelection, $currentPhotos, true)) {
            $currentPhotos = array_values(array_diff($currentPhotos, [$mainPhotoSelection]));
            array_unshift($currentPhotos, $mainPhotoSelection);
        }

        $linkWebsite = trim($validated['link_website'] ?? '');
        if (! empty($linkWebsite) && ! str_starts_with($linkWebsite, 'http://') && ! str_starts_with($linkWebsite, 'https://') && ! str_starts_with($linkWebsite, '/')) {
            $linkWebsite = 'https://'.$linkWebsite;
        }

        $slug = $programStudi->slug;
        if ($programStudi->nama !== $validated['nama'] || empty($slug)) {
            $slug = $this->generateUniqueSlug($validated['nama'], $programStudi->id);
        }

        $programStudi->update([
            'nama' => $validated['nama'],
            'slug' => $slug,
            'jenjang' => $validated['jenjang'],
            'fakultas' => $validated['fakultas'],
            'icon' => $validated['icon'] ?: 'bi-mortarboard-fill',
            'akreditasi' => $validated['akreditasi'] ?? null,
            'gelar' => $validated['gelar'] ?? null,
            'deskripsi_singkat' => $validated['deskripsi_singkat'] ?? null,
            'deskripsi' => $validated['deskripsi'] ?? null,
            'visi' => $validated['visi'] ?? null,
            'misi' => $validated['misi'] ?? null,
            'prospek_karir' => $validated['prospek_karir'] ?? null,
            'foto' => $currentPhotos[0] ?? null,
            'galeri' => count($currentPhotos) > 0 ? $currentPhotos : null,
            'link_website' => $linkWebsite ?: null,
            'urutan' => $validated['urutan'] ?? $programStudi->urutan,
            'is_active' => $request->boolean('is_active'),
        ]);

        alert()->success('Berhasil!', 'Data Program Studi "'.$programStudi->nama.'" berhasil diperbarui.');

        return redirect()->route('program-studi.index');
    }

    public function destroy(ProgramStudi $programStudi): RedirectResponse
    {
        foreach ($programStudi->all_photos as $photo) {
            if (! str_starts_with($photo, 'http') && ! str_starts_with($photo, 'assets/img/')) {
                if (Storage::disk('public')->exists($photo)) {
                    Storage::disk('public')->delete($photo);
                }
            }
        }

        $programStudi->delete();

        alert()->success('Berhasil!', 'Program Studi berhasil dihapus.');

        return redirect()->route('program-studi.index');
    }

    private function generateUniqueSlug(string $nama, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($nama) ?: 'program-studi';
        $slug = $baseSlug;
        $counter = 2;

        while (
            ProgramStudi::where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $baseSlug.'-'.$counter++;
        }

        return $slug;
    }
}

