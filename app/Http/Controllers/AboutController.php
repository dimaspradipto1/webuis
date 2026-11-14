<?php

namespace App\Http\Controllers;

use App\Http\Requests\AboutRequest;
use App\Models\About;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AboutController extends Controller
{
    /**
     * Profil "Tentang UIS" hanya satu data, jadi menu langsung membuka form sunting.
     */
    public function index(): View
    {
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
        $data = $request->validated();

        if ($request->hasFile('video_file')) {
            $data['video_file'] = $request->file('video_file')->store('about-videos', 'public');
        }

        if (! empty($data['video_url'])) {
            $raw = trim($data['video_url']);
            if (preg_match('/<iframe.*?src=["\']([^"\']+)["\']/i', $raw, $frameMatch)) {
                $raw = $frameMatch[1];
            }
            $data['video_url'] = $raw;
        }

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

        if (! empty($data['video_url'])) {
            $raw = trim($data['video_url']);
            if (preg_match('/<iframe.*?src=["\']([^"\']+)["\']/i', $raw, $frameMatch)) {
                $raw = $frameMatch[1];
            }
            $data['video_url'] = $raw;
        }

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
