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
        return [
            'icon' => ['required', 'string', 'max:100'],
            'nama' => ['required', 'string', 'max:200'],
            'kategori' => ['nullable', 'string', 'max:100'],
            'deskripsi' => ['nullable', 'string', 'max:1000'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:20480'],
            'galeri' => ['nullable', 'array'],
            'galeri.*' => ['image', 'mimes:jpeg,png,jpg,webp,svg', 'max:20480'],
            'konten_detail' => ['nullable', 'string'],
            'lokasi' => ['nullable', 'string', 'max:255'],
            'kapasitas' => ['nullable', 'string', 'max:150'],
            'jam_operasional' => ['nullable', 'string', 'max:150'],
            'penanggung_jawab' => ['nullable', 'string', 'max:150'],
            'spesifikasi' => ['nullable', 'string'],
            'urutan' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'icon.required' => 'Icon Bootstrap wajib diisi.',
            'nama.required' => 'Nama sarana / laboratorium wajib diisi.',
            'foto.image' => 'Foto utama harus berupa berkas gambar.',
            'foto.max' => 'Ukuran foto utama maksimal 20 MB.',
            'galeri.*.image' => 'Setiap foto galeri harus berupa berkas gambar.',
            'galeri.*.max' => 'Ukuran foto galeri maksimal 20 MB per file.',
        ];
    }
}
