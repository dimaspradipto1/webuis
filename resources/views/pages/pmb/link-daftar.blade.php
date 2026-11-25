@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle mb-4">
    <h1 class="mb-1">Kelola Tautan Pendaftaran PMB Online</h1>
    <nav>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">PMB</li>
            <li class="breadcrumb-item active">Daftar Online</li>
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

@if (isset($errors) && $errors->any())
    <div class="alert alert-danger alert-dismissible fade show mb-4 rounded-3 border-0 shadow-sm" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        <strong>Periksa kembali kesalahan pengisian berikut:</strong>
        <ul class="mb-0 mt-1 ps-3">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white">
            <h5 class="fw-bold text-dark border-bottom pb-3 mb-4 d-flex align-items-center gap-2">
                <i class="bi bi-link-45deg text-success fs-4"></i> Form Submit Link Pendaftaran PMB Online
            </h5>

            <form action="{{ route('admin.pmb.link-daftar.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="link_pendaftaran" class="form-label fw-bold text-dark">
                        URL / Tautan Portal Pendaftaran PMB <span class="text-danger">*</span>
                    </label>
                    <div class="input-group input-group-lg">
                        <span class="input-group-text bg-light border-end-0 text-success">
                            <i class="bi bi-globe2 fs-5"></i>
                        </span>
                        <input type="url" 
                               id="link_pendaftaran" 
                               name="link_pendaftaran" 
                               class="form-control border-start-0 ps-0 @error('link_pendaftaran') is-invalid @enderror" 
                               value="{{ old('link_pendaftaran', $pmb->link_pendaftaran ?? 'https://pmb.uis.ac.id') }}" 
                               placeholder="https://pmb.uis.ac.id" 
                               required>
                    </div>
                    @error('link_pendaftaran')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                    <div class="form-text small text-muted mt-2">
                        <i class="bi bi-info-circle me-1"></i> Masukkan tautan lengkap diawali dengan <code>https://</code> atau <code>http://</code>. Contoh: <code>https://pmb.uis.ac.id</code> atau tautan Google Form pendaftaran jika ada.
                    </div>
                </div>

                {{-- Preview & Test Link --}}
                @if(!empty($pmb->link_pendaftaran))
                <div class="p-3.5 rounded-3 bg-light border mb-4 d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <div>
                        <div class="small text-muted fw-semibold">Tautan PMB Aktif Saat Ini:</div>
                        <a href="{{ $pmb->link_pendaftaran }}" target="_blank" class="fw-bold text-success text-break">
                            {{ $pmb->link_pendaftaran }} <i class="bi bi-box-arrow-up-right small ms-1"></i>
                        </a>
                    </div>
                    <a href="{{ $pmb->link_pendaftaran }}" target="_blank" class="btn btn-sm btn-outline-success rounded-pill px-3 py-1.5 fw-semibold">
                        <i class="bi bi-box-arrow-up-right me-1"></i> Buka / Uji Link
                    </a>
                </div>
                @endif

                <div class="d-flex align-items-center gap-2">
                    <button type="submit" class="btn btn-success px-4 py-2.5 rounded-pill fw-bold shadow-sm" style="background-color: #046B26; border-color: #046B26;">
                        <i class="bi bi-save me-1"></i> Simpan Tautan PMB
                    </button>
                    <a href="{{ route('admin.pmb.index') }}" class="btn btn-outline-secondary px-4 py-2.5 rounded-pill">
                        Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
            <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">
                <i class="bi bi-lightning-charge-fill text-warning me-1"></i> Area Sinkronisasi Otomatis
            </h6>
            <p class="text-muted small mb-3" style="line-height: 1.7;">
                Ketika tautan di atas disimpan, sistem akan secara otomatis memperbarui link pendaftaran di seluruh elemen website:
            </p>
            <ul class="list-unstyled small mb-0 d-flex flex-column gap-2 text-dark">
                <li class="d-flex align-items-start gap-2">
                    <i class="bi bi-check-circle-fill text-success mt-0.5"></i>
                    <span>Submenu <strong>"Daftar Online"</strong> pada Dropdown PMB Header Website.</span>
                </li>
                <li class="d-flex align-items-start gap-2">
                    <i class="bi bi-check-circle-fill text-success mt-0.5"></i>
                    <span>Tombol <strong>"Daftar PMB Online"</strong> pada Halaman Informasi Khusus PMB.</span>
                </li>
                <li class="d-flex align-items-start gap-2">
                    <i class="bi bi-check-circle-fill text-success mt-0.5"></i>
                    <span>Banner PMB Beranda & footer tombol pendaftaran mahasiswa baru.</span>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection
