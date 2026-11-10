@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Edit Data Statistik Universitas Ibnu Sina</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('faculty-stat.index') }}">Statistik Universitas</a></li>
            <li class="breadcrumb-item active">Edit Data</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3" style="border-top: 3px solid #046B26;">
                <h5 class="mb-0 fw-bold text-dark">
                    <i class="bi bi-pencil-square me-2 text-success"></i>Form Edit Statistik & Background Banner UIS
                </h5>
            </div>
            <div class="card-body p-4">

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('faculty-stat.update', $facultyStat->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- 1. Judul Section --}}
                    <div class="mb-4">
                        <label for="title" class="form-label fw-bold">
                            Judul Section / Heading <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               id="title"
                               name="title"
                               class="form-control @error('title') is-invalid @enderror"
                               value="{{ old('title', $facultyStat->title) }}"
                               placeholder="Contoh: Universitas Ibnu Sina">
                        <div class="form-text">Teks judul putih di tengah banner statistik (Contoh di screenshot: <strong>Universitas Ibnu Sina</strong>).</div>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- 2. Background Image Banner --}}
                    <div class="card border border-success-subtle bg-light p-3 mb-4 rounded-3">
                        <label for="background_image" class="form-label fw-bold text-dark mb-1">
                            <i class="bi bi-image text-success me-1"></i> Background Banner Gedung / Kampus UIS
                        </label>
                        <p class="text-muted small mb-3">Foto latar belakang gedung kampus UIS yang menjadi background utama statistik (Foto panoramic drone kampus UIS).</p>

                        @if ($facultyStat->background_image)
                            <div class="mb-3">
                                <p class="small text-muted mb-1">Background saat ini:</p>
                                <img src="{{ $facultyStat->bg_image_url }}"
                                     alt="Background Statistik"
                                     style="max-width:380px;height:140px;object-fit:cover;border-radius:10px;border:2px solid #fff;box-shadow:0 4px 12px rgba(0,0,0,0.15)">
                                <div class="mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="remove_background" name="remove_background" value="1">
                                        <label class="form-check-label text-danger small fw-semibold" for="remove_background">
                                            <i class="bi bi-trash me-1"></i>Hapus background custom (kembalikan ke default)
                                        </label>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="mb-3">
                                <p class="small text-muted mb-1">Background default aktif:</p>
                                <img src="{{ asset('frontend/img/gedung-uis.jpg') }}"
                                     alt="Default Gedung UIS"
                                     style="max-width:320px;height:120px;object-fit:cover;border-radius:8px;">
                            </div>
                        @endif

                        <input type="file"
                               id="background_image"
                               name="background_image"
                               class="form-control @error('background_image') is-invalid @enderror"
                               accept="image/jpg,image/jpeg,image/png,image/webp">
                        <div class="form-text">Format: JPG, PNG, WEBP (Rekomendasi Landscape 1920x600 px / Maks 20 MB).</div>
                        @error('background_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- 3. Tab Pengaturan Angka Statistik: Mahasiswa, Prestasi, Kerjasama --}}
                    <div class="card border shadow-sm mb-4">
                        <div class="card-header bg-white py-3 border-bottom">
                            <ul class="nav nav-pills card-header-pills" id="statTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active fw-bold px-4" id="mhs-tab" data-bs-toggle="pill" data-bs-target="#mhs-content" type="button" role="tab">
                                        <i class="bi bi-people-fill me-1"></i> Tab 1: Mahasiswa
                                    </button>
                                </li>
                                <li class="nav-item ms-2" role="presentation">
                                    <button class="nav-link fw-bold px-4" id="prestasi-tab" data-bs-toggle="pill" data-bs-target="#prestasi-content" type="button" role="tab">
                                        <i class="bi bi-trophy-fill me-1"></i> Tab 2: Prestasi
                                    </button>
                                </li>
                                <li class="nav-item ms-2" role="presentation">
                                    <button class="nav-link fw-bold px-4" id="kerjasama-tab" data-bs-toggle="pill" data-bs-target="#kerjasama-content" type="button" role="tab">
                                        <i class="bi bi-briefcase-fill me-1"></i> Tab 3: Kerjasama
                                    </button>
                                </li>
                            </ul>
                        </div>

                        <div class="card-body p-4">
                            <div class="tab-content" id="statTabsContent">

                                {{-- TAB 1: MAHASISWA --}}
                                <div class="tab-pane fade show active" id="mhs-content" role="tabpanel">
                                    <div class="mb-3">
                                        <label for="tab_1_label" class="form-label fw-bold small">Nama Tab</label>
                                        <input type="text" id="tab_1_label" name="tab_1_label" class="form-control"
                                               value="{{ old('tab_1_label', $facultyStat->tab_1_label ?? 'Mahasiswa') }}" required>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <div class="p-3 border rounded bg-light">
                                                <label class="form-label small fw-semibold text-dark">Angka 1 (Total Mahasiswa)</label>
                                                <input type="number" name="mhs_total" class="form-control text-center fw-bold fs-4 mb-2"
                                                       value="{{ old('mhs_total', $facultyStat->mhs_total ?? 5273) }}" required>
                                                <input type="text" name="mhs_total_label" class="form-control form-control-sm text-center"
                                                       value="{{ old('mhs_total_label', $facultyStat->mhs_total_label ?? 'Total Mahasiswa') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="p-3 border rounded bg-light">
                                                <label class="form-label small fw-semibold text-dark">Angka 2 (Mahasiswa Baru)</label>
                                                <input type="number" name="mhs_baru" class="form-control text-center fw-bold fs-4 mb-2"
                                                       value="{{ old('mhs_baru', $facultyStat->mhs_baru ?? 1520) }}" required>
                                                <input type="text" name="mhs_baru_label" class="form-control form-control-sm text-center"
                                                       value="{{ old('mhs_baru_label', $facultyStat->mhs_baru_label ?? 'Jumlah Mahasiswa Baru 2026') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="p-3 border rounded bg-light">
                                                <label class="form-label small fw-semibold text-dark">Angka 3 (Alumni)</label>
                                                <input type="number" name="mhs_alumni" class="form-control text-center fw-bold fs-4 mb-2"
                                                       value="{{ old('mhs_alumni', $facultyStat->mhs_alumni ?? 7968) }}" required>
                                                <input type="text" name="mhs_alumni_label" class="form-control form-control-sm text-center"
                                                       value="{{ old('mhs_alumni_label', $facultyStat->mhs_alumni_label ?? 'Alumni') }}" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- TAB 2: PRESTASI --}}
                                <div class="tab-pane fade" id="prestasi-content" role="tabpanel">
                                    <div class="mb-3">
                                        <label for="tab_2_label" class="form-label fw-bold small">Nama Tab</label>
                                        <input type="text" id="tab_2_label" name="tab_2_label" class="form-control"
                                               value="{{ old('tab_2_label', $facultyStat->tab_2_label ?? 'Prestasi') }}" required>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <div class="p-3 border rounded bg-light">
                                                <label class="form-label small fw-semibold text-dark">Angka 1 (Nasional)</label>
                                                <input type="number" name="prestasi_nasional" class="form-control text-center fw-bold fs-4 mb-2"
                                                       value="{{ old('prestasi_nasional', $facultyStat->prestasi_nasional ?? 37) }}" required>
                                                <input type="text" name="prestasi_nasional_label" class="form-control form-control-sm text-center"
                                                       value="{{ old('prestasi_nasional_label', $facultyStat->prestasi_nasional_label ?? 'Nasional') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="p-3 border rounded bg-light">
                                                <label class="form-label small fw-semibold text-dark">Angka 2 (Provinsi)</label>
                                                <input type="number" name="prestasi_provinsi" class="form-control text-center fw-bold fs-4 mb-2"
                                                       value="{{ old('prestasi_provinsi', $facultyStat->prestasi_provinsi ?? 39) }}" required>
                                                <input type="text" name="prestasi_provinsi_label" class="form-control form-control-sm text-center"
                                                       value="{{ old('prestasi_provinsi_label', $facultyStat->prestasi_provinsi_label ?? 'Provinsi') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="p-3 border rounded bg-light">
                                                <label class="form-label small fw-semibold text-dark">Angka 3 (International)</label>
                                                <input type="number" name="prestasi_internasional" class="form-control text-center fw-bold fs-4 mb-2"
                                                       value="{{ old('prestasi_internasional', $facultyStat->prestasi_internasional ?? 10) }}" required>
                                                <input type="text" name="prestasi_internasional_label" class="form-control form-control-sm text-center"
                                                       value="{{ old('prestasi_internasional_label', $facultyStat->prestasi_internasional_label ?? 'International') }}" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- TAB 3: KERJASAMA --}}
                                <div class="tab-pane fade" id="kerjasama-content" role="tabpanel">
                                    <div class="mb-3">
                                        <label for="tab_3_label" class="form-label fw-bold small">Nama Tab</label>
                                        <input type="text" id="tab_3_label" name="tab_3_label" class="form-control"
                                               value="{{ old('tab_3_label', $facultyStat->tab_3_label ?? 'Kerjasama') }}" required>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-md-3">
                                            <div class="p-3 border rounded bg-light">
                                                <label class="form-label small fw-semibold text-dark">Angka 1 (Total)</label>
                                                <input type="number" name="kerjasama_total" class="form-control text-center fw-bold fs-4 mb-2"
                                                       value="{{ old('kerjasama_total', $facultyStat->kerjasama_total ?? 50) }}" required>
                                                <input type="text" name="kerjasama_total_label" class="form-control form-control-sm text-center"
                                                       value="{{ old('kerjasama_total_label', $facultyStat->kerjasama_total_label ?? 'Jumlah Kerjasama') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="p-3 border rounded bg-light">
                                                <label class="form-label small fw-semibold text-dark">Angka 2 (Perusahaan)</label>
                                                <input type="number" name="kerjasama_perusahaan" class="form-control text-center fw-bold fs-4 mb-2"
                                                       value="{{ old('kerjasama_perusahaan', $facultyStat->kerjasama_perusahaan ?? 8) }}" required>
                                                <input type="text" name="kerjasama_perusahaan_label" class="form-control form-control-sm text-center"
                                                       value="{{ old('kerjasama_perusahaan_label', $facultyStat->kerjasama_perusahaan_label ?? 'Perusahaan') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="p-3 border rounded bg-light">
                                                <label class="form-label small fw-semibold text-dark">Angka 3 (Pemerintahan)</label>
                                                <input type="number" name="kerjasama_pemerintahan" class="form-control text-center fw-bold fs-4 mb-2"
                                                       value="{{ old('kerjasama_pemerintahan', $facultyStat->kerjasama_pemerintahan ?? 19) }}" required>
                                                <input type="text" name="kerjasama_pemerintahan_label" class="form-control form-control-sm text-center"
                                                       value="{{ old('kerjasama_pemerintahan_label', $facultyStat->kerjasama_pemerintahan_label ?? 'Pemerintahan') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="p-3 border rounded bg-light">
                                                <label class="form-label small fw-semibold text-dark">Angka 4 (Sekolah)</label>
                                                <input type="number" name="kerjasama_sekolah" class="form-control text-center fw-bold fs-4 mb-2"
                                                       value="{{ old('kerjasama_sekolah', $facultyStat->kerjasama_sekolah ?? 5) }}" required>
                                                <input type="text" name="kerjasama_sekolah_label" class="form-control form-control-sm text-center"
                                                       value="{{ old('kerjasama_sekolah_label', $facultyStat->kerjasama_sekolah_label ?? 'Sekolah') }}" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- Status Aktif --}}
                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                                   {{ old('is_active', $facultyStat->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold" for="is_active">
                                Aktifkan (tampil di halaman Beranda Utama)
                            </label>
                        </div>
                    </div>

                    {{-- Tombol Simpan --}}
                    <div class="d-flex gap-2 pt-2 border-top mt-2">
                        <a href="{{ route('faculty-stat.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-success fw-bold px-4 shadow-sm" style="background:#046B26;border-color:#046B26;">
                            <i class="bi bi-save me-1"></i> Perbarui Data Statistik
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection
