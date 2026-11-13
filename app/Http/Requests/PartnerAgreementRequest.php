<?php

namespace App\Http\Requests;

use App\Models\PartnerAgreement;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PartnerAgreementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'aktif' => $this->has('aktif'),
            'urutan' => $this->input('urutan') ?? 0,
        ]);
    }

    public function rules(): array
    {
        return [
            'jenis' => ['required', 'string', Rule::in(PartnerAgreement::TYPES)],
            'judul' => ['required', 'string', 'max:255'],
            'nomor' => ['nullable', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string', 'max:10000'],
            'tanggal_mulai' => ['nullable', 'date'],
            'tanggal_selesai' => ['nullable', 'date', 'after_or_equal:tanggal_mulai'],
            'file' => ['nullable', 'file', 'mimes:pdf', 'max:20480'],
            'tautan' => ['nullable', 'url:http,https', 'max:2048'],
            'urutan' => ['nullable', 'integer', 'min:0'],
            'aktif' => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'jenis.required' => 'Jenis dokumen wajib dipilih.',
            'jenis.in' => 'Jenis dokumen harus MOU, MOA, atau IA.',
            'judul.required' => 'Judul kerjasama wajib diisi.',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai tidak boleh sebelum tanggal mulai.',
            'file.mimes' => 'Dokumen kerjasama harus berupa PDF.',
            'file.max' => 'Ukuran dokumen maksimal 20 MB.',
            'tautan.url' => 'Tautan harus berupa URL yang valid.',
            'urutan.integer' => 'Urutan harus berupa angka.',
        ];
    }
}
