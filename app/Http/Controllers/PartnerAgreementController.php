<?php

namespace App\Http\Controllers;

use App\Http\Requests\PartnerAgreementRequest;
use App\Models\Partner;
use App\Models\PartnerAgreement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PartnerAgreementController extends Controller
{
    public function index(Partner $partner): View
    {
        $agreements = $partner->agreements()
            ->orderBy('urutan')
            ->orderByDesc('id')
            ->get();

        return view('pages.partner-agreements.index', compact('partner', 'agreements'));
    }

    public function create(Partner $partner): View
    {
        $agreement = new PartnerAgreement(['aktif' => true]);

        return view('pages.partner-agreements.create', compact('partner', 'agreement'));
    }

    public function store(PartnerAgreementRequest $request, Partner $partner): RedirectResponse
    {
        $data = $request->validated();
        unset($data['file']);

        if ($request->hasFile('file')) {
            $data['file_path'] = $request->file('file')->store('partner-agreements', 'public');
        }

        $partner->agreements()->create($data);

        alert()->success('Berhasil!', 'Dokumen kerjasama berhasil ditambahkan.');

        return redirect()->route('partner.agreements.index', $partner);
    }

    public function edit(Partner $partner, PartnerAgreement $agreement): View
    {
        $agreement = $partner->agreements()->findOrFail($agreement->id);

        return view('pages.partner-agreements.edit', compact('partner', 'agreement'));
    }

    public function update(PartnerAgreementRequest $request, Partner $partner, PartnerAgreement $agreement): RedirectResponse
    {
        $agreement = $partner->agreements()->findOrFail($agreement->id);
        $data = $request->validated();
        unset($data['file']);
        $previousFilePath = $agreement->file_path;

        if ($request->hasFile('file')) {
            $data['file_path'] = $request->file('file')->store('partner-agreements', 'public');
        }

        $agreement->update($data);

        if ($request->hasFile('file') && $previousFilePath && Storage::disk('public')->exists($previousFilePath)) {
            Storage::disk('public')->delete($previousFilePath);
        }

        alert()->success('Berhasil!', 'Dokumen kerjasama berhasil diperbarui.');

        return redirect()->route('partner.agreements.index', $partner);
    }

    public function destroy(Partner $partner, PartnerAgreement $agreement): RedirectResponse
    {
        $agreement = $partner->agreements()->findOrFail($agreement->id);

        $filePath = $agreement->file_path;
        $agreement->delete();

        if ($filePath && Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }

        alert()->success('Berhasil!', 'Dokumen kerjasama berhasil dihapus.');

        return redirect()->route('partner.agreements.index', $partner);
    }
}
