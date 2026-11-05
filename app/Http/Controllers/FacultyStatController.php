<?php

namespace App\Http\Controllers;

use App\DataTables\FacultyStatDataTable;
use App\Models\FacultyStat;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class FacultyStatController extends Controller
{
    /**
     * Tampilkan daftar statistik fakultas via DataTables.
     */
    public function index(FacultyStatDataTable $dataTables)
    {
        return $dataTables->render('pages.faculty-stat.index');
    }

    /**
     * Tampilkan form tambah data statistik.
     */
    public function create(): View
    {
        return view('pages.faculty-stat.create');
    }

    /**
     * Simpan data statistik baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:20480'],
            'background_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:20480'],

            // Tab 1: Mahasiswa
            'tab_1_label' => ['required', 'string', 'max:50'],
            'mhs_total' => ['required', 'integer', 'min:0'],
            'mhs_total_label' => ['required', 'string', 'max:100'],
            'mhs_baru' => ['required', 'integer', 'min:0'],
            'mhs_baru_label' => ['required', 'string', 'max:100'],
            'mhs_alumni' => ['required', 'integer', 'min:0'],
            'mhs_alumni_label' => ['required', 'string', 'max:100'],

            // Tab 2: Prestasi
            'tab_2_label' => ['required', 'string', 'max:50'],
            'prestasi_nasional' => ['required', 'integer', 'min:0'],
            'prestasi_nasional_label' => ['required', 'string', 'max:100'],
            'prestasi_provinsi' => ['required', 'integer', 'min:0'],
            'prestasi_provinsi_label' => ['required', 'string', 'max:100'],
            'prestasi_internasional' => ['required', 'integer', 'min:0'],
            'prestasi_internasional_label' => ['required', 'string', 'max:100'],

            // Tab 3: Kerjasama
            'tab_3_label' => ['required', 'string', 'max:50'],
            'kerjasama_total' => ['required', 'integer', 'min:0'],
            'kerjasama_total_label' => ['required', 'string', 'max:100'],
            'kerjasama_perusahaan' => ['required', 'integer', 'min:0'],
            'kerjasama_perusahaan_label' => ['required', 'string', 'max:100'],
            'kerjasama_pemerintahan' => ['required', 'integer', 'min:0'],
            'kerjasama_pemerintahan_label' => ['required', 'string', 'max:100'],
            'kerjasama_sekolah' => ['required', 'integer', 'min:0'],
            'kerjasama_sekolah_label' => ['required', 'string', 'max:100'],

            'is_active' => ['nullable', 'boolean'],
        ]);

        $data = [
            'title' => $validated['title'],
            'is_active' => $request->has('is_active') ? true : false,

            // Legacy backward-compat
            'jumlah_prodi' => 12,
            'total_mahasiswa' => $validated['mhs_total'],
            'total_dosen' => 0,
            'total_alumni' => $validated['mhs_alumni'],

            // Tab 1: Mahasiswa
            'tab_1_label' => $validated['tab_1_label'],
            'mhs_total' => $validated['mhs_total'],
            'mhs_total_label' => $validated['mhs_total_label'],
            'mhs_baru' => $validated['mhs_baru'],
            'mhs_baru_label' => $validated['mhs_baru_label'],
            'mhs_alumni' => $validated['mhs_alumni'],
            'mhs_alumni_label' => $validated['mhs_alumni_label'],

            // Tab 2: Prestasi
            'tab_2_label' => $validated['tab_2_label'],
            'prestasi_nasional' => $validated['prestasi_nasional'],
            'prestasi_nasional_label' => $validated['prestasi_nasional_label'],
            'prestasi_provinsi' => $validated['prestasi_provinsi'],
            'prestasi_provinsi_label' => $validated['prestasi_provinsi_label'],
            'prestasi_internasional' => $validated['prestasi_internasional'],
            'prestasi_internasional_label' => $validated['prestasi_internasional_label'],

            // Tab 3: Kerjasama
            'tab_3_label' => $validated['tab_3_label'],
            'kerjasama_total' => $validated['kerjasama_total'],
            'kerjasama_total_label' => $validated['kerjasama_total_label'],
            'kerjasama_perusahaan' => $validated['kerjasama_perusahaan'],
            'kerjasama_perusahaan_label' => $validated['kerjasama_perusahaan_label'],
            'kerjasama_pemerintahan' => $validated['kerjasama_pemerintahan'],
            'kerjasama_pemerintahan_label' => $validated['kerjasama_pemerintahan_label'],
            'kerjasama_sekolah' => $validated['kerjasama_sekolah'],
            'kerjasama_sekolah_label' => $validated['kerjasama_sekolah_label'],
        ];

        if ($request->hasFile('background_image')) {
            $data['background_image'] = $request->file('background_image')->store('faculty-stats', 'public');
        }

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('faculty-stats', 'public');
        }

        FacultyStat::create($data);

        alert()->success('Berhasil!', 'Data statistik fakultas berhasil ditambahkan.');

        return redirect()->route('faculty-stat.index');
    }

    /**
     * Tampilkan form edit data statistik.
     */
    public function edit(FacultyStat $facultyStat): View
    {
        return view('pages.faculty-stat.edit', compact('facultyStat'));
    }

    /**
     * Update data statistik fakultas.
     */
    public function update(Request $request, FacultyStat $facultyStat): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:20480'],
            'background_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:20480'],

            // Tab 1: Mahasiswa
            'tab_1_label' => ['required', 'string', 'max:50'],
            'mhs_total' => ['required', 'integer', 'min:0'],
            'mhs_total_label' => ['required', 'string', 'max:100'],
            'mhs_baru' => ['required', 'integer', 'min:0'],
            'mhs_baru_label' => ['required', 'string', 'max:100'],
            'mhs_alumni' => ['required', 'integer', 'min:0'],
            'mhs_alumni_label' => ['required', 'string', 'max:100'],

            // Tab 2: Prestasi
            'tab_2_label' => ['required', 'string', 'max:50'],
            'prestasi_nasional' => ['required', 'integer', 'min:0'],
            'prestasi_nasional_label' => ['required', 'string', 'max:100'],
            'prestasi_provinsi' => ['required', 'integer', 'min:0'],
            'prestasi_provinsi_label' => ['required', 'string', 'max:100'],
            'prestasi_internasional' => ['required', 'integer', 'min:0'],
            'prestasi_internasional_label' => ['required', 'string', 'max:100'],

            // Tab 3: Kerjasama
            'tab_3_label' => ['required', 'string', 'max:50'],
            'kerjasama_total' => ['required', 'integer', 'min:0'],
            'kerjasama_total_label' => ['required', 'string', 'max:100'],
            'kerjasama_perusahaan' => ['required', 'integer', 'min:0'],
            'kerjasama_perusahaan_label' => ['required', 'string', 'max:100'],
            'kerjasama_pemerintahan' => ['required', 'integer', 'min:0'],
            'kerjasama_pemerintahan_label' => ['required', 'string', 'max:100'],
            'kerjasama_sekolah' => ['required', 'integer', 'min:0'],
            'kerjasama_sekolah_label' => ['required', 'string', 'max:100'],

            'jumlah_prodi' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data = [
            'title' => $validated['title'],
            'is_active' => $request->has('is_active') ? true : false,

            // Legacy backward-compat
            'jumlah_prodi' => $validated['jumlah_prodi'] ?? $facultyStat->jumlah_prodi,
            'total_mahasiswa' => $validated['mhs_total'],
            'total_alumni' => $validated['mhs_alumni'],

            // Tab 1: Mahasiswa
            'tab_1_label' => $validated['tab_1_label'],
            'mhs_total' => $validated['mhs_total'],
            'mhs_total_label' => $validated['mhs_total_label'],
            'mhs_baru' => $validated['mhs_baru'],
            'mhs_baru_label' => $validated['mhs_baru_label'],
            'mhs_alumni' => $validated['mhs_alumni'],
            'mhs_alumni_label' => $validated['mhs_alumni_label'],

            // Tab 2: Prestasi
            'tab_2_label' => $validated['tab_2_label'],
            'prestasi_nasional' => $validated['prestasi_nasional'],
            'prestasi_nasional_label' => $validated['prestasi_nasional_label'],
            'prestasi_provinsi' => $validated['prestasi_provinsi'],
            'prestasi_provinsi_label' => $validated['prestasi_provinsi_label'],
            'prestasi_internasional' => $validated['prestasi_internasional'],
            'prestasi_internasional_label' => $validated['prestasi_internasional_label'],

            // Tab 3: Kerjasama
            'tab_3_label' => $validated['tab_3_label'],
            'kerjasama_total' => $validated['kerjasama_total'],
            'kerjasama_total_label' => $validated['kerjasama_total_label'],
            'kerjasama_perusahaan' => $validated['kerjasama_perusahaan'],
            'kerjasama_perusahaan_label' => $validated['kerjasama_perusahaan_label'],
            'kerjasama_pemerintahan' => $validated['kerjasama_pemerintahan'],
            'kerjasama_pemerintahan_label' => $validated['kerjasama_pemerintahan_label'],
            'kerjasama_sekolah' => $validated['kerjasama_sekolah'],
            'kerjasama_sekolah_label' => $validated['kerjasama_sekolah_label'],
        ];

        // Background Image
        if ($request->hasFile('background_image')) {
            if ($facultyStat->background_image && Storage::disk('public')->exists($facultyStat->background_image)) {
                Storage::disk('public')->delete($facultyStat->background_image);
            }
            $data['background_image'] = $request->file('background_image')->store('faculty-stats', 'public');
        } elseif ($request->boolean('remove_background') && ! $request->hasFile('background_image')) {
            if ($facultyStat->background_image && Storage::disk('public')->exists($facultyStat->background_image)) {
                Storage::disk('public')->delete($facultyStat->background_image);
            }
            $data['background_image'] = null;
        }

        // Gambar Pendukung (Opsional)
        if ($request->hasFile('image')) {
            if ($facultyStat->image && Storage::disk('public')->exists($facultyStat->image)) {
                Storage::disk('public')->delete($facultyStat->image);
            }
            $data['image'] = $request->file('image')->store('faculty-stats', 'public');
        } elseif ($request->boolean('remove_image') && ! $request->hasFile('image')) {
            if ($facultyStat->image && Storage::disk('public')->exists($facultyStat->image)) {
                Storage::disk('public')->delete($facultyStat->image);
            }
            $data['image'] = null;
        }

        $facultyStat->update($data);

        alert()->success('Berhasil!', 'Data statistik UIS dan background berhasil diperbarui.');

        return redirect()->route('faculty-stat.index');
    }

    /**
     * Hapus data statistik dan gambarnya.
     */
    public function destroy(FacultyStat $facultyStat): RedirectResponse
    {
        if ($facultyStat->image && Storage::disk('public')->exists($facultyStat->image)) {
            Storage::disk('public')->delete($facultyStat->image);
        }

        $facultyStat->delete();

        alert()->success('Berhasil!', 'Data statistik fakultas berhasil dihapus.');

        return redirect()->route('faculty-stat.index');
    }
}
