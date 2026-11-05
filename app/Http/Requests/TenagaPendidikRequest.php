<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TenagaPendidikRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'layanan_id' => ['nullable', 'exists:layanans,id'],
            'nama' => ['required', 'string', 'max:255'],
            'bidang' => ['nullable', 'string', 'max:255'],
            'keterangan' => ['nullable', 'string', 'max:1000'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:20480'],
            'icon' => ['nullable', 'string', 'max:100'],
            'link' => ['nullable', 'string', 'max:255'],
            'tombol_teks' => ['nullable', 'string', 'max:100'],
            'urutan' => ['nullable', 'integer', 'min:0', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    /**
     * Custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'nama.required' => 'Nama kelompok/dosen bidang wajib diisi.',
            'foto.image' => 'File foto harus berupa gambar.',
            'foto.max' => 'Ukuran foto maksimal 20MB.',
            'urutan.integer' => 'Urutan harus berupa angka.',
        ];
    }
}
