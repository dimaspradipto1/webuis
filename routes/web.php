<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AkademikController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BahasaSettingController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DesainGrafisController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\EmagazineHumasController;
use App\Http\Controllers\FacultyStatController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\FeatureController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HeroHumasController;
use App\Http\Controllers\KurikulumController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\LayananHumasController;
use App\Http\Controllers\LayananTerkaitController;
use App\Http\Controllers\MilestoneController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\NilaiPerusahaanController;
use App\Http\Controllers\OrganisasiMahasiswaController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\PmbSettingController;
use App\Http\Controllers\PrestasiController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\PublikasiController;
use App\Http\Controllers\PusatInformasiHumasController;
use App\Http\Controllers\SambutanDekanController;
use App\Http\Controllers\SaranaController;
use App\Http\Controllers\SocialMediaController;
use App\Http\Controllers\StrukturOrganisasiController;
use App\Http\Controllers\TemplateDokumenController;
use App\Http\Controllers\TenagaPendidikController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\TopbarController;
use App\Http\Controllers\TriDharmaController;
use App\Http\Controllers\UnduhanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VisiMisiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Frontend / Public Routes — FIKES (Fakultas Ilmu Kesehatan)
|--------------------------------------------------------------------------
*/
Route::controller(FrontendController::class)->group(function () {
    Route::get('/', 'homepage')->name('homepage');
    Route::get('/tentang', 'tentang')->name('homepage.tentang');
    Route::get('/sambutan-rektor', 'sambutanDekan')->name('homepage.sambutan-rektor');
    Route::get('/sambutan-dekan', fn () => redirect()->route('homepage.sambutan-rektor', [], 301))->name('homepage.sambutan-dekan');
    Route::get('/visi-misi', 'visiMisi')->name('homepage.visi-misi');
    Route::get('/sejarah', 'sejarah')->name('homepage.sejarah');
    Route::get('/organisasi', 'strukturOrganisasi')->name('homepage.struktur-organisasi');
    Route::get('/kurikulum', 'kurikulum')->name('homepage.kurikulum');
    Route::get('/kalender-akademik', 'kalenderAkademik')->name('homepage.kalender-akademik');
    Route::get('/pedoman-akademik', 'pedomanAkademik')->name('homepage.pedoman-akademik');
    Route::get('/sistem-akademik', 'sistemAkademik')->name('homepage.sistem-akademik');
    Route::get('/layanan', 'layanan')->name('homepage.layanan');
    Route::get('/layanan/{slug}', 'layananDetail')->name('homepage.layanan.detail');
    Route::get('/galeri', 'galeri')->name('homepage.galeri');
    Route::get('/galeri/humas', 'galeriHumas')->name('homepage.galeri.humas');
    Route::get('/galeri/universitas', 'galeriUniversitas')->name('homepage.galeri.universitas');
    Route::get('/galeri/{slug}', 'galeriDetail')->name('homepage.galeri.detail');
    Route::get('/prestasi-mahasiswa', 'prestasi')->name('homepage.prestasi');
    Route::get('/prestasi-mahasiswa/{slug}', 'prestasiDetail')->name('homepage.prestasi.detail');
    Route::get('/organisasi-mahasiswa', 'organisasiMahasiswa')->name('homepage.organisasi');
    Route::get('/organisasi-mahasiswa/{slug}', 'organisasiMahasiswaDetail')->name('homepage.organisasi.detail');
    Route::redirect('/dosen', '/layanan')->name('homepage.dosen');
    Route::get('/testimoni', 'testimoni')->name('homepage.testimoni');
    Route::get('/alumni', 'testimoni')->name('homepage.alumni');
    Route::get('/alumni/kirim-testimoni', 'alumniCreateTestimoni')->name('homepage.alumni.create');
    Route::post('/alumni/kirim-testimoni', 'storeTestimonial')->name('homepage.alumni.store');
    Route::get('/berita', 'news')->name('homepage.news');
    Route::get('/berita/kategori/{categorySlug}', 'newsCategory')->name('homepage.news.category');
    Route::get('/berita/{slug}', 'newsDetail')->name('homepage.news.detail');
    Route::get('/faq', 'faq')->name('homepage.faq');
    Route::get('/humas', 'humas')->name('homepage.humas');
    Route::get('/unduhan', 'unduhan')->name('homepage.unduhan');
    Route::get('/unduhan/{kategori}', 'unduhan')->name('homepage.unduhan.kategori');
    Route::get('/desain-grafis', 'desainGrafis')->name('homepage.desain-grafis');
    Route::get('/template-dokumen', 'templateDokumen')->name('homepage.template-dokumen');
    Route::get('/permintaan-rilis', 'permintaanRilis')->name('homepage.permintaan-rilis');
    Route::get('/pendampingan-acara', 'pendampinganAcara')->name('homepage.pendampingan-acara');
    Route::get('/survey-layanan', 'surveyLayanan')->name('homepage.survey-layanan');
    Route::get('/kontak', 'kontak')->name('homepage.kontak');
});

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::post('/loginproses', 'loginproses')->name('loginproses');
    Route::get('/logout', 'logout')->name('logout');
});

