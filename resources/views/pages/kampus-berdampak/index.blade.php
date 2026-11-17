@extends('layouts.dashboard.template')

@section('title', 'Manajemen Kampus Berdampak')

@push('styles')
<style>
    .kampus-tabs .nav-link {
        color: #475569;
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 11px 18px;
        font-weight: 600;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    .kampus-tabs .nav-link:hover {
        background-color: #eaf6ee;
        color: #046B26;
        border-color: #cce8d4;
    }
    .kampus-tabs .nav-link.active {
        background-color: #046B26 !important;
        color: #ffffff !important;
        border-color: #046B26 !important;
        box-shadow: 0 4px 14px rgba(4, 107, 38, 0.25) !important;
    }
    .preview-poster-box {
        max-width: 260px;
        border-radius: 14px;
        overflow: hidden;
        border: 2px solid #e2e8f0;
        box-shadow: 0 6px 16px rgba(0,0,0,0.06);
    }
    .preview-poster-img {
        width: 100%;
        height: auto;
        display: block;
    }
</style>
@endpush

@section('content')
<div class="pagetitle d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
    <div>
        <h1>Kampus Berdampak</h1>
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('partner.index') }}">Mitra Kerjasama</a></li>
                <li class="breadcrumb-item active">Kampus Berdampak</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex align-items-center gap-2">
        <a href="{{ route('homepage.kampus-berdampak') }}" target="_blank" class="btn btn-outline-success rounded-pill px-3 py-2 fw-semibold">
            <i class="bi bi-box-arrow-up-right me-1"></i> Lihat Halaman Frontend
        </a>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
    <i class="bi bi-check-circle-fill fs-5"></i>
    <div>{{ session('success') }}</div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(isset($errors) && $errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong><i class="bi bi-exclamation-triangle-fill me-1"></i> Terjadi kesalahan:</strong>
    <ul class="mb-0 mt-2">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="card shadow-sm border-0 rounded-4">
    <div class="card-body p-4">
        <!-- Tabs Navigasi -->
        <ul class="nav nav-pills kampus-tabs gap-2 mb-4" id="kampusTab" role="tablist">
            <li class="nav-item flex-grow-1" role="presentation">
                <button class="nav-link active w-100" id="setting-tab" data-bs-toggle="tab" data-bs-target="#tab-setting" type="button" role="tab" aria-controls="tab-setting" aria-selected="true">
                    <i class="bi bi-gear-fill"></i> Konten & Tentang Kampus Berdampak
                </button>
            </li>
            <li class="nav-item flex-grow-1" role="presentation">
                <button class="nav-link w-100" id="program-tab" data-bs-toggle="tab" data-bs-target="#tab-program" type="button" role="tab" aria-controls="tab-program" aria-selected="false">
                    <i class="bi bi-list-check"></i> Daftar Program Pilihan ({{ $programs->count() }})
                </button>
            </li>
        </ul>

        <div class="tab-content" id="kampusTabContent">
            <!-- TAB 1: PENGATURAN TENTANG KAMPUS BERDAMPAK -->
            <div class="tab-pane fade show active" id="tab-setting" role="tabpanel" aria-labelledby="setting-tab">
                <form action="{{ route('kampus-berdampak.setting.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">
                        <div class="col-lg-8">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Judul Section Utama <span class="text-danger">*</span></label>
                                <input type="text" name="judul_section" class="form-control" value="{{ old('judul_section', $setting->judul_section) }}" required>
                                <div class="form-text">Ditampilkan sebagai judul utama pada kolom kanan (misal: "Tentang Kampus Berdampak").</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Tagline Poster</label>
                                <input type="text" name="tagline" class="form-control" value="{{ old('tagline', $setting->tagline) }}">
                                <div class="form-text">Sub-judul / slogan singkat (misal: "Menciptakan Perubahan Nyata untuk Masa Depan").</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Deskripsi Kampus Berdampak / MBKM <span class="text-danger">*</span></label>
                                <textarea name="deskripsi" class="form-control" rows="6" required>{{ old('deskripsi', $setting->deskripsi) }}</textarea>
                                <div class="form-text">Teks penjelasan program Merdeka Belajar Kampus Merdeka di bawah poster.</div>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Label Status / Badge Kartu Beranda</label>
                                    <input type="text" name="badge_status" class="form-control" value="{{ old('badge_status', $setting->badge_status) }}" placeholder="Contoh: AKTIF 2024">
                                    <div class="form-text">Otomatis sinkron ke kartu "Kampus Berdampak" di beranda.</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Teks Tombol Unduh</label>
                                    <input type="text" name="tombol_teks" class="form-control" value="{{ old('tombol_teks', $setting->tombol_teks) }}" placeholder="Download Panduan MBKM">
                                </div>
                            </div>

                            <div class="mt-3">
                                <label class="form-label fw-bold">Link URL Panduan Eksternal (Opsional)</label>
                                <input type="url" name="file_panduan_url" class="form-control" value="{{ old('file_panduan_url', $setting->file_panduan_url) }}" placeholder="https://kampusmerdeka.kemdikbud.go.id/...">
                                <div class="form-text">Digunakan apabila tidak mengunggah file dokumen manual di bawah ini.</div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <!-- Upload Poster -->
                            <div class="card border bg-light rounded-3 p-3 mb-3">
                                <label class="form-label fw-bold d-flex align-items-center gap-1">
                                    <i class="bi bi-image text-success"></i> Poster / Banner Visual
                                </label>
                                @if(!empty($setting->poster))
                                <div class="preview-poster-box mx-auto my-2">
                                    <img src="{{ asset('storage/' . $setting->poster) }}" alt="Poster Kampus Berdampak" class="preview-poster-img">
                                </div>
                                @endif
                                <input type="file" name="poster" class="form-control mt-2" accept="image/*">
                                <small class="text-muted mt-1 d-block">Format: JPG, PNG, WEBP. Maks 5MB.</small>
                            </div>

                            <!-- Upload File Panduan -->
                            <div class="card border bg-light rounded-3 p-3">
                                <label class="form-label fw-bold d-flex align-items-center gap-1">
                                    <i class="bi bi-file-earmark-pdf-fill text-danger"></i> File Panduan MBKM (PDF)
                                </label>
                                @if(!empty($setting->file_panduan))
                                <div class="alert alert-secondary py-2 px-3 small d-flex align-items-center justify-content-between mb-2">
                                    <span class="text-truncate" style="max-width: 180px;"><i class="bi bi-file-pdf me-1"></i> File Tersedia</span>
                                    <a href="{{ asset('storage/' . $setting->file_panduan) }}" target="_blank" class="btn btn-sm btn-outline-primary py-0 px-2">Unduh</a>
                                </div>
                                @endif
                                <input type="file" name="file_panduan" class="form-control" accept=".pdf,.doc,.docx,.zip">
                                <small class="text-muted mt-1 d-block">Unggah berkas panduan PDF jika ingin diunduh langsung pengunjung.</small>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                        <button type="submit" class="btn btn-success px-4 py-2 rounded-pill fw-semibold">
                            <i class="bi bi-save me-1"></i> Simpan Perubahan Konten
                        </button>
                    </div>
                </form>
            </div>

            <!-- TAB 2: DAFTAR PROGRAM PILIHAN -->
            <div class="tab-pane fade" id="tab-program" role="tabpanel" aria-labelledby="program-tab">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                    <div>
                        <h5 class="fw-bold mb-1">Daftar Program Pilihan (Accordion)</h5>
                        <p class="text-muted small mb-0">Program-program yang ditampilkan pada kolom accordion sebelah kiri.</p>
                    </div>
                    <button type="button" class="btn btn-success rounded-pill px-3 py-2 fw-semibold" data-bs-toggle="modal" data-bs-target="#modalTambahProgram">
                        <i class="bi bi-plus-circle me-1"></i> Tambah Program Pilihan
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 60px;" class="text-center">No</th>
                                <th>Nama Program</th>
                                <th>Ringkasan / Rincian Penjelasan</th>
                                <th style="width: 90px;" class="text-center">Urutan</th>
                                <th style="width: 100px;" class="text-center">Status</th>
                                <th style="width: 130px;" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($programs as $index => $prog)
                            <tr>
                                <td class="text-center fw-semibold">{{ $index + 1 }}</td>
                                <td>
                                    <span class="fw-bold text-dark">{{ $prog->nama_program }}</span>
                                </td>
                                <td>
                                    <span class="text-muted small d-inline-block" style="max-width: 480px; line-height: 1.45;">
                                        {{ Str::limit($prog->deskripsi, 130) ?: 'Belum ada rincian.' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-light text-dark border px-2 py-1">{{ $prog->urutan }}</span>
                                </td>
                                <td class="text-center">
                                    @if($prog->is_active)
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary px-2 py-1">Non-Aktif</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalEditProgram{{ $prog->id }}" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <form action="{{ route('kampus-berdampak.program.destroy', $prog->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus program ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            <!-- Modal Edit Program -->
                            <div class="modal fade" id="modalEditProgram{{ $prog->id }}" tabindex="-1" aria-labelledby="modalEditLabel{{ $prog->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content border-0 shadow">
                                        <form action="{{ route('kampus-berdampak.program.update', $prog->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header bg-success text-white">
                                                <h5 class="modal-title fw-bold" id="modalEditLabel{{ $prog->id }}">
                                                    <i class="bi bi-pencil-square me-1"></i> Edit Program Pilihan
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body p-4">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Nama Program <span class="text-danger">*</span></label>
                                                    <input type="text" name="nama_program" class="form-control" value="{{ $prog->nama_program }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Deskripsi / Rincian Program</label>
                                                    <textarea name="deskripsi" class="form-control" rows="5" placeholder="Penjelasan lengkap saat accordion dibuka">{{ $prog->deskripsi }}</textarea>
                                                </div>
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-bold">Urutan Tampil</label>
                                                        <input type="number" name="urutan" class="form-control" value="{{ $prog->urutan }}">
                                                    </div>
                                                    <div class="col-md-6 d-flex align-items-center mt-4">
                                                        <div class="form-check form-switch fs-5">
                                                            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="activeSwitch{{ $prog->id }}" {{ $prog->is_active ? 'checked' : '' }}>
                                                            <label class="form-check-label fs-6 fw-semibold" for="activeSwitch{{ $prog->id }}">Status Aktif</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer bg-light">
                                                <button type="button" class="btn btn-secondary rounded-pill px-3" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-success rounded-pill px-4">Simpan Perubahan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    <i class="bi bi-inbox fs-2 d-block mb-1"></i>
                                    Belum ada data program pilihan.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Program -->
<div class="modal fade" id="modalTambahProgram" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <form action="{{ route('kampus-berdampak.program.store') }}" method="POST">
                @csrf
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title fw-bold" id="modalTambahLabel">
                        <i class="bi bi-plus-circle me-1"></i> Tambah Program Pilihan Baru
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Program <span class="text-danger">*</span></label>
                        <input type="text" name="nama_program" class="form-control" placeholder="Contoh: Magang Industri Bersertifikat" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Deskripsi / Rincian Program</label>
                        <textarea name="deskripsi" class="form-control" rows="5" placeholder="Penjelasan lengkap saat accordion dibuka"></textarea>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Urutan Tampil</label>
                            <input type="number" name="urutan" class="form-control" value="{{ ($programs->max('urutan') ?? 0) + 1 }}">
                        </div>
                        <div class="col-md-6 d-flex align-items-center mt-4">
                            <div class="form-check form-switch fs-5">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" id="activeSwitchNew" checked>
                                <label class="form-check-label fs-6 fw-semibold" for="activeSwitchNew">Status Aktif</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary rounded-pill px-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success rounded-pill px-4">Simpan Program</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
