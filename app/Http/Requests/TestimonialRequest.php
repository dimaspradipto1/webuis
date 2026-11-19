<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TestimonialRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        // Hanya merge aktif untuk edit/create dari admin panel, bukan form publik
        if ($this->has('aktif') || $this->routeIs('testimonial.store') || $this->routeIs('testimonial.update')) {
            $this->merge([
                'aktif' => $this->has('aktif') ? true : false,
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:255'],
            'pekerjaan' => ['required', 'string', 'max:255'],
            'kategori' => ['required', 'string', 'max:150'],
            'bintang' => ['required', 'integer', 'min:1', 'max:5'],
            'pesan' => ['required', 'string', 'min:5'],
            'aktif' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama lengkap wajib diisi.',
            'pekerjaan.required' => 'Profesi / tempat bekerja wajib diisi.',
            'kategori.required' => 'Pilih salah satu kategori profil.',
            'bintang.required' => 'Rating bintang wajib dipilih.',
            'bintang.integer' => 'Rating bintang tidak valid.',
            'bintang.min' => 'Rating bintang minimal 1.',
            'bintang.max' => 'Rating bintang maksimal 5.',
            'pesan.required' => 'Ulasan testimoni wajib diisi.',
            'pesan.min' => 'Ulasan testimoni minimal berisi 5 karakter.',
        ];
    }
}
