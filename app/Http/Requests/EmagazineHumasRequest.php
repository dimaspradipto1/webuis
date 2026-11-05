<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmagazineHumasRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'judul_seksi' => ['required', 'string', 'max:255'],
            'is_active' => ['nullable'],

            // Tab 1: E-Magazine
            'tab_1_label' => ['required', 'string', 'max:100'],
            'tab_1_badge_text' => ['nullable', 'string', 'max:50'],
            'tab_1_cover_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:20480'],
            'tab_1_judul' => ['required', 'string', 'max:255'],
            'tab_1_deskripsi' => ['nullable', 'string'],
            'tab_1_btn_preview_text' => ['nullable', 'string', 'max:100'],
            'tab_1_btn_preview_url' => ['nullable', 'string', 'max:1000'],
            'tab_1_btn_download_text' => ['nullable', 'string', 'max:100'],
            'tab_1_file_download' => ['nullable', 'file', 'mimes:pdf,docx,zip', 'max:102400'],
            'tab_1_download_url' => ['nullable', 'string', 'max:1000'],

            // Tab 2: Buku Saku
            'tab_2_label' => ['required', 'string', 'max:100'],
            'tab_2_badge_text' => ['nullable', 'string', 'max:50'],
            'tab_2_cover_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:20480'],
            'tab_2_judul' => ['required', 'string', 'max:255'],
            'tab_2_deskripsi' => ['nullable', 'string'],
            'tab_2_btn_preview_text' => ['nullable', 'string', 'max:100'],
            'tab_2_btn_preview_url' => ['nullable', 'string', 'max:1000'],
            'tab_2_btn_download_text' => ['nullable', 'string', 'max:100'],
            'tab_2_file_download' => ['nullable', 'file', 'mimes:pdf,docx,zip', 'max:102400'],
            'tab_2_download_url' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
