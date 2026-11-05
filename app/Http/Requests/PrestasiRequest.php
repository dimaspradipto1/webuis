<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PrestasiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'judul_prestasi' => ['required', 'string', 'max:255'],
            'nama_mahasiswa' => ['required', 'string', 'max:255'],
            'nim' => ['nullable', 'string', 'max:50'],
            'prodi' => ['nullable', 'string', 'max:255'],
            'tingkat' => ['required', 'string', 'in:Internasional,Nasional,Provinsi / Wilayah,Universitas'],
            'peringkat' => ['nullable', 'string', 'max:100'],
            'penyelenggara' => ['nullable', 'string', 'max:255'],
            'tahun' => ['nullable', 'string', 'max:10'],
            'deskripsi' => ['nullable', 'string'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:20480'],
            'is_active' => ['nullable'],
            'urutan' => ['nullable', 'integer'],
        ];
    }

    public function messages(): array
    {
        return [
            'judul_prestasi.required' => 'Judul Prestasi / Nama Kejuaraan wajib diisi.',
            'nama_mahasiswa.required' => 'Nama Mahasiswa / Tim peraih prestasi wajib diisi.',
            'tingkat.required' => 'Tingkatan kejuaraan wajib dipilih.',
            'tingkat.in' => 'Tingkatan kejuaraan tidak valid.',
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Format foto yang diperbolehkan: JPEG, PNG, JPG, WEBP.',
            'foto.max' => 'Ukuran foto maksimal 20 MB.',
        ];
    }
}
