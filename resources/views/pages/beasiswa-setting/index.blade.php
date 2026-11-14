@extends('layouts.dashboard.template')

@push('styles')
<style>
    /* ═══════════════════════════════════════════════════════════════
       CUSTOM TAB & ACTIVE STYLING UIS GREEN THEME (ANTI WARNA BIRU)
    ═══════════════════════════════════════════════════════════════ */
    #beasiswaTabs .nav-link {
        color: #475569;
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 10px 18px;
        font-weight: 600;
        transition: all 0.2s ease;
    }
    #beasiswaTabs .nav-link:hover {
        background-color: #eaf6ee;
        color: #046B26;
        border-color: #cce8d4;
    }
    #beasiswaTabs .nav-link.active,
    #beasiswaTabs .nav-pills .nav-link.active,
    .nav-pills .nav-link.active {
        background-color: #046B26 !important;
        color: #ffffff !important;
        border-color: #046B26 !important;
        box-shadow: 0 4px 12px rgba(4, 107, 38, 0.25) !important;
    }
    #beasiswaTabs .nav-link.active i {
        color: #FED802 !important; /* Aksen emas khas UIS saat aktif */
    }
    #beasiswaTabs .nav-link:not(.active) i {
        color: #046B26 !important;
    }

    /* Override Fokus & Active Input/Switch agar tidak pernah biru */
    .form-check-input:checked {
        background-color: #046B26 !important;
        border-color: #046B26 !important;
    }
    .form-check-input:focus {
        border-color: #046B26 !important;
        box-shadow: 0 0 0 0.2rem rgba(4, 107, 38, 0.18) !important;
    }
    .form-control:focus, .form-select:focus {
        border-color: #046B26 !important;
        box-shadow: 0 0 0 0.2rem rgba(4, 107, 38, 0.15) !important;
    }

    /* Accordion Admin Header Styling */
    .jalur-card-item .accordion-button:not(.collapsed) {
        background-color: #eaf6ee !important;
        color: #046B26 !important;
        box-shadow: none !important;
    }
    .jalur-card-item .accordion-button:focus {
        border-color: #046B26 !important;
        box-shadow: 0 0 0 0.2rem rgba(4, 107, 38, 0.15) !important;
    }
</style>
@endpush

@section('content')
<div class="pagetitle">
    <h1>Pengaturan Program Beasiswa</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Kemahasiswaan</li>
            <li class="breadcrumb-item active">Program Beasiswa</li>
        </ol>
    </nav>
