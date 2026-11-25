@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Kelola Visi, Misi & Tata Nilai UIS</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Profil</li>
            <li class="breadcrumb-item active">Visi & Misi</li>
        </ol>
    </nav>
</div>

{{-- ═══════════════════════════════════════════════════════════════
     INFORMASI PENGATURAN BREADCRUMB & HERO BANNER TERPUSAT
     ═══════════════════════════════════════════════════════════════ --}}
<div class="alert alert-light border shadow-sm d-flex flex-wrap align-items-center justify-content-between p-3 mb-4 rounded-3" style="border-left: 4px solid #046B26 !important; background: #ffffff;">
    <div class="d-flex align-items-center gap-3">
        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: #e8f5e9; color: #046B26; flex-shrink: 0;">
            <i class="bi bi-compass fs-4"></i>
        </div>
        <div>
            <div class="fw-bold text-dark" style="font-size: 15px;">Pengaturan Judul & Hero Banner Halaman Terpusat di Breadcrumb</div>
            <div class="text-muted small" style="line-height: 1.4;">Teks judul hero banner, label badge kategori, kalimat pengantar, dan jejak breadcrumb navigasi dikelola secara terpusat di modul Breadcrumb.</div>
        </div>
    </div>
    <div class="d-flex align-items-center gap-2 mt-2 mt-lg-0">
        <a href="{{ route('breadcrumb-setting.edit', $breadcrumb->id ?? 2) }}" class="btn btn-sm btn-outline-success fw-semibold">
            <i class="bi bi-pencil-square me-1"></i> Edit Breadcrumb & Hero Banner
        </a>
        <a href="{{ route('homepage.visi-misi') }}" target="_blank" class="btn btn-sm btn-success fw-semibold" style="background-color: #046B26; border-color: #046B26;">
            <i class="bi bi-box-arrow-up-right me-1"></i> Pratinjau Frontend
        </a>
    </div>
</div>

