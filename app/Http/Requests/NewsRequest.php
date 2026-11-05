<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:1000'],
            'content' => ['required', 'string'],
            'status' => ['required', 'in:draft,published'],
            'category' => ['required', 'string', 'max:100'],
            'is_featured' => ['nullable', 'boolean'],
            'published_at' => ['nullable', 'date'],
            'gallery' => ['nullable', 'array'],
            'gallery.*' => ['image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:20480'],
        ];

        $rules['thumbnail'] = ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:20480'];

        return $rules;
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul wajib diisi.',
            'title.max' => 'Judul maksimal 255 karakter.',
            'description.required' => 'Deskripsi singkat wajib diisi.',
            'description.max' => 'Deskripsi singkat maksimal 1000 karakter.',
            'content.required' => 'Konten berita wajib diisi.',
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status tidak valid.',
            'thumbnail.required' => 'Thumbnail utama wajib diunggah.',
            'thumbnail.image' => 'File thumbnail harus berupa gambar.',
            'thumbnail.mimes' => 'Format gambar harus jpeg, png, jpg, gif, svg, atau webp.',
            'thumbnail.max' => 'Ukuran thumbnail maksimal 20 MB.',
            'gallery.*.image' => 'Setiap file galeri harus berupa gambar.',
            'gallery.*.mimes' => 'Format gambar galeri harus jpeg, png, jpg, gif, svg, atau webp.',
            'gallery.*.max' => 'Ukuran setiap gambar galeri maksimal 20 MB.',
        ];
    }
}
