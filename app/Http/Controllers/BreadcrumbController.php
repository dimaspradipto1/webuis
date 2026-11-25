<?php

namespace App\Http\Controllers;

use App\Models\Breadcrumb;
use Database\Seeders\BreadcrumbSeeder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class BreadcrumbController extends Controller
{
    /**
     * Display a listing of breadcrumbs.
     */
    public function index(Request $request): View
    {
        // Auto-seed jika data masih kosong agar selalu terisi penuh 30 menu
        if (Breadcrumb::count() === 0) {
            (new BreadcrumbSeeder())->run();
        }

        $kategori = $request->query('kategori');
        $search = trim($request->query('q', ''));

        $query = Breadcrumb::query()->orderBy('urutan')->orderBy('id');

        if (!empty($kategori) && $kategori !== 'all') {
            $query->where('kategori_menu', $kategori);
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('menu_name', 'like', "%{$search}%")
                  ->orWhere('judul', 'like', "%{$search}%")
                  ->orWhere('page_key', 'like', "%{$search}%")
                  ->orWhere('breadcrumb_active', 'like', "%{$search}%");
            });
        }

        $breadcrumbs = $query->get();
        $categories = Breadcrumb::select('kategori_menu')->distinct()->pluck('kategori_menu');
        $totalItems = Breadcrumb::count();

        return view('pages.breadcrumb-setting.index', compact('breadcrumbs', 'categories', 'kategori', 'search', 'totalItems'));
    }

    /**
     * Show the form for editing the specified breadcrumb.
     */
    public function edit(Breadcrumb $breadcrumb): View
    {
        return view('pages.breadcrumb-setting.edit', compact('breadcrumb'));
    }

    /**
     * Update the specified breadcrumb in storage.
     */
    public function update(Request $request, Breadcrumb $breadcrumb): RedirectResponse
    {
        $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'subjudul' => ['nullable', 'string', 'max:1000'],
            'badge_text' => ['nullable', 'string', 'max:100'],
            'breadcrumb_item_1' => ['required', 'string', 'max:100'],
            'breadcrumb_url_1' => ['nullable', 'string', 'max:255'],
            'breadcrumb_item_2' => ['nullable', 'string', 'max:100'],
            'breadcrumb_url_2' => ['nullable', 'string', 'max:255'],
            'breadcrumb_active' => ['required', 'string', 'max:150'],
            'background_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
        ], [
            'judul.required' => 'Judul Hero Banner wajib diisi.',
            'breadcrumb_item_1.required' => 'Teks Breadcrumb 1 (Beranda) wajib diisi.',
            'breadcrumb_active.required' => 'Teks Halaman Aktif Breadcrumb wajib diisi.',
            'background_image.image' => 'File background harus berupa gambar (JPG, PNG, WebP).',
            'background_image.max' => 'Ukuran file background maksimal 5 MB.',
        ]);

        $data = [
            'judul' => $request->judul,
            'subjudul' => $request->subjudul,
            'badge_text' => $request->badge_text,
            'breadcrumb_item_1' => $request->breadcrumb_item_1,
            'breadcrumb_url_1' => $request->breadcrumb_url_1,
            'breadcrumb_item_2' => $request->breadcrumb_item_2,
            'breadcrumb_url_2' => $request->breadcrumb_url_2,
            'breadcrumb_active' => $request->breadcrumb_active,
            'is_active' => $request->has('is_active') ? true : false,
        ];

        // Hapus background jika diminta
        if ($request->boolean('remove_background_image')) {
            if ($breadcrumb->background_image && Storage::disk('public')->exists($breadcrumb->background_image)) {
                Storage::disk('public')->delete($breadcrumb->background_image);
            }
            $data['background_image'] = null;
        }

        // Upload background baru jika ada
        if ($request->hasFile('background_image')) {
            if ($breadcrumb->background_image && Storage::disk('public')->exists($breadcrumb->background_image)) {
                Storage::disk('public')->delete($breadcrumb->background_image);
            }
            $data['background_image'] = $request->file('background_image')->store('breadcrumbs', 'public');
        }

        $breadcrumb->update($data);

        return redirect()->route('breadcrumb-setting.index')
            ->with('success', "Pengaturan breadcrumb untuk menu '{$breadcrumb->menu_name}' berhasil diperbarui!");
    }

    /**
     * Reset breadcrumb to default.
     */
    public function reset(Breadcrumb $breadcrumb): RedirectResponse
    {
        (new BreadcrumbSeeder())->run();

        return redirect()->route('breadcrumb-setting.index')
            ->with('success', "Breadcrumb untuk '{$breadcrumb->menu_name}' berhasil di-reset ke standar awal!");
    }

    /**
     * Sinkronkan / Muat ulang semua 30 data breadcrumb.
     */
    public function resetAll(): RedirectResponse
    {
        (new BreadcrumbSeeder())->run();

        return redirect()->route('breadcrumb-setting.index')
            ->with('success', 'Seluruh 30 menu breadcrumb frontend berhasil disinkronkan dan terisi penuh!');
    }
}
