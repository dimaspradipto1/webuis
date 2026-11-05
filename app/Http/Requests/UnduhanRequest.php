<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UnduhanRequest extends FormRequest
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
            'kategori' => ['required', 'in:image,video,audio,template'],
            'file' => ['nullable', 'file', 'max:102400'], // maks 100MB
            'file_url' => ['nullable', 'url', 'max:1000'],
            'file_size' => ['nullable', 'string', 'max:50'],
            'deskripsi' => ['nullable', 'string'],
            'urutan' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'judul.required' => 'Judul item unduhan wajib diisi.',
            'judul.max' => 'Judul maksimal 255 karakter.',
            'kategori.required' => 'Kategori unduhan wajib dipilih.',
            'kategori.in' => 'Pilihan kategori harus salah satu dari: Image, Video, Audio, atau Template.',
            'file.file' => 'Berkas harus berupa file yang valid.',
            'file.max' => 'Ukuran file maksimal 100 MB.',
            'file_url.url' => 'Format URL unduhan eksternal tidak valid.',
            'urutan.integer' => 'Urutan harus berupa angka.',
        ];
    }
}
