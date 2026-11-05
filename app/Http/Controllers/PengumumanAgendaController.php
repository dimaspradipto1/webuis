<?php

namespace App\Http\Controllers;

use App\Models\PengumumanAgenda;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PengumumanAgendaController extends Controller
{
    public function index(Request $request): View
    {
        $selectedTipe = $request->query('tipe', '');

        $pengumumans = PengumumanAgenda::where('tipe', 'pengumuman')
            ->orderBy('urutan')
            ->orderByDesc('id')
            ->get();

        $agendas = PengumumanAgenda::where('tipe', 'agenda')
            ->orderBy('urutan')
            ->orderByDesc('id')
            ->get();

        return view('pages.pengumuman-agenda.index', compact('pengumumans', 'agendas', 'selectedTipe'));
    }

    public function create(Request $request): View
    {
        $defaultTipe = $request->query('tipe', 'pengumuman');
        $nextUrutan = (PengumumanAgenda::where('tipe', $defaultTipe)->max('urutan') ?? 0) + 1;

        return view('pages.pengumuman-agenda.create', compact('defaultTipe', 'nextUrutan'));
    }

    public function store(Request $request): RedirectResponse
    {
        $rules = [
            'tipe' => ['required', 'in:pengumuman,agenda'],
            'judul' => ['required', 'string', 'max:500'],
            'waktu' => ['required', 'string', 'max:255'],
            'lokasi' => ['nullable', 'string', 'max:255'],
            'konten' => ['nullable', 'string'],
            'url' => ['nullable', 'string', 'max:1000'],
            'file_lampiran' => ['nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar,jpg,jpeg,png', 'max:102400'],
            'urutan' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable'],
        ];

        if ($request->hasFile('foto') && is_array($request->file('foto'))) {
            $rules['foto'] = ['nullable', 'array'];
            $rules['foto.*'] = ['image', 'mimes:jpg,jpeg,png,webp,gif', 'max:20480'];
        } else {
            $rules['foto'] = ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:20480'];
        }

        $validated = $request->validate($rules, [
            'judul.required' => 'Judul wajib diisi.',
            'waktu.required' => 'Tanggal / rentang waktu wajib diisi.',
            'foto.*.image' => 'Semua foto harus berupa file gambar.',
            'foto.*.max' => 'Ukuran masing-masing foto maksimal 20 MB.',
            'file_lampiran.max' => 'Ukuran file lampiran maksimal 100 MB.',
        ]);

        $uploadedPhotos = [];
        if ($request->hasFile('foto')) {
            $files = is_array($request->file('foto')) ? $request->file('foto') : [$request->file('foto')];
            foreach ($files as $file) {
                $uploadedPhotos[] = $file->store('pengumuman-agenda', 'public');
            }
        }

        $lampiranPath = null;
        if ($request->hasFile('file_lampiran')) {
            $lampiranPath = $request->file('file_lampiran')->store('pengumuman-agenda/lampiran', 'public');
        }

        $maxUrutan = PengumumanAgenda::where('tipe', $validated['tipe'])->max('urutan') ?? 0;

        PengumumanAgenda::create([
            'tipe' => $validated['tipe'],
            'judul' => $validated['judul'],
            'waktu' => $validated['waktu'],
            'lokasi' => $validated['lokasi'] ?? null,
            'konten' => $validated['konten'] ?? null,
            'foto' => $uploadedPhotos[0] ?? null,
            'galeri' => ! empty($uploadedPhotos) ? $uploadedPhotos : null,
            'file_lampiran' => $lampiranPath,
            'url' => ! empty($validated['url']) ? trim($validated['url']) : null,
            'urutan' => $validated['urutan'] ?? ($maxUrutan + 1),
            'is_active' => $request->boolean('is_active', true),
        ]);

        $label = $validated['tipe'] === 'agenda' ? 'Agenda' : 'Pengumuman';
        alert()->success('Berhasil!', "{$label} berhasil ditambahkan.");

        return redirect()->route('pengumuman-agenda.index');
    }

    public function edit(PengumumanAgenda $pengumumanAgenda): View
    {
        return view('pages.pengumuman-agenda.edit', compact('pengumumanAgenda'));
    }

    public function update(Request $request, PengumumanAgenda $pengumumanAgenda): RedirectResponse
    {
        $rules = [
            'tipe' => ['required', 'in:pengumuman,agenda'],
            'judul' => ['required', 'string', 'max:500'],
            'waktu' => ['required', 'string', 'max:255'],
            'lokasi' => ['nullable', 'string', 'max:255'],
            'konten' => ['nullable', 'string'],
            'url' => ['nullable', 'string', 'max:1000'],
            'file_lampiran' => ['nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar,jpg,jpeg,png', 'max:102400'],
            'hapus_galeri' => ['nullable', 'array'],
            'set_main_photo' => ['nullable', 'string'],
            'hapus_lampiran' => ['nullable', 'boolean'],
            'urutan' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable'],
        ];

        if ($request->hasFile('foto') && is_array($request->file('foto'))) {
            $rules['foto'] = ['nullable', 'array'];
            $rules['foto.*'] = ['image', 'mimes:jpg,jpeg,png,webp,gif', 'max:20480'];
        } else {
            $rules['foto'] = ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:20480'];
        }

        $validated = $request->validate($rules, [
            'judul.required' => 'Judul wajib diisi.',
            'waktu.required' => 'Tanggal / rentang waktu wajib diisi.',
            'foto.*.image' => 'Semua foto harus berupa file gambar.',
            'foto.*.max' => 'Ukuran masing-masing foto maksimal 20 MB.',
            'file_lampiran.max' => 'Ukuran file lampiran maksimal 100 MB.',
        ]);

        $existingGaleri = is_array($pengumumanAgenda->galeri) ? $pengumumanAgenda->galeri : [];
        if (! empty($pengumumanAgenda->foto) && ! in_array($pengumumanAgenda->foto, $existingGaleri, true)) {
            array_unshift($existingGaleri, $pengumumanAgenda->foto);
        }

        // Hapus foto yang dicentang
        $toDelete = $request->input('hapus_galeri', []);
        if (! empty($toDelete) && is_array($toDelete)) {
            foreach ($toDelete as $delPath) {
                if (Storage::disk('public')->exists($delPath)) {
                    Storage::disk('public')->delete($delPath);
                }
                $existingGaleri = array_values(array_filter($existingGaleri, fn ($p) => $p !== $delPath));
            }
        }

        // Tambah foto baru
        $newPhotos = [];
        if ($request->hasFile('foto')) {
            $files = is_array($request->file('foto')) ? $request->file('foto') : [$request->file('foto')];
            foreach ($files as $file) {
                $newPhotos[] = $file->store('pengumuman-agenda', 'public');
            }
        }

        $mergedGaleri = array_values(array_unique(array_merge($existingGaleri, $newPhotos)));

        $mainFoto = $pengumumanAgenda->foto;
        if (! empty($toDelete) && in_array($mainFoto, $toDelete, true)) {
            $mainFoto = $mergedGaleri[0] ?? null;
        }
        if ($request->filled('set_main_photo') && in_array($request->input('set_main_photo'), $mergedGaleri, true)) {
            $mainFoto = $request->input('set_main_photo');
        } elseif (empty($mainFoto) && ! empty($mergedGaleri)) {
            $mainFoto = $mergedGaleri[0];
        }

        // Kelola file lampiran
        $lampiranPath = $pengumumanAgenda->file_lampiran;
        if ($request->boolean('hapus_lampiran') && $lampiranPath) {
            if (Storage::disk('public')->exists($lampiranPath)) {
                Storage::disk('public')->delete($lampiranPath);
            }
            $lampiranPath = null;
        }
        if ($request->hasFile('file_lampiran')) {
            if ($lampiranPath && Storage::disk('public')->exists($lampiranPath)) {
                Storage::disk('public')->delete($lampiranPath);
            }
            $lampiranPath = $request->file('file_lampiran')->store('pengumuman-agenda/lampiran', 'public');
        }

        $pengumumanAgenda->update([
            'tipe' => $validated['tipe'],
            'judul' => $validated['judul'],
            'waktu' => $validated['waktu'],
            'lokasi' => $validated['lokasi'] ?? null,
            'konten' => $validated['konten'] ?? null,
            'foto' => $mainFoto,
            'galeri' => ! empty($mergedGaleri) ? $mergedGaleri : null,
            'file_lampiran' => $lampiranPath,
            'url' => ! empty($validated['url']) ? trim($validated['url']) : null,
            'urutan' => $validated['urutan'] ?? $pengumumanAgenda->urutan,
            'is_active' => $request->boolean('is_active'),
        ]);

        $label = $validated['tipe'] === 'agenda' ? 'Agenda' : 'Pengumuman';
        alert()->success('Berhasil!', "{$label} berhasil diperbarui.");

        return redirect()->route('pengumuman-agenda.index');
    }

    public function destroy(PengumumanAgenda $pengumumanAgenda): RedirectResponse
    {
        if ($pengumumanAgenda->foto && Storage::disk('public')->exists($pengumumanAgenda->foto)) {
            Storage::disk('public')->delete($pengumumanAgenda->foto);
        }
        if (! empty($pengumumanAgenda->galeri) && is_array($pengumumanAgenda->galeri)) {
            foreach ($pengumumanAgenda->galeri as $gImg) {
                if ($gImg && Storage::disk('public')->exists($gImg)) {
                    Storage::disk('public')->delete($gImg);
                }
            }
        }
        if ($pengumumanAgenda->file_lampiran && Storage::disk('public')->exists($pengumumanAgenda->file_lampiran)) {
            Storage::disk('public')->delete($pengumumanAgenda->file_lampiran);
        }

        $label = $pengumumanAgenda->tipe === 'agenda' ? 'Agenda' : 'Pengumuman';
        $pengumumanAgenda->delete();

        alert()->success('Berhasil!', "{$label} berhasil dihapus.");

        return redirect()->route('pengumuman-agenda.index');
    }
}
