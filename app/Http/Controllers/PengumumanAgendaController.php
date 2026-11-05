<?php

namespace App\Http\Controllers;

use App\Models\PengumumanAgenda;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PengumumanAgendaController extends Controller
{
    public function index(): View
    {
        $pengumumans = PengumumanAgenda::where('tipe', 'pengumuman')
            ->orderBy('urutan')
            ->orderByDesc('id')
            ->get();

        $agendas = PengumumanAgenda::where('tipe', 'agenda')
            ->orderBy('urutan')
            ->orderByDesc('id')
            ->get();

        return view('pages.pengumuman-agenda.index', compact('pengumumans', 'agendas'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'tipe' => ['required', 'in:pengumuman,agenda'],
            'judul' => ['required', 'string', 'max:500'],
            'waktu' => ['required', 'string', 'max:255'],
            'url' => ['nullable', 'string', 'max:1000'],
            'urutan' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable'],
        ], [
            'judul.required' => 'Judul wajib diisi.',
            'waktu.required' => 'Tanggal / rentang waktu wajib diisi.',
        ]);

        $maxUrutan = PengumumanAgenda::where('tipe', $validated['tipe'])->max('urutan') ?? 0;

        PengumumanAgenda::create([
            'tipe' => $validated['tipe'],
            'judul' => $validated['judul'],
            'waktu' => $validated['waktu'],
            'url' => ! empty($validated['url']) ? trim($validated['url']) : null,
            'urutan' => $validated['urutan'] ?? ($maxUrutan + 1),
            'is_active' => $request->has('is_active'),
        ]);

        $label = $validated['tipe'] === 'agenda' ? 'Agenda' : 'Pengumuman';

        return redirect()
            ->route('pengumuman-agenda.index')
            ->with('success', "{$label} berhasil ditambahkan.");
    }

    public function update(Request $request, PengumumanAgenda $pengumumanAgenda): RedirectResponse
    {
        $validated = $request->validate([
            'tipe' => ['required', 'in:pengumuman,agenda'],
            'judul' => ['required', 'string', 'max:500'],
            'waktu' => ['required', 'string', 'max:255'],
            'url' => ['nullable', 'string', 'max:1000'],
            'urutan' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable'],
        ], [
            'judul.required' => 'Judul wajib diisi.',
            'waktu.required' => 'Tanggal / rentang waktu wajib diisi.',
        ]);

        $pengumumanAgenda->update([
            'tipe' => $validated['tipe'],
            'judul' => $validated['judul'],
            'waktu' => $validated['waktu'],
            'url' => ! empty($validated['url']) ? trim($validated['url']) : null,
            'urutan' => $validated['urutan'] ?? $pengumumanAgenda->urutan,
            'is_active' => $request->has('is_active'),
        ]);

        $label = $validated['tipe'] === 'agenda' ? 'Agenda' : 'Pengumuman';

        return redirect()
            ->route('pengumuman-agenda.index')
            ->with('success', "{$label} berhasil diperbarui.");
    }

    public function destroy(PengumumanAgenda $pengumumanAgenda): RedirectResponse
    {
        $label = $pengumumanAgenda->tipe === 'agenda' ? 'Agenda' : 'Pengumuman';
        $pengumumanAgenda->delete();

        return redirect()
            ->route('pengumuman-agenda.index')
            ->with('success', "{$label} berhasil dihapus.");
    }
}

