<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaranaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'icon' => ['required', 'string', 'max:100'],
            'nama' => ['required', 'string', 'max:255'],
            'kategori' => ['nullable', 'string', 'max:100'],
            'deskripsi' => ['nullable', 'string', 'max:1000'],
            'galeri' => ['nullable', 'array'],
            'galeri.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:20480'],
            'hapus_galeri' => ['nullable', 'array'],
            'set_main_photo' => ['nullable', 'string'],
            'konten_detail' => ['nullable', 'string'],
            'lokasi' => ['nullable', 'string', 'max:255'],
            'kapasitas' => ['nullable', 'string', 'max:255'],
            'jam_operasional' => ['nullable', 'string', 'max:255'],
            'penanggung_jawab' => ['nullable', 'string', 'max:255'],
            'spesifikasi' => ['nullable', 'string'],
            'urutan' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ];

        if ($this->hasFile('foto') && is_array($this->file('foto'))) {
            $rules['foto'] = ['nullable', 'array'];
            $rules['foto.*'] = ['image', 'mimes:jpg,jpeg,png,webp', 'max:20480'];
        } else {
            $rules['foto'] = ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:20480'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'icon.required' => 'Icon wajib diisi.',
            'icon.max' => 'Nama icon maksimal 100 karakter.',
            'nama.required' => 'Nama sarana wajib diisi.',
            'nama.max' => 'Nama sarana maksimal 255 karakter.',
            'deskripsi.max' => 'Deskripsi maksimal 1000 karakter.',
            'foto.image' => 'Foto harus berupa file gambar.',
            'foto.max' => 'Ukuran foto maksimal 20 MB.',
            'foto.*.image' => 'Semua foto yang diunggah harus berupa file gambar.',
            'foto.*.max' => 'Ukuran masing-masing foto maksimal 20 MB.',
            'galeri.*.image' => 'File galeri harus berupa gambar.',
            'galeri.*.max' => 'Ukuran foto galeri maksimal 20 MB per file.',
            'urutan.integer' => 'Urutan harus berupa angka.',
            'urutan.min' => 'Urutan minimal 0.',
        ];
    }
}
