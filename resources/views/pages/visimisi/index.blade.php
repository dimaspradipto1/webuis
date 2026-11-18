@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Kelola Gambar Visi & Misi</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Profil</li>
            <li class="breadcrumb-item active">Visi & Misi</li>
        </ol>
    </nav>
</div>

<div class="card shadow-sm border-0 mb-4" style="border-radius: 12px;">
    <div class="card-header bg-white py-3 d-flex flex-wrap align-items-center justify-content-between gap-2" style="border-top: 3px solid #046B26; border-radius: 12px 12px 0 0;">
        <div class="d-flex align-items-center gap-2">
            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background-color: #e8f5e9; color: #046B26;">
                <i class="bi bi-images fs-5"></i>
            </div>
            <div>
                <h5 class="mb-0 fw-bold" style="color: #2b2f32; font-size: 16px;">Daftar Gambar Visi & Misi</h5>
                <small class="text-muted">Konsep upload gambar untuk ditampilkan dalam 3 kolom full-width di frontend</small>
            </div>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('homepage.visi-misi') }}" target="_blank" class="btn btn-outline-success btn-sm">
                <i class="bi bi-box-arrow-up-right me-1"></i> Lihat Halaman Frontend
            </a>
            <a href="{{ route('visimisi.create') }}" class="btn btn-success btn-sm fw-semibold" style="background-color: #046B26; border-color: #046B26;">
                <i class="bi bi-cloud-arrow-up-fill me-1"></i> Upload Gambar Baru
            </a>
        </div>
    </div>
    <div class="card-body pt-3">
        <div class="alert alert-light border border-success-subtle d-flex align-items-start gap-2 mb-3 p-3" style="background-color: #f0fdf4; border-radius: 10px;">
            <i class="bi bi-info-circle-fill text-success fs-5 flex-shrink-0"></i>
            <div class="small text-muted" style="line-height: 1.5;">
                <strong class="text-success">Informasi Tampilan Frontend:</strong>
                Semua gambar yang diunggah dan berstatus <strong>Aktif</strong> akan otomatis ditampilkan dalam format <strong>3 Kolom (Grid 3 Col)</strong> dengan lebar gambar <strong>Full Width (100%)</strong> di halaman <a href="{{ route('homepage.visi-misi') }}" target="_blank" class="text-success fw-bold text-decoration-underline">/visi-misi</a>. Pengunjung juga dapat mengklik gambar untuk memperbesar secara penuh.
            </div>
        </div>

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
