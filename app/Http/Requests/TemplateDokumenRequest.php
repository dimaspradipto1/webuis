<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TemplateDokumenRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'judul' => ['required', 'string', 'max:255'],
            'tipe_file' => ['nullable', 'string', 'max:50'],
            'link_drive' => ['required', 'string', 'max:1000'],
            'icon_preset' => ['required', 'string', 'in:powerpoint,word,idcard,excel,pdf,custom'],
            'custom_icon' => ['nullable', 'image', 'mimes:png,jpg,jpeg,svg,webp', 'max:20480'],
            'urutan' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable'],
        ];
    }

    public function messages(): array
    {
        return [
            'judul.required' => 'Judul template dokumen wajib diisi.',
            'link_drive.required' => 'Link Google Drive wajib diisi.',
            'custom_icon.image' => 'Ikon kustom harus berupa file gambar.',
            'custom_icon.max' => 'Ukuran ikon maksimal 20 MB.',
        ];
    }
}
