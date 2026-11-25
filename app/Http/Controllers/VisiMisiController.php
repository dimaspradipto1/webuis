<?php

namespace App\Http\Controllers;

use App\DataTables\VisiMisiDataTable;
use App\Http\Requests\VisiMisiRequest;
use App\Models\About;
use App\Models\Breadcrumb;
use App\Models\VisiMisi;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class VisiMisiController extends Controller
{
    public function index(): View
    {
        $this->ensureSchemaExists();

        $about = About::firstOrCreate(['id' => 1]);
        $breadcrumb = Breadcrumb::getForPage('visi-misi');

        return view('pages.visimisi.index', compact('about', 'breadcrumb'));
    }

    /**
     * Update konten teks Visi, Misi, Tata Nilai dan Upload Background Utama
     */
    public function updateContent(Request $request): RedirectResponse
    {
        $this->ensureSchemaExists();

        $validated = $request->validate([
            'visimisi_background' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'visimisi_tagline_visi' => ['nullable', 'string', 'max:5000'],
            'visimisi_misi_items' => ['nullable', 'string', 'max:10000'],
            'visimisi_tatanilai_judul' => ['nullable', 'string', 'max:255'],
            'visimisi_tatanilai_items' => ['nullable', 'string', 'max:10000'],
            'visimisi_badge_humas' => ['nullable', 'string', 'max:255'],
            'visimisi_footer_fb' => ['nullable', 'string', 'max:255'],
            'visimisi_footer_ig' => ['nullable', 'string', 'max:255'],
            'visimisi_footer_url' => ['nullable', 'string', 'max:255'],
        ]);

        $about = About::firstOrCreate(['id' => 1]);

        if ($request->hasFile('visimisi_background')) {
            if ($about->visimisi_background) {
                $oldPath = ltrim(preg_replace('#^(public/|storage/)#', '', $about->visimisi_background), '/');
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
                if (file_exists(public_path('storage/' . $oldPath))) {
                    @unlink(public_path('storage/' . $oldPath));
                }
            }
            $validated['visimisi_background'] = $request->file('visimisi_background')->store('visi-misi', 'public');
        } else {
            // PENTING: Jangan overwrite visimisi_background dengan null jika user tidak mengunggah file baru
            unset($validated['visimisi_background']);
        }

        // Simpan juga ke kolom visi dan misi standar About agar sinkron
        if (!empty($validated['visimisi_tagline_visi'])) {
            $validated['visi'] = $validated['visimisi_tagline_visi'];
        }
        if (!empty($validated['visimisi_misi_items'])) {
            $validated['misi'] = $validated['visimisi_misi_items'];
        }

        // Pastikan kolom visimisi_background pasti ada di tabel database jika ada file yang diunggah
        if (isset($validated['visimisi_background']) && !Schema::hasColumn('abouts', 'visimisi_background')) {
            try {
                \Illuminate\Support\Facades\DB::statement("ALTER TABLE `abouts` ADD COLUMN `visimisi_background` VARCHAR(255) NULL AFTER `visimisi_deskripsi`");
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::error('Auto add column visimisi_background failed: ' . $e->getMessage());
            }
        }

        // Hanya simpan field yang benar-benar ada di tabel database untuk mencegah Column not found 1054
        $existingColumns = Schema::getColumnListing('abouts');
        $safeData = array_intersect_key($validated, array_flip($existingColumns));

        // Pastikan visimisi_background pasti disertakan jika baru saja diunggah
        if (isset($validated['visimisi_background']) && Schema::hasColumn('abouts', 'visimisi_background')) {
            $safeData['visimisi_background'] = $validated['visimisi_background'];
        }

        $about->update($safeData);

        alert()->success('Berhasil!', 'Konten teks Visi, Misi, Tata Nilai dan background berhasil disimpan.');

        return redirect()->route('visimisi.index');
    }

    /**
     * Memastikan seluruh kolom kustom Visi & Misi di tabel abouts tersedia secara otomatis
     */
    private function ensureSchemaExists(): void
    {
        if (!Schema::hasTable('abouts')) {
            return;
        }

        $neededColumns = [
            'visimisi_background' => 'VARCHAR(255) NULL',
            'visimisi_tagline_visi' => 'TEXT NULL',
            'visimisi_misi_items' => 'TEXT NULL',
            'visimisi_tatanilai_judul' => 'VARCHAR(255) NULL',
            'visimisi_tatanilai_items' => 'TEXT NULL',
            'visimisi_badge_humas' => 'VARCHAR(255) NULL',
            'visimisi_footer_fb' => 'VARCHAR(255) NULL',
            'visimisi_footer_ig' => 'VARCHAR(255) NULL',
            'visimisi_footer_url' => 'VARCHAR(255) NULL',
        ];

        foreach ($neededColumns as $col => $def) {
            if (!Schema::hasColumn('abouts', $col)) {
                try {
                    \Illuminate\Support\Facades\DB::statement("ALTER TABLE `abouts` ADD COLUMN `{$col}` {$def}");
                } catch (\Throwable $e) {
                    try {
                        Schema::table('abouts', function (Blueprint $table) use ($col, $def) {
                            if (str_starts_with($def, 'TEXT')) {
                                $table->text($col)->nullable();
                            } else {
                                $table->string($col)->nullable();
                            }
                        });
                    } catch (\Throwable $e2) {
                        \Illuminate\Support\Facades\Log::error("Failed to add column {$col} to abouts: " . $e2->getMessage());
                    }
                }
            }
        }
    }

    /**
     * Hapus background utama dan gunakan latar default sistem
     */
    public function deleteBackground(): RedirectResponse
    {
        $about = About::firstOrCreate(['id' => 1]);

        if ($about->visimisi_background) {
            $clean = ltrim(preg_replace('#^(public/|storage/)#', '', $about->visimisi_background), '/');
            if (Storage::disk('public')->exists($clean)) {
                Storage::disk('public')->delete($clean);
            }
            if (file_exists(public_path('storage/' . $clean))) {
                @unlink(public_path('storage/' . $clean));
            }
        }

        $about->visimisi_background = null;
        $about->save();

        alert()->success('Berhasil!', 'Background utama visi misi berhasil direset ke latar standar.');

        return redirect()->route('visimisi.index');
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
