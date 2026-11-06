@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
    <div>
        <h1 class="mb-1">Edit Profil Pimpinan: {{ $pimpinan->nama }}</h1>
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('struktur-organisasi.index') }}">Profil dan Struktur Pimpinan</a></li>
                <li class="breadcrumb-item active">{{ $pimpinan->nama }}</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('homepage.pimpinan.detail', $pimpinan->slug) }}" target="_blank" class="btn btn-outline-success rounded-3 px-3">
            <i class="bi bi-box-arrow-up-right me-1"></i> Lihat Halaman Detail
        </a>
        <a href="{{ route('struktur-organisasi.index') }}" class="btn btn-outline-secondary rounded-3 px-3">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>

{{-- Quick Switcher Antar Pimpinan --}}
<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body py-2.5 px-3">
        <div class="d-flex align-items-center gap-2 overflow-auto py-1">
            <span class="small fw-bold text-muted text-nowrap me-1"><i class="bi bi-arrow-left-right me-1"></i>Pilih Pimpinan:</span>
            @foreach($allPimpinans as $item)
                <a href="{{ route('struktur-organisasi.edit', $item->id) }}"
                   class="btn btn-sm rounded-pill text-nowrap {{ $item->id === $pimpinan->id ? 'btn-success text-white fw-bold' : 'btn-light text-dark border' }}"
                   style="{{ $item->id === $pimpinan->id ? 'background: #046B26; border-color: #046B26;' : '' }}">
                    {{ $item->nama }}
                </a>
            @endforeach
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 col-xl-10">
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

        <form action="{{ route('struktur-organisasi.update', $pimpinan->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

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
                            <input type="text" name="nama" class="form-control" value="{{ old('nama', $pimpinan->nama) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Jabatan <span class="text-danger">*</span></label>
                            <input type="text" name="jabatan" class="form-control" value="{{ old('jabatan', $pimpinan->jabatan) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Posisi Baris Kartu <span class="text-danger">*</span></label>
                            <select name="baris" class="form-select" required>
                                <option value="1" {{ (int) old('baris', $pimpinan->baris) === 1 ? 'selected' : '' }}>Baris 1 — Ketua Yayasan & Rektor (2 Kolom)</option>
                                <option value="2" {{ (int) old('baris', $pimpinan->baris) === 2 ? 'selected' : '' }}>Baris 2 — Jajaran Wakil Rektor (3 Kolom)</option>
                                <option value="3" {{ (int) old('baris', $pimpinan->baris) === 3 ? 'selected' : '' }}>Baris 3 — Jajaran Dekan Fakultas (3 Kolom)</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-bold small">Urutan Tampil</label>
                            <input type="number" name="urutan" class="form-control" value="{{ old('urutan', $pimpinan->urutan) }}" min="1">
                        </div>

                        <div class="col-md-3 d-flex align-items-end">
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" name="is_active" id="isActive" value="1" {{ old('is_active', $pimpinan->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold small" for="isActive">Tampilkan (Aktif)</label>
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold small">
                                Profil Lengkap / Biografi & Arah Pengembangan (Ditampilkan pada Halaman Detail Pimpinan)
                            </label>
                            <textarea name="biografi" rows="12" class="form-control">{{ old('biografi', $pimpinan->biografi) }}</textarea>
                            <div class="form-text">Gunakan baris baru (Enter 2x) untuk memisahkan antar paragraf atau subjudul.</div>
                        </div>

                        <div class="col-12 mt-3">
                            @php
                                $existingPhotos = $pimpinan->all_photos;
                            @endphp
                            @if(count($existingPhotos) > 0)
                                <label class="form-label fw-bold small d-block mb-2">Foto Saat Ini ({{ count($existingPhotos) }} Foto)</label>
                                <div class="row g-3 mb-3">
                                    @foreach($existingPhotos as $idx => $photoPath)
                                        @php
                                            $photoUrl = str_starts_with($photoPath, 'http') ? $photoPath : (str_starts_with($photoPath, 'assets/') ? asset($photoPath) : asset('storage/' . $photoPath));
                                        @endphp
                                        <div class="col-6 col-md-3">
                                            <div class="border rounded-3 p-2 bg-light h-100 d-flex flex-column justify-content-between">
                                                <img src="{{ $photoUrl }}" alt="Foto Pimpinan" class="w-100 rounded-2 mb-2" style="height: 175px; object-fit: cover;">
                                                <div class="d-flex flex-column gap-1">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="main_photo" id="main_photo_{{ $idx }}" value="{{ $photoPath }}" {{ $idx === 0 ? 'checked' : '' }}>
                                                        <label class="form-check-label small fw-semibold" for="main_photo_{{ $idx }}">Foto Utama</label>
                                                    </div>
                                                    @if(count($existingPhotos) > 1)
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="delete_photos[]" id="del_photo_{{ $idx }}" value="{{ $photoPath }}">
                                                            <label class="form-check-label small text-danger" for="del_photo_{{ $idx }}">Hapus Foto</label>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <label class="form-label fw-bold small">Ganti / Tambah Foto Baru (Bisa Pilih Lebih dari 1 Foto)</label>
                            <input type="file" name="foto[]" id="multiPhotoInput" class="form-control" accept="image/jpeg,image/png,image/webp" multiple>
                            <div class="form-text">Maksimal 20 MB per foto (PNG, JPG, WEBP).</div>
                            <div id="photoPreviewGrid" class="row g-3 mt-2 d-none"></div>
                        </div>
                    </div>
                </div>

                <div class="card-footer bg-light py-3 px-4 d-flex justify-content-between align-items-center" style="border-radius: 0 0 16px 16px;">
                    <a href="{{ route('struktur-organisasi.index') }}" class="btn btn-outline-secondary rounded-3 px-3">Batal</a>
                    <button type="submit" class="btn btn-success fw-bold px-4 py-2 rounded-3" style="background: #046B26; border-color: #046B26;">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan
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
    let selectedFiles = new DataTransfer();

    if (fileInput && previewGrid) {
        fileInput.addEventListener('change', function () {
            Array.from(this.files).forEach(file => selectedFiles.items.add(file));
            this.files = selectedFiles.files;
            renderPreviews();
        });
    }

    function renderPreviews() {
        previewGrid.innerHTML = '';
        if (selectedFiles.files.length === 0) {
            previewGrid.classList.add('d-none');
            return;
        }
        previewGrid.classList.remove('d-none');

        Array.from(selectedFiles.files).forEach((file, idx) => {
            const url = URL.createObjectURL(file);
            const col = document.createElement('div');
            col.className = 'col-6 col-md-3';
            col.innerHTML = `
                <div class="border rounded-3 p-2 position-relative bg-white shadow-xs">
                    <img src="${url}" class="w-100 rounded-2" style="height: 150px; object-fit: cover;">
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <span class="badge bg-success" style="font-size: 10px;">Foto Baru #${idx + 1}</span>
                        <button type="button" class="btn btn-sm btn-outline-danger py-0 px-1" data-remove-idx="${idx}">
                            <i class="bi bi-x-lg"></i>
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

