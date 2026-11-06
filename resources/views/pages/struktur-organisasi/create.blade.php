@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle d-flex flex-wrap align-items-center justify-content-between gap-2 mb-4">
    <div>
        <h1 class="mb-1">Tambah Profil Pimpinan Baru</h1>
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('struktur-organisasi.index') }}">Profil dan Struktur Pimpinan</a></li>
                <li class="breadcrumb-item active">Tambah Pimpinan</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('struktur-organisasi.index') }}" class="btn btn-outline-secondary rounded-3 px-3">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="row">
    <div class="col-12">
        @if ($errors->any())
            <div class="alert alert-danger rounded-3">
                <strong class="d-block mb-1"><i class="bi bi-exclamation-triangle-fill me-1"></i> Periksa kembali inputan Anda:</strong>
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('struktur-organisasi.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 px-4" style="border-top: 3px solid #046B26; border-radius: 16px 16px 0 0;">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="bi bi-person-badge-fill text-success me-2"></i>Data Utama & Biografi Detail Pimpinan
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Nama Lengkap & Gelar <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" placeholder="Contoh: drg. Andi Tenri Ummu, MM." required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Jabatan <span class="text-danger">*</span></label>
                            <input type="text" name="jabatan" class="form-control" value="{{ old('jabatan') }}" placeholder="Contoh: Ketua Yayasan Pendidikan Ibnu Sina Batam (YAPISTA)" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Posisi Baris Kartu <span class="text-danger">*</span></label>
                            <select name="baris" class="form-select" required>
                                <option value="1" {{ (int) old('baris', $selectedBaris) === 1 ? 'selected' : '' }}>Baris 1 — Ketua Yayasan & Rektor (2 Kolom)</option>
                                <option value="2" {{ (int) old('baris', $selectedBaris) === 2 ? 'selected' : '' }}>Baris 2 — Jajaran Wakil Rektor (3 Kolom)</option>
                                <option value="3" {{ (int) old('baris', $selectedBaris) === 3 ? 'selected' : '' }}>Baris 3 — Jajaran Dekan Fakultas (3 Kolom)</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-bold small">Urutan Tampil</label>
                            <input type="number" name="urutan" class="form-control" value="{{ old('urutan', $nextUrutan) }}" min="1">
                        </div>

                        <div class="col-md-3 d-flex align-items-end">
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" name="is_active" id="isActive" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold small" for="isActive">Tampilkan (Aktif)</label>
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold small">
                                Profil Lengkap / Biografi & Arah Pengembangan (Ditampilkan pada Halaman Detail Pimpinan)
                            </label>
                            <textarea name="biografi" rows="10" class="form-control" placeholder="Tuliskan profil lengkap, riwayat pendidikan, arah pengembangan, atau sambutan pimpinan. Pisahkan paragraf dengan Enter...">{{ old('biografi') }}</textarea>
                            <div class="form-text">Gunakan baris baru (Enter 2x) untuk memisahkan antar paragraf atau subjudul.</div>
                        </div>

                        <div class="col-12 mt-4">
                            <label class="form-label fw-bold small d-block mb-2">
                                <i class="bi bi-cloud-arrow-up-fill text-success me-1"></i> Upload Foto Kartu Pimpinan (Kapasitas Lapang Maks. 20 MB per Foto)
                            </label>
                            <div id="dropzoneBox"
                                 class="w-100 text-center p-4 p-md-5 rounded-4 position-relative"
                                 style="border: 2px dashed #046B26; background: #f4faf6; cursor: pointer; transition: all 0.2s ease;"
                                 onclick="document.getElementById('multiPhotoInput').click()">
                                <input type="file"
                                       name="foto[]"
                                       id="multiPhotoInput"
                                       class="d-none"
                                       accept="image/jpeg,image/png,image/webp"
                                       multiple
                                       onclick="event.stopPropagation()">
                                <div class="mx-auto mb-3 rounded-circle d-inline-flex align-items-center justify-content-center"
                                     style="width: 68px; height: 68px; background: #e3f3e8; color: #046B26; font-size: 30px;">
                                    <i class="bi bi-cloud-arrow-up-fill"></i>
                                </div>
                                <h6 class="fw-bold text-dark mb-1" style="font-size: 16px;">
                                    Klik di Sini atau Tarik & Lepas Foto Pimpinan
                                </h6>
                                <p class="text-muted small mb-3">
                                    Mendukung pemilihan banyak foto sekaligus (Multi-Upload). Gambar akan ditampilkan penuh (fullwidth) tanpa terpotong.
                                </p>
                                <div class="d-inline-flex align-items-center gap-2 px-3 py-1.5 rounded-pill fw-semibold small"
                                     style="background: #046B26; color: #ffffff;">
                                    <i class="bi bi-check-circle-fill text-warning"></i>
                                    <span>Kapasitas Lapang: Maksimal 20 MB / Foto (PNG, JPG, WEBP)</span>
                                </div>
                            </div>

                            <div id="photoPreviewGrid" class="row g-3 mt-3 d-none"></div>
                        </div>
                    </div>
                </div>

                <div class="card-footer bg-light py-3 px-4 d-flex justify-content-between align-items-center" style="border-radius: 0 0 16px 16px;">
                    <a href="{{ route('struktur-organisasi.index') }}" class="btn btn-outline-secondary rounded-3 px-3">Batal</a>
                    <button type="submit" class="btn btn-success fw-bold px-4 py-2 rounded-3" style="background: #046B26; border-color: #046B26;">
                        <i class="bi bi-save me-1"></i> Simpan Profil Pimpinan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const fileInput = document.getElementById('multiPhotoInput');
    const previewGrid = document.getElementById('photoPreviewGrid');
    const dropzoneBox = document.getElementById('dropzoneBox');
    const MAX_BYTES = 20 * 1024 * 1024; // 20 MB
    let selectedFiles = new DataTransfer();

    function addFiles(filesList) {
        Array.from(filesList).forEach(file => {
            if (file.size > MAX_BYTES) {
                alert('Ukuran file "' + file.name + '" melebihi batas maksimal 20 MB.');
                return;
            }
            selectedFiles.items.add(file);
        });
        fileInput.files = selectedFiles.files;
        renderPreviews();
    }

    if (fileInput && previewGrid) {
        fileInput.addEventListener('change', function () {
            addFiles(this.files);
        });
    }

    if (dropzoneBox) {
        ['dragenter', 'dragover'].forEach(evt => {
            dropzoneBox.addEventListener(evt, function (e) {
                e.preventDefault();
                e.stopPropagation();
                this.style.background = '#e4f4ea';
                this.style.borderColor = '#024d1a';
            });
        });
        ['dragleave', 'drop'].forEach(evt => {
            dropzoneBox.addEventListener(evt, function (e) {
                e.preventDefault();
                e.stopPropagation();
                this.style.background = '#f4faf6';
                this.style.borderColor = '#046B26';
            });
        });
        dropzoneBox.addEventListener('drop', function (e) {
            if (e.dataTransfer && e.dataTransfer.files.length > 0) {
                addFiles(e.dataTransfer.files);
            }
        });
    }

    function renderPreviews() {
        previewGrid.innerHTML = '';
        if (selectedFiles.files.length === 0) {
            previewGrid.classList.add('d-none');
            return;
        }
        previewGrid.classList.remove('d-none');

        const count = selectedFiles.files.length;
        const colClass = count === 1 ? 'col-12' : 'col-12 col-md-6 col-lg-4';

        Array.from(selectedFiles.files).forEach((file, idx) => {
            const url = URL.createObjectURL(file);
            const sizeMb = (file.size / (1024 * 1024)).toFixed(2);
            const col = document.createElement('div');
            col.className = colClass;
            col.innerHTML = `
                <div class="border rounded-4 p-3 position-relative bg-white shadow-sm h-100">
                    <div class="text-center bg-light rounded-3 p-3 border mb-2">
                        <img src="${url}" class="img-fluid rounded-2" style="width: 100%; max-height: 480px; height: auto; object-fit: contain;">
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <div>
                            <span class="badge ${idx === 0 ? 'bg-success' : 'bg-secondary'} me-1">
                                ${idx === 0 ? 'Foto Utama' : 'Foto #' + (idx + 1)}
                            </span>
                            <span class="text-muted small">${sizeMb} MB</span>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-danger rounded-3 px-2" data-remove-idx="${idx}">
                            <i class="bi bi-trash me-1"></i>Batal
                        </button>
                    </div>
                </div>
            `;
            previewGrid.appendChild(col);
        });

        previewGrid.querySelectorAll('[data-remove-idx]').forEach(btn => {
            btn.addEventListener('click', function () {
                const rmIdx = parseInt(this.getAttribute('data-remove-idx'), 10);
                const nextDt = new DataTransfer();
                Array.from(selectedFiles.files).forEach((f, i) => {
                    if (i !== rmIdx) nextDt.items.add(f);
                });
                selectedFiles = nextDt;
                fileInput.files = selectedFiles.files;
                renderPreviews();
            });
        });
    }
});
</script>
@endpush
