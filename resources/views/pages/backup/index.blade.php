@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Backup Database & Storage</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Pengaturan Sistem</li>
            <li class="breadcrumb-item active">Backup Database & Storage</li>
        </ol>
    </nav>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (isset($errors) && $errors->any())
    <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        <strong>Periksa kembali berkas yang diunggah:</strong>
        <ul class="mb-0 mt-1 ps-3">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<section class="section">
    <div class="row g-4 align-items-stretch">

        {{-- Kolom Kiri: Ekspor & Impor Database --}}
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100 mb-0" style="border-radius: 12px;">
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex align-items-start gap-3 mb-4">
                            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                 style="width: 48px; height: 48px; background-color: #2e6b34; color: #ffffff;">
                                <i class="bi bi-database-fill-gear fs-5"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1" style="color: #1e293b; font-size: 17px;">Ekspor & Impor Database</h5>
                                <p class="text-muted small mb-0" style="line-height: 1.5;">
                                    Unduh atau pulihkan struktur tabel dan data database aplikasi sebagai berkas SQL.
                                </p>
                            </div>
                        </div>

                        <div class="mb-4" style="font-size: 14px;">
                            <div class="row py-1.5 mb-2 align-items-center">
                                <div class="col-4 text-secondary fw-semibold">Koneksi</div>
                                <div class="col-8">
                                    <span class="badge bg-light text-dark border fw-bold px-2.5 py-1" style="font-size: 11.5px; letter-spacing: 0.4px;">
                                        {{ strtoupper($connection) }}
                                    </span>
                                </div>
                            </div>
                            <div class="row py-1.5 mb-2 align-items-center">
                                <div class="col-4 text-secondary fw-semibold">Database</div>
                                <div class="col-8">
                                    <code style="color: #d63384; font-size: 13.5px; background: transparent; padding: 0;">{{ $databaseName }}</code>
                                </div>
                            </div>
                            <div class="row py-1.5 align-items-center">
                                <div class="col-4 text-secondary fw-semibold">Isi backup</div>
                                <div class="col-8 text-dark">
                                    Struktur dan data semua tabel MySQL ({{ $tableCount }} tabel)
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="alert border-0 mb-4 py-3 px-3" style="background-color: #e0f5ff; color: #055160; border-radius: 8px; font-size: 13px; line-height: 1.55;">
                            <i class="bi bi-shield-fill-check me-1"></i>
                            Hanya administrator yang dapat mengunduh dan memulihkan database. Simpan berkas SQL di lokasi aman karena berisi seluruh data aplikasi.
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <a href="{{ route('backup.export-database') }}"
                               class="btn text-white fw-medium px-3 py-2"
                               style="background-color: #2e6b34; border-color: #2e6b34; font-size: 13.5px; border-radius: 6px;">
                                <i class="bi bi-download me-1"></i> Unduh Backup SQL
                            </a>
                            <button type="button"
                                    class="btn btn-outline-primary fw-medium px-3 py-2"
                                    style="font-size: 13.5px; border-radius: 6px;"
                                    data-bs-toggle="modal"
                                    data-bs-target="#importDbModal">
                                <i class="bi bi-upload me-1"></i> Import / Pulihkan Database
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Backup & Impor Storage Public --}}
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100 mb-0" style="border-radius: 12px;">
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex align-items-start gap-3 mb-4">
                            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                 style="width: 48px; height: 48px; background-color: #eaf3ec; color: #2e6b34;">
                                <i class="bi bi-folder-symlink fs-5"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1" style="color: #1e293b; font-size: 17px;">Backup & Impor Storage Public</h5>
                                <p class="text-muted small mb-0" style="line-height: 1.5;">
                                    Arsipkan atau pulihkan semua file pada folder <code style="color: #d63384;">storage/app/public</code> ke dalam berkas ZIP.
                                </p>
                            </div>
                        </div>

                        <div class="mb-4" style="font-size: 14px;">
                            <div class="row py-1.5 mb-2 align-items-center">
                                <div class="col-4 text-secondary fw-semibold">Direktori</div>
                                <div class="col-8">
                                    <code style="color: #d63384; font-size: 13.5px; background: transparent; padding: 0;">storage/app/public</code>
                                </div>
                            </div>
                            <div class="row py-1.5 mb-2 align-items-center">
                                <div class="col-4 text-secondary fw-semibold">Total Berkas</div>
                                <div class="col-8 text-dark">
                                    {{ number_format($storageFileCount, 0, ',', '.') }} berkas ({{ $storageSizeFormatted }})
                                </div>
                            </div>
                            <div class="row py-1.5 align-items-center">
                                <div class="col-4 text-secondary fw-semibold">Format Arsip</div>
                                <div class="col-8 text-dark">
                                    ZIP Archive (<code>.zip</code>)
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="alert border-0 mb-4 py-3 px-3" style="background-color: #fff3cd; color: #664d03; border-radius: 8px; font-size: 13px; line-height: 1.55;">
                            <i class="bi bi-exclamation-triangle-fill me-1 text-warning"></i>
                            Backup storage memuat seluruh berkas lampiran, gambar, foto pimpinan, berita, dan dokumen publik aplikasi.
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <a href="{{ route('backup.export-storage') }}"
                               class="btn text-white fw-medium px-3 py-2"
                               style="background-color: #2e6b34; border-color: #2e6b34; font-size: 13.5px; border-radius: 6px;">
                                <i class="bi bi-download me-1"></i> Unduh Backup Storage ZIP
                            </a>
                            <button type="button"
                                    class="btn fw-medium px-3 py-2"
                                    style="font-size: 13.5px; border-radius: 6px; color: #2e6b34; border: 1px solid #2e6b34; background: transparent;"
                                    data-bs-toggle="modal"
                                    data-bs-target="#importStorageModal">
                                <i class="bi bi-upload me-1"></i> Import / Pulihkan Storage
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

