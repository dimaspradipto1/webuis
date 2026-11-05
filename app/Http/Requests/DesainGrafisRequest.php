<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DesainGrafisRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->has('is_active') ? true : false,
            'urutan' => $this->filled('urutan') ? (int) $this->urutan : 0,
        ]);
    }

    public function rules(): array
    {
        return [
            'judul' => ['required', 'string', 'max:255'],
            'kategori' => ['required', 'string', 'max:100'],
            'badge_teks' => ['nullable', 'string', 'max:150'],
            'spesifikasi' => ['nullable', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'canva_url' => ['nullable', 'url', 'max:1000'],
            'gambar_preview' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:20480'], // maks 20MB
            'warna_gradient' => ['nullable', 'string', 'max:255'],
            'urutan' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'judul.required' => 'Judul templat desain wajib diisi.',
            'judul.max' => 'Judul maksimal 255 karakter.',
            'kategori.required' => 'Kategori lokasi / ruangan wajib dipilih.',
            'canva_url.url' => 'Format tautan Canva URL tidak valid.',
            'gambar_preview.image' => 'File preview harus berupa gambar (JPG, PNG, WEBP, SVG).',
            'gambar_preview.max' => 'Ukuran gambar preview maksimal 20 MB.',
        ];
    }
}
