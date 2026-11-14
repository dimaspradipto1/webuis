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

        $partner->agreements()->create($data);

        alert()->success('Berhasil!', 'Data kerjasama berhasil ditambahkan.');

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

        $agreement->update($data);

        alert()->success('Berhasil!', 'Data kerjasama berhasil diperbarui.');

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

        alert()->success('Berhasil!', 'Data kerjasama berhasil dihapus.');

        return redirect()->route('partner.agreements.index', $partner);
    }
}
