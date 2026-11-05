<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AboutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'judul_profil' => ['nullable', 'string', 'max:255'],
            'deskripsi_profil_1' => ['nullable', 'string'],
            'deskripsi_profil_2' => ['nullable', 'string'],
            'video_url' => ['nullable', 'string', 'max:1000'],
            'video_file' => ['nullable', 'file', 'mimes:mp4,webm,mov,ogg', 'max:102400'],
            'visi' => ['nullable', 'string'],
            'visi_judul' => ['nullable', 'string', 'max:255'],
            'visi_icon' => ['nullable', 'string', 'max:255'],
            'misi' => ['nullable', 'string'],
            'misi_judul' => ['nullable', 'string', 'max:255'],
            'misi_icon' => ['nullable', 'string', 'max:255'],
            'judul_nilai' => ['nullable', 'string', 'max:255'],
            'deskripsi_nilai' => ['nullable', 'string'],
            'nilai_1_judul' => ['nullable', 'string', 'max:255'],
            'nilai_1_deskripsi' => ['nullable', 'string'],
            'nilai_1_icon' => ['nullable', 'string', 'max:255'],
            'nilai_2_judul' => ['nullable', 'string', 'max:255'],
            'nilai_2_deskripsi' => ['nullable', 'string'],
            'nilai_2_icon' => ['nullable', 'string', 'max:255'],
            'nilai_3_judul' => ['nullable', 'string', 'max:255'],
            'nilai_3_deskripsi' => ['nullable', 'string'],
            'nilai_3_icon' => ['nullable', 'string', 'max:255'],
            'nilai_4_judul' => ['nullable', 'string', 'max:255'],
            'nilai_4_deskripsi' => ['nullable', 'string'],
            'nilai_4_icon' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'judul_profil.max' => 'Judul profil maksimal 255 karakter.',
            'judul_nilai.max' => 'Judul nilai utama maksimal 255 karakter.',
            'nilai_1_judul.max' => 'Judul nilai 1 maksimal 255 karakter.',
            'nilai_1_icon.max' => 'Icon nilai 1 maksimal 255 karakter.',
            'nilai_2_judul.max' => 'Judul nilai 2 maksimal 255 karakter.',
            'nilai_2_icon.max' => 'Icon nilai 2 maksimal 255 karakter.',
            'nilai_3_judul.max' => 'Judul nilai 3 maksimal 255 karakter.',
            'nilai_3_icon.max' => 'Icon nilai 3 maksimal 255 karakter.',
            'nilai_4_judul.max' => 'Judul nilai 4 maksimal 255 karakter.',
            'nilai_4_icon.max' => 'Icon nilai 4 maksimal 255 karakter.',
        ];
    }
}
