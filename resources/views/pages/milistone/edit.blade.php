@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Sunting Milestone</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('milestone.index') }}">Milestone</a></li>
            <li class="breadcrumb-item active">Sunting</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header py-3">
                <h5 class="mb-0 fw-semibold">
                    <i class="bi bi-pencil-square me-2 text-primary"></i>Form Sunting Milestone
                </h5>
            </div>
            <div class="card-body pt-4">

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <strong>Periksa kembali data Anda:</strong>
                        <ul class="mb-0 mt-1 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('milestone.update', $milestone->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="tahun" class="form-label fw-semibold">Tahun <span class="text-danger">*</span></label>
                        <input type="number" id="tahun" name="tahun"
                               class="form-control @error('tahun') is-invalid @enderror"
                               value="{{ old('tahun', $milestone->tahun) }}"
                               placeholder="Contoh: 2016"
                               min="1900" max="2100">
                        @error('tahun')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="judul" class="form-label fw-semibold">Judul Milestone <span class="text-danger">*</span></label>
                        <input type="text" id="judul" name="judul"
                               class="form-control @error('judul') is-invalid @enderror"
                               value="{{ old('judul', $milestone->judul) }}"
                               placeholder="Contoh: Awal Pendirian">
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="deskripsi" class="form-label fw-semibold">Deskripsi</label>
                        <textarea id="deskripsi" name="deskripsi" rows="8"
                                  class="form-control @error('deskripsi') is-invalid @enderror"
                                  style="line-height: 1.7;"
                                  placeholder="Ceritakan pencapaian pada tahun tersebut (gunakan Enter untuk membuat paragraf baru)...">{{ old('deskripsi', $milestone->clean_deskripsi) }}</textarea>
                        <div class="form-text">Gunakan tombol <strong>Enter</strong> untuk membuat baris atau paragraf baru.</div>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('milestone.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
