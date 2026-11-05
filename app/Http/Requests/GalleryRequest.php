<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GalleryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'judul' => ['nullable', 'string', 'max:255'],
            'kategori' => ['required', 'string', 'in:universitas,humas'],
            'deskripsi' => ['nullable', 'string'],
        ];

        if ($this->isMethod('POST')) {
            $rules['foto'] = ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:20480'];
        } else {
            $rules['foto'] = ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:20480'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'foto.required' => 'Foto wajib diunggah.',
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Format gambar harus jpeg, png, jpg, gif, svg, atau webp.',
            'foto.max' => 'Ukuran gambar maksimal 20MB.',
            'judul.max' => 'Judul maksimal 255 karakter.',
            'kategori.required' => 'Kategori galeri wajib dipilih.',
            'kategori.in' => 'Kategori harus bernilai universitas atau humas.',
        ];
    }
}
