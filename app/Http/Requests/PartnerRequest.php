<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PartnerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'aktif' => $this->has('aktif') ? true : false,
        ]);
    }

    public function rules(): array
    {
        $rules = [
            'nama' => ['required', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:20480'],
            'urutan' => ['nullable', 'integer', 'min:0'],
            'aktif' => ['nullable', 'boolean'],
        ];

        if ($this->isMethod('POST')) {
            $rules['perjanjian_jenis'] = ['nullable', 'string', 'in:MOU,MOA,IA'];
            $rules['perjanjian_judul'] = ['nullable', 'string', 'max:5000'];
            $rules['perjanjian_nomor'] = ['nullable', 'string', 'max:255'];
            $rules['perjanjian_deskripsi'] = ['nullable', 'string', 'max:10000'];
            $rules['perjanjian_tanggal_mulai'] = ['nullable', 'date'];
            $rules['perjanjian_tanggal_selesai'] = ['nullable', 'date', 'after_or_equal:perjanjian_tanggal_mulai'];
            $rules['perjanjian_aktif'] = ['nullable', 'boolean'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama mitra kerjasama wajib diisi.',
            'nama.max' => 'Nama maksimal 255 karakter.',
            'logo.image' => 'File harus berupa gambar.',
            'logo.mimes' => 'Format gambar harus jpeg, png, jpg, webp, atau svg.',
            'logo.max' => 'Ukuran file logo maksimal 20 MB.',
            'urutan.integer' => 'Urutan harus berupa angka.',
            'perjanjian_tanggal_selesai.after_or_equal' => 'Tanggal selesai perjanjian tidak boleh sebelum tanggal mulai.',
        ];
    }
}
