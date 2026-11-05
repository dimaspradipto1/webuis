<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KurikulumRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'layanan_id' => ['nullable', 'exists:layanans,id'],
            'prodi_nama' => ['nullable', 'string', 'max:255'],
            'kode_mk' => ['required', 'string', 'max:50'],
            'nama_mk' => ['required', 'string', 'max:255'],
            'semester' => ['required', 'integer', 'min:1', 'max:8'],
            'sks' => ['required', 'integer', 'min:1', 'max:12'],
            'kategori' => ['required', 'string', 'max:50'],
            'file_rps' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:102400'],
            'link_rps' => ['nullable', 'string', 'max:500'],
            'deskripsi' => ['nullable', 'string'],
            'urutan' => ['nullable', 'integer'],
            'is_active' => ['nullable'],
        ];
    }

    public function messages(): array
    {
        return [
            'kode_mk.required' => 'Kode matakuliah wajib diisi.',
            'nama_mk.required' => 'Nama matakuliah wajib diisi.',
            'semester.required' => 'Semester wajib dipilih (1 - 8).',
            'sks.required' => 'Jumlah SKS wajib diisi.',
            'file_rps.max' => 'Ukuran file RPS maksimal 100MB.',
            'file_rps.mimes' => 'File RPS harus berformat PDF, DOC, atau DOCX.',
        ];
    }
}
