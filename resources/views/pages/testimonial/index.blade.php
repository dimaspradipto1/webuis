@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Testimoni Alumni</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Testimoni</li>
        </ol>
    </nav>
</div>

<div class="card shadow-sm">
    <div class="card-header d-flex align-items-center justify-content-between py-3">
        <h5 class="mb-0 fw-semibold">
            <i class="bi bi-chat-square-quote-fill me-2 text-primary"></i>Daftar Testimoni Alumni & Civitas
        </h5>
        <a href="{{ route('testimonial.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i> Tambah Testimoni
        </a>
    </div>
    <div class="card-body pt-3">
        <div class="alert alert-info alert-dismissible fade show mb-3" role="alert">
            <i class="bi bi-info-circle-fill me-2"></i>
            <strong>Info Moderasi:</strong> Setiap testimoni yang dikirimkan oleh alumni maupun publik via website akan berstatus <strong>Pending</strong>.
            Anda perlu mengklik tombol <strong>Edit</strong> dan mencentang status <strong>Aktif</strong> agar ulasan tersebut tampil di halaman utama website.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
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