{{-- Modal Import / Pulihkan Database --}}
<div class="modal fade" id="importDbModal" tabindex="-1" aria-labelledby="importDbModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header text-white" style="background-color: #2e6b34;">
                <h5 class="modal-title fw-bold" id="importDbModalLabel">
                    <i class="bi bi-database-up me-2"></i>Import / Pulihkan Database SQL
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('backup.import-database') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="alert alert-warning border-0 small mb-3">
                        <i class="bi bi-exclamation-triangle-fill me-1"></i>
                        <strong>Perhatian:</strong> Memulihkan database akan menimpa tabel dan data yang ada saat ini dengan isi dari berkas backup SQL yang Anda unggah.
                    </div>
                    <div class="mb-2">
                        <label for="sql_file" class="form-label fw-semibold text-dark">
                            Pilih Berkas Backup Database (<code>.sql</code> atau <code>.zip</code>) <span class="text-danger">*</span>
                        </label>
                        <input type="file"
                               id="sql_file"
                               name="sql_file"
                               class="form-control"
                               accept=".sql,.zip,.txt"
                               required>
                        <div class="form-text text-muted small mt-1">
                            Format yang didukung: <strong>.sql</strong> atau <strong>.zip</strong> (berisi file .sql). Maksimal ukuran berkas: 500 MB.
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary px-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn text-white px-4 fw-semibold" style="background-color: #2e6b34; border-color: #2e6b34;">
                        <i class="bi bi-upload me-1"></i> Pulihkan Database Sekarang
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Import / Pulihkan Storage Public --}}
<div class="modal fade" id="importStorageModal" tabindex="-1" aria-labelledby="importStorageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header text-white" style="background-color: #2e6b34;">
                <h5 class="modal-title fw-bold" id="importStorageModalLabel">
                    <i class="bi bi-folder-symlink me-2"></i>Import / Pulihkan Storage Public (ZIP)
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('backup.import-storage') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="alert alert-info border-0 small mb-3">
                        <i class="bi bi-info-circle-fill me-1"></i>
                        Seluruh isi berkas di dalam arsip <strong>.zip</strong> akan diekstrak kembali ke dalam direktori <code>storage/app/public</code>.
                    </div>
                    <div class="mb-2">
                        <label for="storage_zip" class="form-label fw-semibold text-dark">
                            Pilih Berkas Backup Storage (<code>.zip</code>) <span class="text-danger">*</span>
                        </label>
                        <input type="file"
                               id="storage_zip"
                               name="storage_zip"
                               class="form-control"
                               accept=".zip,application/zip,application/x-zip-compressed"
                               required>
                        <div class="form-text text-muted small mt-1">
                            Format yang didukung: <strong>.zip</strong> hasil backup storage. Maksimal ukuran berkas: 500 MB.
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary px-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn text-white px-4 fw-semibold" style="background-color: #2e6b34; border-color: #2e6b34;">
                        <i class="bi bi-upload me-1"></i> Pulihkan Storage Sekarang
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
