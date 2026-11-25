<?php

namespace App\Http\Controllers;

use App\Models\Akreditasi;
use App\Models\ProgramStudi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AkreditasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $search = trim($request->input('q', ''));
        $tingkatFilter = trim($request->input('tingkat', ''));
        $kategoriFilter = trim($request->input('kategori', ''));

        $query = Akreditasi::query();

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('nomor_sk', 'like', "%{$search}%")
                    ->orWhere('lembaga', 'like', "%{$search}%")
                    ->orWhere('peringkat', 'like', "%{$search}%")
                    ->orWhere('kategori_label', 'like', "%{$search}%");
            });
        }

        if ($tingkatFilter !== '' && $tingkatFilter !== 'semua') {
            $query->where('tingkat', $tingkatFilter);
        }

        if ($kategoriFilter !== '' && $kategoriFilter !== 'semua') {
            $query->where('kategori_label', $kategoriFilter);
        }

        $items = $query->orderBy('tingkat')
            ->orderBy('urutan')
            ->orderBy('id')
            ->paginate(20)
            ->withQueryString();

        // Statistics
        $totalCount = Akreditasi::count();
        $univCount = Akreditasi::where('tingkat', 'universitas')->count();
        $fakultasCount = Akreditasi::where('tingkat', 'fakultas')->count();
        $prodiCount = Akreditasi::where('tingkat', 'prodi')->count();

        // Categories list for filter
        $kategoriList = Akreditasi::select('kategori_label')
            ->distinct()
            ->pluck('kategori_label')
            ->filter()
            ->values();

        return view('pages.akreditasi.index', compact(
            'items',
            'search',
            'tingkatFilter',
            'kategoriFilter',
            'totalCount',
            'univCount',
            'fakultasCount',
            'prodiCount',
            'kategoriList'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $fakultasOptions = [
            'Institusi' => 'Institusi / Universitas',
            'Program Pascasarjana' => 'Program Pascasarjana',
            'Fakultas Ekonomi dan Bisnis' => 'Fakultas Ekonomi dan Bisnis (FEB)',
            'Fakultas Sains dan Teknologi' => 'Fakultas Sains dan Teknologi (FST)',
            'Fakultas Ilmu Kesehatan' => 'Fakultas Ilmu Kesehatan (FIKES)',
        ];

        $lembagaOptions = ['BAN-PT', 'LAM-INFOKOM', 'LAMEMBA', 'LAM-PTKes', 'LAM Teknik', 'Lainnya'];
        $peringkatOptions = ['Unggul', 'Baik Sekali', 'Baik', 'A', 'B', 'C', 'Terakreditasi'];

        return view('pages.akreditasi.create', compact('fakultasOptions', 'lembagaOptions', 'peringkatOptions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'tingkat' => 'required|in:universitas,fakultas,prodi',
            'kategori_label' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'jenjang' => 'nullable|string|max:50',
            'lembaga' => 'required|string|max:100',
            'peringkat' => 'required|string|max:50',
            'nomor_sk' => 'nullable|string|max:255',
            'tahun_sk' => 'nullable|string|max:20',
            'masa_berlaku' => 'nullable|string|max:100',
            'file_sertifikat' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:20480',
            'urutan' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ], [
            'file_sertifikat.mimes' => 'Format file sertifikat harus berupa PDF, JPG, PNG, atau WEBP.',
            'file_sertifikat.max' => 'Ukuran file sertifikat maksimal 20 MB.',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['urutan'] = (int) ($validated['urutan'] ?? 0);

        // Upload sertifikat file
        if ($request->hasFile('file_sertifikat')) {
            $file = $request->file('file_sertifikat');
            $extension = $file->getClientOriginalExtension();
            $cleanName = time() . '_' . preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $file->getClientOriginalName());
            $storedPath = $file->storeAs('akreditasi', $cleanName, 'public');
            $validated['file_sertifikat'] = $storedPath;

            // Direct copy to public for reliability
            $targetDir = public_path('assets/img/akreditasi');
            if (!File::isDirectory($targetDir)) {
                File::makeDirectory($targetDir, 0755, true, true);
            }
            try {
                File::copy($file->getRealPath(), $targetDir . DIRECTORY_SEPARATOR . $cleanName);
            } catch (\Throwable $e) {
                // Ignore copy errors if permissions restricted
            }
        }

        Akreditasi::create($validated);

        return redirect()
            ->route('akreditasi.index')
            ->with('success', 'Data sertifikat akreditasi baru berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Akreditasi $akreditasi): View
    {
        $fakultasOptions = [
            'Institusi' => 'Institusi / Universitas',
            'Program Pascasarjana' => 'Program Pascasarjana',
            'Fakultas Ekonomi dan Bisnis' => 'Fakultas Ekonomi dan Bisnis (FEB)',
            'Fakultas Sains dan Teknologi' => 'Fakultas Sains dan Teknologi (FST)',
            'Fakultas Ilmu Kesehatan' => 'Fakultas Ilmu Kesehatan (FIKES)',
        ];

        $lembagaOptions = ['BAN-PT', 'LAM-INFOKOM', 'LAMEMBA', 'LAM-PTKes', 'LAM Teknik', 'Lainnya'];
        $peringkatOptions = ['Unggul', 'Baik Sekali', 'Baik', 'A', 'B', 'C', 'Terakreditasi'];

        return view('pages.akreditasi.edit', compact('akreditasi', 'fakultasOptions', 'lembagaOptions', 'peringkatOptions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Akreditasi $akreditasi): RedirectResponse
    {
        $validated = $request->validate([
            'tingkat' => 'required|in:universitas,fakultas,prodi',
            'kategori_label' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'jenjang' => 'nullable|string|max:50',
            'lembaga' => 'required|string|max:100',
            'peringkat' => 'required|string|max:50',
            'nomor_sk' => 'nullable|string|max:255',
            'tahun_sk' => 'nullable|string|max:20',
            'masa_berlaku' => 'nullable|string|max:100',
            'file_sertifikat' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:20480',
            'urutan' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ], [
            'file_sertifikat.mimes' => 'Format file sertifikat harus berupa PDF, JPG, PNG, atau WEBP.',
            'file_sertifikat.max' => 'Ukuran file sertifikat maksimal 20 MB.',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['urutan'] = (int) ($validated['urutan'] ?? 0);

        // Upload sertifikat file baru jika ada
        if ($request->hasFile('file_sertifikat')) {
            if ($akreditasi->file_sertifikat && Storage::disk('public')->exists($akreditasi->file_sertifikat)) {
                Storage::disk('public')->delete($akreditasi->file_sertifikat);
            }

            $file = $request->file('file_sertifikat');
            $cleanName = time() . '_' . preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $file->getClientOriginalName());
            $storedPath = $file->storeAs('akreditasi', $cleanName, 'public');
            $validated['file_sertifikat'] = $storedPath;

            // Direct copy to public for reliability
            $targetDir = public_path('assets/img/akreditasi');
            if (!File::isDirectory($targetDir)) {
                File::makeDirectory($targetDir, 0755, true, true);
            }
            try {
                File::copy($file->getRealPath(), $targetDir . DIRECTORY_SEPARATOR . $cleanName);
            } catch (\Throwable $e) {
                // Ignore copy errors
            }
        }

        $akreditasi->update($validated);

        return redirect()
            ->route('akreditasi.index')
            ->with('success', 'Data sertifikat akreditasi berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Akreditasi $akreditasi): RedirectResponse
    {
        if ($akreditasi->file_sertifikat && Storage::disk('public')->exists($akreditasi->file_sertifikat)) {
            Storage::disk('public')->delete($akreditasi->file_sertifikat);
        }

        $akreditasi->delete();

        return redirect()
            ->route('akreditasi.index')
            ->with('success', 'Data sertifikat akreditasi berhasil dihapus.');
    }
}
