<?php

namespace App\Http\Controllers;

use App\Http\Requests\AboutRequest;
use App\Models\About;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AboutController extends Controller
{
    /**
     * Pastikan kolom dokumen profil otomatis dibuat jika belum ada di database (misal di cPanel / hosting).
     */
    private function ensureDokumenColumnsExist(): void
    {
        try {
            if (! Schema::hasTable('abouts')) {
                return;
            }

            $neededColumns = [
                'dokumen_file' => 'VARCHAR(255) NULL',
                'dokumen_nama' => 'VARCHAR(255) NULL',
                'dokumen_link' => 'VARCHAR(1000) NULL',
            ];

            foreach ($neededColumns as $col => $def) {
                if (! Schema::hasColumn('abouts', $col)) {
                    try {
                        DB::statement("ALTER TABLE `abouts` ADD COLUMN `{$col}` {$def}");
                    } catch (\Throwable $e) {
                        try {
                            Schema::table('abouts', function (Blueprint $table) use ($col) {
                                if ($col === 'dokumen_link') {
                                    $table->string($col, 1000)->nullable();
                                } else {
                                    $table->string($col)->nullable();
                                }
                            });
                        } catch (\Throwable $e2) {
                            Log::error("Failed to add column {$col} to abouts: " . $e2->getMessage());
                        }
                    }
                }
            }
        } catch (\Throwable $ex) {
            Log::error("ensureDokumenColumnsExist error: " . $ex->getMessage());
        }
    }

    /**
     * Profil "Tentang UIS" hanya satu data, jadi menu langsung membuka form sunting.
     */
    public function index(): View
    {
        $this->ensureDokumenColumnsExist();
        $about = $this->singleton();

        return view('pages.about.edit', compact('about'));
    }

    public function create(): RedirectResponse
    {
        return redirect()->route('about.index');
    }

    public function show(About $about): RedirectResponse
    {
        return redirect()->route('about.index');
    }

    /**
     * Ambil satu-satunya data profil; buat data kosong bila belum ada.
     */
    private function singleton(): About
    {
        return About::orderBy('id')->first()
            ?? About::create(['judul_profil' => 'UNIVERSITAS IBNU SINA']);
    }

    public function store(AboutRequest $request): RedirectResponse
    {
        $this->ensureDokumenColumnsExist();
        $data = $request->validated();

        if ($request->hasFile('video_file')) {
            $data['video_file'] = $request->file('video_file')->store('about-videos', 'public');
        }

        if ($request->hasFile('dokumen_file')) {
            $data['dokumen_file'] = $request->file('dokumen_file')->store('about-documents', 'public');
        }

        if (! empty($data['video_url'])) {
            $raw = trim($data['video_url']);
            if (preg_match('/<iframe.*?src=["\']([^"\']+)["\']/i', $raw, $frameMatch)) {
                $raw = $frameMatch[1];
            }
            $data['video_url'] = $raw;
        }

        // Filter kolom agar tidak error jika ada kolom yang belum ada di database
        $existingColumns = Schema::getColumnListing('abouts');
        $data = array_intersect_key($data, array_flip($existingColumns));

        About::create($data);

        return redirect()
            ->route('about.index')
            ->with('success', 'Data Profil Tentang Kami berhasil ditambahkan.');
    }

    public function edit(About $about): RedirectResponse
    {
        return redirect()->route('about.index');
    }

    public function update(AboutRequest $request, About $about): RedirectResponse
    {
        $this->ensureDokumenColumnsExist();
        $data = $request->validated();

        // Hapus video file jika diminta
        if ($request->boolean('delete_video_file')) {
            if ($about->video_file && Storage::disk('public')->exists($about->video_file)) {
                Storage::disk('public')->delete($about->video_file);
            }
            $data['video_file'] = null;
        }

        if ($request->hasFile('video_file')) {
            if ($about->video_file && Storage::disk('public')->exists($about->video_file)) {
                Storage::disk('public')->delete($about->video_file);
            }
            $data['video_file'] = $request->file('video_file')->store('about-videos', 'public');
        }

        // Hapus file dokumen jika diminta
        if ($request->boolean('delete_dokumen_file')) {
            if ($about->dokumen_file && Storage::disk('public')->exists($about->dokumen_file)) {
                Storage::disk('public')->delete($about->dokumen_file);
            }
            $data['dokumen_file'] = null;
        }

        if ($request->hasFile('dokumen_file')) {
            if ($about->dokumen_file && Storage::disk('public')->exists($about->dokumen_file)) {
                Storage::disk('public')->delete($about->dokumen_file);
            }
            $data['dokumen_file'] = $request->file('dokumen_file')->store('about-documents', 'public');
        }

        if (! empty($data['video_url'])) {
            $raw = trim($data['video_url']);
            if (preg_match('/<iframe.*?src=["\']([^"\']+)["\']/i', $raw, $frameMatch)) {
                $raw = $frameMatch[1];
            }
            $data['video_url'] = $raw;
        }

        // Filter kolom agar tidak error jika ada kolom yang belum ada di database
        $existingColumns = Schema::getColumnListing('abouts');
        $data = array_intersect_key($data, array_flip($existingColumns));

        $about->update($data);

        return redirect()
            ->route('about.index')
            ->with('success', 'Data Profil Tentang Kami berhasil diperbarui.');
    }

    public function destroy(About $about): RedirectResponse
    {
        // Profil tunggal tidak dihapus agar halaman Tentang UIS tidak kosong
        return redirect()->route('about.index');
    }
}
