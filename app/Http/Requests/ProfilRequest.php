<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfilRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:20480'],
            'nama_perusahaan' => ['nullable', 'string', 'max:255'],
            'nama_pemilik' => ['nullable', 'string', 'max:255'],
            'no_telp' => ['nullable', 'string', 'max:20'],
            'alamat' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'logo.image' => 'Logo harus berupa gambar.',
            'logo.mimes' => 'Format logo harus jpeg, png, jpg, gif, svg, atau webp.',
            'logo.max' => 'Ukuran logo maksimal 20MB.',
            'nama_perusahaan.max' => 'Nama perusahaan maksimal 255 karakter.',
            'nama_pemilik.max' => 'Nama pemilik maksimal 255 karakter.',
            'no_telp.max' => 'Nomor telepon maksimal 20 karakter.',
        ];
    }
}
