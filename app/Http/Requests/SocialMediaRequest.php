<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SocialMediaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:255'],
            'kategori' => ['required', 'string', 'in:universitas,humas'],
            'handle' => ['nullable', 'string', 'max:255'],
            'logo' => ['nullable', 'file', 'mimes:png,webp,svg,jpg,jpeg', 'max:20480'],
            'url' => ['required', 'string', 'max:500'],
            'video_url' => ['nullable', 'string', 'max:500'],
            'thumbnail_video' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,mp4,webm', 'max:102400'],
            'video_judul' => ['nullable', 'string', 'max:255'],
            'urutan' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama media sosial wajib diisi.',
            'kategori.required' => 'Kategori (Universitas/Humas) wajib dipilih.',
            'logo.mimes' => 'Logo harus berformat gambar PNG (atau webp/svg).',
            'logo.max' => 'Ukuran file logo maksimal 20MB.',
            'url.required' => 'URL / Link media sosial wajib diisi.',
            'thumbnail_video.max' => 'Ukuran thumbnail / video maksimal 100MB.',
        ];
    }
}
