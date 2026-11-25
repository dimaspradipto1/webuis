<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrganisasiMahasiswaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_organisasi' => ['required', 'string', 'max:200'],
            'singkatan' => ['nullable', 'string', 'max:50'],
            'kategori' => ['required', 'string', 'max:100'],
            'deskripsi' => ['nullable', 'string'],
            'visi' => ['nullable', 'string'],
            'misi' => ['nullable', 'string'],
            'nama_ketua' => ['nullable', 'string', 'max:150'],
            'nama_wakil' => ['nullable', 'string', 'max:150'],
            'pembina' => ['nullable', 'string', 'max:150'],
            'periode' => ['nullable', 'string', 'max:50'],
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:5120'],
            'foto_kegiatan' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'instagram' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:100'],
            'link_pendaftaran' => ['nullable', 'string', 'max:255'],
            'urutan' => ['nullable', 'integer'],
            'is_active' => ['nullable'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama_organisasi.required' => 'Nama organisasi wajib diisi.',
            'kategori.required' => 'Kategori organisasi wajib dipilih.',
            'logo.image' => 'Logo harus berupa berkas gambar.',
            'logo.max' => 'Ukuran berkas logo maksimal 5 MB.',
            'foto_kegiatan.image' => 'Foto kegiatan harus berupa berkas gambar.',
            'foto_kegiatan.max' => 'Ukuran berkas foto kegiatan maksimal 5 MB.',
        ];
    }
}
