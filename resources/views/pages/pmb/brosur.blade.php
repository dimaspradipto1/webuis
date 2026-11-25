@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle mb-4">
    <h1 class="mb-1">Kelola Brosur & Poster PMB</h1>
    <nav>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">PMB</li>
            <li class="breadcrumb-item active">Brosur & Poster</li>
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

<div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white">
    <h5 class="fw-bold text-dark border-bottom pb-3 mb-4 d-flex align-items-center gap-2">
        <i class="bi bi-images text-success fs-4"></i> Upload & Kelola Poster Infografis PMB
    </h5>

    <form action="{{ route('admin.pmb.brosur.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-4 mb-4">
            {{-- Brosur 1 (Utama) --}}
            <div class="col-md-6">
                <div class="p-3.5 rounded-4 bg-light border h-100 d-flex flex-column justify-content-between">
                    <div>
                        <h6 class="fw-bold text-dark mb-2">Poster / Brosur Utama PMB</h6>
                        <p class="text-muted small mb-3">Format: JPG, PNG, WEBP. Maksimal 10 MB.</p>

                        @if(!empty($pmb->gambar_brosur))
                            <div class="mb-3 text-center bg-white p-2 rounded-3 border">
                                <img src="{{ $pmb->gambar_brosur_url }}" alt="Brosur Utama" class="img-fluid rounded" style="max-height: 280px; object-fit: contain;">
                                <div class="form-check mt-2 text-start">
                                    <input class="form-check-input" type="checkbox" id="hapus_brosur_1" name="hapus_brosur_1" value="1">
                                    <label class="form-check-label text-danger small fw-semibold" for="hapus_brosur_1">
                                        <i class="bi bi-trash me-1"></i> Hapus Poster Utama Ini
                                    </label>
                                </div>
                            </div>
                        @endif

                        <label for="gambar_brosur" class="form-label fw-bold text-dark small">Pilih Berkas Gambar Baru</label>
                        <input type="file" id="gambar_brosur" name="gambar_brosur" class="form-control" accept="image/*">
                    </div>
                </div>
            </div>

            {{-- Brosur 2 (Tambahan / Alur & Biaya) --}}
            <div class="col-md-6">
                <div class="p-3.5 rounded-4 bg-light border h-100 d-flex flex-column justify-content-between">
                    <div>
                        <h6 class="fw-bold text-dark mb-2">Poster / Brosur Kedua (Alur & Rincian)</h6>
                        <p class="text-muted small mb-3">Format: JPG, PNG, WEBP. Maksimal 10 MB.</p>

                        @if(!empty($pmb->gambar_brosur_2))
                            <div class="mb-3 text-center bg-white p-2 rounded-3 border">
                                <img src="{{ $pmb->gambar_brosur_2_url }}" alt="Brosur Kedua" class="img-fluid rounded" style="max-height: 280px; object-fit: contain;">
                                <div class="form-check mt-2 text-start">
                                    <input class="form-check-input" type="checkbox" id="hapus_brosur_2" name="hapus_brosur_2" value="1">
                                    <label class="form-check-label text-danger small fw-semibold" for="hapus_brosur_2">
                                        <i class="bi bi-trash me-1"></i> Hapus Poster Kedua Ini
                                    </label>
                                </div>
                            </div>
                        @endif

                        <label for="gambar_brosur_2" class="form-label fw-bold text-dark small">Pilih Berkas Gambar Baru</label>
                        <input type="file" id="gambar_brosur_2" name="gambar_brosur_2" class="form-control" accept="image/*">
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-success px-4 py-2.5 rounded-pill fw-bold shadow-sm" style="background-color: #046B26; border-color: #046B26;">
            <i class="bi bi-save me-1"></i> Simpan Poster & Brosur
        </button>
    </form>
</div>
@endsection
