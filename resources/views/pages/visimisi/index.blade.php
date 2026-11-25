@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Kelola Visi & Misi</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Profil</li>
            <li class="breadcrumb-item active">Visi & Misi</li>
        </ol>
    </nav>
</div>

{{-- ═══════════════════════════════════════════════════════════════
     INFORMASI PENGATURAN BREADCRUMB & HERO BANNER TERPUSAT
     ═══════════════════════════════════════════════════════════════ --}}
<div class="alert alert-light border shadow-sm d-flex flex-wrap align-items-center justify-content-between p-3 mb-4 rounded-3" style="border-left: 4px solid #046B26 !important; background: #ffffff;">
    <div class="d-flex align-items-center gap-3">
        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: #e8f5e9; color: #046B26; flex-shrink: 0;">
            <i class="bi bi-compass fs-4"></i>
        </div>
        <div>
            <div class="fw-bold text-dark" style="font-size: 15px;">Pengaturan Judul & Hero Banner Halaman Visi & Misi Terpusat di Breadcrumb</div>
            <div class="text-muted small" style="line-height: 1.4;">Teks judul, badge kategori atas, kalimat pengantar (slogan), latar belakang banner, dan hierarki navigasi halaman ini dikelola secara terpusat di modul Breadcrumb.</div>
        </div>
    </div>
    <div class="d-flex align-items-center gap-2 mt-2 mt-lg-0">
        <a href="{{ route('breadcrumb-setting.edit', $breadcrumb->id ?? 2) }}" class="btn btn-sm btn-outline-success fw-semibold">
            <i class="bi bi-pencil-square me-1"></i> Edit Breadcrumb & Hero Banner
        </a>
        <a href="{{ route('homepage.visi-misi') }}" target="_blank" class="btn btn-sm btn-success fw-semibold" style="background-color: #046B26; border-color: #046B26;">
            <i class="bi bi-box-arrow-up-right me-1"></i> Pratinjau Frontend
        </a>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════════
     CARD 2: DAFTAR GAMBAR VISI & MISI (3 KOLOM FRONTEND)
     ═══════════════════════════════════════════════════════════════ --}}
<div class="card shadow-sm border-0 mb-4" style="border-radius: 12px;">
    <div class="card-header bg-white py-3 d-flex flex-wrap align-items-center justify-content-between gap-2" style="border-top: 3px solid #046B26; border-radius: 12px 12px 0 0;">
        <div class="d-flex align-items-center gap-2">
            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background-color: #e8f5e9; color: #046B26;">
                <i class="bi bi-images fs-5"></i>
            </div>
            <div>
                <h5 class="mb-0 fw-bold" style="color: #2b2f32; font-size: 16px;">Daftar Gambar Visi & Misi</h5>
                <small class="text-muted">Setiap gambar akan disusun dalam 3 kolom dengan lebar penuh (Full Width 100%) di frontend</small>
            </div>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('visimisi.create') }}" class="btn btn-success btn-sm fw-semibold" style="background-color: #046B26; border-color: #046B26;">
                <i class="bi bi-cloud-arrow-up-fill me-1"></i> Upload Gambar Baru
            </a>
        </div>
    </div>
    <div class="card-body pt-3">
        <div class="table-responsive">
            {{ $dataTable->table([
                'class' => 'table table-hover table-bordered align-middle',
                'style' => 'width:100%',
            ]) }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
    @if(app()->environment('production'))
        {!! str_replace('http:', 'https:', $dataTable->scripts()) !!}
    @else
        {!! $dataTable->scripts() !!}
    @endif
@endpush
