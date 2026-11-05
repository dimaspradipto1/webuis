<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PusatInformasiHumasRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'judul' => ['nullable', 'string', 'max:255'],
            'gambar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:20480'],
            'link_drive' => ['nullable', 'string', 'max:1000'],
            'button_text' => ['required', 'string', 'max:50'],
            'button_url' => ['nullable', 'string', 'max:1000'],
            'target_blank' => ['nullable'],
            'urutan' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable'],
        ];
    }

    public function messages(): array
    {
        return [
            'button_text.required' => 'Teks tombol wajib diisi (contoh: Lihat / Buka / Akses).',
            'gambar.image' => 'File background harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus jpeg, png, jpg, webp, atau svg.',
            'gambar.max' => 'Ukuran file gambar maksimal 20 MB.',
        ];
    }
}
