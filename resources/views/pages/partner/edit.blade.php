@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
        <h1>Edit Mitra Kerjasama</h1>
        <a href="{{ route('partner.agreements.index', $partner) }}" class="btn btn-outline-success btn-sm">
            <i class="bi bi-file-earmark-check me-1"></i>Kelola MOU / MOA / IA
        </a>
    </div>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('partner.index') }}">Mitra Kerjasama</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-8 col-md-10">
        <div class="card shadow-sm">
            <div class="card-header py-3">
                <h5 class="mb-0 fw-semibold">
                    <i class="bi bi-pencil-square me-2 text-warning"></i>Edit Mitra Kerjasama
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

                <form action="{{ route('partner.update', $partner->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="nama" class="form-label fw-semibold">Nama Mitra Kerjasama <span class="text-danger">*</span></label>
                        <input type="text" id="nama" name="nama"
                               class="form-control @error('nama') is-invalid @enderror"
                               value="{{ old('nama', $partner->nama) }}">
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    @if ($partner->logo)
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Logo Saat Ini</label>
                            <div>
                                <img src="{{ asset('storage/' . $partner->logo) }}"
                                     alt="{{ $partner->nama }}"
                                     style="max-width:200px;max-height:120px;object-fit:contain;border-radius:8px;border:1px solid #dee2e6">
                            </div>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label for="logo" class="form-label fw-semibold">
                            {{ $partner->logo ? 'Ganti Logo' : 'Upload Logo' }}
                            <span class="badge bg-secondary fw-normal ms-1" style="font-size:10px">Opsional</span>
                        </label>
                        <input type="file"
                               id="logo"
                               name="logo"
                               class="form-control @error('logo') is-invalid @enderror"
                               accept="image/jpg,image/jpeg,image/png,image/webp,image/svg+xml"
                               onchange="previewLogo(this)">
                        <div class="form-text">
                            <i class="bi bi-info-circle me-1"></i>
                            Kosongkan jika tidak ingin mengganti logo. Format: JPG, PNG, WebP, SVG. Maks: 20 MB.
                        </div>
                        @error('logo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <div id="previewWrap" class="mt-3 d-none">
                            <p class="small text-muted mb-1">Preview logo baru:</p>
                            <img id="previewImg" src="" alt="Preview"
                                 style="max-width:200px;max-height:120px;object-fit:contain;border-radius:8px;border:2px solid #0d6efd">
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-sm-4">
                            <label for="urutan" class="form-label fw-semibold">Urutan Tampil</label>
                            <input type="number" id="urutan" name="urutan"
                                   class="form-control @error('urutan') is-invalid @enderror"
                                   value="{{ old('urutan', $partner->urutan) }}" min="0">
                            @error('urutan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-8 d-flex align-items-center" style="padding-top:28px">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="aktif" name="aktif" value="1"
                                       {{ old('aktif', $partner->aktif) ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="aktif">
                                    Aktifkan (tampil di homepage)
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('partner.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-warning text-white">
                            <i class="bi bi-save me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function previewLogo(input) {
        const wrap = document.getElementById('previewWrap');
        const img  = document.getElementById('previewImg');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                img.src = e.target.result;
                wrap.classList.remove('d-none');
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            wrap.classList.add('d-none');
        }
    }
</script>
@endpush
