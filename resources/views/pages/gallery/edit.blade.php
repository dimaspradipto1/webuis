@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Edit Foto Galeri</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('gallery.index') }}">Galeri</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-8 col-md-10">
        <div class="card shadow-sm">
            <div class="card-header py-3 d-flex align-items-center justify-content-between">
                <h5 class="mb-0 fw-semibold">
                    <i class="bi bi-pencil-square me-2 text-warning"></i>Edit & Kelola Multi-Foto Galeri
                </h5>
                @if($gallery->slug)
                    <a href="{{ route('homepage.galeri.detail', $gallery->slug) }}" target="_blank" class="btn btn-sm btn-outline-success">
                        <i class="bi bi-eye me-1"></i> Lihat di Website
                    </a>
                @endif
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

                <form action="{{ route('gallery.update', $gallery->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

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
                               value="{{ old('judul', $gallery->judul) }}"
                               placeholder="Masukkan judul foto (opsional)">
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Kategori Galeri --}}
                    <div class="mb-3">
                        <label for="kategori" class="form-label fw-semibold">
                            Kategori Galeri <span class="text-danger">*</span>
                        </label>
                        <select id="kategori"
                                name="kategori"
                                class="form-select @error('kategori') is-invalid @enderror"
                                required>
                            <option value="universitas" {{ old('kategori', $gallery->kategori ?? 'universitas') === 'universitas' ? 'selected' : '' }}>
                                Universitas (Galeri & Dokumentasi Universitas)
                            </option>
                            <option value="humas" {{ old('kategori', $gallery->kategori ?? 'universitas') === 'humas' ? 'selected' : '' }}>
                                Humas (Galeri & Kegiatan Humas)
                            </option>
                        </select>
                        <div class="form-text">Foto dengan kategori <strong>Humas</strong> akan otomatis tampil pada halaman Home Humas.</div>
                        @error('kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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
                                  placeholder="Deskripsi singkat foto (opsional)">{{ old('deskripsi', $gallery->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Daftar Foto Tersimpan Saat Ini --}}
                    @php
                        $existingPhotos = is_array($gallery->galeri) ? $gallery->galeri : [];
                        if (!empty($gallery->url) && !in_array($gallery->url, $existingPhotos, true)) {
                            array_unshift($existingPhotos, $gallery->url);
                        }
                    @endphp
                    @if(count($existingPhotos) > 0)
                        <div class="mb-4 p-3 rounded-3 border bg-light bg-opacity-50">
                            <label class="form-label fw-semibold small text-dark mb-2">
                                <i class="bi bi-collection me-1 text-primary"></i> Foto Tersimpan di Album Ini ({{ count($existingPhotos) }} Foto)
                            </label>
                            <div class="row g-2">
                                @foreach($existingPhotos as $idx => $pImg)
                                    @php
                                        $isMain = ($gallery->url === $pImg) || (empty($gallery->url) && $idx === 0);
                                    @endphp
                                    <div class="col-6 col-sm-4 col-md-3">
                                        <div class="border rounded-3 p-2 bg-white h-100 d-flex flex-column justify-content-between shadow-sm">
                                            <div class="position-relative mb-2">
                                                <img src="{{ asset('storage/' . $pImg) }}"
                                                     alt="Foto Galeri"
                                                     class="rounded-2 w-100"
                                                     style="height: 95px; object-fit: cover;">
                                                @if($isMain)
                                                    <span class="badge bg-success position-absolute top-0 start-0 m-1" style="font-size: 9.5px;">Sampul Utama</span>
                                                @endif
                                            </div>
                                            <div class="d-flex flex-column gap-1" style="font-size: 11px;">
                                                <label class="form-check-label d-flex align-items-center gap-1 text-primary" style="cursor:pointer;">
                                                    <input type="radio" name="set_main_photo" value="{{ $pImg }}" class="form-check-input m-0" {{ $isMain ? 'checked' : '' }}>
                                                    <span>Jadikan Sampul</span>
                                                </label>
                                                <label class="form-check-label d-flex align-items-center gap-1 text-danger" style="cursor:pointer;">
                                                    <input type="checkbox" name="hapus_galeri[]" value="{{ $pImg }}" class="form-check-input m-0">
                                                    <span>Hapus Foto</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Tambah / Upload Multi-Foto Baru --}}
                    <div class="mb-4">
                        <label for="foto" class="form-label fw-semibold">
                            Tambah Foto Baru ke Galeri Ini
                            <span class="badge bg-primary ms-1">Bisa Pilih Banyak Foto Sekaligus</span>
                        </label>
                        <div class="border border-2 border-dashed rounded-3 p-3 text-center bg-white" style="border-color: #cbd5e1 !important;">
                            <i class="bi bi-cloud-arrow-up-fill text-primary fs-2 d-block mb-1"></i>
                            <div class="fw-semibold small text-dark mb-1">Pilih 1 atau Banyak Foto Tambahan</div>
                            <div class="text-muted mb-2" style="font-size: 12px;">
                                Kosongkan jika tidak ingin menambah foto. Format: JPG, JPEG, PNG, WebP. Maksimal <strong>20 MB</strong> per foto.
                            </div>
                            <input type="file"
                                   id="foto"
                                   name="foto[]"
                                   class="form-control form-control-sm mx-auto @error('foto') is-invalid @enderror @error('foto.*') is-invalid @enderror"
                                   style="max-width: 420px;"
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

                        {{-- Preview foto baru --}}
                        <div id="previewWrap" class="mt-3 d-none">
                            <p class="small fw-semibold text-primary mb-2">
                                <i class="bi bi-images me-1"></i> Preview Foto Baru yang Akan Ditambahkan (<span id="selectedCount">0</span> Foto):
                            </p>
                            <div id="multiPreviewGrid" class="row g-2"></div>
                        </div>
                    </div>

                    {{-- Tombol --}}
                    <div class="d-flex gap-2">
                        <a href="{{ route('gallery.index') }}" class="btn btn-secondary">
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
                <div class="position-relative border border-primary rounded-3 overflow-hidden bg-white shadow-sm">
                    <img src="${url}" alt="Preview" style="width:100%;height:100px;object-fit:cover;">
                    <span class="badge bg-primary position-absolute top-0 start-0 m-1" style="font-size:10px;">
                        Baru #${idx + 1}
                    </span>
                    <button type="button" onclick="removeGalleryFile(${idx})" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1 p-0 d-flex align-items-center justify-content-center rounded-circle" style="width:22px;height:22px;font-size:12px;" title="Batal pilih">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
            `;
            grid.appendChild(col);
        });
    }
</script>
@endpush
