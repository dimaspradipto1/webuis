<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DosenRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'layanan_id' => ['required', 'exists:layanans,id'],
            'prodi_nama' => ['nullable', 'string', 'max:255'],
            'nama_dosen' => ['required', 'string', 'max:255'],
            'jabatan_fungsional' => ['nullable', 'string', 'max:100'],
            'nidn' => ['nullable', 'string', 'max:50'],
            'nuptk' => ['nullable', 'string', 'max:50'],
            'link' => ['nullable', 'string', 'max:500'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:20480'],
            'is_active' => ['nullable'],
        ];
    }

    public function messages(): array
    {
        return [
            'layanan_id.required' => 'Program Studi wajib dipilih.',
            'nama_dosen.required' => 'Nama Dosen beserta gelar wajib diisi.',
            'foto.image' => 'File foto harus berupa gambar.',
            'foto.max' => 'Ukuran foto maksimal 20 MB.',
        ];
    }
}
