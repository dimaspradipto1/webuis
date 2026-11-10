@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Tambah Post / Berita</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('news.index') }}">Post</a></li>
            <li class="breadcrumb-item active">Tambah</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-10 col-md-12">
        <div class="card shadow-sm">
            <div class="card-header py-3">
                <h5 class="mb-0 fw-semibold">
                    <i class="bi bi-newspaper me-2 text-primary"></i>Form Tambah Post & Berita UIS
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

                <form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Judul --}}
                    <div class="mb-3">
                        <label for="title" class="form-label fw-semibold">
                            Judul Post / Berita <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               id="title"
                               name="title"
                               class="form-control @error('title') is-invalid @enderror"
                               value="{{ old('title') }}"
                               placeholder="Masukkan judul artikel/berita"
                               required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Deskripsi Singkat --}}
                    <div class="mb-3">
                        <label for="description" class="form-label fw-semibold">
                            Deskripsi Singkat <span class="text-danger">*</span>
                        </label>
                        <textarea id="description"
                                  name="description"
                                  class="form-control @error('description') is-invalid @enderror"
                                  rows="2"
                                  placeholder="Deskripsi singkat atau kutipan artikel berita"
                                  required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Isi Konten (TinyMCE) --}}
                    <div class="mb-3">
                        <label for="content" class="form-label fw-semibold">
                            Konten Lengkap <span class="text-danger">*</span>
                        </label>
                        <textarea id="content"
                                  name="content"
                                  class="form-control @error('content') is-invalid @enderror"
                                  rows="10">{{ old('content') }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Baris Pengaturan: Kategori & Tanggal Publish --}}
                    <div class="row mb-3">
                        {{-- Kategori --}}
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label for="category" class="form-label fw-semibold">
                                Kategori Berita <span class="text-danger">*</span>
                            </label>
                            @php $cat = old('category'); @endphp
                            <select id="category"
                                    name="category"
                                    class="form-select @error('category') is-invalid @enderror"
                                    required>
                                <option value="Berita Universitas"          {{ $cat == 'Berita Universitas' ? 'selected' : '' }}>Berita Universitas</option>
                                <option value="Berita Humas"                {{ $cat == 'Berita Humas' ? 'selected' : '' }}>Berita Humas</option>
                                <option value="Akademik & Kemahasiswaan"    {{ $cat == 'Akademik & Kemahasiswaan' ? 'selected' : '' }}>Akademik & Kemahasiswaan</option>
                                <option value="Teknologi & Rekayasa"        {{ $cat == 'Teknologi & Rekayasa' ? 'selected' : '' }}>Teknologi & Rekayasa</option>
                                <option value="Bisnis & Manajemen"          {{ $cat == 'Bisnis & Manajemen' ? 'selected' : '' }}>Bisnis & Manajemen</option>
                                <option value="K3 & Lingkungan Industri"    {{ $cat == 'K3 & Lingkungan Industri' ? 'selected' : '' }}>K3 & Lingkungan Industri</option>
                                <option value="Penelitian & Riset"          {{ $cat == 'Penelitian & Riset' ? 'selected' : '' }}>Penelitian & Riset</option>
                                <option value="Pengabdian Masyarakat"       {{ $cat == 'Pengabdian Masyarakat' ? 'selected' : '' }}>Pengabdian Masyarakat</option>
                                <option value="Kerjasama Industri"          {{ $cat == 'Kerjasama Industri' ? 'selected' : '' }}>Kerjasama Industri</option>
                                <option value="Pengumuman & Agenda"         {{ $cat == 'Pengumuman & Agenda' ? 'selected' : '' }}>Pengumuman & Agenda</option>
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tanggal Publish --}}
                        <div class="col-md-6">
                            <label for="published_at" class="form-label fw-semibold">
                                <i class="bi bi-calendar-event me-1 text-primary"></i> Tanggal & Waktu Publish
                            </label>
                            <input type="datetime-local"
                                   id="published_at"
                                   name="published_at"
                                   class="form-control @error('published_at') is-invalid @enderror"
                                   value="{{ old('published_at') }}">
                            <div class="form-text text-muted small">
                                <i class="bi bi-info-circle me-1"></i> Boleh dikosongkan. Jika tidak diisi otomatis menggunakan waktu saat ini (<code>now()</code>).
                            </div>
                            @error('published_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Baris: Status + Artikel Unggulan --}}
                    <div class="row mb-4">
                        {{-- Status --}}
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label for="status" class="form-label fw-semibold">
                                Status <span class="text-danger">*</span>
                            </label>
                            <select id="status"
                                    name="status"
                                    class="form-select @error('status') is-invalid @enderror"
                                    required>
                                <option value="published"  {{ old('status', 'published') == 'published'  ? 'selected' : '' }}>Published (Terbit)</option>
                                <option value="draft"      {{ old('status') == 'draft'      ? 'selected' : '' }}>Draft</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Artikel Unggulan --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold d-block">Artikel Unggulan</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input"
                                       type="checkbox"
                                       role="switch"
                                       id="is_featured"
                                       name="is_featured"
                                       value="1"
                                       {{ old('is_featured') ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_featured">
                                    Jadikan Berita Utama
                                </label>
                            </div>
                            <div class="form-text text-muted small">
                                <i class="bi bi-star-fill text-warning"></i> Ditampilkan di banner sorotan utama.
                            </div>
                        </div>
                    </div>

                    {{-- Gambar Thumbnail Utama --}}
                    <div class="mb-4 p-3 rounded bg-light border">
                        <label for="thumbnail" class="form-label fw-semibold">
                            <i class="bi bi-image me-1 text-primary"></i> Gambar Thumbnail Utama <span class="text-muted small fw-normal">(Opsional - Boleh dikosongkan)</span>
                        </label>
                        <input type="file"
                               id="thumbnail"
                               name="thumbnail"
                               class="form-control @error('thumbnail') is-invalid @enderror"
                               accept="image/*"
                               onchange="previewThumbnail(this)">
                        <div class="form-text text-muted">Format: JPG, JPEG, PNG, WebP. Maks: 20 MB. Boleh dikosongkan jika belum memiliki gambar.</div>
                        @error('thumbnail')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        {{-- Preview Thumbnail --}}
                        <div id="thumbnailPreviewWrap" class="mt-3 d-none">
                            <p class="small text-muted mb-1 fw-semibold">Preview Thumbnail:</p>
                            <img id="thumbnailPreview"
                                 src=""
                                 alt="Preview Thumbnail"
                                 class="img-thumbnail rounded"
                                 style="max-height: 180px; object-fit: cover;">
                        </div>
                    </div>

                    {{-- Galeri Foto Berita (Multiple Images) --}}
                    <div class="mb-4 p-3 rounded bg-light border">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label for="gallery" class="form-label fw-semibold mb-0">
                                <i class="bi bi-images me-1 text-success"></i> Galeri Foto Dokumentasi (Bisa Pilih Banyak Gambar)
                            </label>
                            <span class="badge bg-primary rounded-pill">Multi Upload</span>
                        </div>
                        <p class="small text-muted mb-2">Unggah foto-foto dokumentasi pendukung untuk berita ini (tekan Ctrl / Shift saat memilih file untuk memilih lebih dari 1 gambar sekaligus).</p>
                        
                        <input type="file"
                               id="gallery"
                               name="gallery[]"
                               class="form-control @error('gallery') is-invalid @enderror @error('gallery.*') is-invalid @enderror"
                               multiple
                               accept="image/*"
                               onchange="previewGallery(this)">
                        <div class="form-text text-muted">Format: JPG, JPEG, PNG, WebP. Maks: 20 MB per gambar.</div>
                        @error('gallery')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        @error('gallery.*')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror

                        {{-- Container Preview Galeri Multi Foto --}}
                        <div id="galleryPreviewContainer" class="mt-3 d-none">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="small fw-semibold text-dark" id="galleryCountText">Foto Terpilih: 0</span>
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="clearGallery()">
                                    <i class="bi bi-trash"></i> Reset Pilihan
                                </button>
                            </div>
                            <div id="galleryGrid" class="row g-2"></div>
                        </div>
                    </div>

                    {{-- Tombol --}}
                    <div class="d-flex gap-2 justify-content-end pt-3 border-top">
                        <a href="{{ route('news.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary" style="background: var(--uis-purple); border-color: var(--uis-purple);">
                            <i class="bi bi-send me-1"></i> Terbitkan Berita
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

    function previewThumbnail(input) {
        const wrap = document.getElementById('thumbnailPreviewWrap');
        const img = document.getElementById('thumbnailPreview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                img.src = e.target.result;
                wrap.classList.remove('d-none');
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            wrap.classList.add('d-none');
        }
    }

    function previewGallery(input) {
        const container = document.getElementById('galleryPreviewContainer');
        const grid = document.getElementById('galleryGrid');
        const countText = document.getElementById('galleryCountText');
        grid.innerHTML = '';

        if (input.files && input.files.length > 0) {
            countText.innerText = `Foto Terpilih: ${input.files.length} Gambar`;
            container.classList.remove('d-none');

            Array.from(input.files).forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const col = document.createElement('div');
                    col.className = 'col-6 col-md-4 col-lg-3';
                    col.innerHTML = `
                        <div class="card h-100 shadow-sm border p-1 position-relative">
                            <img src="${e.target.result}" class="rounded w-100" style="height: 110px; object-fit: cover;">
                            <span class="badge bg-dark position-absolute top-0 start-0 m-2 opacity-75">#${index + 1}</span>
                            <div class="small text-truncate text-muted mt-1 px-1" style="font-size: 11px;">${file.name}</div>
                        </div>
                    `;
                    grid.appendChild(col);
                };
                reader.readAsDataURL(file);
            });
        } else {
            container.classList.add('d-none');
        }
    }

    function clearGallery() {
        const input = document.getElementById('gallery');
        input.value = '';
        document.getElementById('galleryPreviewContainer').classList.add('d-none');
        document.getElementById('galleryGrid').innerHTML = '';
    }
</script>
@endpush
