@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle mb-4">
    <h1 class="mb-1">Kelola Dokumen Panduan PMB (PDF)</h1>
    <nav>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">PMB</li>
            <li class="breadcrumb-item active">Dokumen Panduan</li>
        </ol>
    </nav>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4 rounded-3 border-0 shadow-sm" role="alert">
        <i class="bi bi-check-circle-fill me-2 fs-5"></i>
        <div>{{ session('success') }}</div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white">
            <h5 class="fw-bold text-dark border-bottom pb-3 mb-4 d-flex align-items-center gap-2">
                <i class="bi bi-file-earmark-pdf-fill text-danger fs-4"></i> Dokumen Buku Panduan & Ketentuan PMB
            </h5>

            <form action="{{ route('admin.pmb.dokumen.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="file_pdf_nama" class="form-label fw-bold text-dark small">Nama Judul Dokumen Panduan</label>
                    <input type="text" id="file_pdf_nama" name="file_pdf_nama" class="form-control" value="{{ old('file_pdf_nama', $pmb->file_pdf_nama) }}" placeholder="Contoh: Buku Panduan & Rincian PMB TA 2026/2027.pdf">
                </div>

                {{-- Status Dokumen Saat Ini --}}
                @if(!empty($pmb->file_pdf))
                    <div class="p-3 rounded-3 bg-light border mb-4 d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-file-earmark-check-fill text-success fs-4"></i>
                            <div>
                                <div class="fw-bold text-dark small">{{ $pmb->file_pdf_nama ?: 'Dokumen Panduan Aktif' }}</div>
                                <div class="text-muted small text-truncate" style="max-width: 320px;">
                                    {{ str_starts_with($pmb->file_pdf, 'http') ? $pmb->file_pdf : basename($pmb->file_pdf) }}
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <a href="{{ $pmb->pdf_url }}" target="_blank" class="btn btn-sm btn-outline-success rounded-pill px-3">
                                <i class="bi bi-box-arrow-up-right me-1"></i> Buka Dokumen
                            </a>
                        </div>
                    </div>
                @endif

                {{-- Opsi 1: Link Google Drive --}}
                <div class="p-3.5 rounded-4 bg-light border mb-3">
                    <label for="link_gdrive" class="form-label fw-bold text-dark mb-1 d-flex align-items-center gap-2">
                        <i class="bi bi-google text-primary fs-5"></i> Tautan Dokumen Google Drive <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2 py-0.5 small">Rekomendasi</span>
                    </label>
                    <p class="text-muted small mb-2">Tautan file PDF panduan PMB yang diunggah ke Google Drive (pastikan izin sharing publik "Siapa saja yang memiliki link").</p>
                    <input type="url" id="link_gdrive" name="link_gdrive" class="form-control" value="{{ old('link_gdrive', str_starts_with($pmb->file_pdf ?? '', 'http') ? $pmb->file_pdf : '') }}" placeholder="https://drive.google.com/file/d/.../view?usp=sharing">
                </div>

                {{-- Opsi 2: Upload File Fisik Lokal --}}
                <div class="p-3 rounded-3 bg-white border mb-4">
                    <label for="file_pdf" class="form-label fw-bold text-secondary mb-1 small d-flex align-items-center gap-2">
                        <i class="bi bi-upload text-secondary"></i> Opsi Cadangan: Upload Berkas PDF Fisik
                    </label>
                    <p class="text-muted small mb-2">Maksimal ukuran file 50 MB.</p>
                    <input type="file" id="file_pdf" name="file_pdf" class="form-control" accept=".pdf">
                    
                    @if(!empty($pmb->file_pdf))
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" id="hapus_pdf" name="hapus_pdf" value="1">
                            <label class="form-check-label text-danger small fw-semibold" for="hapus_pdf">
                                Hapus Dokumen Panduan yang Tersimpan
                            </label>
                        </div>
                    @endif
                </div>

                <button type="submit" class="btn btn-success px-4 py-2.5 rounded-pill fw-bold shadow-sm" style="background-color: #046B26; border-color: #046B26;">
                    <i class="bi bi-save me-1"></i> Simpan Dokumen Panduan
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
