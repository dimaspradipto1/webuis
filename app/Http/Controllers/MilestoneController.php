<?php

namespace App\Http\Controllers;

use App\DataTables\MilestoneDataTable;
use App\Http\Requests\MilestoneRequest;
use App\Models\About;
use App\Models\Milestone;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MilestoneController extends Controller
{
    public function index(MilestoneDataTable $dataTable)
    {
        $about = About::first();

        return $dataTable->render('pages.milistone.index', compact('about'));
    }

    public function updateSetting(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'sejarah_label' => ['nullable', 'string', 'max:255'],
            'sejarah_judul' => ['nullable', 'string', 'max:255'],
            'sejarah_judul_highlight' => ['nullable', 'string', 'max:255'],
            'sejarah_deskripsi_1' => ['nullable', 'string'],
            'sejarah_deskripsi_2' => ['nullable', 'string'],
            'sejarah_card_judul' => ['nullable', 'string', 'max:255'],
            'sejarah_card_subjudul' => ['nullable', 'string', 'max:255'],
            'sejarah_card_narasi' => ['nullable', 'string'],
            'sejarah_pilar_1' => ['nullable', 'string', 'max:100'],
            'sejarah_pilar_2' => ['nullable', 'string', 'max:100'],
            'sejarah_pilar_3' => ['nullable', 'string', 'max:100'],
        ]);

        $about = About::first();
        if ($about) {
            $about->update($validated);
        } else {
            About::create($validated);
        }

        return redirect()
            ->route('milestone.index')
            ->with('success', 'Pengaturan Narasi Sejarah berhasil diperbarui.');
    }

    public function create(): View
    {
        return view('pages.milistone.create');
    }

    public function store(MilestoneRequest $request): RedirectResponse
    {
        Milestone::create($request->validated());

        return redirect()
            ->route('milestone.index')
            ->with('success', 'Milestone berhasil ditambahkan.');
    }

    public function edit(Milestone $milestone): View
    {
        return view('pages.milistone.edit', compact('milestone'));
    }

    public function update(MilestoneRequest $request, Milestone $milestone): RedirectResponse
    {
        $milestone->update($request->validated());

        return redirect()
            ->route('milestone.index')
            ->with('success', 'Milestone berhasil diperbarui.');
    }

    public function destroy(Milestone $milestone): RedirectResponse
    {
        $milestone->delete();

        return redirect()
            ->route('milestone.index')
            ->with('success', 'Milestone berhasil dihapus.');
    }
}
