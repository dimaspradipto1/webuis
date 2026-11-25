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

        // Berikan nilai awal default jika data teks masih kosong agar editor langsung terisi
        $dirty = false;
        if (empty(trim(strip_tags($about->visimisi_tagline_visi ?? '')))) {
            $about->visimisi_tagline_visi = '<p>Unggul, Berintegritas, Berjiwa Entrepreneurship</p>';
            $dirty = true;
        }
        if (empty(trim(strip_tags($about->visimisi_misi_items ?? '')))) {
            $about->visimisi_misi_items = "<ol>\n<li>Menyelenggarakan pendidikan tinggi yang unggul dengan mengintegrasikan nilai-nilai integritas dan kewirausahaan dalam proses pembelajaran, penelitian, dan pengabdian kepada Masyarakat.</li>\n<li>Mengembangkan penelitian inovatif dan relevan yang berkontribusi pada kemajuan ilmu pengetahuan, teknologi, dan pemecahan masalah di masyarakat.</li>\n<li>Membangun ekosistem kewirausahaan yang mendorong kreativitas, inovasi, dan kemandirian di kalangan civitas akademika dan masyarakat luas.</li>\n<li>Menerapkan tata kelola universitas yang kredibel, transparan, akuntabel, bertanggungjawab dan berintegritas tinggi untuk mendukung pencapaian keunggulan institusi.</li>\n<li>Menjalin kerjasama strategis dengan berbagai pemangku kepentingan untuk meningkatkan daya saing, reputasi, dan kontribusi universitas di tingkat nasional dan internasional.</li>\n</ol>";
            $dirty = true;
        }
        if (empty(trim(strip_tags($about->visimisi_tatanilai_items ?? '')))) {
            $about->visimisi_tatanilai_items = "<p><strong>(C) CERDAS:</strong> Spiritual, intelektual dan emosional</p>\n<p><strong>(I) INTEGRITAS:</strong> Jujur, disiplin, Komitmen dan bertanggung jawab</p>\n<p><strong>(P) PROFESIONAL:</strong> Objektif, Adil dan Transparan</p>";
            $dirty = true;
        }
        if (empty($about->visimisi_tatanilai_judul)) {
            $about->visimisi_tatanilai_judul = 'TATA NILAI UIS "CIP"';
            $dirty = true;
        }
        if ($dirty) {
            $about->save();
        }

        $breadcrumb = Breadcrumb::getForPage('visi-misi');

        return view('pages.visimisi.index', compact('about', 'breadcrumb'));
    }

    /**
     * Upload dan simpan khusus Background Utama dan Spacing Visi Misi
     */
    public function updateBackground(Request $request): RedirectResponse
    {
        $this->ensureSchemaExists();

        $validated = $request->validate([
            'visimisi_background' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'visimisi_padding_top' => ['nullable', 'integer', 'min:0', 'max:500'],
            'visimisi_padding_bottom' => ['nullable', 'integer', 'min:0', 'max:500'],
        ]);

        $about = About::firstOrCreate(['id' => 1]);
        $updateData = [];

        if ($request->has('visimisi_padding_top')) {
            $updateData['visimisi_padding_top'] = $request->input('visimisi_padding_top');
        }
        if ($request->has('visimisi_padding_bottom')) {
            $updateData['visimisi_padding_bottom'] = $request->input('visimisi_padding_bottom');
        }

        if ($request->hasFile('visimisi_background')) {
            $file = $request->file('visimisi_background');
            $ext = strtolower($file->getClientOriginalExtension() ?: 'jpg');
            $filename = 'visimisi_bg_' . time() . '_' . uniqid() . '.' . $ext;

            // 1. Simpan ke Storage disk public standar Laravel
            $storedPath = $file->storeAs('visi-misi', $filename, 'public');

            // 2. Simpan juga langsung ke public/assets/img/ agar 100% langsung bisa diakses tanpa ketergantungan symlink storage
            try {
                $publicImgDir = public_path('assets/img');
                if (!file_exists($publicImgDir)) {
                    @mkdir($publicImgDir, 0755, true);
                }
                @copy($file->getRealPath(), $publicImgDir . '/' . $filename);
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::warning('Copy visimisi bg to assets/img failed: ' . $e->getMessage());
            }

            // 3. Simpan juga ke public/storage/visi-misi jika folder public/storage ada
            try {
                $publicStorageDir = public_path('storage/visi-misi');
                if (!file_exists($publicStorageDir)) {
                    @mkdir($publicStorageDir, 0755, true);
                }
                @copy($file->getRealPath(), $publicStorageDir . '/' . $filename);
            } catch (\Throwable $e) {}

            // Hapus file lama jika ada
            if ($about->visimisi_background) {
                $oldRaw = $about->visimisi_background;
                $oldClean = ltrim(preg_replace('#^(public/|storage/)#', '', $oldRaw), '/');
                $oldBase = basename($oldClean);

                try {
                    if (Storage::disk('public')->exists($oldClean)) {
                        Storage::disk('public')->delete($oldClean);
                    }
                    if (file_exists(public_path('storage/' . $oldClean))) {
                        @unlink(public_path('storage/' . $oldClean));
                    }
                    if (file_exists(public_path('assets/img/' . $oldBase))) {
                        @unlink(public_path('assets/img/' . $oldBase));
                    }
                } catch (\Throwable $e) {}
            }

            $updateData['visimisi_background'] = $filename;
        }

        if (!empty($updateData)) {
            $about->update($updateData);
        }

        alert()->success('Berhasil!', 'Pengaturan background dan jarak margin banner berhasil disimpan.');
        return redirect()->route('visimisi.index');
    }

    /**
     * Update konten teks Visi, Misi, Tata Nilai dan Upload Background Utama
     */
    public function updateContent(Request $request): RedirectResponse
    {
        $this->ensureSchemaExists();

        $validated = $request->validate([
            'visimisi_background' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'visimisi_padding_top' => ['nullable', 'integer', 'min:0', 'max:500'],
            'visimisi_padding_bottom' => ['nullable', 'integer', 'min:0', 'max:500'],
            'visimisi_tagline_visi' => ['nullable', 'string', 'max:5000'],
            'visimisi_misi_items' => ['nullable', 'string', 'max:10000'],
            'visimisi_tatanilai_judul' => ['nullable', 'string', 'max:255'],
            'visimisi_tatanilai_items' => ['nullable', 'string', 'max:10000'],
            'visimisi_badge_humas' => ['nullable', 'string', 'max:255'],
            'visimisi_footer_fb' => ['nullable', 'string', 'max:255'],
            'visimisi_footer_ig' => ['nullable', 'string', 'max:255'],
            'visimisi_footer_url' => ['nullable', 'string', 'max:255'],
        ]);

        if (!empty($validated['visimisi_footer_url'])) {
            $url = trim($validated['visimisi_footer_url']);
            if (!preg_match('#^https?://#i', $url)) {
                $validated['visimisi_footer_url'] = 'https://' . ltrim($url, '/');
            } else {
                $validated['visimisi_footer_url'] = $url;
            }
        }

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
            'visimisi_padding_top' => 'INT NULL DEFAULT 50',
            'visimisi_padding_bottom' => 'INT NULL DEFAULT 70',
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
            $raw = $about->visimisi_background;
            $clean = ltrim(preg_replace('#^(public/|storage/)#', '', $raw), '/');
            $base = basename($clean);

            try {
                if (Storage::disk('public')->exists($clean)) {
                    Storage::disk('public')->delete($clean);
                }
                if (file_exists(public_path('storage/' . $clean))) {
                    @unlink(public_path('storage/' . $clean));
                }
                if (file_exists(public_path('assets/img/' . $base))) {
                    @unlink(public_path('assets/img/' . $base));
                }
            } catch (\Throwable $e) {}
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
