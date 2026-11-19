<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AlumniTestimonialRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:255'],
            'pekerjaan' => ['required', 'string', 'max:255'],
            'kategori' => ['required', 'string', 'max:150'],
            'bintang' => ['required', 'integer', 'min:1', 'max:5'],
            'pesan' => ['required', 'string', 'max:2000'],
            'captcha' => [
                'required',
                'numeric',
                function ($attribute, $value, $fail) {
                    $expected = session('alumni_captcha_answer');
                    if ($expected === null || (int) $value !== (int) $expected) {
                        $fail('Jawaban verifikasi captcha keamanan tidak cocok. Silakan coba lagi.');
                    }
                },
            ],
            // Honeypot trap: bot spammer otomatis mengisi input tak kasat mata
            'website_trap' => [
                'nullable',
                'max:0',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama lengkap wajib diisi.',
            'pekerjaan.required' => 'Profesi / instansi / angkatan wajib diisi.',
            'kategori.required' => 'Kategori hubungan wajib dipilih.',
            'bintang.required' => 'Rating kepuasan bintang wajib dipilih.',
            'pesan.required' => 'Pesan / testimoni Anda wajib diisi.',
            'captcha.required' => 'Jawaban verifikasi captcha keamanan wajib diisi.',
            'captcha.numeric' => 'Jawaban captcha harus berupa angka.',
            'website_trap.max' => 'Spam terdeteksi.',
        ];
    }
}
