<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LayananHumasRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:100'],
            'badge_text' => ['nullable', 'string', 'max:50'],
            'deskripsi' => ['nullable', 'string'],
            'icon' => ['nullable', 'string', 'max:50'],
            'url' => ['nullable', 'string', 'max:1000'],
            'file' => ['nullable', 'file', 'max:102400'],
            'target_blank' => ['nullable'],
            'is_active' => ['nullable'],

            // Pengaturan Khusus Halaman
            'judul_seksi' => ['nullable', 'string', 'max:255'],
            'deskripsi_seksi' => ['nullable', 'string'],
            'link_form' => ['nullable', 'string', 'max:1000'],
            'no_wa' => ['nullable', 'string', 'max:50'],
            'email_tujuan' => ['nullable', 'string', 'max:100'],
            'min_kata' => ['nullable', 'integer', 'min:50'],
            'min_paragraf' => ['nullable', 'integer', 'min:1'],
            'catatan_tambahan' => ['nullable', 'string'],

            // Khusus Pendampingan Acara
            'sapaan' => ['nullable', 'string', 'max:255'],
            'konten' => ['nullable', 'string'],
            'paragraf_1' => ['nullable', 'string'],
            'paragraf_2' => ['nullable', 'string'],
            'poin_bantuan' => ['nullable', 'string'],
            'paragraf_3' => ['nullable', 'string'],
            'tombol_teks' => ['nullable', 'string', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama layanan wajib diisi.',
            'file.max' => 'Ukuran file maksimal 100 MB.',
        ];
    }
}