<form action="{{ route('visimisi.update-content') }}" method="POST" enctype="multipart/form-data">
    @csrf

    {{-- ═══════════════════════════════════════════════════════════════
         KARTU 1: UPLOAD BACKGROUND UTAMA VISI MISI
         ═══════════════════════════════════════════════════════════════ --}}
    <div class="card shadow-sm border-0 mb-4" style="border-radius: 12px;">
        <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between" style="border-top: 3px solid #046B26; border-radius: 12px 12px 0 0;">
            <div class="d-flex align-items-center gap-2">
                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background-color: #e8f5e9; color: #046B26;">
                    <i class="bi bi-image fs-5"></i>
                </div>
                <div>
                    <h5 class="mb-0 fw-bold" style="color: #2b2f32; font-size: 16px;">Background Utama Banner Visi Misi</h5>
                    <small class="text-muted">Unggah foto latar belakang (contoh: foto gedung kampus UIS / motif institusi) sebagai background utama banner</small>
                </div>
            </div>
            <span class="badge" style="background-color: #046B26; color: #ffffff; font-size: 11.5px; font-weight: 700; padding: 6px 12px; border-radius: 6px;">
                <i class="bi bi-layers me-1"></i> Background Banner Utama
            </span>
        </div>
        <div class="card-body pt-3 pb-4">
            <div class="row g-4 align-items-center">
                {{-- Preview Background Aktif --}}
                <div class="col-lg-4 col-md-5 col-12">
                    <label class="form-label fw-bold text-dark small mb-2">Preview Background Saat Ini</label>
                    <div class="position-relative rounded-3 overflow-hidden border shadow-sm" style="height: 160px; background: #046B26;">
                        @if($about->visimisi_background_url)
                            <img src="{{ $about->visimisi_background_url }}" 
                                 alt="Background Visi Misi" 
                                 id="currentBgPreviewImg"
                                 style="width: 100%; height: 100%; object-fit: cover;"
                                 onerror="this.style.display='none'; document.getElementById('bgFallbackStandard').classList.remove('d-none'); document.getElementById('bgOverlayBar').classList.add('d-none');">
                        @endif
                        <div id="bgOverlayBar" class="position-absolute bottom-0 start-0 end-0 p-2 d-flex align-items-center justify-content-between @if(!$about->visimisi_background_url) d-none @endif" style="background: rgba(0,0,0,0.65);">
                            <span class="badge bg-success" style="font-size: 10.5px;"><i class="bi bi-check-circle me-1"></i>Kustom Aktif</span>
                            <button type="button" class="btn btn-danger btn-sm py-0 px-2" style="font-size: 11px;" onclick="document.getElementById('formDeleteBackground').submit();" title="Hapus Background Kustom">
                                <i class="bi bi-trash me-1"></i>Hapus
                            </button>
                        </div>
                        <div id="bgFallbackStandard" class="d-flex flex-column align-items-center justify-content-center h-100 text-white text-center p-3 @if($about->visimisi_background_url) d-none @endif" style="background: linear-gradient(135deg, #13883a 0%, #034b1a 100%);">
                            <i class="bi bi-palette fs-2 mb-1 text-warning"></i>
                            <span class="fw-bold small">Latar Standar Gradasi Hijau UIS</span>
                            <small class="text-white-50" style="font-size: 11px;">Belum ada foto background kustom</small>
                        </div>
                    </div>
                </div>

                {{-- Upload File Baru --}}
                <div class="col-lg-8 col-md-7 col-12">
                    <label for="visimisi_background" class="form-label fw-bold text-dark small">
                        Pilih Gambar Background Baru <small class="text-muted fw-normal">(JPG, PNG, WEBP, Maks. 5MB)</small>
                    </label>
                    <input type="file" 
                           class="form-control @error('visimisi_background') is-invalid @enderror" 
                           id="visimisi_background" 
                           name="visimisi_background" 
                           accept="image/jpeg,image/png,image/jpg,image/webp">
                    <div class="form-text text-muted small mt-2" style="line-height: 1.5;">
                        <i class="bi bi-info-circle me-1 text-success"></i>
                        Disarankan menggunakan foto lanskap gedung/aktivitas kampus dengan resolusi minimal <strong>1920 × 1080 piksel</strong>. Sistem akan otomatis memadukan gambar dengan overlay hijau khas UIS agar teks tetap mudah dibaca.
                    </div>
                    @error('visimisi_background')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════
         KARTU 2: KELOLA KONTEN TEKS 3 KARTU (VISI, MISI, TATA NILAI)
         ═══════════════════════════════════════════════════════════════ --}}
    <div class="card shadow-sm border-0 mb-4" style="border-radius: 12px;">
        <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between" style="border-top: 3px solid #046B26; border-radius: 12px 12px 0 0;">
            <div class="d-flex align-items-center gap-2">
                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background-color: #e8f5e9; color: #046B26;">
                    <i class="bi bi-card-text fs-5"></i>
                </div>
                <div>
                    <h5 class="mb-0 fw-bold" style="color: #2b2f32; font-size: 16px;">Konten Teks Visi, Misi & Tata Nilai UIS</h5>
                    <small class="text-muted">Kelola isi teks Visi, Misi dan Tata Nilai yang tampil di dalam banner utama dalam bentuk teks dinamis (bukan gambar mati)</small>
                </div>
            </div>
            <span class="badge" style="background-color: #fed802; color: #111111; font-size: 11.5px; font-weight: 700; padding: 6px 12px; border-radius: 6px;">
                <i class="bi bi-fonts me-1"></i> Teks Dinamis
            </span>
        </div>
        <div class="card-body pt-3 pb-4">
            <div class="row g-4">
                {{-- Kolom 1: Visi UIS --}}
                <div class="col-lg-4 col-12">
                    <div class="p-3 rounded-3 border h-100" style="background: #fbfdfb; border-color: #d1e7dd !important;">
                        <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
                            <span class="badge rounded-circle p-2" style="background: #046B26; color: #fff;">
                                <i class="bi bi-eye-fill"></i>
                            </span>
                            <div>
                                <h6 class="fw-bold mb-0 text-success">Kartu 1: Visi UIS</h6>
                                <small class="text-muted" style="font-size: 11px;">Tagline & teks visi institusi</small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="visimisi_tagline_visi" class="form-label fw-bold small text-dark">
                                Teks / Tagline Utama Visi <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control tinymce-visimisi @error('visimisi_tagline_visi') is-invalid @enderror" 
                                      id="visimisi_tagline_visi" 
                                      name="visimisi_tagline_visi" 
                                      rows="8">{!! old('visimisi_tagline_visi', !empty(trim(strip_tags($about->visimisi_tagline_visi ?? ''))) ? $about->visimisi_tagline_visi : '<p>Unggul, Berintegritas, Berjiwa Entrepreneurship</p>') !!}</textarea>
                            <div class="form-text text-muted small mt-1">
                                Teks ini akan tampil besar dan elegan di tengah kartu Visi.
                            </div>
                            @error('visimisi_tagline_visi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Kolom 2: Misi UIS --}}
                <div class="col-lg-4 col-12">
                    <div class="p-3 rounded-3 border h-100" style="background: #fbfdfb; border-color: #d1e7dd !important;">
                        <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
                            <span class="badge rounded-circle p-2" style="background: #046B26; color: #fff;">
                                <i class="bi bi-bullseye"></i>
                            </span>
                            <div>
                                <h6 class="fw-bold mb-0 text-success">Kartu 2: Misi UIS</h6>
                                <small class="text-muted" style="font-size: 11px;">Daftar butir-butir misi</small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="visimisi_misi_items" class="form-label fw-bold small text-dark">
                                Butir-Butir Misi UIS <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control tinymce-visimisi @error('visimisi_misi_items') is-invalid @enderror" 
                                      id="visimisi_misi_items" 
                                      name="visimisi_misi_items" 
                                      rows="11" 
                                      style="font-size: 12.5px; line-height: 1.5;">{!! old('visimisi_misi_items', !empty(trim(strip_tags($about->visimisi_misi_items ?? ''))) ? $about->visimisi_misi_items : "<ol>\n<li>Menyelenggarakan pendidikan tinggi yang unggul dengan mengintegrasikan nilai-nilai integritas dan kewirausahaan dalam proses pembelajaran, penelitian, dan pengabdian kepada Masyarakat.</li>\n<li>Mengembangkan penelitian inovatif dan relevan yang berkontribusi pada kemajuan ilmu pengetahuan, teknologi, dan pemecahan masalah di masyarakat.</li>\n<li>Membangun ekosistem kewirausahaan yang mendorong kreativitas, inovasi, dan kemandirian di kalangan civitas akademika dan masyarakat luas.</li>\n<li>Menerapkan tata kelola universitas yang kredibel, transparan, akuntabel, bertanggungjawab dan berintegritas tinggi untuk mendukung pencapaian keunggulan institusi.</li>\n<li>Menjalin kerjasama strategis dengan berbagai pemangku kepentingan untuk meningkatkan daya saing, reputasi, dan kontribusi universitas di tingkat nasional dan internasional.</li>\n</ol>") !!}</textarea>
                            <div class="form-text text-muted small mt-1">
                                Tuliskan setiap butir misi (bisa menggunakan fitur Numbered List di editor).
                            </div>
                            @error('visimisi_misi_items')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Kolom 3: Tata Nilai UIS CIP --}}
                <div class="col-lg-4 col-12">
                    <div class="p-3 rounded-3 border h-100" style="background: #fbfdfb; border-color: #d1e7dd !important;">
                        <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
                            <span class="badge rounded-circle p-2" style="background: #046B26; color: #fff;">
                                <i class="bi bi-gem"></i>
                            </span>
                            <div>
                                <h6 class="fw-bold mb-0 text-success">Kartu 3: Tata Nilai UIS</h6>
                                <small class="text-muted" style="font-size: 11px;">Budaya nilai "CIP"</small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="visimisi_tatanilai_judul" class="form-label fw-bold small text-dark">
                                Judul Tata Nilai <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control form-control-sm @error('visimisi_tatanilai_judul') is-invalid @enderror" 
                                   id="visimisi_tatanilai_judul" 
                                   name="visimisi_tatanilai_judul" 
                                   value="{{ old('visimisi_tatanilai_judul', $about->visimisi_tatanilai_judul ?? 'TATA NILAI UIS "CIP"') }}" 
                                   required>
                            @error('visimisi_tatanilai_judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="visimisi_tatanilai_items" class="form-label fw-bold small text-dark">
                                Butir Tata Nilai CIP <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control tinymce-visimisi @error('visimisi_tatanilai_items') is-invalid @enderror" 
                                      id="visimisi_tatanilai_items" 
                                      name="visimisi_tatanilai_items" 
                                      rows="7" 
                                      style="font-size: 12.5px; line-height: 1.5;">{!! old('visimisi_tatanilai_items', !empty(trim(strip_tags($about->visimisi_tatanilai_items ?? ''))) ? $about->visimisi_tatanilai_items : "<p><strong>(C) CERDAS:</strong> Spiritual, intelektual dan emosional</p>\n<p><strong>(I) INTEGRITAS:</strong> Jujur, disiplin, Komitmen dan bertanggung jawab</p>\n<p><strong>(P) PROFESIONAL:</strong> Objektif, Adil dan Transparan</p>") !!}</textarea>
                            <div class="form-text text-muted small mt-1">
                                Format: <code>(C) CERDAS: Penjelasan</code> (gunakan format Bold atau warna untuk label).
                            </div>
                            @error('visimisi_tatanilai_items')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════
         KARTU 3: PENGATURAN BADGE & IDENTITAS SOSIAL FOOTER KARTU
         ═══════════════════════════════════════════════════════════════ --}}
    <div class="accordion mb-4" id="accordionExtraSettings">
        <div class="accordion-item border shadow-sm rounded-3 overflow-hidden">
            <h2 class="accordion-header" id="headingExtra">
                <button class="accordion-button collapsed fw-bold text-dark py-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExtra" aria-expanded="false">
                    <i class="bi bi-sliders me-2 text-success"></i> Pengaturan Badge & Identitas Sosial Media Footer Kartu (Opsional)
                </button>
            </h2>
            <div id="collapseExtra" class="accordion-collapse collapse" data-bs-parent="#accordionExtraSettings">
                <div class="accordion-body bg-light bg-opacity-25 pt-3 pb-4">
                    <div class="row g-3">
                        <div class="col-md-6 col-12">
                            <label for="visimisi_badge_humas" class="form-label fw-bold small text-dark">Teks Badge Bawah (Pill Kuning)</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="visimisi_badge_humas" 
                                   name="visimisi_badge_humas" 
                                   value="{{ old('visimisi_badge_humas', $about->visimisi_badge_humas ?? 'HUMAS UNIVERSITAS IBNU SINA') }}" 
                                   placeholder="HUMAS UNIVERSITAS IBNU SINA">
                        </div>
                        <div class="col-md-6 col-12">
                            <label for="visimisi_footer_fb" class="form-label fw-bold small text-dark">Label Akun YouTube / Facebook</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="visimisi_footer_fb" 
                                   name="visimisi_footer_fb" 
                                   value="{{ old('visimisi_footer_fb', $about->visimisi_footer_fb ?? 'Universitas Ibnu Sina') }}" 
                                   placeholder="Universitas Ibnu Sina">
                        </div>
                        <div class="col-md-6 col-12">
                            <label for="visimisi_footer_ig" class="form-label fw-bold small text-dark">Label Akun Instagram / TikTok</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="visimisi_footer_ig" 
                                   name="visimisi_footer_ig" 
                                   value="{{ old('visimisi_footer_ig', $about->visimisi_footer_ig ?? 'Official.uisbatam') }}" 
                                   placeholder="Official.uisbatam">
                        </div>
                        <div class="col-md-6 col-12">
                            <label for="visimisi_footer_url" class="form-label fw-bold small text-dark">Tautan Website Utama</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="visimisi_footer_url" 
                                   name="visimisi_footer_url" 
                                   value="{{ old('visimisi_footer_url', $about->visimisi_footer_url ?? 'https://uis.ac.id') }}" 
                                   placeholder="https://uis.ac.id">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════
         TOMBOL SIMPAN UTAMA
         ═══════════════════════════════════════════════════════════════ --}}
    <div class="card shadow-sm border-0 mb-4" style="border-radius: 12px;">
        <div class="card-body py-3 d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div class="text-muted small">
                <i class="bi bi-shield-check text-success me-1"></i> Perubahan teks dan background akan langsung diterapkan secara realtime di halaman Visi & Misi frontend.
            </div>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('homepage.visi-misi') }}" target="_blank" class="btn btn-outline-success fw-semibold">
                    <i class="bi bi-box-arrow-up-right me-1"></i> Lihat Frontend
                </a>
                <button type="submit" class="btn fw-semibold px-4 shadow-sm" style="background-color: #046B26; color: #ffffff; border-color: #046B26;">
                    <i class="bi bi-floppy-fill me-1"></i> Simpan Visi, Misi & Tata Nilai
                </button>
            </div>
        </div>
    </div>
