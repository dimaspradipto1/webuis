<?php

namespace App\Http\Controllers;

use App\DataTables\DesainGrafisDataTable;
use App\Http\Requests\DesainGrafisRequest;
use App\Models\DesainGrafis;
use App\Models\DesainGrafisSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class DesainGrafisController extends Controller
{
    public function index(DesainGrafisDataTable $dataTable)
    {
        $setting = DesainGrafisSetting::firstOrCreate([], [
            'hero_title' => 'Desain Mudah,',
            'hero_highlight' => 'Siap Digunakan !',
            'hero_subtitle' => 'Kami menyediakan template desain resmi untuk keperluan presentasi LED, ruang sidang, agenda rapat, dan spanduk acara di lingkungan Universitas Ibnu Sina.',
            'order_box_title' => 'Pesan desain disini',
            'order_box_text' => 'Butuh desain yang belum tersedia dalam template? Sampaikan kebutuhan acara Anda, dan tim Humas & Promosi UIS siap membantu mewujudkannya.',
            'order_box_btn_text' => 'Pesan Sekarang',
            'track_bar_text' => 'Lacak progress pesanan desain kamu disini!',
            'stat_total' => 82,
            'stat_selesai' => 74,
            'stat_dikerjakan' => 2,
            'stat_menunggu' => 5,
            'guide_title' => 'Langkah Menggunakan Templat Desain',
            'guide_steps' => "1. Pilih Templat\n2. Masuk ke Canva\n3. Edit Teks/Elemen Templat\n4. Desain Siap\n5. Export Desain format .JPG\n6. Klik tombol Share (kanan atas)\n7. Klik Download\n8. Pilih Format .JPG\n9. Atur Quality Spasi ke 100% untuk kualitas terbaik\n10. Klik Download",
        ]);

        return $dataTable->render('pages.desain-grafis.index', compact('setting'));
    }

    public function updateSetting(Request $request): RedirectResponse
    {
        $setting = DesainGrafisSetting::firstOrCreate([], []);

        $validated = $request->validate([
            'hero_title' => ['required', 'string', 'max:255'],
            'hero_highlight' => ['required', 'string', 'max:255'],
            'hero_subtitle' => ['nullable', 'string'],
            'order_box_title' => ['required', 'string', 'max:255'],
            'order_box_text' => ['nullable', 'string'],
            'order_box_btn_text' => ['required', 'string', 'max:100'],
            'order_box_wa_url' => ['nullable', 'url', 'max:1000'],
            'track_bar_text' => ['required', 'string', 'max:255'],
            'stat_total' => ['required', 'integer', 'min:0'],
            'stat_selesai' => ['required', 'integer', 'min:0'],
            'stat_dikerjakan' => ['required', 'integer', 'min:0'],
            'stat_menunggu' => ['required', 'integer', 'min:0'],
            'guide_title' => ['nullable', 'string', 'max:255'],
            'guide_steps' => ['nullable', 'string'],
            'guide_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:20480'], // maks 20MB
        ], [
            'guide_image.image' => 'File gambar panduan harus berupa foto/gambar yang valid.',
            'guide_image.max' => 'Ukuran gambar panduan maksimal 20 MB.',
        ]);

        $guideImagePath = $setting->guide_image;

        if ($request->hasFile('guide_image')) {
            if ($guideImagePath && Storage::disk('public')->exists($guideImagePath)) {
                Storage::disk('public')->delete($guideImagePath);
            }
            $guideImagePath = $request->file('guide_image')->store('desain_grafis/guide', 'public');
        } elseif ($request->boolean('remove_guide_image')) {
            if ($guideImagePath && Storage::disk('public')->exists($guideImagePath)) {
                Storage::disk('public')->delete($guideImagePath);
            }
            $guideImagePath = null;
        }

        $validated['guide_image'] = $guideImagePath;

        $setting->update($validated);

        alert()->success('Berhasil!', 'Pengaturan konten & gambar halaman Desain Grafis berhasil diperbarui.');

        return redirect()->route('desain-grafis.index');
    }

    public function create(): View
    {
        return view('pages.desain-grafis.create');
    }

    public function store(DesainGrafisRequest $request): RedirectResponse
    {
        $previewPath = null;

        if ($request->hasFile('gambar_preview')) {
            $previewPath = $request->file('gambar_preview')->store('desain_grafis', 'public');
        }

        DesainGrafis::create([
            'judul' => $request->judul,
            'kategori' => $request->kategori,
            'badge_teks' => $request->badge_teks,
            'spesifikasi' => $request->spesifikasi,
            'deskripsi' => $request->deskripsi,
            'canva_url' => $request->canva_url,
            'gambar_preview' => $previewPath,
            'warna_gradient' => $request->warna_gradient ?: 'linear-gradient(135deg, #0b6828 0%, #15803d 100%)',
            'urutan' => $request->urutan ?? 0,
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        alert()->success('Berhasil!', 'Templat desain grafis baru berhasil ditambahkan.');

        return redirect()->route('desain-grafis.index');
    }

    public function edit(DesainGrafis $desainGrafis): View
    {
        return view('pages.desain-grafis.edit', compact('desainGrafis'));
    }

    public function update(DesainGrafisRequest $request, DesainGrafis $desainGrafis): RedirectResponse
    {
        $previewPath = $desainGrafis->gambar_preview;

        if ($request->hasFile('gambar_preview')) {
            if ($previewPath && Storage::disk('public')->exists($previewPath)) {
                Storage::disk('public')->delete($previewPath);
            }
            $previewPath = $request->file('gambar_preview')->store('desain_grafis', 'public');
        }

        $desainGrafis->update([
            'judul' => $request->judul,
            'kategori' => $request->kategori,
            'badge_teks' => $request->badge_teks,
            'spesifikasi' => $request->spesifikasi,
            'deskripsi' => $request->deskripsi,
            'canva_url' => $request->canva_url,
            'gambar_preview' => $previewPath,
            'warna_gradient' => $request->warna_gradient ?: $desainGrafis->warna_gradient,
            'urutan' => $request->urutan ?? 0,
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        alert()->success('Berhasil!', 'Templat desain grafis berhasil diperbarui.');

        return redirect()->route('desain-grafis.index');
    }

    public function destroy(DesainGrafis $desainGrafis): RedirectResponse
    {
        if ($desainGrafis->gambar_preview && Storage::disk('public')->exists($desainGrafis->gambar_preview)) {
            Storage::disk('public')->delete($desainGrafis->gambar_preview);
        }

        $desainGrafis->delete();

        alert()->success('Berhasil!', 'Templat desain grafis berhasil dihapus.');

        return redirect()->route('desain-grafis.index');
    }
}
