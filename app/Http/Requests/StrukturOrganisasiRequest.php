<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StrukturOrganisasiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'url_struktur' => ['required', 'image', 'mimes:png,jpg,jpeg,webp,svg', 'max:20480'],
        ];
    }

    public function messages(): array
    {
        return [
            'url_struktur.required' => 'File gambar struktur organisasi wajib diunggah.',
            'url_struktur.image' => 'File harus berupa gambar.',
            'url_struktur.mimes' => 'Gambar struktur organisasi harus dalam format PNG, JPG, JPEG, WEBP, atau SVG.',
            'url_struktur.max' => 'Ukuran gambar maksimal 20 MB.',
        ];
    }
}
