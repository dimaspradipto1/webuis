<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LayananTerkaitRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string', 'max:1000'],
            'url' => ['required', 'string', 'max:500'],
            'logo' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,svg', 'max:20480'],
            'icon' => ['nullable', 'string', 'max:100'],
            'urutan' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama Layanan wajib diisi.',
            'url.required' => 'Tautan / URL wajib diisi.',
            'logo.mimes' => 'Logo harus berupa file bertipe: jpg, jpeg, png, webp, atau svg.',
            'logo.max' => 'Ukuran file logo maksimal 20MB.',
        ];
    }
}