</div>

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        <strong>Periksa kembali isian formulir:</strong>
        <ul class="mb-0 mt-1 ps-3">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<form action="{{ route('beasiswa.admin.update') }}" method="POST" enctype="multipart/form-data" id="formBeasiswaSetting">
    @csrf
    @method('PUT')

    {{-- NAV TABS KONTROL KONTEN BEASISWA --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white border-bottom p-2 p-md-3">
            <ul class="nav nav-pills flex-column flex-sm-row gap-2" id="beasiswaTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active fw-semibold text-start text-sm-center" id="tab-hero-btn" data-bs-toggle="pill" data-bs-target="#tab-hero" type="button" role="tab">
                        <i class="bi bi-megaphone me-1 text-success"></i> 1. Hero & Pembuka
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-semibold text-start text-sm-center" id="tab-tentang-btn" data-bs-toggle="pill" data-bs-target="#tab-tentang" type="button" role="tab">
                        <i class="bi bi-info-circle me-1 text-success"></i> 2. Tentang & Keunggulan
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-semibold text-start text-sm-center" id="tab-stats-btn" data-bs-toggle="pill" data-bs-target="#tab-stats" type="button" role="tab">
                        <i class="bi bi-bar-chart-fill me-1 text-success"></i> 3. Statistik (4 Kotak)
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-semibold text-start text-sm-center" id="tab-jalur-btn" data-bs-toggle="pill" data-bs-target="#tab-jalur" type="button" role="tab">
                        <i class="bi bi-grid-fill me-1 text-success"></i> 4. Jalur Beasiswa
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-semibold text-start text-sm-center" id="tab-alur-faq-btn" data-bs-toggle="pill" data-bs-target="#tab-alur-faq" type="button" role="tab">
                        <i class="bi bi-signpost-split me-1 text-success"></i> 5. Alur & FAQ
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-semibold text-start text-sm-center" id="tab-cta-btn" data-bs-toggle="pill" data-bs-target="#tab-cta" type="button" role="tab">
                        <i class="bi bi-star-fill me-1 text-success"></i> 6. Banner Ajakan (CTA)
                    </button>
                </li>
            </ul>
        </div>

        <div class="card-body p-3 p-md-4">
            <div class="tab-content" id="beasiswaTabsContent">

                {{-- TAB 1: HERO & PEMBUKA --}}
                <div class="tab-pane fade show active" id="tab-hero" role="tabpanel">
                    <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                        <h5 class="fw-bold text-dark mb-0"><i class="bi bi-megaphone text-success me-2"></i>Informasi Hero & Status Beasiswa</h5>
                        <span class="badge bg-light text-secondary border">Bagian Atas Halaman</span>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-12">
                            <label for="hero_badge" class="form-label fw-semibold">Teks Badge Status</label>
                            <input type="text" id="hero_badge" name="hero_badge"
                                   class="form-control @error('hero_badge') is-invalid @enderror"
                                   value="{{ old('hero_badge', $beasiswa->hero_badge) }}"
                                   placeholder="Contoh: PENDAFTARAN BEASISWA T.A. 2026/2027 TELAH DIBUKA">
                            <small class="text-muted">Muncul di atas judul dengan titik animasi berkedip.</small>
                            @error('hero_badge')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <label for="hero_judul" class="form-label fw-semibold">Judul Utama Hero <span class="text-danger">*</span></label>
                            <textarea id="hero_judul" name="hero_judul" rows="2"
                                      class="form-control @error('hero_judul') is-invalid @enderror" required
                                      placeholder="Contoh: Raih Impian & Masa Depan Bersama Program Beasiswa Universitas Ibnu Sina">{{ old('hero_judul', $beasiswa->hero_judul) }}</textarea>
                            @error('hero_judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <label for="hero_deskripsi" class="form-label fw-semibold">Deskripsi Singkat Hero</label>
                            <textarea id="hero_deskripsi" name="hero_deskripsi" rows="3"
                                      class="form-control @error('hero_deskripsi') is-invalid @enderror"
                                      placeholder="Tuliskan ulasan pembuka beasiswa...">{{ old('hero_deskripsi', $beasiswa->hero_deskripsi) }}</textarea>
                            @error('hero_deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-8">
                            <label for="link_daftar" class="form-label fw-semibold">
                                Tautan Khusus Pendaftaran Beasiswa
                                <span class="badge bg-secondary fw-normal ms-1" style="font-size:10px">Opsional</span>
                            </label>
                            <input type="text" id="link_daftar" name="link_daftar"
                                   class="form-control @error('link_daftar') is-invalid @enderror"
                                   value="{{ old('link_daftar', $beasiswa->link_daftar) }}"
                                   placeholder="Contoh: https://pmb.uis.ac.id/beasiswa atau kosongkan">
                            <div class="form-text">Bila dikosongkan, tombol otomatis mengarah ke portal PMB yang aktif.</div>
                            @error('link_daftar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 d-flex align-items-center pt-md-3">
                            <div class="form-check form-switch p-2 border rounded bg-light w-100">
                                <input class="form-check-input ms-0 me-2" type="checkbox" id="is_active" name="is_active" value="1"
                                       {{ old('is_active', $beasiswa->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="is_active">
                                    Aktifkan Status Buka Beasiswa
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- TAB 2: TENTANG & KEUNGGULAN --}}
                <div class="tab-pane fade" id="tab-tentang" role="tabpanel">
                    <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                        <h5 class="fw-bold text-dark mb-0"><i class="bi bi-info-circle text-success me-2"></i>Tentang Beasiswa & Foto Showcase</h5>
                        <span class="badge bg-light text-secondary border">Bagian Overview</span>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-12">
                            <label for="tentang_judul" class="form-label fw-semibold">Judul Bagian Tentang Beasiswa</label>
                            <input type="text" id="tentang_judul" name="tentang_judul"
                                   class="form-control @error('tentang_judul') is-invalid @enderror"
                                   value="{{ old('tentang_judul', $beasiswa->tentang_judul) }}"
                                   placeholder="Contoh: Membuka Akses Pendidikan Tinggi Unggul Tanpa Kendala Biaya">
                            @error('tentang_judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-7">
                            <label for="tentang_deskripsi" class="form-label fw-semibold">Deskripsi Lengkap Tentang Beasiswa</label>
                            <textarea id="tentang_deskripsi" name="tentang_deskripsi" rows="6"
                                      class="form-control @error('tentang_deskripsi') is-invalid @enderror"
                                      placeholder="Tuliskan komitmen universitas dalam memfasilitasi beasiswa...">{{ old('tentang_deskripsi', $beasiswa->tentang_deskripsi) }}</textarea>
                            @error('tentang_deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <div class="mt-4">
                                <label class="form-label fw-semibold text-dark">
                                    <i class="bi bi-check2-circle text-success me-1"></i>3 Poin Keunggulan Utama (List Checkmark)
                                </label>
                                @php
                                    $keunggulanData = old('keunggulan_list', $beasiswa->effective_keunggulan);
                                @endphp
                                @for($i = 0; $i < 3; $i++)
                                    <div class="input-group mb-2">
                                        <span class="input-group-text bg-light text-success fw-bold"><i class="bi bi-check-circle-fill"></i></span>
                                        <input type="text" name="keunggulan_list[]" class="form-control"
                                               value="{{ $keunggulanData[$i] ?? '' }}"
                                               placeholder="Poin keunggulan {{ $i + 1 }} (Contoh: Pembebasan Biaya Kuliah: Subsidi hingga 100%)">
                                    </div>
                                @endfor
                                <small class="text-muted">Poin-poin ini tampil di bawah teks deskripsi tentang beasiswa.</small>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <label for="gambar" class="form-label fw-semibold">
                                Foto Showcase Beasiswa
                                <span class="badge bg-secondary fw-normal ms-1" style="font-size:10px">Opsional</span>
                            </label>
                            <input type="file" id="gambar" name="gambar"
                                   class="form-control @error('gambar') is-invalid @enderror"
                                   accept="image/jpg,image/jpeg,image/png,image/webp"
                                   onchange="previewImgFile(this)">
                            <div class="form-text">Format: JPG, PNG, WebP. Maksimal: 10 MB. Kosongkan untuk memakai gambar default gedung UIS.</div>
                            @error('gambar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            @if($beasiswa->gambar)
                                <div class="mt-3">
                                    <p class="small text-muted mb-1">Foto saat ini:</p>
                                    <img src="{{ asset('storage/' . $beasiswa->gambar) }}" alt="Preview"
                                         style="max-width:100%;max-height:160px;object-fit:cover;border-radius:12px;border:1px solid #dee2e6">
                                </div>
                            @endif

                            <div id="previewWrap" class="mt-3 d-none">
                                <p class="small text-muted mb-1">Preview foto baru:</p>
                                <img id="previewImg" src="" alt="Preview"
                                     style="max-width:100%;max-height:160px;object-fit:cover;border-radius:12px;border:2px solid #046B26">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- TAB 3: STATISTIK BEASISWA --}}
                <div class="tab-pane fade" id="tab-stats" role="tabpanel">
                    <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                        <h5 class="fw-bold text-dark mb-0"><i class="bi bi-bar-chart-fill text-success me-2"></i>4 Kotak Angka Statistik</h5>
                        <span class="badge bg-light text-secondary border">Highlight Kartu</span>
                    </div>
                    <p class="text-muted small mb-3">Empat kartu ringkasan angka statistik yang tampil di bawah informasi hero.</p>

                    @php
                        $statsData = old('stats', $beasiswa->effective_stats);
                    @endphp
                    <div class="row g-3">
                        @foreach($statsData as $idx => $st)
                            <div class="col-md-6 col-lg-3">
                                <div class="card border p-3 h-100 bg-light">
                                    <span class="badge bg-success align-self-start mb-2">Statistik #{{ $idx + 1 }}</span>
                                    <div class="mb-2">
                                        <label class="form-label small fw-semibold mb-1">Ikon (Bootstrap Icons)</label>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text"><i class="bi {{ $st['icon'] ?? 'bi-star-fill' }}"></i></span>
                                            <input type="text" name="stats[{{ $idx }}][icon]" class="form-control"
                                                   value="{{ $st['icon'] ?? 'bi-mortarboard-fill' }}" placeholder="bi-mortarboard-fill">
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label small fw-semibold mb-1">Angka / Nilai Highlight</label>
                                        <input type="text" name="stats[{{ $idx }}][nilai]" class="form-control form-control-sm fw-bold"
                                               value="{{ $st['nilai'] ?? '' }}" placeholder="Contoh: 6+, 100%, dsb.">
                                    </div>
                                    <div>
                                        <label class="form-label small fw-semibold mb-1">Keterangan Label</label>
                                        <input type="text" name="stats[{{ $idx }}][label]" class="form-control form-control-sm"
                                               value="{{ $st['label'] ?? '' }}" placeholder="Contoh: Jalur Beasiswa">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- TAB 4: JALUR BEASISWA --}}
                <div class="tab-pane fade" id="tab-jalur" role="tabpanel">
                    <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                        <div>
                            <h5 class="fw-bold text-dark mb-0"><i class="bi bi-grid-fill text-success me-2"></i>Daftar Pilihan Jalur Beasiswa</h5>
                            <small class="text-muted">Konten detail untuk setiap jalur beasiswa: dropdown, accordion, persyaratan & manfaat.</small>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-success" onclick="tambahJalurBaru()">
                            <i class="bi bi-plus-circle me-1"></i> Tambah Jalur Baru
                        </button>
                    </div>

                    @php
                        $jalurData = old('jalur_list', $beasiswa->effective_jalur);
                    @endphp

                    <div class="accordion" id="adminJalurAccordion">
                        @foreach($jalurData as $jIdx => $jalur)
                            <div class="accordion-item mb-3 border shadow-none rounded-3 overflow-hidden jalur-card-item" id="adminJalurCard_{{ $jIdx }}">
                                <div class="accordion-header d-flex align-items-center bg-light" id="headingAdminJalur_{{ $jIdx }}">
                                    <button class="accordion-button {{ $jIdx > 0 ? 'collapsed' : '' }} py-2 px-3 bg-light fw-bold text-dark flex-grow-1 border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdminJalur_{{ $jIdx }}">
                                        <span class="badge bg-success me-2 jalur-badge-num">{{ $jIdx + 1 }}</span>
                                        <span class="me-2 jalur-title-header text-truncate" style="max-width: 500px;">{{ $jalur['judul'] ?? 'Jalur Beasiswa' }}</span>
                                        <span class="badge bg-warning text-dark ms-auto me-2 jalur-badge-label">{{ $jalur['badge'] ?? 'Beasiswa' }}</span>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-danger me-2 py-1 px-2 flex-shrink-0" title="Hapus Jalur Beasiswa Ini" onclick="hapusJalurCard('adminJalurCard_{{ $jIdx }}'); event.stopPropagation();">
                                        <i class="bi bi-trash me-1"></i> Hapus
                                    </button>
                                </div>
                                <div id="collapseAdminJalur_{{ $jIdx }}" class="accordion-collapse collapse {{ $jIdx == 0 ? 'show' : '' }}" data-bs-parent="#adminJalurAccordion">
                                    <div class="accordion-body bg-white p-3 p-md-4">
                                        <input type="hidden" name="jalur_list[{{ $jIdx }}][id]" value="{{ $jalur['id'] ?? ('collapse_jalur_' . ($jIdx + 1)) }}">

                                        <div class="row g-3">
                                            <div class="col-md-7">
                                                <label class="form-label fw-semibold">Nama / Judul Jalur Beasiswa <span class="text-danger">*</span></label>
                                                <input type="text" name="jalur_list[{{ $jIdx }}][judul]" class="form-control"
                                                       value="{{ $jalur['judul'] ?? '' }}" required
                                                       oninput="updateJalurHeader(this, 'adminJalurCard_{{ $jIdx }}', 'title')"
                                                       placeholder="Contoh: Beasiswa KIP-Kuliah Merdeka (Kemendikbudristek)">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label fw-semibold">Badge Highlight</label>
                                                <input type="text" name="jalur_list[{{ $jIdx }}][badge]" class="form-control"
                                                       value="{{ $jalur['badge'] ?? '' }}"
                                                       oninput="updateJalurHeader(this, 'adminJalurCard_{{ $jIdx }}', 'badge')"
                                                       placeholder="Contoh: Bebas 100% SPP">
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label fw-semibold">Ikon Bi-*</label>
                                                <input type="text" name="jalur_list[{{ $jIdx }}][icon]" class="form-control"
                                                       value="{{ $jalur['icon'] ?? 'bi-mortarboard-fill' }}"
                                                       placeholder="bi-mortarboard-fill">
                                            </div>

                                            <div class="col-12">
                                                <label class="form-label fw-semibold">Ringkasan Singkat (Subtitle)</label>
                                                <input type="text" name="jalur_list[{{ $jIdx }}][ringkasan]" class="form-control"
                                                       value="{{ $jalur['ringkasan'] ?? '' }}"
                                                       placeholder="Ringkasan 1 kalimat yang muncul di header accordion">
                                            </div>

                                            <div class="col-12">
                                                <label class="form-label fw-semibold">Deskripsi Lengkap Jalur</label>
                                                <textarea name="jalur_list[{{ $jIdx }}][deskripsi]" rows="2" class="form-control"
                                                          placeholder="Penjelasan latar belakang dan sasaran jalur beasiswa ini...">{{ $jalur['deskripsi'] ?? '' }}</textarea>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold text-success">
                                                    <i class="bi bi-gift-fill me-1"></i> Cakupan & Fasilitas Beasiswa
                                                </label>
                                                <textarea name="jalur_list[{{ $jIdx }}][manfaat]" rows="5" class="form-control"
                                                          placeholder="Tuliskan tiap poin manfaat dalam baris baru (Enter)...">{{ $jalur['manfaat'] ?? '' }}</textarea>
                                                <small class="text-muted">Gunakan baris baru (Enter) untuk memisahkan setiap butir manfaat.</small>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold text-success">
                                                    <i class="bi bi-card-checklist me-1"></i> Persyaratan Dokumen & Ketentuan
                                                </label>
                                                <textarea name="jalur_list[{{ $jIdx }}][syarat]" rows="5" class="form-control"
                                                          placeholder="Tuliskan tiap syarat dalam baris baru (Enter)...">{{ $jalur['syarat'] ?? '' }}</textarea>
                                                <small class="text-muted">Gunakan baris baru (Enter) untuk memisahkan setiap butir persyaratan.</small>
                                            </div>

                                            <div class="col-md-10">
                                                <label class="form-label fw-semibold">Periode Seleksi / Jadwal Pendaftaran</label>
                                                <input type="text" name="jalur_list[{{ $jIdx }}][periode]" class="form-control"
                                                       value="{{ $jalur['periode'] ?? '' }}"
                                                       placeholder="Contoh: Mengikuti jadwal resmi PMB UIS Gelombang 1 & 2">
                                            </div>

                                            <div class="col-md-2 d-flex align-items-end">
                                                <button type="button" class="btn btn-danger w-100" onclick="hapusJalurCard('adminJalurCard_{{ $jIdx }}')">
                                                    <i class="bi bi-trash me-1"></i> Hapus Jalur
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- TAB 5: ALUR & FAQ --}}
                <div class="tab-pane fade" id="tab-alur-faq" role="tabpanel">
                    <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                        <h5 class="fw-bold text-dark mb-0"><i class="bi bi-signpost-split text-success me-2"></i>Tahapan Alur Pendaftaran & FAQ</h5>
                        <span class="badge bg-light text-secondary border">Alur & Tanya Jawab</span>
                    </div>

                    {{-- ALUR PENDAFTARAN --}}
                    <div class="mb-4">
                        <h6 class="fw-bold text-success mb-2"><i class="bi bi-123 me-1"></i>4 Tahapan Alur Pendaftaran Beasiswa</h6>
                        @php
                            $alurData = old('alur_list', $beasiswa->effective_alur);
                        @endphp
                        <div class="row g-3">
                            @foreach($alurData as $aIdx => $al)
                                <div class="col-md-6 col-lg-3">
                                    <div class="card border p-3 h-100 bg-light">
                                        <div class="d-flex align-items-center gap-2 mb-2">
                                            <span class="badge bg-success rounded-pill px-2 py-1">Langkah {{ $al['nomor'] ?? ($aIdx + 1) }}</span>
                                            <input type="hidden" name="alur_list[{{ $aIdx }}][nomor]" value="{{ $al['nomor'] ?? ($aIdx + 1) }}">
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label small fw-semibold mb-1">Judul Langkah</label>
                                            <input type="text" name="alur_list[{{ $aIdx }}][judul]" class="form-control form-control-sm fw-bold"
                                                   value="{{ $al['judul'] ?? '' }}" placeholder="Judul alur">
                                        </div>
                                        <div>
                                            <label class="form-label small fw-semibold mb-1">Keterangan Singkat</label>
                                            <textarea name="alur_list[{{ $aIdx }}][deskripsi]" rows="3" class="form-control form-control-sm"
                                                      placeholder="Penjelasan tahapan...">{{ $al['deskripsi'] ?? '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <hr class="my-4">

                    {{-- FAQ LIST --}}
                    <div>
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h6 class="fw-bold text-success mb-0"><i class="bi bi-question-circle-fill me-1"></i>FAQ Seputar Program Beasiswa</h6>
                            <button type="button" class="btn btn-sm btn-outline-success" onclick="tambahFaqBaru()">
                                <i class="bi bi-plus-circle me-1"></i> Tambah FAQ
                            </button>
                        </div>

                        @php
                            $faqData = old('faq_list', $beasiswa->effective_faq);
                        @endphp
                        <div id="faqListContainer">
                            @foreach($faqData as $fIdx => $fq)
                                <div class="card border mb-3 p-3 bg-light faq-card-item" id="faqCard_{{ $fIdx }}">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="badge bg-success">FAQ #{{ $fIdx + 1 }}</span>
                                        <button type="button" class="btn btn-sm btn-outline-danger py-0 px-2" onclick="hapusFaqCard('faqCard_{{ $fIdx }}')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label small fw-semibold mb-1">Pertanyaan</label>
                                        <input type="text" name="faq_list[{{ $fIdx }}][tanya]" class="form-control"
                                               value="{{ $fq['tanya'] ?? '' }}" placeholder="Tuliskan pertanyaan...">
                                    </div>
                                    <div>
                                        <label class="form-label small fw-semibold mb-1">Jawaban</label>
                                        <textarea name="faq_list[{{ $fIdx }}][jawab]" rows="2" class="form-control"
                                                  placeholder="Tuliskan jawaban yang jelas dan informatif...">{{ $fq['jawab'] ?? '' }}</textarea>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- TAB 6: BANNER CTA --}}
                <div class="tab-pane fade" id="tab-cta" role="tabpanel">
                    <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                        <h5 class="fw-bold text-dark mb-0"><i class="bi bi-star-fill text-success me-2"></i>Banner Ajakan (Call to Action) Bagian Bawah</h5>
                        <span class="badge bg-light text-secondary border">Footer Banner</span>
                    </div>

                    @php
                        $ctaData = old('cta_data', $beasiswa->effective_cta);
                    @endphp
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Teks Badge CTA</label>
                            <input type="text" name="cta_data[badge]" class="form-control"
                                   value="{{ $ctaData['badge'] ?? 'Jangan Lewatkan Kesempatan Ini' }}"
                                   placeholder="Contoh: Jangan Lewatkan Kesempatan Ini">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Teks Tombol Aksi Utama</label>
                            <input type="text" name="cta_data[btn_text]" class="form-control"
                                   value="{{ $ctaData['btn_text'] ?? 'Daftar Online PMB' }}"
                                   placeholder="Contoh: Daftar Online PMB">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Judul Banner CTA</label>
                            <input type="text" name="cta_data[judul]" class="form-control"
                                   value="{{ $ctaData['judul'] ?? 'Siap Meraih Beasiswa Impian Anda di Universitas Ibnu Sina?' }}"
                                   placeholder="Contoh: Siap Meraih Beasiswa Impian Anda di Universitas Ibnu Sina?">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Deskripsi Ajakan CTA</label>
                            <textarea name="cta_data[deskripsi]" rows="3" class="form-control"
                                      placeholder="Tuliskan ajakan singkat yang memotivasi calon mahasiswa...">{{ $ctaData['deskripsi'] ?? 'Kuota terbatas untuk setiap gelombang pendaftaran. Segera persiapkan dokumen Anda dan bergabunglah bersama ribuan mahasiswa berprestasi UIS Batam!' }}</textarea>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- FOOTER AKSI SIMPAN --}}
        <div class="card-footer bg-white border-top p-3 d-flex flex-wrap justify-content-between align-items-center gap-2">
            <a href="{{ route('homepage.beasiswa') }}" target="_blank" class="btn btn-outline-success">
                <i class="bi bi-box-arrow-up-right me-1"></i> Preview Halaman Beasiswa Frontend
            </a>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success px-4 py-2 fw-semibold shadow-sm">
                    <i class="bi bi-save me-1"></i> Simpan Semua Konten Beasiswa
                </button>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
    function previewImgFile(input) {
        const wrap = document.getElementById('previewWrap');
        const img  = document.getElementById('previewImg');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                img.src = e.target.result;
                wrap.classList.remove('d-none');
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            wrap.classList.add('d-none');
        }
    }

    function reindexJalurBadges() {
        const badges = document.querySelectorAll('#adminJalurAccordion .jalur-card-item .jalur-badge-num');
        badges.forEach((b, i) => {
            b.textContent = (i + 1);
        });
    }

    function updateJalurHeader(input, cardId, type) {
        const card = document.getElementById(cardId);
        if (!card) return;
        if (type === 'title') {
            const titleEl = card.querySelector('.jalur-title-header');
            if (titleEl) {
                titleEl.textContent = input.value.trim() ? input.value : 'Jalur Beasiswa Baru';
            }
        } else if (type === 'badge') {
            const badgeEl = card.querySelector('.jalur-badge-label');
            if (badgeEl) {
                badgeEl.textContent = input.value.trim() ? input.value : 'Beasiswa';
            }
        }
    }

    function hapusJalurCard(elementId) {
        if (confirm('Yakin ingin menghapus jalur beasiswa ini dari daftar?')) {
            const el = document.getElementById(elementId);
            if (el) {
                el.remove();
                reindexJalurBadges();
            }
        }
    }

    function hapusFaqCard(elementId) {
        if (confirm('Yakin ingin menghapus pertanyaan FAQ ini?')) {
            const el = document.getElementById(elementId);
            if (el) el.remove();
        }
    }

    let nextJalurIdx = {{ count($jalurData) + 10 }};
    function tambahJalurBaru() {
        const idx = nextJalurIdx++;
        const template = `
            <div class="accordion-item mb-3 border shadow-none rounded-3 overflow-hidden jalur-card-item" id="adminJalurCard_${idx}">
                <div class="accordion-header d-flex align-items-center bg-light" id="headingAdminJalur_${idx}">
                    <button class="accordion-button py-2 px-3 bg-light fw-bold text-dark flex-grow-1 border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdminJalur_${idx}">
                        <span class="badge bg-success me-2 jalur-badge-num">+</span>
                        <span class="me-2 jalur-title-header text-truncate" style="max-width: 500px;">Jalur Beasiswa Baru</span>
                        <span class="badge bg-warning text-dark ms-auto me-2 jalur-badge-label">Baru</span>
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-danger me-2 py-1 px-2 flex-shrink-0" title="Hapus Jalur Ini" onclick="hapusJalurCard('adminJalurCard_${idx}'); event.stopPropagation();">
                        <i class="bi bi-trash me-1"></i> Hapus
                    </button>
                </div>
                <div id="collapseAdminJalur_${idx}" class="accordion-collapse collapse show" data-bs-parent="#adminJalurAccordion">
                    <div class="accordion-body bg-white p-3 p-md-4">
                        <input type="hidden" name="jalur_list[${idx}][id]" value="collapse_jalur_${idx}">
                        <div class="row g-3">
                            <div class="col-md-7">
                                <label class="form-label fw-semibold">Nama / Judul Jalur Beasiswa <span class="text-danger">*</span></label>
                                <input type="text" name="jalur_list[${idx}][judul]" class="form-control" required
                                       oninput="updateJalurHeader(this, 'adminJalurCard_${idx}', 'title')"
                                       placeholder="Contoh: Beasiswa Mitra Spesial">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Badge Highlight</label>
                                <input type="text" name="jalur_list[${idx}][badge]" class="form-control"
                                       oninput="updateJalurHeader(this, 'adminJalurCard_${idx}', 'badge')"
                                       placeholder="Contoh: Bebas SPP 50%">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label fw-semibold">Ikon Bi-*</label>
                                <input type="text" name="jalur_list[${idx}][icon]" class="form-control" value="bi-award-fill">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Ringkasan Singkat (Subtitle)</label>
                                <input type="text" name="jalur_list[${idx}][ringkasan]" class="form-control" placeholder="Ringkasan 1 kalimat">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Deskripsi Lengkap Jalur</label>
                                <textarea name="jalur_list[${idx}][deskripsi]" rows="2" class="form-control" placeholder="Uraian beasiswa..."></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-success"><i class="bi bi-gift-fill me-1"></i> Cakupan & Fasilitas Beasiswa</label>
                                <textarea name="jalur_list[${idx}][manfaat]" rows="5" class="form-control" placeholder="Tuliskan tiap poin manfaat per baris baru..."></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-success"><i class="bi bi-card-checklist me-1"></i> Persyaratan Dokumen</label>
                                <textarea name="jalur_list[${idx}][syarat]" rows="5" class="form-control" placeholder="Tuliskan tiap syarat per baris baru..."></textarea>
                            </div>
                            <div class="col-md-10">
                                <label class="form-label fw-semibold">Periode Seleksi</label>
                                <input type="text" name="jalur_list[${idx}][periode]" class="form-control" placeholder="Contoh: Mengikuti jadwal PMB UIS">
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="button" class="btn btn-danger w-100" onclick="hapusJalurCard('adminJalurCard_${idx}')">
                                    <i class="bi bi-trash me-1"></i> Hapus Jalur
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
        document.getElementById('adminJalurAccordion').insertAdjacentHTML('beforeend', template);
        reindexJalurBadges();
    }

    let nextFaqIdx = {{ count($faqData) + 10 }};
    function tambahFaqBaru() {
        const idx = nextFaqIdx++;
        const template = `
            <div class="card border mb-3 p-3 bg-light faq-card-item" id="faqCard_${idx}">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="badge bg-success">FAQ Baru</span>
                    <button type="button" class="btn btn-sm btn-outline-danger py-0 px-2" onclick="hapusFaqCard('faqCard_${idx}')">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
                <div class="mb-2">
                    <label class="form-label small fw-semibold mb-1">Pertanyaan</label>
                    <input type="text" name="faq_list[${idx}][tanya]" class="form-control" placeholder="Tuliskan pertanyaan...">
                </div>
                <div>
                    <label class="form-label small fw-semibold mb-1">Jawaban</label>
                    <textarea name="faq_list[${idx}][jawab]" rows="2" class="form-control" placeholder="Tuliskan jawaban..."></textarea>
                </div>
            </div>
        `;
        document.getElementById('faqListContainer').insertAdjacentHTML('beforeend', template);
    }
</script>
@endpush
