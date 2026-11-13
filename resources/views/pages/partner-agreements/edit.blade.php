@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Edit Dokumen Kerjasama</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('partner.index') }}">Mitra</a></li>
            <li class="breadcrumb-item"><a href="{{ route('partner.agreements.index', $partner) }}">{{ $partner->nama }}</a></li>
            <li class="breadcrumb-item active">Edit Dokumen</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-xl-9">
        <div class="card shadow-sm">
            <div class="card-header py-3">
                <h5 class="mb-0 fw-semibold"><i class="bi bi-pencil-square me-2 text-warning"></i>Edit {{ $agreement->judul }}</h5>
            </div>
            <div class="card-body pt-4">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <strong>Periksa kembali data Anda:</strong>
                        <ul class="mb-0 mt-1">
                            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('partner.agreements.update', [$partner, $agreement]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @include('pages.partner-agreements._form')
                    <div class="d-flex gap-2 mt-4">
                        <a href="{{ route('partner.agreements.index', $partner) }}" class="btn btn-outline-secondary">Batal</a>
                        <button type="submit" class="btn btn-warning text-white"><i class="bi bi-save me-1"></i>Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
