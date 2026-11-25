@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle mb-4">
    <h1 class="mb-1">Kelola Jadwal Gelombang PMB</h1>
    <nav>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">PMB</li>
            <li class="breadcrumb-item active">Jadwal Gelombang</li>
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
                <i class="bi bi-calendar-event-fill text-success fs-4"></i> Rincian Gelombang Pendaftaran
            </h5>

            <form action="{{ route('admin.pmb.gelombang.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="gelombang_info" class="form-label fw-bold text-dark">
                        Daftar Jadwal Gelombang (Teks / Poin-Poin) <span class="text-danger">*</span>
                    </label>
                    <textarea id="gelombang_info" name="gelombang_info" class="form-control @error('gelombang_info') is-invalid @enderror" rows="6" placeholder="Contoh:&#10;• Gelombang I : Januari - Maret 2026&#10;• Gelombang II : April - Juni 2026&#10;• Gelombang III: Juli - September 2026" required>{{ old('gelombang_info', $pmb->gelombang_info) }}</textarea>
                    @error('gelombang_info')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                    <div class="form-text small text-muted mt-2">
                        Gunakan simbol poin (• atau angka 1, 2, 3) dan baris baru (Enter) untuk memisahkan setiap gelombang.
                    </div>
                </div>

                <button type="submit" class="btn btn-success px-4 py-2.5 rounded-pill fw-bold shadow-sm" style="background-color: #046B26; border-color: #046B26;">
                    <i class="bi bi-save me-1"></i> Simpan Jadwal Gelombang
                </button>
            </form>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
            <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">
                <i class="bi bi-eye text-primary me-1"></i> Pratinjau Tampilan Web
            </h6>
            <div class="p-3 rounded-3 bg-light border small text-dark" style="line-height: 1.8; white-space: pre-line;">
                {{ $pmb->gelombang_info ?: 'Belum ada data jadwal gelombang yang disimpan.' }}
            </div>
        </div>
    </div>
</div>
@endsection
