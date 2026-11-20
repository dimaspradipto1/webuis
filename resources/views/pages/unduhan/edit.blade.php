@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Edit Unduhan Dokumen Humas</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('unduhan.index') }}">Unduhan Dokumen Humas</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-8 col-md-10">
        <div class="card shadow-sm">
            <div class="card-header py-3">
                <h5 class="mb-0 fw-semibold">
                    <i class="bi bi-pencil-square me-2 text-warning"></i>Edit Berkas / Item Unduhan
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

                <form action="{{ route('unduhan.update', $unduhan->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Judul Item -->
                    <div class="mb-3">
                        <label for="judul" class="form-label fw-semibold">Nama / Judul Item <span class="text-danger">*</span></label>
                        <input type="text" id="judul" name="judul"
                               class="form-control @error('judul') is-invalid @enderror"
                               value="{{ old('judul', $unduhan->judul) }}"
                               placeholder="Contoh: Logo Resmi Universitas Ibnu Sina (HD Vector)" required>
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Kategori -->
                    <div class="mb-3">
                        <label for="kategori" class="form-label fw-semibold">Kategori Unduhan <span class="text-danger">*</span></label>
                        <select id="kategori" name="kategori" class="form-select @error('kategori') is-invalid @enderror" required>
                            <option value="image" {{ old('kategori', $unduhan->kategori) == 'image' ? 'selected' : '' }}>🖼️ Image (Logo, Banner, Poster, Foto Resmi)</option>
                            <option value="video" {{ old('kategori', $unduhan->kategori) == 'video' ? 'selected' : '' }}>🎬 Video (Video Bumper, Teaser, Profil Kampus)</option>
                            <option value="audio" {{ old('kategori', $unduhan->kategori) == 'audio' ? 'selected' : '' }}>🎵 Audio (Jingle, Mars, Hymne, Sound Effect)</option>
                            <option value="template" {{ old('kategori', $unduhan->kategori) == 'template' ? 'selected' : '' }}>🖌️ Template (PPT, Frame Feed, Sertifikat, Dokumen)</option>
                        </select>
                        @error('kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Upload File Lokal -->
                    <div class="mb-3">
                        <label for="file" class="form-label fw-semibold">
                            Ganti File Dokumen / Media
                            <span class="badge bg-secondary fw-normal ms-1" style="font-size:10px">Opsional</span>
                        </label>
                        <input type="file" id="file" name="file"
                               class="form-control @error('file') is-invalid @enderror"
                               onchange="detectFileInfo(this)">
                        <div class="form-text">
                            <i class="bi bi-info-circle me-1"></i>
                            Biarkan kosong jika tidak ingin mengganti file yang ada. Maks: 50 MB.
                        </div>
                        @error('file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        @if($unduhan->file_path)
                            <div class="mt-2 p-2 bg-light rounded border d-flex align-items-center justify-content-between">
                                <span class="small text-muted">
                                    <i class="bi bi-file-earmark-check text-success me-1"></i>
                                    File saat ini: <strong>{{ basename($unduhan->file_path) }}</strong>
                                </span>
                                <a href="{{ asset('storage/' . $unduhan->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary py-0" style="font-size:11px">
                                    <i class="bi bi-box-arrow-up-right me-1"></i>Lihat File
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- URL Eksternal / Cloud Link -->
                    <div class="mb-3">
                        <label for="file_url" class="form-label fw-semibold">
                            Tautan / Link Unduhan Eksternal
                            <span class="badge bg-secondary fw-normal ms-1" style="font-size:10px">Alternatif</span>
                        </label>
                        <input type="url" id="file_url" name="file_url"
                               class="form-control @error('file_url') is-invalid @enderror"
                               value="{{ old('file_url', $unduhan->file_url) }}"
                               placeholder="Contoh: https://drive.google.com/file/d/xxxx/view">
                        <div class="form-text">
                            <i class="bi bi-link-45deg me-1"></i>
                            Gunakan jika berkas tersimpan di Google Drive, Dropbox, OneDrive, atau server CDN.
                        </div>
                        @error('file_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <!-- Ukuran File -->
                        <div class="col-sm-6">
                            <label for="file_size" class="form-label fw-semibold">Ukuran File / Format</label>
                            <input type="text" id="file_size" name="file_size"
                                   class="form-control @error('file_size') is-invalid @enderror"
                                   value="{{ old('file_size', $unduhan->file_size) }}"
                                   placeholder="Contoh: 2.4 MB">
                            @error('file_size')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div class="col-sm-6">
                            <label for="deskripsi" class="form-label fw-semibold">Deskripsi Singkat (Opsional)</label>
                            <input type="text" id="deskripsi" name="deskripsi"
                                   class="form-control @error('deskripsi') is-invalid @enderror"
                                   value="{{ old('deskripsi', $unduhan->deskripsi) }}"
                                   placeholder="Keterangan tambahan">
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-sm-4">
                            <label for="urutan" class="form-label fw-semibold">Urutan Tampil</label>
                            <input type="number" id="urutan" name="urutan"
                                   class="form-control @error('urutan') is-invalid @enderror"
                                   value="{{ old('urutan', $unduhan->urutan) }}" min="0">
                            @error('urutan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-8 d-flex align-items-center" style="padding-top:28px">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                                       {{ old('is_active', $unduhan->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="is_active">
                                    Aktifkan (tampil di halaman Unduhan Humas)
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('unduhan.index') }}" class="btn btn-secondary">
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

@push('scripts')
<script>
    function detectFileInfo(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const sizeInBytes = file.size;
            
            const units = ['B', 'KB', 'MB', 'GB'];
            let size = sizeInBytes;
            let unitIndex = 0;
            while (size >= 1024 && unitIndex < units.length - 1) {
                size /= 1024;
                unitIndex++;
            }
            const formattedSize = size.toFixed(1) + ' ' + units[unitIndex];

            const ukuranInput = document.getElementById('file_size');
            if (ukuranInput) {
                ukuranInput.value = formattedSize;
            }
        }
    }
</script>
@endpush
