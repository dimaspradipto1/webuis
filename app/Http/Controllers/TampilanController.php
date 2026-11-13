<?php

namespace App\Http\Controllers;

use App\Support\TampilanConfig;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class TampilanController extends Controller
{
    private const HEX = ['required', 'regex:/^#([0-9a-fA-F]{3}|[0-9a-fA-F]{6})$/'];

    public function index(Request $request): View
    {
        $tampilan = TampilanConfig::get();
        $presets = TampilanConfig::presets();
        $catalog = TampilanConfig::sectionCatalog();
        $activeTab = in_array($request->query('tab'), ['header', 'footer', 'layout'], true)
            ? $request->query('tab')
            : 'header';

        return view('pages.tampilan.index', compact('tampilan', 'presets', 'catalog', 'activeTab'));
    }

    public function updateHeader(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:80'],
            'subjudul' => ['nullable', 'string', 'max:120'],
            'logo' => ['nullable', 'file', 'mimes:png,jpg,jpeg,webp,svg', 'max:10240'],
            'nav_bg' => self::HEX,
            'nav_text' => self::HEX,
            'nav_accent' => self::HEX,
            'pmb_bg' => self::HEX,
            'pmb_text' => self::HEX,
        ], [
            'judul.required' => 'Judul utama header wajib diisi.',
            'logo.mimes' => 'Logo harus berformat PNG, JPG, WEBP, atau SVG.',
            'logo.max' => 'Ukuran logo maksimal 10MB.',
            '*.regex' => 'Format warna harus berupa kode HEX (contoh: #046b26).',
        ]);

        $values = collect($validated)->except('logo')->map(fn ($v) => is_string($v) ? trim($v) : $v)->all();
        $values['subjudul'] = $values['subjudul'] ?? '';

        if ($request->hasFile('logo')) {
            $old = TampilanConfig::all()['header']['logo'] ?? null;
            $values['logo'] = $request->file('logo')->store('settings', 'public');
            if ($old && Storage::disk('public')->exists($old)) {
                Storage::disk('public')->delete($old);
            }
        } elseif ($request->boolean('hapus_logo')) {
            $old = TampilanConfig::all()['header']['logo'] ?? null;
            if ($old && Storage::disk('public')->exists($old)) {
                Storage::disk('public')->delete($old);
            }
            $values['logo'] = null;
        }

        TampilanConfig::save('header', $values);
        alert()->success('Berhasil!', 'Pengaturan header berhasil disimpan.');

        return redirect()->route('tampilan.index', ['tab' => 'header']);
    }

    public function updateFooter(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'deskripsi' => ['nullable', 'string', 'max:600'],
            'copyright' => ['nullable', 'string', 'max:150'],
            'jam_operasional' => ['nullable', 'string', 'max:120'],
            'footer_bg' => self::HEX,
            'footer_text' => self::HEX,
            'footer_heading' => self::HEX,
            'footer_accent' => self::HEX,
        ], [
            '*.regex' => 'Format warna harus berupa kode HEX (contoh: #023814).',
        ]);

        TampilanConfig::save('footer', array_map(fn ($v) => trim((string) $v), $validated));
        alert()->success('Berhasil!', 'Pengaturan footer berhasil disimpan.');

        return redirect()->route('tampilan.index', ['tab' => 'footer']);
    }

    public function updateLayout(Request $request): RedirectResponse
    {
        $catalog = TampilanConfig::sectionCatalog();
        $orderKeys = array_values(array_filter(
            explode(',', (string) $request->input('urutan')),
            fn ($k) => isset($catalog[$k])
        ));
        // Section yang tidak terkirim tetap disertakan di urutan akhir
        foreach (array_keys($catalog) as $key) {
            if (! in_array($key, $orderKeys, true)) {
                $orderKeys[] = $key;
            }
        }

        $visible = (array) $request->input('visible', []);
        $layout = [];
        foreach ($orderKeys as $i => $key) {
            $layout[$key] = ['order' => $i + 1, 'visible' => isset($visible[$key])];
        }

        TampilanConfig::save('layout', $layout);
        alert()->success('Berhasil!', 'Tata letak beranda berhasil disimpan.');

        return redirect()->route('tampilan.index', ['tab' => 'layout']);
    }

    public function reset(string $group): RedirectResponse
    {
        abort_unless(in_array($group, ['header', 'footer', 'layout'], true), 404);

        TampilanConfig::reset($group);
        alert()->success('Berhasil!', 'Pengaturan dikembalikan ke default.');

        return redirect()->route('tampilan.index', ['tab' => $group]);
    }
}

