@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle mb-4">
    <h1 class="mb-1">Kelola Informasi Utama PMB</h1>
    <nav>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">PMB</li>
            <li class="breadcrumb-item active">Informasi PMB</li>
        </ol>
    </nav>
</div>

@include('pages.pmb.nav-tabs')

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
                <i class="bi bi-info-circle-fill text-success fs-4"></i> Pengaturan Teks & Pengumuman PMB
            </h5>

            <form action="{{ route('admin.pmb.informasi.update') }}" method="POST">
                @csrf
                @method('PUT')

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
                    <label for="deskripsi_singkat" class="form-label fw-bold text-dark small">Teks Pengumuman Resmi / Deskripsi Singkat PMB</label>
                    <textarea id="deskripsi_singkat" name="deskripsi_singkat" class="form-control" rows="4" placeholder="Teks pengantar informasi pendaftaran mahasiswa baru...">{{ old('deskripsi_singkat', $pmb->deskripsi_singkat) }}</textarea>
                </div>

                <div class="mb-4">
                    <label for="no_wa_pmb" class="form-label fw-bold text-dark small">Nomor WhatsApp Helpdesk Panitia PMB</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-success"><i class="bi bi-whatsapp"></i></span>
                        <input type="text" id="no_wa_pmb" name="no_wa_pmb" class="form-control" value="{{ old('no_wa_pmb', $pmb->no_wa_pmb) }}" placeholder="Contoh: 082283958644 atau 6282283958644">
                    </div>
                    <div class="form-text small">Nomor ini digunakan untuk tombol "Chat Panitia PMB" via WhatsApp langsung.</div>
                </div>

                <div class="form-check form-switch mb-4">
                    <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1" {{ old('is_active', $pmb->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold text-dark" for="is_active">Status Informasi PMB Aktif & Tampil di Web</label>
                </div>

                <button type="submit" class="btn btn-success px-4 py-2.5 rounded-pill fw-bold shadow-sm" style="background-color: #046B26; border-color: #046B26;">
                    <i class="bi bi-save me-1"></i> Simpan Informasi PMB
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
