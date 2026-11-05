@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Tambah Foto Galeri</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('gallery.index') }}">Galeri</a></li>
            <li class="breadcrumb-item active">Tambah</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-8 col-md-10">
        <div class="card shadow-sm">
            <div class="card-header py-3">
                <h5 class="mb-0 fw-semibold">
                    <i class="bi bi-images me-2 text-primary"></i>Form Upload Multi-Foto Galeri Dokumentasi
                </h5>
            </div>
            <div class="card-body pt-4">

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

                <form action="{{ route('gallery.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Judul (nullable) --}}
                    <div class="mb-3">
                        <label for="judul" class="form-label fw-semibold">
                            Judul Kegiatan / Dokumentasi
                            <span class="badge bg-secondary fw-normal ms-1" style="font-size:10px">Opsional</span>
                        </label>
                        <input type="text"
                               id="judul"
                               name="judul"
                               class="form-control @error('judul') is-invalid @enderror"
                               value="{{ old('judul') }}"
                               placeholder="Masukkan judul kegiatan atau dokumentasi foto">
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3 mb-3">
                        {{-- Kategori Galeri --}}
                        <div class="col-md-6">
                            <label for="kategori" class="form-label fw-semibold">
                                Kategori Galeri <span class="text-danger">*</span>
                            </label>
                            <select id="kategori"
                                    name="kategori"
                                    class="form-select @error('kategori') is-invalid @enderror"
                                    required>
                                <option value="universitas" {{ old('kategori', 'universitas') === 'universitas' ? 'selected' : '' }}>
                                    Universitas (Galeri & Dokumentasi Universitas)
                                </option>
                                <option value="humas" {{ old('kategori') === 'humas' ? 'selected' : '' }}>
                                    Humas (Galeri & Kegiatan Humas)
                                </option>
                            </select>
                            <div class="form-text small">Foto kategori <strong>Humas</strong> otomatis tampil di halaman Humas.</div>
                            @error('kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Mode Penyimpanan Multi-Foto --}}
                        <div class="col-md-6">
                            <label for="mode_upload" class="form-label fw-semibold">
                                Mode Penyimpanan Multi-Foto
                            </label>
                            <select id="mode_upload" name="mode_upload" class="form-select">
                                <option value="album" {{ old('mode_upload', 'album') === 'album' ? 'selected' : '' }}>
                                    1 Album Dokumentasi (Semua foto tampil di Halaman Detail)
                                </option>
                                <option value="terpisah" {{ old('mode_upload') === 'terpisah' ? 'selected' : '' }}>
                                    Item Terpisah (Setiap foto menjadi 1 kartu galeri sendiri)
                                </option>
                            </select>
                            <div class="form-text small">Pilih bagaimana jika Anda mengunggah lebih dari 1 foto.</div>
                        </div>
                    </div>

                    {{-- Deskripsi (nullable) --}}
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label fw-semibold">
                            Deskripsi Kegiatan
                            <span class="badge bg-secondary fw-normal ms-1" style="font-size:10px">Opsional</span>
                        </label>
                        <textarea id="deskripsi"
                                  name="deskripsi"
                                  class="form-control @error('deskripsi') is-invalid @enderror"
                                  rows="3"
                                  placeholder="Deskripsi singkat kegiatan / foto dokumentasi (opsional)">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Upload Multi-Foto (wajib) --}}
                    <div class="mb-4">
                        <label for="foto" class="form-label fw-semibold">
                            Upload Foto Dokumentasi <span class="text-danger">*</span>
                            <span class="badge bg-primary ms-1">Bisa Pilih Banyak Foto Sekaligus</span>
                        </label>
                        <div class="border border-2 border-dashed rounded-3 p-4 text-center bg-light bg-opacity-50" style="border-color: #cbd5e1 !important;">
                            <i class="bi bi-cloud-arrow-up-fill text-primary fs-1 d-block mb-1"></i>
                            <div class="fw-semibold text-dark mb-1">Pilih 1 atau Banyak Foto Sekaligus</div>
                            <div class="text-muted small mb-3">
                                Format: JPG, JPEG, PNG, WebP. Maksimal <strong>20 MB</strong> per foto. Anda dapat memilih beberapa foto sekaligus.
                            </div>
                            <input type="file"
                                   id="foto"
                                   name="foto[]"
                                   class="form-control mx-auto @error('foto') is-invalid @enderror @error('foto.*') is-invalid @enderror"
                                   style="max-width: 440px;"
                                   accept="image/jpg,image/jpeg,image/png,image/webp"
                                   multiple
                                   onchange="handleGalleryMultiFiles(this)">
                            @error('foto')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            @error('foto.*')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Preview Multi-Foto --}}
                        <div id="previewWrap" class="mt-3 d-none">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="small fw-semibold text-secondary">
                                    <i class="bi bi-images me-1"></i> Preview Foto Terpilih (<span id="selectedCount">0</span> Foto):
                                </span>
                                <button type="button" onclick="clearAllGalleryFiles()" class="btn btn-sm btn-outline-danger py-0 px-2" style="font-size: 11.5px;">
                                    <i class="bi bi-trash me-1"></i> Reset Pilihan
                                </button>
                            </div>
                            <div id="multiPreviewGrid" class="row g-2"></div>
                        </div>
                    </div>

                    {{-- Tombol --}}
                    <div class="d-flex gap-2">
                        <a href="{{ route('gallery.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-upload me-1"></i> Upload & Simpan Galeri
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
    let galleryFilesDT = new DataTransfer();

    function handleGalleryMultiFiles(input) {
        if (input.files && input.files.length > 0) {
            Array.from(input.files).forEach(file => galleryFilesDT.items.add(file));
            input.files = galleryFilesDT.files;
        }
        renderGalleryMultiPreview();
    }

    function removeGalleryFile(index) {
        const dt = new DataTransfer();
        Array.from(galleryFilesDT.files).forEach((file, i) => {
            if (i !== index) dt.items.add(file);
        });
        galleryFilesDT = dt;
        document.getElementById('foto').files = galleryFilesDT.files;
        renderGalleryMultiPreview();
    }

    function clearAllGalleryFiles() {
        galleryFilesDT = new DataTransfer();
        document.getElementById('foto').files = galleryFilesDT.files;
        renderGalleryMultiPreview();
    }

    function renderGalleryMultiPreview() {
        const wrap = document.getElementById('previewWrap');
        const grid = document.getElementById('multiPreviewGrid');
        const countEl = document.getElementById('selectedCount');
        grid.innerHTML = '';

        const files = Array.from(galleryFilesDT.files);
        countEl.textContent = files.length;

        if (files.length === 0) {
            wrap.classList.add('d-none');
            return;
        }

        wrap.classList.remove('d-none');
        files.forEach((file, idx) => {
            const url = URL.createObjectURL(file);
            const col = document.createElement('div');
            col.className = 'col-6 col-sm-4 col-md-3';
            col.innerHTML = `
                <div class="position-relative border rounded-3 overflow-hidden bg-white shadow-sm">
                    <img src="${url}" alt="Preview" style="width:100%;height:110px;object-fit:cover;">
                    <span class="badge ${idx === 0 ? 'bg-success' : 'bg-dark bg-opacity-75'} position-absolute top-0 start-0 m-1" style="font-size:10px;">
                        ${idx === 0 ? 'Sampul Utama' : 'Foto #' + (idx + 1)}
                    </span>
                    <button type="button" onclick="removeGalleryFile(${idx})" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1 p-0 d-flex align-items-center justify-content-center rounded-circle" style="width:22px;height:22px;font-size:12px;" title="Hapus dari daftar upload">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
            `;
            grid.appendChild(col);
        });
    }
</script>
@endpush
