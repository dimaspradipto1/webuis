@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Tambah Banner</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('banner.index') }}">Banner</a></li>
            <li class="breadcrumb-item active">Tambah</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-8 col-md-10">
        <div class="card shadow-sm">
            <div class="card-header py-3">
                <h5 class="mb-0 fw-semibold">
                    <i class="bi bi-image-fill me-2 text-primary"></i>Form Tambah Banner
                </h5>
            </div>
            <div class="card-body pt-4">

                {{-- Info ukuran --}}
                <div class="alert alert-info mb-4">
                    <i class="bi bi-info-circle-fill me-2"></i>
                    <strong>Panduan ukuran banner:</strong> Ukuran ideal <strong>1920 × 780 px</strong>,
                    rasio aspek ~2.5:1. Konten penting letakkan di tengah gambar. Format: JPG, PNG, WebP.
                </div>

                {{-- Error Summary --}}
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

                <form action="{{ route('banner.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Judul (opsional) --}}
                    <div class="mb-3">
                        <label for="judul" class="form-label fw-semibold">
                            Judul
                            <span class="badge bg-secondary fw-normal ms-1" style="font-size:10px">Opsional</span>
                        </label>
                        <input type="text"
                               id="judul"
                               name="judul"
                               class="form-control @error('judul') is-invalid @enderror"
                               value="{{ old('judul') }}"
                               placeholder="Contoh: Layanan Riksa Uji K3 BJI">
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Upload Gambar (wajib) --}}
                    <div class="mb-3">
                        <label for="foto" class="form-label fw-semibold">
                            Gambar Banner <span class="text-danger">*</span>
                        </label>
                        <input type="file"
                               id="foto"
                               name="foto"
                               class="form-control @error('foto') is-invalid @enderror"
                               accept="image/jpg,image/jpeg,image/png,image/webp"
                               onchange="previewBanner(this)">
                        <div class="form-text">
                            <i class="bi bi-info-circle me-1"></i>
                            Format: JPG, JPEG, PNG, WebP. Maksimal: 20 MB. Resolusi disarankan: 1920 × 780 px.
                        </div>
                        @error('foto')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        {{-- Preview gambar --}}
                        <div id="previewWrap" class="mt-3 d-none">
                            <p class="small text-muted mb-1">Preview:</p>
                            <img id="previewImg"
                                 src=""
                                 alt="Preview"
                                 style="max-width:100%;max-height:250px;object-fit:cover;border-radius:8px;border:1px solid #dee2e6">
                            <div id="previewDim" class="small text-muted mt-1"></div>
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        {{-- Urutan --}}
                        <div class="col-sm-4">
                            <label for="urutan" class="form-label fw-semibold">
                                Urutan Tampil
                            </label>
                            <input type="number"
                                   id="urutan"
                                   name="urutan"
                                   class="form-control @error('urutan') is-invalid @enderror"
                                   value="{{ old('urutan', 0) }}"
                                   min="0"
                                   placeholder="0">
                            <div class="form-text">Angka kecil tampil lebih dulu.</div>
                            @error('urutan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Status Aktif --}}
                        <div class="col-sm-8 d-flex align-items-center" style="padding-top:28px">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="aktif" name="aktif" value="1"
                                       {{ old('aktif', true) ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="aktif">
                                    Aktifkan banner (tampil di homepage)
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Tombol --}}
                    <div class="d-flex gap-2">
                        <a href="{{ route('banner.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-upload me-1"></i> Upload & Simpan
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
    function previewBanner(input) {
        const wrap = document.getElementById('previewWrap');
        const img  = document.getElementById('previewImg');
        const dim  = document.getElementById('previewDim');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                img.src = e.target.result;
                wrap.classList.remove('d-none');
                // Tampilkan dimensi asli
                const tmpImg = new Image();
                tmpImg.onload = function () {
                    dim.textContent = 'Dimensi: ' + tmpImg.width + ' × ' + tmpImg.height + ' px';
                };
                tmpImg.src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            wrap.classList.add('d-none');
        }
    }
</script>
@endpush