/*
|--------------------------------------------------------------------------
| Dashboard / Admin Routes (Auth Protected)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'checkrole'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // My Profile & Self Password Management
    Route::get('/my-profile', [UserController::class, 'myProfile'])->name('user.my-profile');
    Route::patch('/my-profile', [UserController::class, 'updateMyProfile'])->name('user.update-my-profile');
    Route::patch('/my-profile/password', [UserController::class, 'updateMyPassword'])->name('user.update-my-password');

    Route::get('/user/{user}/update-password', [UserController::class, 'updatePasswordForm'])
        ->name('user.updatePasswordForm');
    Route::patch('/user/{user}/update-password', [UserController::class, 'updatePassword'])
        ->name('user.updatePassword');

    Route::resource('user', UserController::class);
    Route::resource('gallery', GalleryController::class);
    Route::resource('profil', ProfilController::class);
    Route::resource('contact', ContactController::class);
    Route::post('news/upload-image', [NewsController::class, 'uploadImage'])->name('news.upload-image');
    Route::get('news/download-template', [NewsController::class, 'downloadTemplate'])->name('news.download-template');
    Route::post('news/import-excel', [NewsController::class, 'importExcel'])->name('news.import-excel');
    Route::resource('news', NewsController::class);
    Route::resource('admin-faq', FaqController::class)
        ->parameters(['admin-faq' => 'faq'])
        ->names('faq');
    Route::resource('about', AboutController::class);
    Route::get('sambutan-rektor-admin', [SambutanDekanController::class, 'index'])->name('sambutan-rektor.index');
    Route::put('sambutan-rektor-admin', [SambutanDekanController::class, 'update'])->name('sambutan-rektor.update');
    Route::get('sambutan-dekan-admin', [SambutanDekanController::class, 'index'])->name('sambutan-dekan.index');
    Route::put('sambutan-dekan-admin', [SambutanDekanController::class, 'update'])->name('sambutan-dekan.update');
    Route::get('pmb-setting-admin', [PmbSettingController::class, 'index'])->name('pmb-setting.index');
    Route::put('pmb-setting-admin', [PmbSettingController::class, 'update'])->name('pmb-setting.update');
    Route::get('admin-hero-humas', [HeroHumasController::class, 'index'])->name('hero-humas.index');
    Route::put('admin-hero-humas', [HeroHumasController::class, 'update'])->name('hero-humas.update');
    Route::resource('admin-unduhan', UnduhanController::class)
        ->parameters(['admin-unduhan' => 'unduhan'])
        ->names('unduhan');
    Route::put('admin-desain-grafis-setting', [DesainGrafisController::class, 'updateSetting'])->name('desain-grafis.update-setting');
    Route::resource('admin-desain-grafis', DesainGrafisController::class)
        ->parameters(['admin-desain-grafis' => 'desainGrafis'])
        ->names('desain-grafis');
    Route::put('admin-pusat-informasi/setting', [PusatInformasiHumasController::class, 'updateSetting'])->name('pusat-informasi.update-setting');
    Route::resource('admin-pusat-informasi', PusatInformasiHumasController::class)
        ->parameters(['admin-pusat-informasi' => 'pusatInformasi'])
        ->names('pusat-informasi');
    Route::get('admin-emagazine-humas', [EmagazineHumasController::class, 'index'])->name('emagazine-humas.index');
    Route::put('admin-emagazine-humas', [EmagazineHumasController::class, 'update'])->name('emagazine-humas.update');
    Route::get('admin-layanan-humas', [LayananHumasController::class, 'index'])->name('layanan-humas.index');
    Route::get('admin-layanan-humas/{kode}', [LayananHumasController::class, 'editItem'])->name('layanan-humas.edit-item');
    Route::put('admin-layanan-humas/{kode}', [LayananHumasController::class, 'updateItem'])->name('layanan-humas.update-item');
    Route::put('admin-template-dokumen/setting', [TemplateDokumenController::class, 'updateSetting'])->name('template-dokumen.update-setting');
    Route::resource('admin-template-dokumen', TemplateDokumenController::class)
        ->parameters(['admin-template-dokumen' => 'templateDokumen'])
        ->names('template-dokumen');

    // Akademik Routes
    Route::prefix('admin-akademik')->name('akademik.')->group(function () {
        Route::get('kurikulum', [AkademikController::class, 'kurikulum'])->name('kurikulum');
        Route::get('kalender', [AkademikController::class, 'kalender'])->name('kalender');
        Route::get('pedoman', [AkademikController::class, 'pedoman'])->name('pedoman');
        Route::get('sistem', [AkademikController::class, 'sistem'])->name('sistem');
        Route::put('{tipe}', [AkademikController::class, 'update'])->name('update');
    });

    Route::post('milestone/setting', [MilestoneController::class, 'updateSetting'])->name('milestone.update-setting');
    Route::resource('milestone', MilestoneController::class);
    Route::resource('admin-kurikulum', KurikulumController::class)
        ->parameters(['admin-kurikulum' => 'kurikulum'])
        ->names('kurikulum');
    Route::resource('banner', BannerController::class);
    Route::post('layanan-terkait/setting', [LayananTerkaitController::class, 'updateSetting'])->name('layanan-terkait.update-setting');
    Route::resource('layanan-terkait', LayananTerkaitController::class);
    Route::post('social-media/setting', [SocialMediaController::class, 'updateSetting'])->name('social-media.update-setting');
    Route::resource('social-media', SocialMediaController::class)
        ->parameters(['social-media' => 'socialMedia']);
    Route::resource('feature', FeatureController::class);
    Route::resource('sarana', SaranaController::class);
    Route::resource('tridharma', TriDharmaController::class);
    Route::resource('tenaga-pendidik', TenagaPendidikController::class);
    Route::resource('testimonial', TestimonialController::class);
    Route::resource('prestasi', PrestasiController::class);
    Route::post('admin-organisasi-mahasiswa/setting', [OrganisasiMahasiswaController::class, 'updateSetting'])->name('organisasi-mahasiswa.update-setting');
    Route::resource('admin-organisasi-mahasiswa', OrganisasiMahasiswaController::class)
        ->parameters(['admin-organisasi-mahasiswa' => 'organisasi-mahasiswa'])
        ->names('organisasi-mahasiswa');
    Route::get('admin-program-studi', [LayananController::class, 'index'])->name('layanan.index');
    Route::post('admin-program-studi', [LayananController::class, 'updateAll'])->name('layanan.update-all');
    Route::get('admin-publikasi', [PublikasiController::class, 'index'])->name('publikasi.index');
    Route::post('admin-publikasi', [PublikasiController::class, 'updateAll'])->name('publikasi.update-all');

    // Dosen Bulk Actions & Excel Import / Template
    Route::post('admin-dosen/bulk-delete', [DosenController::class, 'bulkDelete'])->name('dosen.bulk-delete');
    Route::post('admin-dosen/delete-all', [DosenController::class, 'deleteAll'])->name('dosen.delete-all');
    Route::get('admin-dosen/download-template', [DosenController::class, 'downloadTemplate'])->name('dosen.download-template');
    Route::post('admin-dosen/import-excel', [DosenController::class, 'importExcel'])->name('dosen.import-excel');
    Route::resource('admin-dosen', DosenController::class)
        ->parameters(['admin-dosen' => 'dosen'])
        ->names('dosen');
    Route::resource('admin-topbar', TopbarController::class)
        ->parameters(['admin-topbar' => 'topbar'])
        ->names('topbar');
    Route::resource('struktur-organisasi', StrukturOrganisasiController::class);
    Route::resource('partner', PartnerController::class);
    Route::resource('visimisi', VisiMisiController::class);
    Route::resource('nilaiperusahaan', NilaiPerusahaanController::class);
    Route::resource('faculty-stat', FacultyStatController::class);

    // Pengaturan Bahasa (Multi-Language)
    Route::get('admin-bahasa', [BahasaSettingController::class, 'index'])->name('bahasa.index');
    Route::post('admin-bahasa', [BahasaSettingController::class, 'store'])->name('bahasa.store');
    Route::post('admin-bahasa/update-all', [BahasaSettingController::class, 'updateAll'])->name('bahasa.update-all');
    Route::put('admin-bahasa/{id}', [BahasaSettingController::class, 'update'])->name('bahasa.update');
    Route::post('admin-bahasa/{id}/toggle', [BahasaSettingController::class, 'toggle'])->name('bahasa.toggle');
    Route::post('admin-bahasa/{id}/set-default', [BahasaSettingController::class, 'setDefault'])->name('bahasa.set-default');
    Route::delete('admin-bahasa/{id}', [BahasaSettingController::class, 'destroy'])->name('bahasa.destroy');
});
