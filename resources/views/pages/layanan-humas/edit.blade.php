@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Kelola Layanan: {{ $item->nama }}</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Layanan Humas</li>
            <li class="breadcrumb-item"><a href="{{ route('layanan-humas.index') }}">Daftar Layanan</a></li>
            <li class="breadcrumb-item active">{{ $item->nama }}</li>
        </ol>
    </nav>
</div>

@if($item->kode === 'sihumas')
    {{-- Banner Khusus SIHUMAS --}}
    <div class="alert alert-success border-0 shadow-sm d-flex align-items-center justify-content-between p-3 mb-4" style="background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%); border-radius: 12px;">
        <div class="d-flex align-items-center gap-3">
            <div class="rounded-circle p-2 bg-white text-success fs-4 d-flex align-items-center justify-content-center shadow-sm" style="width: 48px; height: 48px;">
                <i class="bi bi-globe2" style="color: #0b6828;"></i>
            </div>
            <div>
                <h6 class="fw-bold mb-1" style="color: #064e3b;">Portal Resmi Sistem Informasi Humas (SIHUMAS)</h6>
                <p class="mb-0 text-muted small">
                    Layanan SIHUMAS terhubung langsung ke aplikasi daring Universitas Ibnu Sina:
                    <a href="https://sihumas.uisbatam.com/" target="_blank" class="fw-bold text-success text-decoration-underline ms-1">
                        https://sihumas.uisbatam.com/ <i class="bi bi-box-arrow-up-right small"></i>
                    </a>
                </p>
            </div>
        </div>
        <a href="https://sihumas.uisbatam.com/" target="_blank" class="btn btn-sm btn-success fw-bold shadow-sm d-none d-md-inline-flex align-items-center gap-1" style="background-color: #0b6828; border-color: #0b6828; border-radius: 8px;">
            <i class="bi bi-box-arrow-up-right"></i> Buka SIHUMAS
        </a>
    </div>
@elseif($item->kode === 'permintaan-rilis')
    {{-- Banner Khusus Permintaan Rilis --}}
    <div class="alert alert-success border-0 shadow-sm d-flex align-items-center justify-content-between p-3 mb-4" style="background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%); border-radius: 12px;">
        <div class="d-flex align-items-center gap-3">
            <div class="rounded-circle p-2 bg-white text-success fs-4 d-flex align-items-center justify-content-center shadow-sm" style="width: 48px; height: 48px;">
                <i class="bi bi-journal-richtext" style="color: #0b6828;"></i>
            </div>
            <div>
                <h6 class="fw-bold mb-1" style="color: #064e3b;">Halaman Publik Permintaan Rilis Aktif</h6>
                <p class="mb-0 text-muted small">
                    Pengunjung dapat membaca ketentuan penulisan 5W+1H, format foto, alur pengajuan, dan mengisi formulir daring di:
                    <a href="{{ route('homepage.permintaan-rilis') }}" target="_blank" class="fw-bold text-success text-decoration-underline ms-1">
                        /permintaan-rilis <i class="bi bi-box-arrow-up-right small"></i>
                    </a>
                </p>
            </div>
        </div>
        <a href="{{ route('homepage.permintaan-rilis') }}" target="_blank" class="btn btn-sm btn-success fw-bold shadow-sm d-none d-md-inline-flex align-items-center gap-1" style="background-color: #0b6828; border-color: #0b6828; border-radius: 8px;">
            <i class="bi bi-eye-fill"></i> Buka Halaman
        </a>
@endif

