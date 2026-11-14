<?php

namespace App\Http\Controllers;

use App\Models\BeasiswaSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BeasiswaSettingController extends Controller
{
    /**
     * Tampilkan formulir pengaturan Program Beasiswa.
     */
    public function index(): View
    {
        $beasiswa = BeasiswaSetting::firstOrCreate([], [
            'hero_badge' => 'PENDAFTARAN BEASISWA T.A. 2026/2027 TELAH DIBUKA',
            'hero_judul' => 'Raih Impian & Masa Depan Bersama Program Beasiswa Universitas Ibnu Sina',
            'hero_deskripsi' => "Universitas Ibnu Sina (UIS) Batam berkomitmen memberikan akses pendidikan tinggi bermutu melalui berbagai skema beasiswa penuh (100% Bebas SPP) maupun beasiswa potongan biaya pendidikan bagi calon mahasiswa berprestasi, tahfidz Al-Qur'an, dan mitra industri.",
            'tentang_judul' => 'Membuka Akses Pendidikan Tinggi Unggul Tanpa Kendala Biaya',
            'tentang_deskripsi' => "Sebagai institusi pendidikan tinggi terkemuka di Kota Batam yang berlandaskan nilai-nilai Iman, Ilmu, dan Amal, Universitas Ibnu Sina meyakini bahwa keterbatasan finansial tidak boleh menjadi penghalang bagi putra-putri bangsa untuk meraih gelar Sarjana (S1) maupun Magister (S2).\n\nProgram Beasiswa UIS dirancang secara komprehensif bersama Kementerian Pendidikan, Pemerintah Daerah, Yayasan Pendidikan Ibnu Sina Batam (YAPISNA), serta asosiasi industri multinasional.",
            'link_daftar' => '',
            'is_active' => true,
            'stats' => BeasiswaSetting::defaultStats(),
            'keunggulan_list' => BeasiswaSetting::defaultKeunggulan(),
            'jalur_list' => BeasiswaSetting::defaultJalur(),
            'alur_list' => BeasiswaSetting::defaultAlur(),
            'faq_list' => BeasiswaSetting::defaultFaq(),
            'cta_data' => BeasiswaSetting::defaultCta(),
        ]);

        return view('pages.beasiswa-setting.index', compact('beasiswa'));
    }

    /**
     * Update data pengaturan Program Beasiswa.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'hero_badge' => 'nullable|string|max:255',
            'hero_judul' => 'required|string|max:255',
            'hero_deskripsi' => 'nullable|string|max:5000',
            'tentang_judul' => 'nullable|string|max:255',
            'tentang_deskripsi' => 'nullable|string|max:10000',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'link_daftar' => 'nullable|string|max:500',
            'is_active' => 'nullable|boolean',
            'stats' => 'nullable|array',
            'stats.*.icon' => 'nullable|string|max:100',
            'stats.*.nilai' => 'nullable|string|max:100',
            'stats.*.label' => 'nullable|string|max:255',
            'keunggulan_list' => 'nullable|array',
            'keunggulan_list.*' => 'nullable|string|max:500',
            'jalur_list' => 'nullable|array',
            'jalur_list.*.judul' => 'nullable|string|max:255',
            'jalur_list.*.badge' => 'nullable|string|max:255',
            'jalur_list.*.icon' => 'nullable|string|max:100',
            'jalur_list.*.ringkasan' => 'nullable|string|max:1000',
            'jalur_list.*.deskripsi' => 'nullable|string|max:3000',
            'jalur_list.*.manfaat' => 'nullable|string|max:5000',
            'jalur_list.*.syarat' => 'nullable|string|max:5000',
            'jalur_list.*.periode' => 'nullable|string|max:255',
            'alur_list' => 'nullable|array',
            'alur_list.*.nomor' => 'nullable|numeric',
            'alur_list.*.judul' => 'nullable|string|max:255',
            'alur_list.*.deskripsi' => 'nullable|string|max:1000',
            'faq_list' => 'nullable|array',
            'faq_list.*.tanya' => 'nullable|string|max:500',
            'faq_list.*.jawab' => 'nullable|string|max:2000',
            'cta_data' => 'nullable|array',
            'cta_data.badge' => 'nullable|string|max:255',
            'cta_data.judul' => 'nullable|string|max:255',
            'cta_data.deskripsi' => 'nullable|string|max:1000',
            'cta_data.btn_text' => 'nullable|string|max:100',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $beasiswa = BeasiswaSetting::first() ?? new BeasiswaSetting();

        // Handle upload gambar jika ada
        if ($request->hasFile('gambar')) {
            if ($beasiswa->gambar && Storage::disk('public')->exists($beasiswa->gambar)) {
                Storage::disk('public')->delete($beasiswa->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('beasiswa', 'public');
        }

        // Clean & Format stats
        if ($request->has('stats')) {
            $stats = [];
            foreach ($request->input('stats', []) as $item) {
                if (!empty($item['label']) || !empty($item['nilai'])) {
                    $stats[] = [
                        'icon' => $item['icon'] ?? 'bi-mortarboard-fill',
                        'nilai' => $item['nilai'] ?? '',
                        'label' => $item['label'] ?? '',
                    ];
                }
            }
            $validated['stats'] = count($stats) > 0 ? $stats : BeasiswaSetting::defaultStats();
        }

        // Clean keunggulan list
        if ($request->has('keunggulan_list')) {
            $keunggulan = array_filter(array_map('trim', $request->input('keunggulan_list', [])), function ($val) {
                return !empty($val);
            });
            $validated['keunggulan_list'] = count($keunggulan) > 0 ? array_values($keunggulan) : BeasiswaSetting::defaultKeunggulan();
        }

        // Clean jalur list
        if ($request->has('jalur_list')) {
            $jalurList = [];
            foreach ($request->input('jalur_list', []) as $idx => $j) {
                if (!empty($j['judul'])) {
                    $id = !empty($j['id']) ? Str::slug($j['id']) : ('collapse_jalur_' . ($idx + 1));
                    $jalurList[] = [
                        'id' => $id,
                        'judul' => $j['judul'] ?? '',
                        'badge' => $j['badge'] ?? '',
                        'icon' => $j['icon'] ?? 'bi-mortarboard-fill',
                        'ringkasan' => $j['ringkasan'] ?? '',
                        'deskripsi' => $j['deskripsi'] ?? '',
                        'manfaat' => $j['manfaat'] ?? '',
                        'syarat' => $j['syarat'] ?? '',
                        'periode' => $j['periode'] ?? '',
                    ];
                }
            }
            $validated['jalur_list'] = count($jalurList) > 0 ? $jalurList : BeasiswaSetting::defaultJalur();
        }

        // Clean alur list
        if ($request->has('alur_list')) {
            $alurList = [];
            foreach ($request->input('alur_list', []) as $idx => $a) {
                if (!empty($a['judul'])) {
                    $alurList[] = [
                        'nomor' => (int) ($a['nomor'] ?? ($idx + 1)),
                        'judul' => $a['judul'] ?? '',
                        'deskripsi' => $a['deskripsi'] ?? '',
                    ];
                }
            }
            $validated['alur_list'] = count($alurList) > 0 ? $alurList : BeasiswaSetting::defaultAlur();
        }

        // Clean FAQ list
        if ($request->has('faq_list')) {
            $faqList = [];
            foreach ($request->input('faq_list', []) as $f) {
                if (!empty($f['tanya'])) {
                    $faqList[] = [
                        'tanya' => $f['tanya'] ?? '',
                        'jawab' => $f['jawab'] ?? '',
                    ];
                }
            }
            $validated['faq_list'] = count($faqList) > 0 ? $faqList : BeasiswaSetting::defaultFaq();
        }

        // Clean CTA data
        if ($request->has('cta_data')) {
            $cta = $request->input('cta_data', []);
            $validated['cta_data'] = [
                'badge' => $cta['badge'] ?? 'Jangan Lewatkan Kesempatan Ini',
                'judul' => $cta['judul'] ?? 'Siap Meraih Beasiswa Impian Anda di Universitas Ibnu Sina?',
                'deskripsi' => $cta['deskripsi'] ?? 'Kuota terbatas untuk setiap gelombang pendaftaran. Segera persiapkan dokumen Anda dan bergabunglah bersama ribuan mahasiswa berprestasi UIS Batam!',
                'btn_text' => $cta['btn_text'] ?? 'Daftar Online PMB',
            ];
        }

        $beasiswa->fill($validated);
        $beasiswa->save();

        alert()->success('Berhasil!', 'Seluruh konten Pengaturan Program Beasiswa berhasil diperbarui.');

        return redirect()->route('beasiswa.admin');
    }
}
