<?php

namespace App\Http\Controllers;

use App\Http\Requests\AkademikRequest;
use App\Models\Akademik;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AkademikController extends Controller
{
    /**
     * Default defaults for each academic category
     */
    private array $defaults = [
        'kurikulum' => [
            'judul' => 'Kurikulum & Capaian Pembelajaran',
            'subjudul' => 'Struktur kurikulum berbasis kompetensi dan Outcome-Based Education (OBE) Universitas Ibnu Sina (UIS).',
            'deskripsi' => '<p>Kurikulum Universitas Ibnu Sina dirancang untuk menghasilkan lulusan yang kompeten, berdaya saing global, berjiwa entrepreneur, dan berintegritas tinggi. Mengacu pada Kerangka Kualifikasi Nasional Indonesia (KKNI) serta standar pendidikan tinggi nasional.</p>',
            'link_url' => '',
        ],
        'kalender' => [
            'judul' => 'Kalender Akademik Tahun Akademik 2026/2027',
            'subjudul' => 'Jadwal perkuliahan, registrasi, UTS, UAS, dan kegiatan akademik fakultas.',
            'deskripsi' => '<p>Kalender Akademik memuat seluruh linimasa kegiatan perkuliahan Semester Ganjil dan Genap, termasuk masa registrasi ulang, pengisian KRS, bimbingan akademik, hingga yudisium dan wisuda.</p>',
            'link_url' => '',
        ],
        'pedoman' => [
            'judul' => 'Pedoman & Panduan Akademik Mahasiswa',
            'subjudul' => 'Buku panduan tata tertib, prosedur skripsi, magang/PKL, dan etika akademik.',
            'deskripsi' => '<p>Buku Pedoman Akademik merupakan acuan utama bagi seluruh civitas akademika Universitas Ibnu Sina (UIS) dalam menjalankan aktivitas belajar-mengajar, tata tertib perkuliahan, evaluasi hasil belajar, dan layanan kemahasiswaan.</p>',
            'link_url' => '',
        ],
        'sistem' => [
            'judul' => 'Portal Sistem Informasi Akademik (SIAKAD & E-Learning)',
            'subjudul' => 'Layanan portal digital terpadu untuk pengisian KRS, presensi, nilai, dan pembelajaran online.',
            'deskripsi' => '<p>Sistem Informasi Akademik (SIAKAD) Universitas Ibnu Sina memfasilitasi mahasiswa dan dosen dalam proses administrasi perkuliahan secara daring, cepat, dan transparan.</p>',
            'link_url' => 'https://siakad.uis.ac.id',
        ],
    ];

    /**
     * Helper to get or create record by tipe
     */
    private function getOrCreateItem(string $tipe): Akademik
    {
        $default = $this->defaults[$tipe] ?? [
            'judul' => ucfirst($tipe),
            'subjudul' => '',
            'deskripsi' => '',
            'link_url' => '',
        ];

        return Akademik::firstOrCreate(
            ['tipe' => $tipe],
            [
                'judul' => $default['judul'],
                'subjudul' => $default['subjudul'],
                'deskripsi' => $default['deskripsi'],
                'link_url' => $default['link_url'],
                'is_active' => true,
            ]
        );
    }

    public function kurikulum(): View
    {
        $item = $this->getOrCreateItem('kurikulum');
        $pageTitle = 'Kurikulum';
        $tipe = 'kurikulum';

        return view('pages.akademik.edit', compact('item', 'pageTitle', 'tipe'));
    }

    public function kalender(): View
    {
        $item = $this->getOrCreateItem('kalender');
        $pageTitle = 'Kalender Akademik';
        $tipe = 'kalender';

        return view('pages.akademik.edit', compact('item', 'pageTitle', 'tipe'));
    }

    public function pedoman(): View
    {
        $item = $this->getOrCreateItem('pedoman');
        $pageTitle = 'Pedoman Akademik';
        $tipe = 'pedoman';

        return view('pages.akademik.edit', compact('item', 'pageTitle', 'tipe'));
    }

    public function sistem(): View
    {
        $item = $this->getOrCreateItem('sistem');
        $pageTitle = 'Sistem Akademik';
        $tipe = 'sistem';

        return view('pages.akademik.edit', compact('item', 'pageTitle', 'tipe'));
    }

    public function update(AkademikRequest $request, string $tipe): RedirectResponse
    {
        if (! in_array($tipe, ['kurikulum', 'kalender', 'pedoman', 'sistem'])) {
            abort(404);
        }

        $validated = $request->validated();
        $validated['is_active'] = $request->has('is_active');

        $item = $this->getOrCreateItem($tipe);

        // Upload File Dokumen (PDF dll)
        if ($request->hasFile('file_dokumen')) {
            if ($item->file_dokumen && Storage::disk('public')->exists($item->file_dokumen)) {
                Storage::disk('public')->delete($item->file_dokumen);
            }
            $file = $request->file('file_dokumen');
            $cleanName = time() . '_' . preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $file->getClientOriginalName());
            $validated['file_dokumen'] = $file->storeAs('akademik/dokumen', $cleanName, 'public');
            if (empty($validated['file_nama'])) {
                $validated['file_nama'] = $file->getClientOriginalName();
            }

            // Direct copy to public for reliability
            $targetDir = public_path('assets/dokumen/akademik');
            if (!\Illuminate\Support\Facades\File::isDirectory($targetDir)) {
                \Illuminate\Support\Facades\File::makeDirectory($targetDir, 0755, true, true);
            }
            try {
                \Illuminate\Support\Facades\File::copy($file->getRealPath(), $targetDir . DIRECTORY_SEPARATOR . $cleanName);
            } catch (\Throwable $e) {}
        }

        // Upload Gambar Banner/Cover
        if ($request->hasFile('gambar')) {
            if ($item->gambar && Storage::disk('public')->exists($item->gambar)) {
                Storage::disk('public')->delete($item->gambar);
            }
            $imgFile = $request->file('gambar');
            $imgCleanName = time() . '_' . preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $imgFile->getClientOriginalName());
            $validated['gambar'] = $imgFile->storeAs('akademik/gambar', $imgCleanName, 'public');

            // Direct copy to public for reliability
            $targetDirImg = public_path('assets/img/akademik');
            if (!\Illuminate\Support\Facades\File::isDirectory($targetDirImg)) {
                \Illuminate\Support\Facades\File::makeDirectory($targetDirImg, 0755, true, true);
            }
            try {
                \Illuminate\Support\Facades\File::copy($imgFile->getRealPath(), $targetDirImg . DIRECTORY_SEPARATOR . $imgCleanName);
            } catch (\Throwable $e) {}
        }

        // Handle agenda_items for kalender
        if ($tipe === 'kalender') {
            if ($request->has('agenda_items') && is_array($request->input('agenda_items'))) {
                $filteredItems = [];
                foreach ($request->input('agenda_items') as $agenda) {
                    if (!empty($agenda['kegiatan']) || !empty($agenda['tanggal_mulai'])) {
                        $filteredItems[] = [
                            'semester' => trim($agenda['semester'] ?? 'Ganjil'),
                            'kegiatan' => trim($agenda['kegiatan'] ?? ''),
                            'tanggal_mulai' => trim($agenda['tanggal_mulai'] ?? ''),
                            'tanggal_selesai' => !empty($agenda['tanggal_selesai']) ? trim($agenda['tanggal_selesai']) : trim($agenda['tanggal_mulai'] ?? ''),
                            'kategori' => trim($agenda['kategori'] ?? 'Akademik'),
                            'keterangan' => trim($agenda['keterangan'] ?? ''),
                            'is_active' => isset($agenda['is_active']) && ($agenda['is_active'] === '1' || $agenda['is_active'] === 1 || $agenda['is_active'] === true),
                        ];
                    }
                }
                $validated['agenda_items'] = $filteredItems;
            } elseif ($request->has('agenda_items_json')) {
                $decoded = json_decode($request->input('agenda_items_json'), true);
                if (is_array($decoded)) {
                    $validated['agenda_items'] = $decoded;
                }
            }
        }

        $item->update($validated);

        $routeName = match ($tipe) {
            'kurikulum' => 'akademik.kurikulum',
            'kalender' => 'akademik.kalender',
            'pedoman' => 'akademik.pedoman',
            'sistem' => 'akademik.sistem',
            default => 'akademik.kurikulum',
        };

        return redirect()
            ->route($routeName)
            ->with('success', "Pengaturan data {$this->defaults[$tipe]['judul']} berhasil diperbarui!");
    }
}