<div class="row">
    <div class="{{ $item->kode === 'pendampingan-acara' ? 'col-12' : 'col-lg-8 col-md-12' }}">
        <div class="card shadow-sm border-0 mb-4" style="border-radius: 12px;">
            <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between" style="border-top: 3px solid #046B26; border-radius: 12px 12px 0 0;">
                <h5 class="mb-0 fw-bold" style="color: #2b2f32; font-size: 16px;">
                    <i class="bi bi-sliders me-2" style="color: #046B26;"></i>Pengaturan Layanan: {{ $item->nama }}
                </h5>
                <div class="d-flex align-items-center gap-2">
                    @if($item->kode === 'pendampingan-acara')
                        <a href="{{ route('homepage.pendampingan-acara') }}" target="_blank" class="btn btn-outline-success btn-sm">
                            <i class="bi bi-box-arrow-up-right me-1"></i> Buka Halaman Publik
                        </a>
                    @elseif($item->kode === 'permintaan-rilis')
                        <a href="{{ route('homepage.permintaan-rilis') }}" target="_blank" class="btn btn-outline-success btn-sm">
                            <i class="bi bi-box-arrow-up-right me-1"></i> Buka Halaman Publik
                        </a>
                    @endif
                    <a href="{{ route('layanan-humas.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
                    </a>
                </div>
            </div>
            <div class="card-body pt-3 pb-4">
                <form action="{{ route('layanan-humas.update-item', $item->kode) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Nama & Label --}}
                    <div class="row g-3 mb-3">
                        <div class="col-md-7 col-12">
                            <label for="nama" class="form-label fw-bold text-dark small">
                                Nama Layanan <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   id="nama"
                                   name="nama"
                                   class="form-control @error('nama') is-invalid @enderror"
                                   value="{{ old('nama', $item->nama) }}"
                                   required>
                            <div class="form-text text-muted small">Teks nama yang tampil di bawah ikon floating bar.</div>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-5 col-12">
                            <label for="badge_text" class="form-label fw-bold text-dark small">
                                Label / Kategori Kecil
                            </label>
                            <input type="text"
                                   id="badge_text"
                                   name="badge_text"
                                   class="form-control @error('badge_text') is-invalid @enderror"
                                   value="{{ old('badge_text', $item->badge_text) }}"
                                   placeholder="Contoh: Format Resmi, Protokoler, Siaran Pers">
                            @error('badge_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Deskripsi --}}
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label fw-bold text-dark small">
                            Deskripsi / Keterangan Layanan
                        </label>
                        <textarea id="deskripsi"
                                  name="deskripsi"
                                  rows="3"
                                  class="form-control tinymce-editor @error('deskripsi') is-invalid @enderror"
                                  placeholder="Contoh: Layanan permohonan penerbitan siaran pers dan liputan berita acara universitas...">{{ old('deskripsi', $item->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Ikon Bootstrap --}}
                    <div class="mb-3">
                        <label for="icon" class="form-label fw-bold text-dark small">
                            Kelas Ikon Bootstrap Icons
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-success fs-5">
                                <i id="icon-preview" class="bi {{ $item->icon ?: 'bi-grid' }}"></i>
                            </span>
                            <input type="text"
                                   id="icon"
                                   name="icon"
                                   class="form-control @error('icon') is-invalid @enderror"
                                   value="{{ old('icon', $item->icon) }}"
                                   placeholder="Contoh: bi-people-fill, bi-journal-richtext, bi-file-earmark-text">
                        </div>
                        <div class="form-text text-muted small">Referensi: <a href="https://icons.getbootstrap.com/" target="_blank">bootstrap icons library</a>.</div>
                        @error('icon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    @if($item->kode === 'permintaan-rilis' && isset($permintaanRilisSetting))
                        {{-- ═════════════════════════════════════════════════════
                             PENGATURAN SPESIFIK HALAMAN PERMINTAAN RILIS
                        ═════════════════════════════════════════════════════ --}}
                        <div class="card border border-success-subtle bg-white p-3 mb-4 shadow-sm" style="border-radius: 12px;">
                            <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
                                <i class="bi bi-file-earmark-richtext-fill text-success fs-5"></i>
                                <h6 class="fw-bold text-dark mb-0">Pengaturan Detail Halaman /permintaan-rilis</h6>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6 col-12">
                                    <label for="judul_seksi" class="form-label fw-bold text-dark small">Judul Seksi Halaman</label>
                                    <input type="text" id="judul_seksi" name="judul_seksi" class="form-control"
                                           value="{{ old('judul_seksi', $permintaanRilisSetting->judul_seksi) }}"
                                           placeholder="Contoh: Ketentuan Permintaan Rilis Berita">
                                </div>
                                <div class="col-md-6 col-12">
                                    <label for="link_form" class="form-label fw-bold text-dark small">Tautan Formulir Pengajuan (Google Form)</label>
                                    <input type="text" id="link_form" name="link_form" class="form-control"
                                           value="{{ old('link_form', $permintaanRilisSetting->link_form ?: $item->url) }}"
                                           placeholder="https://forms.gle/... atau https://docs.google.com/forms/...">
                                    <div class="form-text small text-muted">Akan terbuka saat pengunjung mengklik tombol "Isi Formulir Rilis".</div>
                                </div>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6 col-12">
                                    <label for="no_wa" class="form-label fw-bold text-dark small">Nomor WhatsApp Redaksi Humas</label>
                                    <input type="text" id="no_wa" name="no_wa" class="form-control"
                                           value="{{ old('no_wa', $permintaanRilisSetting->no_wa) }}"
                                           placeholder="Contoh: 081234567890">
                                </div>
                                <div class="col-md-6 col-12">
                                    <label for="email_tujuan" class="form-label fw-bold text-dark small">Email Redaksi Humas</label>
                                    <input type="email" id="email_tujuan" name="email_tujuan" class="form-control"
                                           value="{{ old('email_tujuan', $permintaanRilisSetting->email_tujuan) }}"
                                           placeholder="Contoh: info@uis.ac.id">
                                </div>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6 col-12">
                                    <label for="min_kata" class="form-label fw-bold text-dark small">Batas Minimal Kata</label>
                                    <input type="number" id="min_kata" name="min_kata" class="form-control"
                                           value="{{ old('min_kata', $permintaanRilisSetting->min_kata ?? 250) }}">
                                </div>
                                <div class="col-md-6 col-12">
                                    <label for="min_paragraf" class="form-label fw-bold text-dark small">Batas Minimal Paragraf</label>
                                    <input type="number" id="min_paragraf" name="min_paragraf" class="form-control"
                                           value="{{ old('min_paragraf', $permintaanRilisSetting->min_paragraf ?? 4) }}">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="deskripsi_seksi" class="form-label fw-bold text-dark small">Paragraf Pengantar Seksi (TinyMCE)</label>
                                <textarea id="deskripsi_seksi" name="deskripsi_seksi" rows="4" class="form-control tinymce-editor">{{ old('deskripsi_seksi', $permintaanRilisSetting->deskripsi_seksi) }}</textarea>
                            </div>

                            <div class="mb-2">
                                <label for="catatan_tambahan" class="form-label fw-bold text-dark small">Catatan Tambahan Redaksi di Halaman (TinyMCE)</label>
                                <textarea id="catatan_tambahan" name="catatan_tambahan" rows="3" class="form-control tinymce-editor">{{ old('catatan_tambahan', $permintaanRilisSetting->catatan_tambahan) }}</textarea>
                            </div>
                        </div>
                    @endif

                    @if($item->kode === 'pendampingan-acara' && isset($pendampinganAcaraSetting))
                        {{-- ═════════════════════════════════════════════════════
                             PENGATURAN SPESIFIK HALAMAN PENDAMPINGAN ACARA
                        ═════════════════════════════════════════════════════ --}}
                        <div class="card border border-success-subtle bg-white p-3 mb-4 shadow-sm" style="border-radius: 12px;">
                            <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
                                <i class="bi bi-people-fill text-success fs-5"></i>
                                <h6 class="fw-bold text-dark mb-0">Pengaturan Detail Halaman /pendampingan-acara</h6>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6 col-12">
                                    <label for="judul_seksi" class="form-label fw-bold text-dark small">Judul Seksi Halaman</label>
                                    <input type="text" id="judul_seksi" name="judul_seksi" class="form-control"
                                           value="{{ old('judul_seksi', $pendampinganAcaraSetting->judul_seksi) }}"
                                           placeholder="Contoh: Pendampingan Acara">
                                </div>
                                <div class="col-md-6 col-12">
                                    <label for="link_form" class="form-label fw-bold text-dark small">Tautan Link / URL Permohonan</label>
                                    <input type="text" id="link_form" name="link_form" class="form-control"
                                           value="{{ old('link_form', $pendampinganAcaraSetting->link_form ?: $item->url) }}"
                                           placeholder="https://... (contoh: https://forms.gle/... atau URL tujuan lainnya)">
                                    <div class="form-text small text-muted">Tautan langsung yang akan dibuka saat pengunjung mengklik tombol "{{ $pendampinganAcaraSetting->tombol_teks ?? 'Ajukan Permohonan' }}".</div>
                                </div>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-4 col-12">
                                    <label for="tombol_teks" class="form-label fw-bold text-dark small">Teks Tombol Permohonan</label>
                                    <input type="text" id="tombol_teks" name="tombol_teks" class="form-control"
                                           value="{{ old('tombol_teks', $pendampinganAcaraSetting->tombol_teks ?? 'Ajukan Permohonan') }}"
                                           placeholder="Contoh: Ajukan Permohonan">
                                </div>
                                <div class="col-md-8 col-12">
                                    <label for="sapaan" class="form-label fw-bold text-dark small">Kalimat Sapaan Utama (Heading)</label>
                                    <input type="text" id="sapaan" name="sapaan" class="form-control"
                                           value="{{ old('sapaan', $pendampinganAcaraSetting->sapaan) }}"
                                           placeholder="Halo, Civitas Akademika Universitas Ibnu Sina dan Mitra Eksternal!">
                                </div>
                            </div>

                            {{-- Editor TinyMCE Terpadu untuk Narasi & Poin Layanan --}}
                            <div class="mb-3">
                                <label for="konten_pendampingan" class="form-label fw-bold text-dark small">
                                    <i class="bi bi-file-earmark-richtext-fill text-success me-1"></i> Konten Penjelasan & Lingkup Bantuan (TinyMCE)
                                </label>
                                <textarea id="konten_pendampingan" name="konten" rows="10" class="form-control tinymce-editor" placeholder="Tuliskan narasi penjelasan, paragraf, dan daftar poin bantuan...">{{ old('konten', $pendampinganAcaraSetting->konten) }}</textarea>
                                <div class="form-text text-muted small">
                                    Gunakan editor TinyMCE di atas untuk mengedit paragraf, huruf tebal, atau daftar bullet point bantuan. Konten ini langsung tersinkronisasi presisi ke tampilan publik <a href="{{ route('homepage.pendampingan-acara') }}" target="_blank" class="fw-bold text-success">/pendampingan-acara</a>.
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($item->kode === 'survey-layanan' && isset($surveyLayananSetting))
                        {{-- ═════════════════════════════════════════════════════
                             PENGATURAN SPESIFIK HALAMAN SURVEY LAYANAN
                        ═════════════════════════════════════════════════════ --}}
                        <div class="card border border-success-subtle bg-white p-3 mb-4 shadow-sm" style="border-radius: 12px;">
                            <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-chat-left-dots text-success fs-5"></i>
                                    <h6 class="fw-bold text-dark mb-0">Pengaturan Detail Halaman & Tombol Survei (/survey-layanan)</h6>
                                </div>
                                <a href="{{ route('homepage.survey-layanan') }}" target="_blank" class="btn btn-sm btn-outline-success">
                                    <i class="bi bi-box-arrow-up-right me-1"></i> Preview Halaman
                                </a>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-12">
                                    <label for="judul_seksi_survey" class="form-label fw-bold text-dark small">Judul Seksi Survei</label>
                                    <input type="text" id="judul_seksi_survey" name="judul_seksi" class="form-control"
                                           value="{{ old('judul_seksi', $surveyLayananSetting->judul_seksi ?? 'Survei Evaluasi') }}"
                                           placeholder="Contoh: Survei Evaluasi">
                                    <div class="form-text small text-muted">Judul utama yang tampil di atas deretan kartu survei.</div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="deskripsi_seksi_survey" class="form-label fw-bold text-dark small">Deskripsi / Pengantar Singkat Survei</label>
                                <textarea id="deskripsi_seksi_survey" name="deskripsi_seksi" rows="2" class="form-control" placeholder="Tuliskan keterangan pengantar survei...">{{ old('deskripsi_seksi', $surveyLayananSetting->deskripsi_seksi) }}</textarea>
                            </div>

                            {{-- ── BUILDER TOMBOL SURVEI (TAMBAH / HAPUS / EDIT LINK) ── --}}
                            <div class="border rounded-3 p-3 bg-light">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div>
                                        <h6 class="fw-bold text-dark mb-1">
                                            <i class="bi bi-ui-checks-grid text-success me-1"></i> Daftar Kartu & Tombol Link Survei
                                        </h6>
                                        <p class="text-muted small mb-0">Atur judul survei dan link tujuan (Google Form dsb). Anda bebas menambah atau menghapus tombol sesuai kebutuhan.</p>
                                    </div>
                                    <button type="button" class="btn btn-success btn-sm fw-bold px-3 shadow-sm" id="btn-tambah-survey">
                                        <i class="bi bi-plus-circle-fill me-1"></i> Tambah Tombol Survei
                                    </button>
                                </div>

                                <div id="survey-buttons-container" class="d-flex flex-column gap-3">
                                    @forelse($surveyButtons as $index => $btn)
                                        <div class="survey-button-item card border shadow-sm p-3 bg-white" data-index="{{ $index }}">
                                            <input type="hidden" name="survey_buttons[{{ $index }}][id]" value="{{ $btn->id }}">
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <span class="badge bg-success-subtle text-success fw-bold survey-btn-badge">
                                                    Survei #<span class="survey-btn-number">{{ $index + 1 }}</span>
                                                </span>
                                                <button type="button" class="btn btn-outline-danger btn-sm py-0 px-2 btn-hapus-survey" title="Hapus Tombol">
                                                    <i class="bi bi-trash-fill me-1"></i> Hapus
                                                </button>
                                            </div>
                                            <div class="row g-2">
                                                <div class="col-md-6 col-12">
                                                    <label class="form-label small fw-semibold text-dark mb-1">Judul Survei / Kuesioner</label>
                                                    <input type="text" name="survey_buttons[{{ $index }}][judul]" class="form-control form-control-sm"
                                                           value="{{ $btn->judul }}" placeholder="Contoh: Survei Kepuasan Informasi Publik" required>
                                                </div>
                                                <div class="col-md-4 col-12">
                                                    <label class="form-label small fw-semibold text-dark mb-1">Tautan Link URL (Google Form dsb)</label>
                                                    <input type="text" name="survey_buttons[{{ $index }}][link_url]" class="form-control form-control-sm"
                                                           value="{{ $btn->link_url }}" placeholder="https://forms.gle/..." required>
                                                </div>
                                                <div class="col-md-2 col-12">
                                                    <label class="form-label small fw-semibold text-dark mb-1">Teks Tombol</label>
                                                    <input type="text" name="survey_buttons[{{ $index }}][tombol_teks]" class="form-control form-control-sm"
                                                           value="{{ $btn->tombol_teks ?? 'Isi Survei' }}" placeholder="Isi Survei">
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="survey-button-item card border shadow-sm p-3 bg-white" data-index="0">
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <span class="badge bg-success-subtle text-success fw-bold survey-btn-badge">
                                                    Survei #<span class="survey-btn-number">1</span>
                                                </span>
                                                <button type="button" class="btn btn-outline-danger btn-sm py-0 px-2 btn-hapus-survey" title="Hapus Tombol">
                                                    <i class="bi bi-trash-fill me-1"></i> Hapus
                                                </button>
                                            </div>
                                            <div class="row g-2">
                                                <div class="col-md-6 col-12">
                                                    <label class="form-label small fw-semibold text-dark mb-1">Judul Survei / Kuesioner</label>
                                                    <input type="text" name="survey_buttons[0][judul]" class="form-control form-control-sm"
                                                           placeholder="Contoh: Survei Kepuasan Informasi Publik" required>
                                                </div>
                                                <div class="col-md-4 col-12">
                                                    <label class="form-label small fw-semibold text-dark mb-1">Tautan Link URL (Google Form dsb)</label>
                                                    <input type="text" name="survey_buttons[0][link_url]" class="form-control form-control-sm"
                                                           placeholder="https://forms.gle/..." required>
                                                </div>
                                                <div class="col-md-2 col-12">
                                                    <label class="form-label small fw-semibold text-dark mb-1">Teks Tombol</label>
                                                    <input type="text" name="survey_buttons[0][tombol_teks]" class="form-control form-control-sm"
                                                           value="Isi Survei" placeholder="Isi Survei">
                                                </div>
                                            </div>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(!in_array($item->kode, ['pendampingan-acara', 'survey-layanan']))
                    {{-- Card Target Tautan / Upload File --}}
                    <div class="card border border-light-subtle bg-light p-3 mb-3" style="border-radius: 10px;">
                        <label class="form-label fw-bold text-dark mb-2" style="font-size: 13.5px;">
                            <i class="bi bi-link-45deg me-1 text-primary"></i> 
                            @if($item->kode === 'sihumas')
    {{-- Banner Khusus SIHUMAS --}}
    <div class="alert alert-success border-0 shadow-sm d-flex align-items-center justify-content-between p-3 mb-4" style="background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%); border-radius: 12px;">
        <div class="d-flex align-items-center gap-3">
            <div class="rounded-circle p-2 bg-white text-success fs-4 d-flex align-items-center justify-content-center shadow-sm" style="width: 48px; height: 48px;">
                <i class="bi bi-globe2" style="color: #0b6828;"></i>
            </div>
            <div>
                <h6 class="fw-bold mb-1" style="color: #064e3b;">Portal Resmi Sistem Informasi Humas (SIHUMAS)</h6>
                <p class="mb-0 text-muted small">
                    Layanan SIHUMAS terhubung langsung ke aplikasi daring Universitas Ibnu Sina:
                    <a href="https://sihumas.uisbatam.com/" target="_blank" class="fw-bold text-success text-decoration-underline ms-1">
                        https://sihumas.uisbatam.com/ <i class="bi bi-box-arrow-up-right small"></i>
                    </a>
                </p>
            </div>
        </div>
        <a href="https://sihumas.uisbatam.com/" target="_blank" class="btn btn-sm btn-success fw-bold shadow-sm d-none d-md-inline-flex align-items-center gap-1" style="background-color: #0b6828; border-color: #0b6828; border-radius: 8px;">
            <i class="bi bi-box-arrow-up-right"></i> Buka SIHUMAS
        </a>
    </div>
@elseif($item->kode === 'permintaan-rilis')
                                Berkas Pedoman / SOP Naskah Siaran Pers
                            @elseif($item->kode === 'pendampingan-acara')
                                Berkas Dokumen SOP Pendampingan Acara (PDF/DOCX)
                            @else
                                Target Tautan / File Panduan
                            @endif
                        </label>
                        <p class="text-muted small mb-3">
                            @if($item->kode === 'sihumas')
    {{-- Banner Khusus SIHUMAS --}}
    <div class="alert alert-success border-0 shadow-sm d-flex align-items-center justify-content-between p-3 mb-4" style="background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%); border-radius: 12px;">
        <div class="d-flex align-items-center gap-3">
            <div class="rounded-circle p-2 bg-white text-success fs-4 d-flex align-items-center justify-content-center shadow-sm" style="width: 48px; height: 48px;">
                <i class="bi bi-globe2" style="color: #0b6828;"></i>
            </div>
            <div>
                <h6 class="fw-bold mb-1" style="color: #064e3b;">Portal Resmi Sistem Informasi Humas (SIHUMAS)</h6>
                <p class="mb-0 text-muted small">
                    Layanan SIHUMAS terhubung langsung ke aplikasi daring Universitas Ibnu Sina:
                    <a href="https://sihumas.uisbatam.com/" target="_blank" class="fw-bold text-success text-decoration-underline ms-1">
                        https://sihumas.uisbatam.com/ <i class="bi bi-box-arrow-up-right small"></i>
                    </a>
                </p>
            </div>
        </div>
        <a href="https://sihumas.uisbatam.com/" target="_blank" class="btn btn-sm btn-success fw-bold shadow-sm d-none d-md-inline-flex align-items-center gap-1" style="background-color: #0b6828; border-color: #0b6828; border-radius: 8px;">
            <i class="bi bi-box-arrow-up-right"></i> Buka SIHUMAS
        </a>
    </div>
@elseif($item->kode === 'permintaan-rilis')
                                Unggah dokumen pedoman atau SOP rilis (PDF/DOCX) yang dapat diunduh langsung oleh sivitas akademika:
                            @elseif($item->kode === 'pendampingan-acara')
                                Unggah dokumen SOP pendampingan acara universitas (PDF/DOCX) yang dapat diunduh di halaman publik:
                            @else
                                Pilih salah satu cara pengunjung mengakses layanan ini saat ikon diklik di halaman Beranda Humas:
                            @endif
                        </p>

                        @if(!in_array($item->kode, ['permintaan-rilis', 'pendampingan-acara']))
                            {{-- Opsi 1: URL Tautan (Untuk layanan selain permintaan-rilis & pendampingan-acara) --}}
                            <div class="mb-3">
                                <label for="url" class="form-label fw-semibold text-dark small">
                                    Opsi A: Tautan URL (Google Form, Drive, Website, dsb)
                                </label>
                                <input type="text"
                                       id="url"
                                       name="url"
                                       class="form-control @error('url') is-invalid @enderror"
                                       value="{{ old('url', $item->url) }}"
                                       placeholder="https://forms.gle/... atau https://drive.google.com/...">
                                <div class="form-text text-muted small">Bisa tempel link Google Form survei/permohonan, Google Drive, atau link eksternal.</div>
                                @error('url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="text-center my-1 text-muted fw-bold small">
                                <span>— ATAU —</span>
                            </div>
                        @endif

                        {{-- Opsi 2: Upload File --}}
                        <div class="mb-2">
                            <label for="file" class="form-label fw-semibold text-dark small">
                                @if($item->kode === 'sihumas')
    {{-- Banner Khusus SIHUMAS --}}
    <div class="alert alert-success border-0 shadow-sm d-flex align-items-center justify-content-between p-3 mb-4" style="background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%); border-radius: 12px;">
        <div class="d-flex align-items-center gap-3">
            <div class="rounded-circle p-2 bg-white text-success fs-4 d-flex align-items-center justify-content-center shadow-sm" style="width: 48px; height: 48px;">
                <i class="bi bi-globe2" style="color: #0b6828;"></i>
            </div>
            <div>
                <h6 class="fw-bold mb-1" style="color: #064e3b;">Portal Resmi Sistem Informasi Humas (SIHUMAS)</h6>
                <p class="mb-0 text-muted small">
                    Layanan SIHUMAS terhubung langsung ke aplikasi daring Universitas Ibnu Sina:
                    <a href="https://sihumas.uisbatam.com/" target="_blank" class="fw-bold text-success text-decoration-underline ms-1">
                        https://sihumas.uisbatam.com/ <i class="bi bi-box-arrow-up-right small"></i>
                    </a>
                </p>
            </div>
        </div>
        <a href="https://sihumas.uisbatam.com/" target="_blank" class="btn btn-sm btn-success fw-bold shadow-sm d-none d-md-inline-flex align-items-center gap-1" style="background-color: #0b6828; border-color: #0b6828; border-radius: 8px;">
            <i class="bi bi-box-arrow-up-right"></i> Buka SIHUMAS
        </a>
    </div>
@elseif($item->kode === 'permintaan-rilis')
                                    Upload File Pedoman / Dokumen SOP Rilis (PDF, DOCX)
                                @elseif($item->kode === 'pendampingan-acara')
                                    Upload File SOP / Pedoman Acara (PDF, DOCX)
                                @else
                                    Opsi B: Upload File Panduan / Dokumen Template (PDF, DOCX, ZIP)
                                @endif
                            </label>
                            <input type="file"
                                   id="file"
                                   name="file"
                                   class="form-control @error('file') is-invalid @enderror">
                            <div class="form-text text-muted small">Maksimal 20 MB.</div>
                            @error('file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            @if($item->file_path)
                                <div class="alert alert-white border shadow-sm p-2 mt-2 mb-0 d-flex align-items-center justify-content-between" style="border-radius: 6px;">
                                    <div class="small">
                                        <i class="bi bi-file-earmark-check text-success me-1"></i>
                                        File saat ini: <strong>{{ basename($item->file_path) }}</strong>
                                        <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank" class="ms-2 text-primary">Buka File</a>
                                    </div>
                                    <div class="form-check m-0">
                                        <input class="form-check-input" type="checkbox" name="hapus_file" id="hapus_file" value="1">
                                        <label class="form-check-label text-danger small fw-semibold" for="hapus_file">
                                            Hapus File
                                        </label>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    {{-- Pengaturan Tambahan --}}
                    <div class="row g-3 mb-4">
                        <div class="col-md-6 col-12">
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" name="target_blank" id="target_blank" value="1" {{ old('target_blank', $item->target_blank) ? 'checked' : '' }}>
                                <label class="form-check-label text-dark small fw-semibold" for="target_blank">
                                    Buka tautan di tab browser baru (target="_blank")
                                </label>
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" role="switch" name="is_active" id="is_active" value="1" {{ old('is_active', $item->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label text-dark fw-semibold small" for="is_active">
                                    Status Aktif (Tampilkan di Beranda Humas)
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="d-flex justify-content-end gap-2 pt-2 border-top">
                        <a href="{{ route('layanan-humas.index') }}" class="btn btn-secondary px-3">Batal</a>
                        <button type="submit" class="btn fw-semibold px-4" style="background-color: #046B26; color: #ffffff;">
                            <i class="bi bi-floppy-fill me-1"></i> Simpan Pengaturan Layanan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if($item->kode !== 'pendampingan-acara')
    {{-- Live Card Preview Side Box --}}
    <div class="col-lg-4 col-md-12">
        <div class="card shadow-sm border-0 sticky-top" style="top: 90px; border-radius: 12px;">
            <div class="card-header bg-white py-3" style="border-top: 3px solid #046B26; border-radius: 12px 12px 0 0;">
                <h6 class="mb-0 fw-bold text-dark">
                    <i class="bi bi-eye-fill me-1 text-success"></i> Simulasi Icon di Frontend
                </h6>
                <small class="text-muted">Tampilan saat pengunjung membuka halaman /humas</small>
            </div>
            <div class="card-body p-4 text-center bg-light" style="border-radius: 0 0 12px 12px;">
                {{-- Mockup floating item --}}
                <div class="p-3 bg-white rounded-3 shadow-sm mx-auto d-inline-flex flex-column align-items-center justify-content-center"
                     style="width: 140px; border: 1px solid #e2e8f0;">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mb-2"
                         style="width: 52px; height: 52px; background-color: #e8f5e9; color: #046B26; font-size: 24px;">
                        <i id="preview-icon-live" class="bi {{ $item->icon ?: 'bi-grid' }}"></i>
                    </div>
                    <span id="preview-nama-live" class="fw-bold text-dark text-center small" style="line-height: 1.3;">
                        {{ $item->nama }}
                    </span>
                </div>

                <div class="mt-3">
                    <span class="badge bg-success-subtle text-success px-2 py-1 small">
                        Kode: {{ $item->kode }}
                    </span>
                </div>

                @if($item->kode === 'sihumas')
    {{-- Banner Khusus SIHUMAS --}}
    <div class="alert alert-success border-0 shadow-sm d-flex align-items-center justify-content-between p-3 mb-4" style="background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%); border-radius: 12px;">
        <div class="d-flex align-items-center gap-3">
            <div class="rounded-circle p-2 bg-white text-success fs-4 d-flex align-items-center justify-content-center shadow-sm" style="width: 48px; height: 48px;">
                <i class="bi bi-globe2" style="color: #0b6828;"></i>
            </div>
            <div>
                <h6 class="fw-bold mb-1" style="color: #064e3b;">Portal Resmi Sistem Informasi Humas (SIHUMAS)</h6>
                <p class="mb-0 text-muted small">
                    Layanan SIHUMAS terhubung langsung ke aplikasi daring Universitas Ibnu Sina:
                    <a href="https://sihumas.uisbatam.com/" target="_blank" class="fw-bold text-success text-decoration-underline ms-1">
                        https://sihumas.uisbatam.com/ <i class="bi bi-box-arrow-up-right small"></i>
                    </a>
                </p>
            </div>
        </div>
        <a href="https://sihumas.uisbatam.com/" target="_blank" class="btn btn-sm btn-success fw-bold shadow-sm d-none d-md-inline-flex align-items-center gap-1" style="background-color: #0b6828; border-color: #0b6828; border-radius: 8px;">
            <i class="bi bi-box-arrow-up-right"></i> Buka SIHUMAS
        </a>
    </div>
@elseif($item->kode === 'permintaan-rilis')
                    <div class="mt-3 pt-3 border-top text-start">
                        <small class="fw-bold text-dark d-block mb-1">
                            <i class="bi bi-link-45deg text-success"></i> Halaman Publik Tujuan:
                        </small>
                        <a href="{{ route('homepage.permintaan-rilis') }}" target="_blank" class="small text-success fw-bold text-break d-flex align-items-center gap-1">
                            {{ url('/permintaan-rilis') }} <i class="bi bi-box-arrow-up-right"></i>
                        </a>
                    </div>
                @elseif($item->kode === 'pendampingan-acara')
                    <div class="mt-3 pt-3 border-top text-start">
                        <small class="fw-bold text-dark d-block mb-1">
                            <i class="bi bi-link-45deg text-success"></i> Halaman Publik Tujuan:
                        </small>
                        <a href="{{ route('homepage.pendampingan-acara') }}" target="_blank" class="small text-success fw-bold text-break d-flex align-items-center gap-1">
                            {{ url('/pendampingan-acara') }} <i class="bi bi-box-arrow-up-right"></i>
                        </a>
                    </div>
                @elseif($item->kode === 'survey-layanan')
                    <div class="mt-3 pt-3 border-top text-start">
                        <small class="fw-bold text-dark d-block mb-1">
                            <i class="bi bi-link-45deg text-success"></i> Halaman Publik Tujuan:
                        </small>
                        <a href="{{ route('homepage.survey-layanan') }}" target="_blank" class="small text-success fw-bold text-break d-flex align-items-center gap-1">
                            {{ url('/survey-layanan') }} <i class="bi bi-box-arrow-up-right"></i>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const iconInput = document.getElementById('icon');
        const iconPreview = document.getElementById('icon-preview');
        const previewIconLive = document.getElementById('preview-icon-live');
        const namaInput = document.getElementById('nama');
        const previewNamaLive = document.getElementById('preview-nama-live');

        if (iconInput) {
            iconInput.addEventListener('input', function () {
                const val = this.value.trim() || 'bi-grid';
                if (iconPreview) iconPreview.className = 'bi ' + val;
                if (previewIconLive) previewIconLive.className = 'bi ' + val;
            });
        }

        if (namaInput && previewNamaLive) {
            namaInput.addEventListener('input', function () {
                previewNamaLive.textContent = this.value.trim() || 'Nama Layanan';
            });
        }

        // Script Dinamis Tambah & Hapus Tombol Survei
        const btnTambahSurvey = document.getElementById('btn-tambah-survey');
        const containerSurvey = document.getElementById('survey-buttons-container');

        function updateSurveyIndices() {
            if (!containerSurvey) return;
            const items = containerSurvey.querySelectorAll('.survey-button-item');
            items.forEach((item, idx) => {
                item.setAttribute('data-index', idx);
                const numberBadge = item.querySelector('.survey-btn-number');
                if (numberBadge) numberBadge.textContent = (idx + 1);

                const idInput = item.querySelector('input[name*="[id]"]');
                if (idInput) idInput.name = `survey_buttons[${idx}][id]`;

                const judulInput = item.querySelector('input[name*="[judul]"]');
                if (judulInput) judulInput.name = `survey_buttons[${idx}][judul]`;

                const linkInput = item.querySelector('input[name*="[link_url]"]');
                if (linkInput) linkInput.name = `survey_buttons[${idx}][link_url]`;

                const teksInput = item.querySelector('input[name*="[tombol_teks]"]');
                if (teksInput) teksInput.name = `survey_buttons[${idx}][tombol_teks]`;
            });
        }

        if (btnTambahSurvey && containerSurvey) {
            btnTambahSurvey.addEventListener('click', function () {
                const items = containerSurvey.querySelectorAll('.survey-button-item');
                const nextIdx = items.length;

                const template = document.createElement('div');
                template.className = 'survey-button-item card border shadow-sm p-3 bg-white';
                template.setAttribute('data-index', nextIdx);
                template.innerHTML = `
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="badge bg-success-subtle text-success fw-bold survey-btn-badge">
                            Survei #<span class="survey-btn-number">${nextIdx + 1}</span>
                        </span>
                        <button type="button" class="btn btn-outline-danger btn-sm py-0 px-2 btn-hapus-survey" title="Hapus Tombol">
                            <i class="bi bi-trash-fill me-1"></i> Hapus
                        </button>
                    </div>
                    <div class="row g-2">
                        <div class="col-md-6 col-12">
                            <label class="form-label small fw-semibold text-dark mb-1">Judul Survei / Kuesioner</label>
                            <input type="text" name="survey_buttons[${nextIdx}][judul]" class="form-control form-control-sm"
                                   placeholder="Contoh: Survei Kepuasan Layanan Baru" required>
                        </div>
                        <div class="col-md-4 col-12">
                            <label class="form-label small fw-semibold text-dark mb-1">Tautan Link URL (Google Form dsb)</label>
                            <input type="text" name="survey_buttons[${nextIdx}][link_url]" class="form-control form-control-sm"
                                   placeholder="https://forms.gle/..." required>
                        </div>
                        <div class="col-md-2 col-12">
                            <label class="form-label small fw-semibold text-dark mb-1">Teks Tombol</label>
                            <input type="text" name="survey_buttons[${nextIdx}][tombol_teks]" class="form-control form-control-sm"
                                   value="Isi Survei" placeholder="Isi Survei">
                        </div>
                    </div>
                `;

                containerSurvey.appendChild(template);
                updateSurveyIndices();
            });

            containerSurvey.addEventListener('click', function (e) {
                const hapusBtn = e.target.closest('.btn-hapus-survey');
                if (hapusBtn) {
                    const item = hapusBtn.closest('.survey-button-item');
                    if (item) {
                        item.remove();
                        updateSurveyIndices();
                    }
                }
            });
        }
    });
</script>
@endpush
