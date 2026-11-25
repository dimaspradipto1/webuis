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
<div class="card border-0 shadow-sm mb-4" style="border-radius: 12px; border-left: 5px solid #046B26 !important;">
    <div class="card-body p-3 p-md-4">
        <div class="row align-items-center g-3">
            <div class="col-xl-8 col-lg-7 col-12">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px; background: #e8f5e9; color: #046B26;">
                        <i class="bi bi-compass fs-4"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold text-dark mb-1" style="font-size: 15px;">Pengaturan Judul & Hero Banner Halaman Terpusat di Breadcrumb</h6>
                        <p class="text-muted small mb-0" style="line-height: 1.5;">Teks judul hero banner, label badge kategori, kalimat pengantar, dan jejak breadcrumb navigasi dikelola secara terpusat di modul Breadcrumb.</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-5 col-12 text-lg-end">
                <div class="d-flex align-items-center justify-content-lg-end gap-2 flex-wrap">
                    <a href="{{ route('breadcrumb-setting.edit', $breadcrumb->id ?? 2) }}" class="btn btn-sm btn-outline-success fw-semibold px-3 py-2">
                        <i class="bi bi-pencil-square me-1"></i> Edit Breadcrumb & Hero Banner
                    </a>
                    <a href="{{ route('homepage.visi-misi') }}" target="_blank" class="btn btn-sm btn-success fw-semibold px-3 py-2" style="background-color: #046B26; border-color: #046B26;">
                        <i class="bi bi-box-arrow-up-right me-1"></i> Pratinjau Frontend
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- ═══════════════════════════════════════════════════════════════
     FORM KELOLA KONTEN TEKS VISI, MISI & TATA NILAI UIS
     (Format Murni Teks Dinamis — Best Practice Codingan)
     ═══════════════════════════════════════════════════════════════ --}}
<form action="{{ route('visimisi.update-content') }}" method="POST">
    @csrf
    @method('PUT')

    <div class="card shadow-sm border-0 mb-4" style="border-radius: 12px;">
        <div class="card-header bg-white py-3 px-4 d-flex align-items-center justify-content-between" style="border-top: 3px solid #046B26; border-radius: 12px 12px 0 0;">
            <div class="d-flex align-items-center gap-2">
                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background-color: #e8f5e9; color: #046B26;">
                    <i class="bi bi-card-text fs-5"></i>
                </div>
                <div>
                    <h5 class="mb-0 fw-bold" style="color: #2b2f32; font-size: 16px;">Konten Teks Visi, Misi & Tata Nilai UIS</h5>
                    <small class="text-muted">Kelola isi teks Visi, Misi dan Tata Nilai yang tampil di halaman frontend dalam format teks dinamis</small>
                </div>
            </div>
            <span class="badge" style="background-color: #046B26; color: #ffffff; font-size: 11.5px; font-weight: 700; padding: 6px 14px; border-radius: 6px;">
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
         TOMBOL SIMPAN UTAMA
         ═══════════════════════════════════════════════════════════════ --}}
    <div class="card shadow-sm border-0 mb-4" style="border-radius: 12px;">
        <div class="card-body py-3 px-4 d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div class="text-muted small d-flex align-items-center gap-2">
                <i class="bi bi-shield-check text-success fs-5"></i>
                <span>Perubahan teks Visi, Misi & Tata Nilai akan langsung diterapkan secara realtime di halaman Visi & Misi frontend.</span>
            </div>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('homepage.visi-misi') }}" target="_blank" class="btn btn-outline-success fw-semibold px-3 py-2">
                    <i class="bi bi-box-arrow-up-right me-1"></i> Lihat Frontend
                </a>
                <button type="submit" class="btn fw-semibold px-4 py-2 shadow-sm" style="background-color: #046B26; color: #ffffff; border-color: #046B26;">
                    <i class="bi bi-floppy-fill me-1"></i> Simpan Visi, Misi & Tata Nilai
                </button>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
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
