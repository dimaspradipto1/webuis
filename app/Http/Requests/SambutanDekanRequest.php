<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SambutanDekanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_dekan' => ['nullable', 'string', 'max:255'],
            'jabatan_dekan' => ['nullable', 'string', 'max:255'],
            'foto_dekan' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:20480'],
            'kutipan_singkat' => ['nullable', 'string'],
            'sambutan_dekan' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'foto_dekan.image' => 'File harus berupa gambar.',
            'foto_dekan.mimes' => 'Format gambar yang diperbolehkan: JPEG, PNG, JPG, WEBP.',
            'foto_dekan.max' => 'Ukuran foto maksimal 20 MB.',
        ];
    }
}