</form>

{{-- Form Tersembunyi untuk Hapus Background --}}
<form id="formDeleteBackground" action="{{ route('visimisi.delete-background') }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Live Preview saat memilih file background baru
        const inputBg = document.getElementById('visimisi_background');
        if (inputBg) {
            inputBg.addEventListener('change', function (e) {
                const file = e.target.files && e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (evt) {
                        let img = document.getElementById('currentBgPreviewImg');
                        const fallback = document.getElementById('bgFallbackStandard');
                        const overlay = document.getElementById('bgOverlayBar');
                        const container = fallback ? fallback.parentElement : null;

                        if (!img && container) {
                            img = document.createElement('img');
                            img.id = 'currentBgPreviewImg';
                            img.alt = 'Background Visi Misi';
                            img.style.width = '100%';
                            img.style.height = '100%';
                            img.style.objectFit = 'cover';
                            container.prepend(img);
                        }

                        if (img) {
                            img.src = evt.target.result;
                            img.style.display = 'block';
                        }
                        if (fallback) fallback.classList.add('d-none');
                        if (overlay) overlay.classList.remove('d-none');
                    };
                    reader.readAsDataURL(file);
                }
            });
        }

        if (typeof tinymce !== 'undefined') {
            tinymce.init({
                selector: 'textarea.tinymce-visimisi',
                height: 320,
                menubar: false,
                branding: false,
                plugins: 'advlist autolink lists link code wordcount',
                toolbar: 'undo redo | bold italic underline | forecolor backcolor | bullist numlist | alignleft aligncenter alignright | removeformat code',
                content_style: 'body { font-family: "Plus Jakarta Sans", Arial, sans-serif; font-size: 13.5px; line-height: 1.6; color: #1e293b; } ol, ul { padding-left: 20px; } p { margin-bottom: 6px; } strong, b { font-weight: 700; }',
                setup: function (editor) {
                    editor.on('change keyup NodeChange', function () {
                        editor.save();
                    });
                }
            });
        }

        const mainForm = document.querySelector('form[action="{{ route('visimisi.update-content') }}"]');
        if (mainForm) {
            mainForm.addEventListener('submit', function () {
                if (typeof tinymce !== 'undefined') {
                    tinymce.triggerSave();
                }
            });
        }
    });
</script>
@endpush
