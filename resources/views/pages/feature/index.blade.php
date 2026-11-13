@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Keunggulan Beranda</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Konten Beranda</li>
            <li class="breadcrumb-item active">Keunggulan Beranda</li>
        </ol>
    </nav>
</div>

<div class="card shadow-sm">
    <div class="card-header d-flex align-items-center justify-content-between py-3">
        <div>
            <h5 class="mb-0 fw-semibold">
                <i class="bi bi-layers-fill me-2 text-success"></i>Pengaturan Keunggulan Beranda
            </h5>
            <small class="text-muted">Menampilkan kartu informasi utama tepat di bawah Banner Hero halaman Beranda (Program Studi, Kerjasama, Program Beasiswa).</small>
        </div>
        <a href="{{ route('feature.create') }}" class="btn btn-success btn-sm">
            <i class="bi bi-plus-lg me-1"></i> Tambah Kartu
        </a>
    </div>
    <div class="card-body pt-3">
        <div class="alert alert-light border d-flex align-items-center gap-2 mb-3 py-2" role="alert">
            <i class="bi bi-info-circle-fill text-success"></i>
            <div class="small text-secondary">
                Kartu dengan <strong>Urutan 1</strong> akan ditampilkan sebagai kartu unggulan berlatar hijau tua (featured card), sedangkan kartu urutan berikutnya tampil dengan latar putih bersih.
            </div>
        </div>
        <div class="table-responsive">
            {{ $dataTable->table([
                'class' => 'table table-striped table-bordered align-middle',
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
