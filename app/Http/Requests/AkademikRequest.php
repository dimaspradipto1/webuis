<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class AkademikRequest extends FormRequest
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
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'judul' => ['required', 'string', 'max:255'],
            'subjudul' => ['nullable', 'string', 'max:500'],
            'deskripsi' => ['nullable', 'string'],
            'link_url' => ['nullable', 'string', 'max:500'],
            'file_nama' => ['nullable', 'string', 'max:255'],
            'file_dokumen' => ['nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx,zip,rar', 'max:102400'],
            'gambar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:20480'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    /**
     * Custom validation messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'file_dokumen.mimes' => 'Format file yang diperbolehkan: PDF, DOC, DOCX, XLS, XLSX, ZIP, RAR.',
            'file_dokumen.max' => 'Ukuran file dokumen maksimal 100MB.',
            'gambar.image' => 'File banner/gambar harus berupa gambar.',
            'gambar.max' => 'Ukuran gambar maksimal 20 MB.',
        ];
    }
}
