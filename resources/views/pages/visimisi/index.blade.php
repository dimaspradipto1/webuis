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
     FORM 1: PENGATURAN BACKGROUND BANNER & JARAK KONTEN (SPACING)
     (Dedicated Form untuk Upload File & Angka Jarak — Aman dari ModSecurity/WAF LiteSpeed)
     ═══════════════════════════════════════════════════════════════ --}}
<form action="{{ route('visimisi.update-background') }}" method="POST" enctype="multipart/form-data">
    @csrf

    {{-- KARTU 1: PENGATURAN BACKGROUND BANNER & MARGIN/PADDING KONTEN --}}
    <div class="card shadow-sm border-0 mb-4" style="border-radius: 12px;">
        <div class="card-header bg-white py-3 px-4 d-flex align-items-center justify-content-between flex-wrap gap-2" style="border-top: 3px solid #046B26; border-radius: 12px 12px 0 0;">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: #e8f5e9; color: #046B26;">
                    <i class="bi bi-image fs-5"></i>
                </div>
                <div>
                    <h5 class="mb-0 fw-bold" style="color: #1e293b; font-size: 16px;">Pengaturan Background Banner & Jarak Konten</h5>
                    <small class="text-muted">Kelola gambar background banner secara dinamis serta atur batas atas dan bawah jarak konten.</small>
                </div>
            </div>
            @if(!empty($about->visimisi_background))
                <span class="badge" style="background-color: #046B26; color: #ffffff; font-size: 11.5px; font-weight: 700; padding: 6px 14px; border-radius: 6px;">
                    <i class="bi bi-check-circle-fill me-1"></i> Background Kustom Aktif
                </span>
            @else
                <span class="badge bg-secondary" style="font-size: 11.5px; font-weight: 700; padding: 6px 14px; border-radius: 6px;">
                    <i class="bi bi-shield-check me-1"></i> Background Default Resmi
                </span>
            @endif
        </div>
        <div class="card-body p-4">
            <div class="row g-4">
                {{-- Kolom Kiri: Pratinjau & Upload Background --}}
                <div class="col-lg-7 col-12">
                    <label class="form-label fw-bold small text-dark mb-2">
                        Pratinjau Background Banner Saat Ini:
                    </label>
                    <div class="position-relative border rounded-3 p-2 bg-light mb-3 text-center overflow-hidden" style="max-height: 220px;">
                        <img src="{{ $about->visimisi_background_url }}" 
                             id="preview-bg-img"
                             alt="Background Visi Misi" 
                             class="img-fluid rounded shadow-sm" 
                             style="max-height: 200px; width: 100%; object-fit: cover;"
                             onerror="this.onerror=null; this.src='{{ asset('assets/img/visimisi-campus-clean-bg.jpg') }}';">
                        @if(!empty($about->visimisi_background))
                            <div class="position-absolute bottom-0 end-0 p-3">
                                <button type="button" 
                                        class="btn btn-sm btn-danger shadow-sm fw-semibold" 
                                        onclick="if(confirm('Yakin ingin mereset background ke latar belakang default resmi UIS?')) document.getElementById('form-delete-bg').submit();">
                                    <i class="bi bi-trash-fill me-1"></i> Reset ke Default
                                </button>
                            </div>
                        @endif
                    </div>

                    <div class="mb-2">
                        <label for="visimisi_background" class="form-label fw-bold small text-dark">
                            Ganti / Upload Background Banner Baru <span class="text-muted fw-normal">(Opsional)</span>
                        </label>
                        <input type="file" 
                               class="form-control form-control-sm @error('visimisi_background') is-invalid @enderror" 
                               id="visimisi_background" 
                               name="visimisi_background" 
                               accept="image/jpeg,image/png,image/jpg,image/webp">
                        <div class="form-text small text-muted">
                            Format: JPG, JPEG, PNG, WEBP (Maksimal 5 MB). Rekomendasi rasio: 1920x780 atau 1920x1080 piksel responsif.
                        </div>
                        @error('visimisi_background')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Kolom Kanan: Pengaturan Batas Margin/Padding Konten --}}
                <div class="col-lg-5 col-12">
                    <div class="p-3 rounded-3 border h-100" style="background: #fbfdfb; border-color: #d1e7dd !important;">
                        <h6 class="fw-bold mb-3 text-success d-flex align-items-center gap-2">
                            <i class="bi bi-arrows-expand"></i> Pengaturan Jarak Konten (Spacing)
                        </h6>

                        {{-- Batas Atas Konten (Padding Top) --}}
                        <div class="mb-3">
                            <label for="visimisi_padding_top" class="form-label fw-bold small text-dark">
                                <i class="bi bi-arrow-up-circle-fill text-success me-1"></i> Batas Atas Konten (Margin/Padding Top)
                            </label>
                            <div class="input-group input-group-sm">
                                <input type="number" 
                                       class="form-control @error('visimisi_padding_top') is-invalid @enderror" 
                                       id="visimisi_padding_top" 
                                       name="visimisi_padding_top" 
                                       value="{{ old('visimisi_padding_top', $about->visimisi_padding_top ?? 50) }}" 
                                       min="0" 
                                       max="300" 
                                       step="5" 
                                       required>
                                <span class="input-group-text bg-white">px</span>
                            </div>
                            <div class="form-text small text-muted mt-1">
                                Jarak antara batas atas banner dengan kartu Visi (Standar: <strong>50px</strong>).
                            </div>
                            @error('visimisi_padding_top')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Batas Bawah Konten (Padding Bottom) --}}
                        <div class="mb-3">
                            <label for="visimisi_padding_bottom" class="form-label fw-bold small text-dark">
                                <i class="bi bi-arrow-down-circle-fill text-success me-1"></i> Batas Bawah Konten (Margin/Padding Bottom)
                            </label>
                            <div class="input-group input-group-sm">
                                <input type="number" 
                                       class="form-control @error('visimisi_padding_bottom') is-invalid @enderror" 
                                       id="visimisi_padding_bottom" 
                                       name="visimisi_padding_bottom" 
                                       value="{{ old('visimisi_padding_bottom', $about->visimisi_padding_bottom ?? 70) }}" 
                                       min="0" 
                                       max="300" 
                                       step="5" 
                                       required>
                                <span class="input-group-text bg-white">px</span>
                            </div>
                            <div class="form-text small text-muted mt-1">
                                Jarak antara batas kartu paling bawah dengan akhir background (Standar: <strong>70px</strong>).
                            </div>
                            @error('visimisi_padding_bottom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="alert alert-light border small text-muted p-2 mb-0 mt-3" style="font-size: 11.5px; line-height: 1.5;">
                            <i class="bi bi-info-circle text-primary me-1"></i> 
                            Jika konten bertambah banyak ke bawah, background banner akan secara otomatis ikut memanjang ke bawah secara responsif.
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer bg-white py-3 px-4 d-flex justify-content-between align-items-center flex-wrap gap-2 border-top">
            <span class="small text-muted"><i class="bi bi-info-circle me-1"></i> Klik simpan untuk menerapkan gambar background baru dan pengaturan jarak spacing.</span>
            <button type="submit" class="btn btn-success fw-semibold px-4 py-2 shadow-sm">
                <i class="bi bi-cloud-arrow-up-fill me-1"></i> Simpan Background & Jarak
            </button>
        </div>
    </div>
</form>

{{-- ═══════════════════════════════════════════════════════════════
     FORM 2: KELOLA KONTEN TEKS VISI, MISI & TATA NILAI UIS
     (Format Standar Form POST — Murni Konten Teks, Bebas Block WAF LiteSpeed)
     ═══════════════════════════════════════════════════════════════ --}}
<form action="{{ route('visimisi.update-content') }}" method="POST">
    @csrf

    {{-- KARTU 2: KONTEN TEKS VISI, MISI & TATA NILAI UIS --}}
    <div class="card shadow-sm border-0 mb-4" style="border-radius: 12px;">
        <div class="card-header bg-white py-3 px-4 d-flex align-items-center justify-content-between flex-wrap gap-2" style="border-top: 3px solid #046B26; border-radius: 12px 12px 0 0;">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: #e8f5e9; color: #046B26;">
                    <i class="bi bi-card-text fs-5"></i>
                </div>
                <div>
                    <h5 class="mb-0 fw-bold" style="color: #1e293b; font-size: 16px;">Konten Teks Visi, Misi & Tata Nilai UIS</h5>
                    <small class="text-muted">Kelola isi teks Visi Institusi, butir-butir Misi, dan Tata Nilai Budaya UIS yang tampil pada halaman profil frontend.</small>
                </div>
            </div>
            <span class="badge" style="background-color: #046B26; color: #ffffff; font-size: 11.5px; font-weight: 700; padding: 6px 14px; border-radius: 6px;">
                <i class="bi bi-fonts me-1"></i> Teks Dinamis
            </span>
        </div>
        <div class="card-body p-4">
            <div class="row g-4">
                {{-- Kolom 1: Visi UIS --}}
                <div class="col-lg-4 col-12">
                    <div class="p-3 rounded-3 border h-100" style="background: #fbfdfb; border-color: #d1e7dd !important;">
                        <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                            <span class="badge" style="background: #fed802; color: #024618; font-weight: 800; font-size: 12px; padding: 6px 14px; border-radius: 50px; letter-spacing: 0.5px;">
                                <i class="bi bi-eye-fill me-1"></i> VISI:
                            </span>
                            <small class="text-muted fw-semibold" style="font-size: 11.5px;">Tagline Visi Institusi</small>
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
                                Teks ini akan tampil besar dan elegan pada kartu Visi di halaman frontend.
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
                        <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                            <span class="badge" style="background: #fed802; color: #024618; font-weight: 800; font-size: 12px; padding: 6px 14px; border-radius: 50px; letter-spacing: 0.5px;">
                                <i class="bi bi-bullseye me-1"></i> MISI:
                            </span>
                            <small class="text-muted fw-semibold" style="font-size: 11.5px;">Butir-Butir Misi UIS</small>
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
                                Tuliskan setiap butir misi (bisa menggunakan fitur penomoran Numbered List di editor).
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
                        <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                            <span class="badge" style="background: #fed802; color: #024618; font-weight: 800; font-size: 12px; padding: 6px 14px; border-radius: 50px; letter-spacing: 0.5px;">
                                <i class="bi bi-gem me-1"></i> TATA NILAI "CIP":
                            </span>
                            <small class="text-muted fw-semibold" style="font-size: 11.5px;">Budaya Nilai UIS</small>
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

{{-- Form Tersembunyi untuk Reset Background ke Default --}}
@if(!empty($about->visimisi_background))
<form id="form-delete-bg" action="{{ route('visimisi.delete-background') }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endif
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

        const bgInput = document.getElementById('visimisi_background');
        const bgPreview = document.getElementById('preview-bg-img');
        if (bgInput && bgPreview) {
            bgInput.addEventListener('change', function (e) {
                const file = e.target.files && e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (evt) {
                        bgPreview.src = evt.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
    });
</script>
@endpush
