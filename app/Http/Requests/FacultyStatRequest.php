<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FacultyStatRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:20480'],
            'background_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:20480'],

            // Tab 1: Mahasiswa
            'tab_1_label' => ['required', 'string', 'max:50'],
            'mhs_total' => ['required', 'integer', 'min:0'],
            'mhs_total_label' => ['required', 'string', 'max:100'],
            'mhs_baru' => ['required', 'integer', 'min:0'],
            'mhs_baru_label' => ['required', 'string', 'max:100'],
            'mhs_alumni' => ['required', 'integer', 'min:0'],
            'mhs_alumni_label' => ['required', 'string', 'max:100'],

            // Tab 2: Prestasi
            'tab_2_label' => ['required', 'string', 'max:50'],
            'prestasi_nasional' => ['required', 'integer', 'min:0'],
            'prestasi_nasional_label' => ['required', 'string', 'max:100'],
            'prestasi_provinsi' => ['required', 'integer', 'min:0'],
            'prestasi_provinsi_label' => ['required', 'string', 'max:100'],
            'prestasi_internasional' => ['required', 'integer', 'min:0'],
            'prestasi_internasional_label' => ['required', 'string', 'max:100'],

            // Tab 3: Kerjasama
            'tab_3_label' => ['required', 'string', 'max:50'],
            'kerjasama_total' => ['required', 'integer', 'min:0'],
            'kerjasama_total_label' => ['required', 'string', 'max:100'],
            'kerjasama_perusahaan' => ['required', 'integer', 'min:0'],
            'kerjasama_perusahaan_label' => ['required', 'string', 'max:100'],
            'kerjasama_pemerintahan' => ['required', 'integer', 'min:0'],
            'kerjasama_pemerintahan_label' => ['required', 'string', 'max:100'],
            'kerjasama_sekolah' => ['required', 'integer', 'min:0'],
            'kerjasama_sekolah_label' => ['required', 'string', 'max:100'],

            'is_active' => ['nullable', 'boolean'],
        ];
    }
}
