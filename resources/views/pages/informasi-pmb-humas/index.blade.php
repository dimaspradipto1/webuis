@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Kelola Informasi Khusus PMB</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Layanan Humas</li>
            <li class="breadcrumb-item active">Informasi Khusus PMB</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card shadow-sm border-0 mb-4" style="border-radius: 12px;">
            <div class="card-header bg-white py-3 d-flex flex-wrap align-items-center justify-content-between gap-2" style="border-top: 3px solid #046B26; border-radius: 12px 12px 0 0;">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; background-color: #e8f5e9; color: #046B26;">
                        <i class="bi bi-mortarboard-fill fs-5"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold" style="color: #2b2f32; font-size: 16px;">Pengaturan Halaman Informasi Khusus PMB</h5>
                        <small class="text-muted">Kelola dokumen PDF panduan, poster brosur gambar, alur pendaftaran, dan kontak resmi PMB</small>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('homepage.informasi-pmb') }}" target="_blank" class="btn btn-outline-success btn-sm fw-semibold">
                        <i class="bi bi-box-arrow-up-right me-1"></i> Buka Halaman Publik Frontend
                    </a>
                </div>
            </div>

            <div class="card-body pt-4">
                @if (isset($errors) && $errors->any())
                    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
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

                <form action="{{ route('informasi-pmb-humas.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- ═══════════════════════════════════════════════════════════════
                         SEKSI 1: IDENTITAS & HERO BANNER
                         ═══════════════════════════════════════════════════════════════ --}}
                    <div class="card border border-light-subtle bg-light p-3 p-md-4 mb-4" style="border-radius: 10px;">
                        <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">
                            <i class="bi bi-card-heading text-success me-1"></i> 1. Informasi Judul & Teks Hero
                        </h6>
                        <div class="row g-3 mb-3">
                            <div class="col-md-7 col-12">
                                <label for="judul" class="form-label fw-bold text-dark small">
                                    Judul Halaman <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       id="judul"
                                       name="judul"
                                       class="form-control @error('judul') is-invalid @enderror"
                                       value="{{ old('judul', $pmb->judul) }}"
                                       placeholder="Informasi Khusus Penerimaan Mahasiswa Baru"
                                       required>
                                @error('judul')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-5 col-12">
                                <label for="badge_text" class="form-label fw-bold text-dark small">
                                    Badge / Label Tahun Akademik
                                </label>
                                <input type="text"
                                       id="badge_text"
                                       name="badge_text"
                                       class="form-control @error('badge_text') is-invalid @enderror"
                                       value="{{ old('badge_text', $pmb->badge_text) }}"
                                       placeholder="PMB TA 2026/2027">
                                @error('badge_text')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6 col-12">
                                <label for="subjudul" class="form-label fw-bold text-dark small">
                                    Subjudul / Keterangan Institusi
                                </label>
                                <input type="text"
                                       id="subjudul"
                                       name="subjudul"
                                       class="form-control @error('subjudul') is-invalid @enderror"
                                       value="{{ old('subjudul', $pmb->subjudul) }}"
                                       placeholder="Tahun Akademik 2026/2027 — Universitas Ibnu Sina">
                                @error('subjudul')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 col-12">
                                <label for="link_pendaftaran" class="form-label fw-bold text-dark small">
                                    Tautan Portal Pendaftaran PMB Online
                                </label>
                                <input type="url"
                                       id="link_pendaftaran"
                                       name="link_pendaftaran"
                                       class="form-control @error('link_pendaftaran') is-invalid @enderror"
                                       value="{{ old('link_pendaftaran', $pmb->link_pendaftaran) }}"
                                       placeholder="https://pmb.uis.ac.id">
                                @error('link_pendaftaran')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row g-3 mb-2">
                            <div class="col-md-6 col-12">
                                <label for="no_wa_pmb" class="form-label fw-bold text-dark small">
                                    Nomor WhatsApp Layanan / Helpdesk PMB
                                </label>
                                <input type="text"
                                       id="no_wa_pmb"
                                       name="no_wa_pmb"
                                       class="form-control @error('no_wa_pmb') is-invalid @enderror"
                                       value="{{ old('no_wa_pmb', $pmb->no_wa_pmb) }}"
                                       placeholder="Contoh: 082283958644">
                                @error('no_wa_pmb')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 col-12">
                                <label for="deskripsi_singkat" class="form-label fw-bold text-dark small">
                                    Deskripsi Singkat / Sambutan Pengantar
                                </label>
                                <textarea id="deskripsi_singkat"
                                          name="deskripsi_singkat"
                                          rows="3"
                                          class="form-control @error('deskripsi_singkat') is-invalid @enderror"
                                          placeholder="Ringkasan narasi pembuka informasi PMB...">{{ old('deskripsi_singkat', $pmb->deskripsi_singkat) }}</textarea>
                                @error('deskripsi_singkat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- ═══════════════════════════════════════════════════════════════
                         SEKSI 2: DOKUMEN RESMI PANDUAN PMB (PDF)
                         ═══════════════════════════════════════════════════════════════ --}}
                    <div class="card border border-light-subtle bg-light p-3 p-md-4 mb-4" style="border-radius: 10px;">
                        <div class="d-flex align-items-center justify-content-between border-bottom pb-2 mb-3">
                            <h6 class="fw-bold text-dark mb-0">
                                <i class="bi bi-file-earmark-pdf-fill text-danger me-1"></i> 2. File Dokumen Panduan PMB (PDF)
                            </h6>
                            <a href="{{ route('homepage.pmb-panduan') }}" target="_blank" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-box-arrow-up-right me-1"></i> Lihat Halaman Panduan
                            </a>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6 col-12">
                                <label for="file_pdf" class="form-label fw-bold text-dark small">
                                    Unggah File PDF Panduan PMB <small class="text-muted">(Maks. 50 MB)</small>
                                </label>
                                <input type="file"
                                       id="file_pdf"
                                       name="file_pdf"
                                       class="form-control @error('file_pdf') is-invalid @enderror"
                                       accept="application/pdf">
                                <div class="form-text small text-muted">Format berkas harus <strong>.PDF</strong>. Pengunjung dapat membaca langsung atau mengunduh dokumen ini.</div>
                                @error('file_pdf')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 col-12">
                                <label for="file_pdf_nama" class="form-label fw-bold text-dark small">
                                    Nama Tampilan Dokumen PDF
                                </label>
                                <input type="text"
                                       id="file_pdf_nama"
                                       name="file_pdf_nama"
                                       class="form-control @error('file_pdf_nama') is-invalid @enderror"
                                       value="{{ old('file_pdf_nama', $pmb->file_pdf_nama) }}"
                                       placeholder="Contoh: Buku Panduan & Biaya Kuliah PMB TA 2026/2027">
                                @error('file_pdf_nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Tampilan PDF Saat Ini --}}
                        @if($pmb->file_pdf)
                            <div class="alert alert-white border shadow-sm p-3 mt-2 d-flex flex-wrap align-items-center justify-content-between gap-3 bg-white" style="border-radius: 8px;">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded p-2 bg-danger-subtle text-danger fs-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                        <i class="bi bi-file-earmark-pdf-fill"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $pmb->file_pdf_nama ?: basename($pmb->file_pdf) }}</div>
                                        <small class="text-muted">
                                            Ukuran file: <strong>{{ $pmb->pdf_size ?? 'Tersimpan' }}</strong>
                                            &bull;
                                            <a href="{{ $pmb->pdf_url }}" target="_blank" class="text-primary fw-semibold">
                                                <i class="bi bi-box-arrow-up-right"></i> Buka File PDF
                                            </a>
                                        </small>
                                    </div>
                                </div>
                                <div class="form-check m-0">
                                    <input class="form-check-input" type="checkbox" name="hapus_pdf" id="hapus_pdf" value="1">
                                    <label class="form-check-label text-danger small fw-semibold" for="hapus_pdf">
                                        <i class="bi bi-trash-fill me-1"></i> Hapus Berkas PDF Ini
                                    </label>
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- ═══════════════════════════════════════════════════════════════
                         SEKSI 3: GAMBAR BROSUR & POSTER PMB
                         ═══════════════════════════════════════════════════════════════ --}}
                    <div class="card border border-light-subtle bg-light p-3 p-md-4 mb-4" style="border-radius: 10px;">
                        <div class="d-flex align-items-center justify-content-between border-bottom pb-2 mb-3">
                            <h6 class="fw-bold text-dark mb-0">
                                <i class="bi bi-images text-success me-1"></i> 3. Gambar Brosur & Poster Infografis PMB
                            </h6>
                            <a href="{{ route('homepage.pmb-brosur') }}" target="_blank" class="btn btn-sm btn-outline-success">
                                <i class="bi bi-box-arrow-up-right me-1"></i> Lihat Halaman Brosur
                            </a>
                        </div>

                        <div class="row g-4">
                            {{-- Poster 1 (Utama) --}}
                            <div class="col-md-6 col-12">
                                <label for="gambar_brosur" class="form-label fw-bold text-dark small">
                                    Poster Brosur Utama <small class="text-muted">(JPG, PNG, WEBP maks 10 MB)</small>
                                </label>
                                <input type="file"
                                       id="gambar_brosur"
                                       name="gambar_brosur"
                                       class="form-control @error('gambar_brosur') is-invalid @enderror"
                                       accept="image/*"
                                       onchange="previewImg(this, 'preview-brosur-1')">
                                @error('gambar_brosur')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <div class="mt-3 p-2 bg-white border rounded text-center" style="border-radius: 8px;">
                                    <small class="fw-semibold text-muted d-block mb-1">Pratinjau Brosur Utama:</small>
                                    @if($pmb->gambar_brosur_url)
                                        <a href="{{ $pmb->gambar_brosur_url }}" target="_blank">
                                            <img id="preview-brosur-1" src="{{ $pmb->gambar_brosur_url }}" alt="Brosur Utama" class="img-fluid rounded shadow-sm" style="max-height: 260px; object-fit: contain;">
                                        </a>
                                        <div class="form-check mt-2 text-start">
                                            <input class="form-check-input" type="checkbox" name="hapus_gambar_brosur" id="hapus_gambar_brosur" value="1">
                                            <label class="form-check-label text-danger small fw-semibold" for="hapus_gambar_brosur">
                                                Hapus Poster Utama
                                            </label>
                                        </div>
                                    @else
                                        <img id="preview-brosur-1" src="#" alt="Belum ada brosur" class="img-fluid rounded shadow-sm d-none" style="max-height: 260px; object-fit: contain;">
                                        <div id="no-brosur-1" class="text-muted small py-4">
                                            <i class="bi bi-image fs-1 d-block text-secondary opacity-50 mb-1"></i>
                                            Belum ada gambar brosur utama yang diunggah
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Poster 2 (Tambahan / Alur / Rincian Biaya) --}}
                            <div class="col-md-6 col-12">
                                <label for="gambar_brosur_2" class="form-label fw-bold text-dark small">
                                    Poster Brosur Tambahan / Rincian Biaya <small class="text-muted">(Opsional)</small>
                                </label>
                                <input type="file"
                                       id="gambar_brosur_2"
                                       name="gambar_brosur_2"
                                       class="form-control @error('gambar_brosur_2') is-invalid @enderror"
                                       accept="image/*"
                                       onchange="previewImg(this, 'preview-brosur-2')">
                                @error('gambar_brosur_2')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <div class="mt-3 p-2 bg-white border rounded text-center" style="border-radius: 8px;">
                                    <small class="fw-semibold text-muted d-block mb-1">Pratinjau Brosur Tambahan:</small>
                                    @if($pmb->gambar_brosur_2_url)
                                        <a href="{{ $pmb->gambar_brosur_2_url }}" target="_blank">
                                            <img id="preview-brosur-2" src="{{ $pmb->gambar_brosur_2_url }}" alt="Brosur Tambahan" class="img-fluid rounded shadow-sm" style="max-height: 260px; object-fit: contain;">
                                        </a>
                                        <div class="form-check mt-2 text-start">
                                            <input class="form-check-input" type="checkbox" name="hapus_gambar_brosur_2" id="hapus_gambar_brosur_2" value="1">
                                            <label class="form-check-label text-danger small fw-semibold" for="hapus_gambar_brosur_2">
                                                Hapus Poster Tambahan
                                            </label>
                                        </div>
                                    @else
                                        <img id="preview-brosur-2" src="#" alt="Belum ada brosur" class="img-fluid rounded shadow-sm d-none" style="max-height: 260px; object-fit: contain;">
                                        <div id="no-brosur-2" class="text-muted small py-4">
                                            <i class="bi bi-image fs-1 d-block text-secondary opacity-50 mb-1"></i>
                                            Belum ada gambar brosur tambahan yang diunggah
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ═══════════════════════════════════════════════════════════════
                         SEKSI 4: PERSYARATAN BERKAS PENDAFTARAN
                         ═══════════════════════════════════════════════════════════════ --}}
                    <div class="card border border-light-subtle bg-light p-3 p-md-4 mb-4" style="border-radius: 10px;">
                        <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">
                            <i class="bi bi-file-earmark-check-fill text-success me-1"></i> 4. Persyaratan Berkas Pendaftaran PMB
                        </h6>

                        <div class="row g-3">
                            <div class="col-12">
                                <label for="persyaratan_info" class="form-label fw-bold text-dark small">
                                    Persyaratan Berkas Pendaftaran
                                </label>
                                <textarea id="persyaratan_info"
                                          name="persyaratan_info"
                                          rows="5"
                                          class="form-control @error('persyaratan_info') is-invalid @enderror"
                                          placeholder="1. Salinan Ijazah/SKL dilegalisir&#10;2. Salinan KK dan KTP&#10;3. Pas foto berwarna 3x4...">{{ old('persyaratan_info', $pmb->persyaratan_info) }}</textarea>
                                <div class="form-text small text-muted">Rincian berkas yang wajib dipersiapkan calon mahasiswa.</div>
                            </div>
                        </div>
                    </div>

                    {{-- Status Aktif --}}
                    <div class="p-3 bg-light rounded-3 mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" name="is_active" id="is_active" value="1" {{ old('is_active', $pmb->is_active ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label text-dark fw-semibold small" for="is_active">
                                Status Aktif (Halaman dapat diakses oleh publik di /informasi-khusus-pmb)
                            </label>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="d-flex justify-content-end gap-2 pt-2 border-top">
                        <button type="submit" class="btn fw-semibold px-4" style="background-color: #046B26; color: #ffffff;">
                            <i class="bi bi-floppy-fill me-1"></i> Simpan Pengaturan Informasi PMB
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function previewImg(input, targetId) {
        const preview = document.getElementById(targetId);
        const noBox = document.getElementById(targetId.replace('preview-', 'no-'));
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                if (preview) {
                    preview.src = e.target.result;
                    preview.classList.remove('d-none');
                }
                if (noBox) {
                    noBox.classList.add('d-none');
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
