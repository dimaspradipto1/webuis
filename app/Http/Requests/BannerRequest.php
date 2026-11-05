<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest
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
            'judul' => ['nullable', 'string', 'max:255'],
            'urutan' => ['nullable', 'integer', 'min:0'],
            'aktif' => ['nullable', 'boolean'],
        ];

        if ($this->isMethod('POST')) {
            // Saat create, gambar wajib
            $rules['foto'] = ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:20480'];
        } else {
            // Saat update, gambar opsional
            $rules['foto'] = ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:20480'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'foto.required' => 'Gambar banner wajib diunggah.',
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Format gambar harus jpeg, png, jpg, atau webp.',
            'foto.max' => 'Ukuran gambar banner maksimal 20 MB.',
            'judul.max' => 'Judul maksimal 255 karakter.',
            'urutan.integer' => 'Urutan harus berupa angka.',
            'urutan.min' => 'Urutan minimal 0.',
        ];
    }
}
