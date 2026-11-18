<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VisiMisiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isCreate = $this->isMethod('post');

        return [
            'gambar' => [$isCreate ? 'required' : 'nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:5120'],
            'judul' => ['nullable', 'string', 'max:255'],
            'keterangan' => ['nullable', 'string', 'max:1000'],
            'tipe' => ['nullable', 'string', 'max:50'],
            'isi' => ['nullable', 'string'],
            'urutan' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable'],
        ];
    }

    public function messages(): array
    {
        return [
            'gambar.required' => 'File gambar wajib diunggah.',
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus berupa jpeg, png, jpg, webp, atau svg.',
            'gambar.max' => 'Ukuran gambar maksimal 5 MB.',
            'urutan.integer' => 'Urutan harus berupa angka.',
        ];
    }
}
