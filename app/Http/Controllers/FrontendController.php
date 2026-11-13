<?php

namespace App\Http\Controllers;

use App\Http\Requests\AlumniTestimonialRequest;
use App\Models\About;
use App\Models\Akademik;
use App\Models\Banner;
use App\Models\Contact;
use App\Models\DesainGrafis;
use App\Models\DesainGrafisSetting;
use App\Models\Dosen;
use App\Models\EmagazineHumas;
use App\Models\FacultyStat;
use App\Models\Faq;
use App\Models\Feature;
use App\Models\Gallery;
use App\Models\HeroHumas;
use App\Models\Kurikulum;
use App\Models\Layanan;
use App\Models\LayananHumasItem;
use App\Models\LayananTerkait;
use App\Models\LayananTerkaitSetting;
use App\Models\Milestone;
use App\Models\News;
use App\Models\NilaiPerusahaan;
use App\Models\OrganisasiMahasiswa;
use App\Models\OrganisasiMahasiswaSetting;
use App\Models\Partner;
use App\Models\PendampinganAcaraSetting;
use App\Models\PengumumanAgenda;
use App\Models\PermintaanRilisSetting;
use App\Models\PimpinanManajemen;
use App\Models\PmbSetting;
use App\Models\Prestasi;
use App\Models\ProfilPimpinan;
use App\Models\ProgramStudi;
use App\Models\PusatInformasiHumas;
use App\Models\PusatInformasiHumasSetting;
use App\Models\SambutanDekan;
use App\Models\Sarana;
use App\Models\SocialMedia;
use App\Models\SocialMediaSetting;
use App\Models\StrukturOrganisasi;
use App\Models\SurveyLayananButton;
use App\Models\SurveyLayananSetting;
use App\Models\TemplateDokumen;
use App\Models\TemplateDokumenSetting;
use App\Models\TenagaPendidik;
use App\Models\Testimonial;
use App\Models\TriDharma;
use App\Models\Unduhan;
use App\Models\VisiMisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FrontendController extends Controller
{
    public function homepage(Request $request)
    {
        $banners = Banner::where('aktif', true)->orderBy('urutan')->get();
        $features = Feature::orderBy('urutan')->get();
        $saranas = Sarana::where('is_active', true)->orderBy('urutan')->get();
        $triDharmas = TriDharma::where('is_active', true)->orderBy('urutan')->get();
        $tenagaPendidiks = TenagaPendidik::with('layanan')->where('is_active', true)->orderBy('urutan')->get();
        $layanans = Layanan::where('aktif', true)->orderBy('urutan')->get();
        $partners = Partner::where('aktif', true)->orderBy('urutan')->get();
        $visiMisis = VisiMisi::orderBy('urutan')->get()->groupBy('tipe');
        $nilaiPerusahaans = NilaiPerusahaan::orderBy('urutan')->get();
        $testimonials = Testimonial::where('aktif', true)->orderByDesc('id')->get();

        $search = trim($request->query('q') ?? $request->query('search') ?? '');
        $newsQuery = News::where('status', 'published');
        if (! empty($search)) {
            $newsQuery->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%");
            });
        }
        $latestNews = $newsQuery
            ->orderByDesc('published_at')
            ->orderByDesc('updated_at')
            ->orderByDesc('id')
            ->paginate(10, ['*'], 'page_berita')
            ->withQueryString();

        if ($request->ajax() && ! $request->hasHeader('X-Realtime-Sync')) {
            $html = view('layouts.frontend.partials.homepage-news-grid', compact('latestNews', 'search'))->render();

            return response()->json([
                'html' => $html,
                'count' => $latestNews->total(),
                'hasPages' => $latestNews->hasPages(),
            ]);
        }

        $announcements = News::where('status', 'published')
            ->where(function ($q) {
                $q->where('category', 'like', '%Pengumuman%')
                    ->orWhere('title', 'like', '%Pengumuman%');
            })
            ->orderByDesc('published_at')
            ->orderByDesc('updated_at')
            ->orderByDesc('id')
            ->take(5)
            ->get();
        $pengumumans = PengumumanAgenda::where('tipe', 'pengumuman')
            ->where('is_active', true)
            ->orderBy('urutan')
            ->orderByDesc('id')
            ->get();
        $agendas = PengumumanAgenda::where('tipe', 'agenda')
            ->where('is_active', true)
            ->orderBy('urutan')
            ->orderByDesc('id')
            ->get();
        $faqs = Faq::take(6)->get();
        $galleries = Gallery::where(function ($q) {
            $q->where('kategori', 'universitas')->orWhereNull('kategori');
        })->latest()->take(6)->get();
        $prestasis = News::where('status', 'published')
            ->where('category', 'Prestasi Mahasiswa')
            ->orderByDesc('published_at')
            ->orderByDesc('updated_at')
            ->orderByDesc('id')
            ->take(6)
            ->get();
        $organisasis = OrganisasiMahasiswa::where('is_active', true)->orderBy('urutan')->get();
        $organisasiSetting = OrganisasiMahasiswaSetting::first();
        $about = About::first();
        $sambutanDekan = SambutanDekan::first();
        $struktur = StrukturOrganisasi::first();
        $pmbSetting = PmbSetting::first();
        $facultyStat = FacultyStat::where('is_active', true)->latest('id')->first();
        $layananTerkaits = LayananTerkait::where('is_active', true)->orderBy('urutan')->get();
        $layananTerkaitSetting = LayananTerkaitSetting::first();
        $socialMedias = SocialMedia::where('is_active', true)
            ->where(function ($q) {
                $q->where('kategori', 'universitas')->orWhereNull('kategori');
            })
            ->orderBy('urutan')
            ->get();
        $socialMediaSetting = SocialMediaSetting::first();

        if (! $facultyStat) {
            $facultyStat = (object) [
                'title' => 'UIS Dalam Angka',
                'jumlah_prodi' => 0,
                'total_mahasiswa' => 0,
                'total_dosen' => 0,
                'total_alumni' => 0,
                'image' => null,
            ];
        }

        return view('layouts.frontend.homepage', compact(
            'banners',
            'features',
            'saranas',
            'triDharmas',
            'tenagaPendidiks',
            'layanans',
            'partners',
            'visiMisis',
            'nilaiPerusahaans',
            'testimonials',
            'latestNews',
            'search',
            'announcements',
            'pengumumans',
            'agendas',
            'faqs',
            'galleries',
            'prestasis',
            'organisasis',
            'organisasiSetting',
            'about',
            'sambutanDekan',
            'struktur',
            'pmbSetting',
            'facultyStat',
            'layananTerkaits',
            'layananTerkaitSetting',
            'socialMedias',
            'socialMediaSetting'
        ));
    }

    public function kurikulum(Request $request)
    {
        $prodis = Layanan::where('aktif', true)->orderBy('urutan')->get();

        $selectedProdiId = $request->query('prodi');
        if ($selectedProdiId) {
            $currentProdi = $prodis->firstWhere('id', $selectedProdiId) ?? $prodis->first();
        } else {
            $currentProdi = $prodis->first();
        }

        $query = Kurikulum::where('is_active', true);
        if ($currentProdi) {
            $query->where('layanan_id', $currentProdi->id);
        }

        $courses = $query->orderBy('semester')->orderBy('urutan')->orderBy('id')->get();
        $coursesBySemester = $courses->groupBy('semester');

        $totalSks = $courses->sum('sks');
        $totalMatakuliah = $courses->count();

        $pageTitle = 'Kurikulum '.($currentProdi?->judul ?? 'Program Studi FIKES');

        return view('layouts.frontend.kurikulum', compact('prodis', 'currentProdi', 'coursesBySemester', 'totalSks', 'totalMatakuliah', 'pageTitle'));
    }

    public function kalenderAkademik()
    {
        $item = Akademik::firstOrCreate(['tipe' => 'kalender'], [
            'judul' => 'Kalender Akademik Tahun Akademik 2026/2027',
            'subjudul' => 'Jadwal perkuliahan, registrasi, UTS, UAS, dan kegiatan akademik fakultas.',
            'deskripsi' => '<p>Kalender Akademik memuat seluruh linimasa kegiatan perkuliahan Semester Ganjil dan Genap, termasuk masa registrasi ulang, pengisian KRS, bimbingan akademik, hingga yudisium dan wisuda.</p>',
            'link_url' => '',
            'is_active' => true,
        ]);
        $pageTitle = 'Kalender Akademik';

        return view('layouts.frontend.akademik', compact('item', 'pageTitle'));
    }

    public function pedomanAkademik()
    {
        $item = Akademik::firstOrCreate(['tipe' => 'pedoman'], [
            'judul' => 'Pedoman & Panduan Akademik Mahasiswa',
            'subjudul' => 'Buku panduan tata tertib, prosedur skripsi, magang/PKL, dan etika akademik.',
            'deskripsi' => '<p>Buku Pedoman Akademik merupakan acuan utama bagi seluruh civitas akademika FIKES UIS dalam menjalankan aktivitas belajar-mengajar, tata tertib perkuliahan, evaluasi hasil belajar, dan layanan kemahasiswaan.</p>',
            'link_url' => '',
            'is_active' => true,
        ]);
        $pageTitle = 'Pedoman Akademik';

        return view('layouts.frontend.akademik', compact('item', 'pageTitle'));
    }

    public function sistemAkademik()
    {
        $item = Akademik::firstOrCreate(['tipe' => 'sistem'], [
            'judul' => 'Portal Sistem Informasi Akademik (SIAKAD & E-Learning)',
            'subjudul' => 'Layanan portal digital terpadu untuk pengisian KRS, presensi, nilai, dan pembelajaran online.',
            'deskripsi' => '<p>Sistem Informasi Akademik (SIAKAD) FIKES Universitas Ibnu Sina memfasilitasi mahasiswa dan dosen dalam proses administrasi perkuliahan secara daring, cepat, dan transparan.</p>',
            'link_url' => 'https://siakad.uis.ac.id',
            'is_active' => true,
        ]);
        $pageTitle = 'Sistem Akademik & Portal Online';

        return view('layouts.frontend.akademik', compact('item', 'pageTitle'));
    }

    public function dosen(Request $request)
    {
        $prodis = Layanan::where('aktif', true)->orderBy('urutan')->get();

        $selectedProdiId = $request->query('prodi');
        if ($selectedProdiId) {
            $currentProdi = $prodis->firstWhere('id', $selectedProdiId) ?? $prodis->first();
        } else {
            $currentProdi = $prodis->first();
        }

        $search = trim($request->query('q', ''));

        $query = Dosen::where('is_active', true);
        if ($currentProdi) {
            $query->where('layanan_id', $currentProdi->id);
        }

        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_dosen', 'like', "%{$search}%")
                    ->orWhere('nidn', 'like', "%{$search}%")
                    ->orWhere('nuptk', 'like', "%{$search}%")
                    ->orWhere('jabatan_fungsional', 'like', "%{$search}%");
            });
        }

        $totalDosen = (clone $query)->count();
        $dosens = $query->orderBy('urutan')->orderBy('nama_dosen')->paginate(10)->withQueryString();

        $pageTitle = 'Dosen '.($currentProdi?->judul ?? 'Program Studi FIKES UIS');

        return view('layouts.frontend.dosen', compact('prodis', 'currentProdi', 'dosens', 'totalDosen', 'search', 'pageTitle'));
    }

    public function programStudi()
    {
        $prodis = ProgramStudi::where('is_active', true)->orderBy('urutan')->orderBy('id')->get();
        $prodisS2 = $prodis->where('jenjang', 'S2')->values();
        $prodisS1Grouped = $prodis->where('jenjang', '!=', 'S2')->groupBy('fakultas');
        $fakultasLinks = Layanan::where('aktif', true)->orderBy('urutan')->get();

        return view('layouts.frontend.program-studi', compact('prodis', 'prodisS2', 'prodisS1Grouped', 'fakultasLinks'));
    }

    public function programStudiDetail($slug)
    {
        $prodi = ProgramStudi::where(function ($q) use ($slug) {
            $q->where('slug', $slug)
                ->orWhere('id', $slug);
        })->first();

        if (! $prodi) {
            return $this->layananDetail($slug);
        }

        if (is_numeric($slug) && ! request()->attributes->get('_virtual_slug_decoded') && ! empty($prodi->slug)) {
            return redirect()->route('homepage.program-studi.detail', $prodi->slug, 301);
        }

        $allProdis = ProgramStudi::where('is_active', true)->orderBy('urutan')->orderBy('id')->get();
        $groupedProdis = $allProdis->groupBy('fakultas');

        return view('layouts.frontend.program-studi-detail', compact('prodi', 'allProdis', 'groupedProdis'));
    }

    public function layanan()
    {
        return $this->programStudi();
    }

    public function layananDetail($slug)
    {
        $layanan = Layanan::where(function ($q) use ($slug) {
            $q->where('slug', $slug)
                ->orWhere('id', $slug);
        })
            ->firstOrFail();

        // Redirect numeric ID to slug if available
        if (is_numeric($slug) && ! request()->attributes->get('_virtual_slug_decoded') && ! empty($layanan->slug)) {
            return redirect()->route('homepage.layanan.detail', $layanan->slug, 301);
        }

        $layanans = Layanan::where('aktif', true)->orderBy('urutan')->get();

        return view('layouts.frontend.layanan-detail', compact('layanan', 'layanans'));
    }

    public function galeri(Request $request, $kategori = null)
    {
        // Jika ada query param ?kategori=humas, redirect 301 ke URL slug /galeri/humas
        if ($request->has('kategori') && empty($kategori)) {
            $cat = $request->query('kategori');
            if (in_array($cat, ['humas', 'universitas'])) {
                return redirect()->route('homepage.galeri.'.$cat, [], 301);
            }
        }

        $kategori = $kategori ?? $request->query('kategori');

        $query = Gallery::query();
        if ($kategori === 'humas') {
            $query->where('kategori', 'humas');
        } else {
            // Default untuk /galeri atau /galeri/universitas: khusus galeri universitas
            $query->where(function ($q) {
                $q->where('kategori', 'universitas')->orWhereNull('kategori');
            });
            $kategori = 'universitas';
        }

        $galleries = $query->latest()->paginate(12)->withPath(
            $kategori === 'humas' ? url('/galeri/humas') : url('/galeri')
        );

        return view('layouts.frontend.galeri', compact('galleries', 'kategori'));
    }

    public function galeriHumas(Request $request)
    {
        return $this->galeri($request, 'humas');
    }

    public function galeriUniversitas(Request $request)
    {
        return $this->galeri($request, 'universitas');
    }

    public function galeriDetail($slug)
    {
        if ($slug === 'humas') {
            return redirect()->route('homepage.galeri.humas', [], 301);
        }
        if ($slug === 'universitas') {
            return redirect()->route('homepage.galeri.universitas', [], 301);
        }

        $gallery = Gallery::where(function ($q) use ($slug) {
            $q->where('slug', $slug)
                ->orWhere('id', $slug);
        })
            ->firstOrFail();

        // Redirect numeric ID to slug if available
        if (is_numeric($slug) && ! request()->attributes->get('_virtual_slug_decoded') && ! empty($gallery->slug)) {
            return redirect()->route('homepage.galeri.detail', $gallery->slug, 301);
        }

        $otherGalleries = Gallery::where('id', '!=', $gallery->id)
            ->when(! empty($gallery->kategori), fn ($q) => $q->where('kategori', $gallery->kategori))
            ->latest('id')
            ->take(6)
            ->get();

        return view('layouts.frontend.galeri-detail', compact('gallery', 'otherGalleries'));
    }

    public function tentang()
    {
        $about = About::first();
        $features = Feature::orderBy('urutan')->get();
        $milestones = Milestone::orderBy('tahun')->get();
        $partners = Partner::orderBy('urutan')->get();
        $contact = Contact::first();

        return view('layouts.frontend.about', compact('about', 'features', 'milestones', 'partners', 'contact'));
    }

    public function sambutanDekan()
    {
        $sambutanDekan = SambutanDekan::first();
        $contact = Contact::first();

        return view('layouts.frontend.sambutan-dekan', compact('sambutanDekan', 'contact'));
    }

    public function visiMisi()
    {
        $about = About::first();
        $visiMisis = VisiMisi::orderBy('urutan')->get()->groupBy('tipe');
        $nilaiPerusahaans = NilaiPerusahaan::orderBy('urutan')->get();

        return view('layouts.frontend.visi-misi', compact('about', 'visiMisis', 'nilaiPerusahaans'));
    }

    public function sejarah()
    {
        $about = About::first();
        $milestones = Milestone::orderBy('tahun')->get();

        return view('layouts.frontend.sejarah', compact('about', 'milestones'));
    }

    public function faq()
    {
        $faqs = Faq::all();

        return view('layouts.frontend.faq', compact('faqs'));
    }

    public function strukturOrganisasi()
    {
        $struktur = StrukturOrganisasi::first();
        $pimpinans = ProfilPimpinan::where('is_active', true)
            ->orderBy('baris')
            ->orderBy('urutan')
            ->orderBy('id')
            ->get();
        $pimpinansByBaris = $pimpinans->groupBy('baris');

        $manajemensAll = PimpinanManajemen::where('is_active', true)
            ->orderBy('no_urut')
            ->orderBy('id')
            ->get()
            ->groupBy('kategori');

        $kategoriTabs = ['Rektorat', 'FEB', 'FST', 'FIKES'];

        return view('layouts.frontend.struktur-organisasi', compact(
            'struktur',
            'pimpinans',
            'pimpinansByBaris',
            'manajemensAll',
            'kategoriTabs'
        ));
    }

    public function pimpinanDetail($slug)
    {
        $pimpinan = ProfilPimpinan::where(function ($q) use ($slug) {
            $q->where('slug', $slug)
                ->orWhere('id', $slug);
        })->firstOrFail();

        if (is_numeric($slug) && ! request()->attributes->get('_virtual_slug_decoded') && ! empty($pimpinan->slug)) {
            return redirect()->route('homepage.pimpinan.detail', $pimpinan->slug, 301);
        }

        $otherPimpinans = ProfilPimpinan::where('is_active', true)
            ->where('id', '!=', $pimpinan->id)
            ->orderBy('baris')
            ->orderBy('urutan')
            ->get();

        return view('layouts.frontend.pimpinan-detail', compact('pimpinan', 'otherPimpinans'));
    }

    public function kontak()
    {
        return view('layouts.frontend.contact');
    }

    public function humas()
    {
        $contact = Contact::first();
        $about = About::first();
        $pmbSetting = PmbSetting::first();

        // Ambil berita khusus yang berkategori 'Berita Humas' saja
        $latestNews = News::where('status', 'published')
            ->where('category', 'Berita Humas')
            ->latest()
            ->take(3)
            ->get();

        $faqs = Faq::take(6)->get();
        $socialMedias = SocialMedia::where('is_active', true)
            ->where('kategori', 'humas')
            ->orderBy('urutan')
            ->get();
        $banners = Banner::where('aktif', true)->orderBy('urutan')->get();
        $galleries = Gallery::where('kategori', 'humas')->latest()->take(6)->get();
        $heroHumas = HeroHumas::first();
        $pusatInformasis = PusatInformasiHumas::active()->get();
        $pusatInformasiSetting = PusatInformasiHumasSetting::first();
        $emagazine = EmagazineHumas::first();
        $layananHumasItems = LayananHumasItem::active()->get()->keyBy('kode');

        return view('layouts.frontend.humas', compact(
            'contact', 'about', 'pmbSetting', 'latestNews', 'faqs',
            'socialMedias', 'banners', 'galleries', 'heroHumas',
            'pusatInformasis', 'pusatInformasiSetting', 'emagazine', 'layananHumasItems'
        ));
    }

    public function unduhan(Request $request, $kategori = null)
    {
        // Jika ada ?kategori=image, redirect 301 ke /unduhan/image
        if ($request->has('kategori') && empty($kategori)) {
            $cat = $request->query('kategori');

            return redirect()->route('homepage.unduhan.kategori', $cat, 301);
        }

        $contact = Contact::first();
        $pmbSetting = PmbSetting::first();
        $selectedCat = $kategori ?? $request->query('kategori', 'image');
        $unduhans = Unduhan::where('is_active', true)
            ->orderBy('urutan')
            ->orderBy('id')
            ->get();

        return view('layouts.frontend.unduhan', compact('unduhans', 'selectedCat', 'contact', 'pmbSetting'));
    }

    public function desainGrafis()
    {
        $contact = Contact::first();
        $pmbSetting = PmbSetting::first();

        $categoryConfigs = [
            'audit' => [
                'id' => 'audit',
                'name' => 'Auditorium lt. 4 Rektorat',
                'specs' => 'Ukuran: LED TENGAH untuk gedung Auditorium lt. 4 gedung H. Rasit Kurnain (Format 704 x 320 px / Landscape)',
            ],
            'sidang' => [
                'id' => 'sidang',
                'name' => 'Ruang Sidang lt. 2 Rektorat',
                'specs' => 'Ukuran Layar LCD & Proyektor Ruang Sidang Utama lt. 2 (Format 1920 x 1080 px / 16:9 Full HD)',
            ],
            'dekanat' => [
                'id' => 'dekanat',
                'name' => 'Ruang Rapat Dekanat',
                'specs' => 'Format Display TV Ruang Rapat Fakultas / Dekanat (Format 1920 x 1080 px / Full HD)',
            ],
            'spanduk' => [
                'id' => 'spanduk',
                'name' => 'Banner & Spanduk Outdoor',
                'specs' => 'Spanduk Gerbang Depan & Backdrop Panggung Utama (Format 3 x 1 meter & 4 x 2 meter)',
            ],
        ];

        $dbTemplates = DesainGrafis::where('is_active', true)
            ->orderBy('urutan')
            ->orderBy('id')
            ->get();

        $categories = [];
        foreach ($categoryConfigs as $catKey => $config) {
            $matched = $dbTemplates->where('kategori', $catKey);
            $categories[$catKey] = [
                'id' => $config['id'],
                'name' => $config['name'],
                'specs' => $matched->first()?->spesifikasi ?: $config['specs'],
                'templates' => $matched->map(function ($item) {
                    return [
                        'title' => $item->judul,
                        'desc' => $item->deskripsi,
                        'badge' => $item->badge_teks ?: 'Landscape',
                        'url' => $item->canva_url ?: 'https://www.canva.com',
                        'color' => $item->warna_gradient ?: 'linear-gradient(135deg, #0b6828 0%, #15803d 100%)',
                        'gambar_preview' => $item->preview_url,
                    ];
                })->values()->toArray(),
            ];
        }

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

        $stats = [
            'total' => $setting->stat_total ?? 82,
            'selesai' => $setting->stat_selesai ?? 74,
            'dikerjakan' => $setting->stat_dikerjakan ?? 2,
            'menunggu' => $setting->stat_menunggu ?? 5,
        ];

        return view('layouts.frontend.desain-grafis', compact('contact', 'pmbSetting', 'categories', 'stats', 'setting'));
    }

    public function templateDokumen()
    {
        $contact = Contact::first();
        $pmbSetting = PmbSetting::first();
        $setting = TemplateDokumenSetting::firstOrCreate(
            ['id' => 1],
            [
                'judul_seksi' => 'TEMPLAT DOKUMEN',
                'deskripsi_seksi' => 'Kami menyediakan Templat untuk Desain, Ms. Power Point, Ms. Word dan berbagai format lainnya. Guna menyeragamkan tampilan desain di lingkungan Universitas Ibnu Sina.',
            ]
        );
        $templates = TemplateDokumen::active()->get();

        return view('layouts.frontend.template-dokumen', compact('contact', 'pmbSetting', 'setting', 'templates'));
    }

    public function permintaanRilis()
    {
        $contact = Contact::first();
        $pmbSetting = PmbSetting::first();
        $item = LayananHumasItem::where('kode', 'permintaan-rilis')->first();
        $setting = PermintaanRilisSetting::firstOrCreate(
            ['id' => 1],
            [
                'judul_hero' => 'Permintaan Rilis',
                'subjudul_hero' => 'Panduan & Layanan Pengajuan Siaran Pers Resmi Universitas Ibnu Sina',
                'badge_label' => 'LAYANAN PUBLIKASI & SIARAN PERS',
                'judul_seksi' => 'Ketentuan Permintaan Rilis Berita',
                'deskripsi_seksi' => 'Layanan ini disediakan oleh Biro Humas Universitas Ibnu Sina (UIS) guna memfasilitasi sivitas akademika dalam mengajukan rilis berita kegiatan atau siaran pers untuk dipublikasikan pada portal berita resmi uis.ac.id dan media massa mitra universitas.',
                'link_form' => null,
                'email_tujuan' => 'info@uis.ac.id',
                'no_wa' => $contact->no_wa ?? '081234567890',
                'min_kata' => 250,
                'min_paragraf' => 4,
                'is_active' => true,
            ]
        );

        // Nomor WA bersih untuk wa.me link
        $waRaw = $setting->no_wa ?: ($contact->no_wa ?? '');
        $cleanWa = preg_replace('/[^0-9]/', '', $waRaw);
        if (str_starts_with($cleanWa, '08')) {
            $cleanWa = '628'.substr($cleanWa, 2);
        }

        return view('layouts.frontend.permintaan-rilis', compact('contact', 'pmbSetting', 'item', 'setting', 'cleanWa'));
    }

    public function pendampinganAcara()
    {
        $contact = Contact::first();
        $pmbSetting = PmbSetting::first();
        $item = LayananHumasItem::where('kode', 'pendampingan-acara')->first();
        $setting = PendampinganAcaraSetting::firstOrCreate(
            ['id' => 1],
            [
                'judul_hero' => 'Pendampingan Acara',
                'subjudul_hero' => 'Layanan Konsultasi Protokol & Pendampingan Acara Resmi Universitas Ibnu Sina',
                'judul_seksi' => 'Pendampingan Acara',
                'sapaan' => 'Halo, Civitas Akademika Universitas Ibnu Sina dan Mitra Eksternal!',
                'paragraf_1' => 'Kami hadir untuk mendukung kesuksesan acara dan kegiatan Anda melalui layanan konsultasi yang profesional, terstruktur, dan sesuai dengan Standar Operasional Prosedur (SOP) Universitas Ibnu Sina.',
                'paragraf_2' => 'Apakah Anda sedang merencanakan seminar, workshop, kegiatan sosial, atau event lainnya? Tim kami siap membantu dalam hal:',
                'poin_bantuan' => "Perencanaan dan konsep acara,\nStrategi promosi dan publikasi,\nPengelolaan logistik,\nPengurusan SOP dan perizinan, serta\nPendampingan selama pelaksanaan acara.",
                'paragraf_3' => 'Untuk memulai, silakan isi formulir konsultasi melalui tombol “Ajukan Permohonan” berikut:',
                'link_form' => null,
                'tombol_teks' => 'Ajukan Permohonan',
                'no_wa' => '081234567890',
                'is_active' => true,
            ]
        );

        $waRaw = ! empty($setting->no_wa) ? $setting->no_wa : '081234567890';
        $cleanWa = preg_replace('/[^0-9]/', '', $waRaw);
        if (str_starts_with($cleanWa, '08')) {
            $cleanWa = '628'.substr($cleanWa, 2);
        } elseif (str_starts_with($cleanWa, '8')) {
            $cleanWa = '628'.substr($cleanWa, 1);
        }

        return view('layouts.frontend.pendampingan-acara', compact('contact', 'pmbSetting', 'item', 'setting', 'cleanWa'));
    }

    public function surveyLayanan()
    {
        $contact = Contact::first();
        $pmbSetting = PmbSetting::first();
        $item = LayananHumasItem::where('kode', 'survey-layanan')->first();
        $setting = SurveyLayananSetting::firstOrCreate(
            ['id' => 1],
            [
                'judul_hero' => 'Survey Layanan',
                'subjudul_hero' => 'Kuesioner Evaluasi Kepuasan & Mutu Pelayanan Humas Universitas Ibnu Sina',
                'judul_seksi' => 'Survei Evaluasi',
                'deskripsi_seksi' => 'Silakan isi formulir evaluasi kepuasan layanan berikut untuk membantu kami meningkatkan kualitas mutu pelayanan Humas Universitas Ibnu Sina.',
                'is_active' => true,
            ]
        );

        $buttons = SurveyLayananButton::where('is_active', true)
            ->orderBy('urutan')
            ->orderBy('id')
            ->get();

        return view('layouts.frontend.survey-layanan', compact('contact', 'pmbSetting', 'item', 'setting', 'buttons'));
    }

    public function news(Request $request, $categorySlug = null)
    {
        // Jika ada query param ?category=..., redirect 301 ke slug URL
        if ($request->has('category') && empty($categorySlug)) {
            $catParam = $request->query('category');
            $slug = Str::slug($catParam);

            return redirect()->route('homepage.news.category', $slug, 301);
        }

        $search = $request->query('q');
        $query = News::where('status', 'published');

        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%");
            });
        }

        // Resolving category slug
        $selectedCat = null;
        if (! empty($categorySlug)) {
            $knownCategories = News::whereNotNull('category')->pluck('category')->unique();
            foreach ($knownCategories as $cat) {
                if (Str::slug($cat) === $categorySlug) {
                    $selectedCat = $cat;
                    break;
                }
            }
            if (! $selectedCat) {
                if (str_contains($categorySlug, 'pengumuman') || str_contains($categorySlug, 'agenda')) {
                    $selectedCat = 'Pengumuman & Agenda';
                } elseif (str_contains($categorySlug, 'berita') || str_contains($categorySlug, 'kampus')) {
                    $selectedCat = 'Berita Universitas';
                } elseif (str_contains($categorySlug, 'humas')) {
                    $selectedCat = 'Berita Humas';
                } elseif (str_contains($categorySlug, 'prestasi')) {
                    $selectedCat = 'Prestasi Mahasiswa';
                } else {
                    $selectedCat = str_replace('-', ' ', $categorySlug);
                }
            }
            $query->where('category', 'like', "%{$selectedCat}%");
        }

        $featured = null;
        if (empty($search) && empty($categorySlug)) {
            $featured = News::where('status', 'published')
                ->where('is_featured', true)
                ->orderByDesc('published_at')
                ->orderByDesc('updated_at')
                ->orderByDesc('id')
                ->first();

            if (! $featured) {
                $featured = News::where('status', 'published')
                    ->orderByDesc('published_at')
                    ->orderByDesc('updated_at')
                    ->orderByDesc('id')
                    ->first();
            }
        }

        $newsList = $query
            ->when($featured, fn ($q) => $q->where('id', '!=', $featured->id))
            ->orderByDesc('published_at')
            ->orderByDesc('updated_at')
            ->orderByDesc('id')
            ->paginate(10)
            ->withPath($categorySlug ? url('/berita/kategori/'.$categorySlug) : url('/berita'));

        $categories = News::where('status', 'published')
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->select('category', DB::raw('count(*) as total'))
            ->groupBy('category')
            ->orderBy('category')
            ->get();

        return view('layouts.frontend.news', compact('featured', 'newsList', 'search', 'categories', 'selectedCat', 'categorySlug'));
    }

    public function newsCategory(Request $request, $categorySlug)
    {
        return $this->news($request, $categorySlug);
    }

    public function newsDetail($slug)
    {
        $news = News::where('status', 'published')
            ->where(function ($q) use ($slug) {
                $q->where('slug', $slug)
                    ->orWhere('id', $slug);
            })
            ->firstOrFail();

        // Redirect numeric ID to slug if available
        if (is_numeric($slug) && ! request()->attributes->get('_virtual_slug_decoded') && ! empty($news->slug)) {
            return redirect()->route('homepage.news.detail', $news->slug, 301);
        }

        $relatedNews = News::where('status', 'published')
            ->where('id', '!=', $news->id)
            ->latest()
            ->take(4)
            ->get();

        $categories = News::where('status', 'published')
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->select('category', DB::raw('count(*) as total'))
            ->groupBy('category')
            ->orderBy('category')
            ->get();

        return view('layouts.frontend.news-detail', compact('news', 'relatedNews', 'categories'));
    }

    public function prestasi(Request $request)
    {
        $search = $request->query('q');

        $query = News::where('status', 'published')
            ->where('category', 'Prestasi Mahasiswa');

        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $prestasiList = $query
            ->orderByDesc('published_at')
            ->orderByDesc('updated_at')
            ->orderByDesc('id')
            ->paginate(9)
            ->withQueryString();

        return view('layouts.frontend.prestasi', compact('prestasiList', 'search'));
    }

    public function prestasiDetail($slug)
    {
        $prestasi = News::where('status', 'published')
            ->where(function ($q) use ($slug) {
                $q->where('slug', $slug)
                    ->orWhere('id', $slug);
            })
            ->firstOrFail();

        if (is_numeric($slug) && ! request()->attributes->get('_virtual_slug_decoded') && ! empty($prestasi->slug)) {
            return redirect()->route('homepage.prestasi.detail', $prestasi->slug, 301);
        }

        $otherPrestasis = News::where('status', 'published')
            ->where('category', 'Prestasi Mahasiswa')
            ->where('id', '!=', $prestasi->id)
            ->orderByDesc('published_at')
            ->orderByDesc('updated_at')
            ->orderByDesc('id')
            ->take(5)
            ->get();

        return view('layouts.frontend.prestasi-detail', compact('prestasi', 'otherPrestasis'));
    }

    public function organisasiMahasiswa(Request $request)
    {
        $search = $request->query('q');
        $selectedKategori = $request->query('kategori');

        $query = OrganisasiMahasiswa::where('is_active', true);

        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_organisasi', 'like', "%{$search}%")
                    ->orWhere('singkatan', 'like', "%{$search}%")
                    ->orWhere('nama_ketua', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        if (! empty($selectedKategori)) {
            $query->where('kategori', $selectedKategori);
        }

        $organisasiList = $query->orderBy('urutan')->latest('id')->paginate(9)->withQueryString();

        $kategoriList = ['BEM / DPM', 'Himpunan Mahasiswa (HIMA)', 'Unit Kegiatan Mahasiswa (UKM)', 'Komunitas Minat Bakat'];

        return view('layouts.frontend.organisasi', compact('organisasiList', 'search', 'selectedKategori', 'kategoriList'));
    }

    public function organisasiMahasiswaDetail($slug)
    {
        $organisasi = OrganisasiMahasiswa::where('is_active', true)
            ->where(function ($q) use ($slug) {
                $q->where('slug', $slug)
                    ->orWhere('id', $slug);
            })
            ->firstOrFail();

        $otherOrganisasis = OrganisasiMahasiswa::where('is_active', true)
            ->where('id', '!=', $organisasi->id)
            ->orderBy('urutan')
            ->latest('id')
            ->take(5)
            ->get();

        return view('layouts.frontend.organisasi-detail', compact('organisasi', 'otherOrganisasis'));
    }

    public function testimoni(Request $request)
    {
        $search = $request->query('q');
        $selectedKategori = $request->query('kategori');
        $selectedRating = $request->query('rating');

        $query = Testimonial::where('aktif', true);

        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('pekerjaan', 'like', "%{$search}%")
                    ->orWhere('pesan', 'like', "%{$search}%");
            });
        }

        if (! empty($selectedKategori)) {
            $query->where('kategori', $selectedKategori);
        }

        if (! empty($selectedRating)) {
            $query->where('bintang', $selectedRating);
        }

        $testimonials = $query->orderByDesc('id')->paginate(10)->withQueryString();

        // Rating Stats for Analytics Chart & Summary
        $allActive = Testimonial::where('aktif', true)->get();
        $totalCount = $allActive->count();
        $avgScore = $totalCount > 0 ? round($allActive->avg('bintang'), 1) : 5.0;

        $ratingCounts = [
            5 => $allActive->where('bintang', 5)->count(),
            4 => $allActive->where('bintang', 4)->count(),
            3 => $allActive->where('bintang', 3)->count(),
            2 => $allActive->where('bintang', 2)->count(),
            1 => $allActive->where('bintang', 1)->count(),
        ];

        $ratingPercentages = [];
        foreach ($ratingCounts as $star => $count) {
            $ratingPercentages[$star] = $totalCount > 0 ? round(($count / $totalCount) * 100) : 0;
        }

        $categories = $allActive->pluck('kategori')->filter()->unique()->values();

        return view('layouts.frontend.testimoni', compact(
            'testimonials',
            'search',
            'selectedKategori',
            'selectedRating',
            'totalCount',
            'avgScore',
            'ratingCounts',
            'ratingPercentages',
            'categories'
        ));
    }

    public function alumniCreateTestimoni()
    {
        return view('layouts.frontend.alumni-form');
    }

    public function storeTestimonial(AlumniTestimonialRequest $request)
    {
        $validated = $request->validated();
        $validated['aktif'] = false; // Pending moderasi admin

        Testimonial::create($validated);

        return redirect()
            ->route('homepage.alumni.create')
            ->with('success', 'Terima kasih atas kontribusi Anda! Testimoni & kisah sukses Anda telah berhasil kami terima dan akan segera ditinjau oleh admin.');
    }

    public function fasilitas(Request $request)
    {
        $selectedKategori = $request->query('kategori', '');

        $query = Sarana::where('is_active', true)->orderBy('urutan');

        if (! empty($selectedKategori)) {
            $query->where('kategori', $selectedKategori);
        }

        $saranas = $query->get();
        $allSaranas = Sarana::where('is_active', true)->orderBy('urutan')->get();

        return view('layouts.frontend.fasilitas', compact('saranas', 'allSaranas', 'selectedKategori'));
    }

    public function fasilitasDetail(string $slug)
    {
        $sarana = Sarana::where('slug', $slug)
            ->orWhere(function ($q) use ($slug) {
                if (is_numeric($slug)) {
                    $q->where('id', (int) $slug);
                }
            })
            ->firstOrFail();

        if (is_numeric($slug) && ! request()->attributes->get('_virtual_slug_decoded') && ! empty($sarana->slug)) {
            return redirect()->route('homepage.fasilitas.detail', $sarana->slug, 301);
        }

        $otherSaranas = Sarana::where('is_active', true)
            ->orderBy('urutan')
            ->get();

        return view('layouts.frontend.fasilitas-detail', compact('sarana', 'otherSaranas'));
    }

    public function pengumumanAgenda(Request $request)
    {
        $selectedTipe = $request->query('tipe', '');

        $allItems = PengumumanAgenda::where('is_active', true)
            ->orderBy('urutan')
            ->orderByDesc('id')
            ->get();

        $items = ! empty($selectedTipe)
            ? $allItems->where('tipe', $selectedTipe)->values()
            : $allItems;

        $pengumumans = $allItems->where('tipe', 'pengumuman')->values();
        $agendas = $allItems->where('tipe', 'agenda')->values();

        return view('layouts.frontend.pengumuman-agenda', compact('items', 'allItems', 'pengumumans', 'agendas', 'selectedTipe'));
    }

    public function pengumumanAgendaDetail(string $slug)
    {
        $item = PengumumanAgenda::where('slug', $slug)
            ->orWhere(function ($q) use ($slug) {
                if (is_numeric($slug)) {
                    $q->where('id', (int) $slug);
                }
            })
            ->firstOrFail();

        if (is_numeric($slug) && ! request()->attributes->get('_virtual_slug_decoded') && ! empty($item->slug)) {
            return redirect()->route('homepage.pengumuman-agenda.detail', $item->slug, 301);
        }

        $otherPengumumans = PengumumanAgenda::where('is_active', true)
            ->where('tipe', 'pengumuman')
            ->where('id', '!=', $item->id)
            ->orderBy('urutan')
            ->orderByDesc('id')
            ->take(5)
            ->get();

        $otherAgendas = PengumumanAgenda::where('is_active', true)
            ->where('tipe', 'agenda')
            ->where('id', '!=', $item->id)
            ->orderBy('urutan')
            ->orderByDesc('id')
            ->take(5)
            ->get();

        return view('layouts.frontend.pengumuman-agenda-detail', compact('item', 'otherPengumumans', 'otherAgendas'));
    }

    public function realtimeState()
    {
        $tables = [
            'news',
            'banners',
            'faculty_stats',
            'program_studis',
            'profil_pimpinans',
            'pimpinan_manajemens',
            'pengumuman_agendas',
            'galleries',
            'partners',
            'prestasis',
            'saranas',
            'layanans',
            'abouts',
            'sambutan_dekans',
            'visi_misis',
            'milestones',
            'faqs',
            'testimonials',
            'organisasi_mahasiswas',
            'features',
            'contacts',
        ];

        $parts = [];
        foreach ($tables as $table) {
            try {
                $row = DB::table($table)
                    ->selectRaw('COUNT(*) as c, MAX(updated_at) as u')
                    ->first();
                $parts[] = $table.':'.($row->c ?? 0).':'.($row->u ?? '');
            } catch (\Throwable $e) {
                // Ignore if table doesn't have updated_at
            }
        }

        try {
            $waPath = storage_path('app/public/settings/wa_admin.json');
            if (file_exists($waPath)) {
                $parts[] = 'wa_admin:' . filemtime($waPath);
            }
        } catch (\Throwable $e) {
        }

        return response()->json([
            'hash' => md5(implode('|', $parts)),
        ])->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
    }
}
