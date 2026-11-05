<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DesainGrafisSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'hero_title' => ['required', 'string', 'max:255'],
            'hero_highlight' => ['required', 'string', 'max:255'],
            'hero_subtitle' => ['nullable', 'string'],
            'order_box_title' => ['required', 'string', 'max:255'],
            'order_box_text' => ['nullable', 'string'],
            'order_box_btn_text' => ['required', 'string', 'max:100'],
            'order_box_wa_url' => ['nullable', 'url', 'max:1000'],
            'track_bar_text' => ['required', 'string', 'max:255'],
            'stat_total' => ['required', 'integer', 'min:0'],
            'stat_selesai' => ['required', 'integer', 'min:0'],
            'stat_dikerjakan' => ['required', 'integer', 'min:0'],
            'stat_menunggu' => ['required', 'integer', 'min:0'],
            'guide_title' => ['nullable', 'string', 'max:255'],
            'guide_steps' => ['nullable', 'string'],
            'guide_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:20480'],
        ];
    }

    public function messages(): array
    {
        return [
            'guide_image.image' => 'File gambar panduan harus berupa foto/gambar yang valid.',
            'guide_image.max' => 'Ukuran gambar panduan maksimal 20 MB.',
        ];
    }
}
