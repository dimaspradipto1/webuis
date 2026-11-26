@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle mb-4">
    <h1 class="mb-1">Kelola Informasi Terpadu PMB</h1>
    <nav>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">PMB</li>
            <li class="breadcrumb-item active">Informasi PMB</li>
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

@if (isset($errors) && $errors->any())
    <div class="alert alert-danger alert-dismissible fade show mb-4 rounded-3 border-0 shadow-sm" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        <strong>Periksa kembali kesalahan berikut:</strong>
        <ul class="mb-0 mt-1 ps-3">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<form action="{{ route('admin.pmb.informasi.update') }}" method="POST">
    @csrf
    @method('PUT')

    <div class="row g-4">
        <div class="col-lg-8">
            {{-- SEKSI 1: IDENTITAS & PENGANTAR PMB --}}
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white">
                <h5 class="fw-bold text-dark border-bottom pb-3 mb-4 d-flex align-items-center gap-2">
                    <i class="bi bi-info-circle-fill text-success fs-4"></i> 1. Identitas & Pengumuman Utama PMB
                </h5>

                <div class="row g-3 mb-3">
                    <div class="col-md-8">
                        <label for="judul" class="form-label fw-bold text-dark small">Judul Utama Halaman PMB <span class="text-danger">*</span></label>
                        <input type="text" id="judul" name="judul" class="form-control" value="{{ old('judul', $pmb->judul) }}" required>
                    </div>
                    <div class="col-md-4">
                        <label for="badge_text" class="form-label fw-bold text-dark small">Badge Tahun Akademik</label>
                        <input type="text" id="badge_text" name="badge_text" class="form-control" value="{{ old('badge_text', $pmb->badge_text) }}" placeholder="PMB TA 2026/2027">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="subjudul" class="form-label fw-bold text-dark small">Subjudul / Keterangan Institusi</label>
                    <input type="text" id="subjudul" name="subjudul" class="form-control" value="{{ old('subjudul', $pmb->subjudul) }}" placeholder="Tahun Akademik 2026/2027 — Universitas Ibnu Sina">
                </div>

                <div class="mb-3">
                    <label for="deskripsi_singkat" class="form-label fw-bold text-dark small">Teks Pengumuman Resmi / Sambutan PMB</label>
                    <textarea id="deskripsi_singkat" name="deskripsi_singkat" class="form-control" rows="3" placeholder="Teks pengantar informasi pendaftaran mahasiswa baru...">{{ old('deskripsi_singkat', $pmb->deskripsi_singkat) }}</textarea>
                </div>

                <div class="mb-2">
                    <label for="no_wa_pmb" class="form-label fw-bold text-dark small">Nomor WhatsApp Helpdesk Panitia PMB</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-success"><i class="bi bi-whatsapp"></i></span>
                        <input type="text" id="no_wa_pmb" name="no_wa_pmb" class="form-control" value="{{ old('no_wa_pmb', $pmb->no_wa_pmb) }}" placeholder="Contoh: 082283958644">
                    </div>
                    <div class="form-text small">Nomor tujuan konsultasi calon mahasiswa baru melalui tombol WhatsApp.</div>
                </div>
            </div>

            {{-- SEKSI 2: JADWAL GELOMBANG PENDAFTARAN --}}
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white" id="seksi-gelombang">
                <h5 class="fw-bold text-dark border-bottom pb-3 mb-4 d-flex align-items-center gap-2">
                    <i class="bi bi-calendar-event-fill text-primary fs-4"></i> 2. Jadwal Gelombang Pendaftaran
                </h5>

                <div class="mb-2">
                    <label for="gelombang_info" class="form-label fw-bold text-dark small">
                        Daftar Jadwal Gelombang (Poin-Poin / Timeline) <span class="text-danger">*</span>
                    </label>
                    <textarea id="gelombang_info" name="gelombang_info" class="form-control" rows="5" placeholder="Contoh:&#10;• Gelombang I : Januari - Maret 2026 (Potongan Biaya Pendaftaran)&#10;• Gelombang II : April - Juni 2026 (Jalur Reguler & Beasiswa)&#10;• Gelombang III: Juli - September 2026 (Jalur Kuota Terakhir)" required>{{ old('gelombang_info', $pmb->gelombang_info) }}</textarea>
                    <div class="form-text small text-muted mt-2">
                        Gunakan simbol poin (• atau angka) dan baris baru untuk memisahkan setiap gelombang pendaftaran.
                    </div>
                </div>
            </div>

            {{-- SEKSI 3: SYARAT PENDAFTARAN --}}
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white" id="seksi-syarat">
                <h5 class="fw-bold text-dark border-bottom pb-3 mb-4 d-flex align-items-center gap-2">
                    <i class="bi bi-file-earmark-check-fill text-warning fs-4"></i> 3. Persyaratan Berkas Pendaftaran
                </h5>

                <div class="mb-2">
                    <label for="persyaratan_info" class="form-label fw-bold text-dark small">
                        Daftar Dokumen / Syarat Berkas Pendaftaran <span class="text-danger">*</span>
                    </label>
                    <textarea id="persyaratan_info" name="persyaratan_info" class="form-control" rows="6" placeholder="Contoh:&#10;1. Salinan Ijazah / SKL SMA/SMK/MA/Sederajat yang dilegalisir (2 lembar)&#10;2. Salinan Kartu Keluarga (KK) dan KTP calon mahasiswa (2 lembar)&#10;3. Pas foto berwarna ukuran 3x4 (3 lembar)&#10;4. Mengisi formulir pendaftaran daring di portal resmi PMB UIS" required>{{ old('persyaratan_info', $pmb->persyaratan_info) }}</textarea>
                    <div class="form-text small text-muted mt-2">
                        Gunakan penomoran (1, 2, 3...) agar di halaman frontend tampil dalam bentuk checklist dokumen interaktif.
                    </div>
                </div>
            </div>

            {{-- SEKSI 4: PROGRAM BEASISWA PMB --}}
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white" id="seksi-beasiswa">
                <div class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-4">
                    <h5 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                        <i class="bi bi-award-fill text-danger fs-4"></i> 4. Program Beasiswa Masuk Kuliah PMB
                    </h5>
                    <a href="{{ route('beasiswa.admin') }}" class="btn btn-sm btn-outline-danger rounded-pill px-3 py-1 fw-semibold">
                        <i class="bi bi-gear-fill me-1"></i> Kelola Detail Jalur Beasiswa
                    </a>
                </div>

                <div class="mb-3">
                    <label for="beasiswa_info" class="form-label fw-bold text-dark small">
                        Catatan & Pengumuman Tambahan Program Beasiswa PMB (Opsional)
                    </label>
                    <textarea id="beasiswa_info" name="beasiswa_info" class="form-control" rows="3" placeholder="Informasi singkat atau catatan khusus kuota beasiswa PMB tahun ini...">{{ old('beasiswa_info', $pmb->beasiswa_info) }}</textarea>
                    <div class="form-text small text-muted mt-1">
                        Daftar jalur beasiswa (KIP-K, Prestasi Akademik, Non-Akademik, Tahfidz, Industri, dan Yayasan) secara otomatis disinkronkan dan ditampilkan di halaman PMB.
                    </div>
                </div>
            </div>

            <div class="d-flex align-items-center gap-2 mb-4">
                <button type="submit" class="btn btn-success px-5 py-2.5 rounded-pill fw-bold shadow-sm" style="background-color: #046B26; border-color: #046B26;">
                    <i class="bi bi-save me-1"></i> Simpan Seluruh Informasi PMB
                </button>
            </div>
        </div>

        {{-- KOLOM KANAN: PENGATURAN STATUS & QUICK ACTIONS --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4 sticky-top" style="top: 90px;">
                <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">
                    <i class="bi bi-sliders text-success me-1"></i> Pengaturan Publikasi
                </h6>

                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1" {{ old('is_active', $pmb->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold text-dark small" for="is_active">
                        Status Informasi PMB Aktif di Website
                    </label>
                </div>

                <hr class="my-3">

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-success py-2.5 rounded-3 fw-bold shadow-sm" style="background-color: #046B26; border-color: #046B26;">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                    </button>
                    <a href="{{ route('homepage.informasi-pmb') }}" target="_blank" class="btn btn-outline-secondary py-2 rounded-3 small fw-semibold">
                        <i class="bi bi-box-arrow-up-right me-1"></i> Lihat Halaman Web
                    </a>
                </div>

                <div class="mt-4 pt-3 border-top">
                    <div class="small fw-bold text-dark mb-2">Navigasi Cepat Formulir:</div>
                    <div class="d-flex flex-column gap-1 small">
                        <a href="#seksi-gelombang" class="text-decoration-none text-muted py-1"><i class="bi bi-arrow-down-short text-success"></i> Menuju Jadwal Gelombang</a>
                        <a href="#seksi-syarat" class="text-decoration-none text-muted py-1"><i class="bi bi-arrow-down-short text-success"></i> Menuju Syarat Pendaftaran</a>
                        <a href="#seksi-beasiswa" class="text-decoration-none text-muted py-1"><i class="bi bi-arrow-down-short text-success"></i> Menuju Program Beasiswa</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
