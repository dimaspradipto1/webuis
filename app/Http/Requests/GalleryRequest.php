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
            'mode_upload' => ['nullable', 'string', 'in:album,terpisah'],
            'hapus_galeri' => ['nullable', 'array'],
        ];

        if ($this->hasFile('foto') && is_array($this->file('foto'))) {
            $rules['foto'] = ['required', 'array', 'min:1'];
            $rules['foto.*'] = ['image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:20480'];
        } elseif ($this->isMethod('POST')) {
            $rules['foto'] = ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:20480'];
        } else {
            $rules['foto'] = ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:20480'];
        }

        $rules['galeri'] = ['nullable', 'array'];
        $rules['galeri.*'] = ['image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:20480'];

        return $rules;
    }

    public function messages(): array
    {
        return [
            'foto.required' => 'Minimal 1 foto wajib diunggah.',
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Format gambar harus jpeg, png, jpg, gif, svg, atau webp.',
            'foto.max' => 'Ukuran gambar maksimal 20MB.',
            'foto.*.image' => 'Semua file yang dipilih harus berupa gambar.',
            'foto.*.mimes' => 'Format gambar harus jpeg, png, jpg, gif, svg, atau webp.',
            'foto.*.max' => 'Ukuran masing-masing gambar maksimal 20MB.',
            'galeri.*.image' => 'Semua file galeri harus berupa gambar.',
            'galeri.*.max' => 'Ukuran masing-masing gambar maksimal 20MB.',
            'judul.max' => 'Judul maksimal 255 karakter.',
            'kategori.required' => 'Kategori galeri wajib dipilih.',
            'kategori.in' => 'Kategori harus bernilai universitas atau humas.',
        ];
    }
}
