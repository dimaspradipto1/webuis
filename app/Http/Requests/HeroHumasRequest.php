<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HeroHumasRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'judul' => ['nullable', 'string', 'max:255'],
            'subjudul' => ['nullable', 'string', 'max:500'],
            'badge_text' => ['nullable', 'string', 'max:100'],
            'background_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:20480'],
            'pill_text_1' => ['nullable', 'string', 'max:255'],
            'pill_url_1' => ['nullable', 'string', 'max:500'],
            'pill_text_2' => ['nullable', 'string', 'max:255'],
            'pill_url_2' => ['nullable', 'string', 'max:500'],
            'pill_text_3' => ['nullable', 'string', 'max:255'],
            'pill_url_3' => ['nullable', 'string', 'max:500'],
            'is_active' => ['nullable'],
        ];
    }

    public function messages(): array
    {
        return [
            'background_image.image' => 'File background harus berupa gambar.',
            'background_image.mimes' => 'Format background harus jpeg, png, jpg, webp, atau svg.',
            'background_image.max' => 'Ukuran file background maksimal 20 MB.',
        ];
    }
}
