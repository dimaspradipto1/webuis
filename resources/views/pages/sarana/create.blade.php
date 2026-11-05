@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Tambah Sarana & Fasilitas</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('sarana.index') }}">Sarana & Fasilitas</a></li>
            <li class="breadcrumb-item active">Tambah</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-8 col-md-10">
        <div class="card shadow-sm">
            <div class="card-header py-3">
                <h5 class="mb-0 fw-semibold">
                    <i class="bi bi-plus-circle-fill me-2 text-primary"></i>Form Tambah Sarana
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

                <form action="{{ route('sarana.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        {{-- Icon --}}
                        <div class="col-md-7 mb-3">
                            <label for="icon" class="form-label fw-semibold">
                                Bootstrap Icon Class <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light" id="icon-preview-box" style="font-size:22px;color:#046B26;min-width:52px;justify-content:center;">
                                    <i class="bi bi-building"></i>
                                </span>
                                <input type="text"
                                       id="icon"
                                       name="icon"
                                       class="form-control @error('icon') is-invalid @enderror"
                                       value="{{ old('icon', 'bi-building') }}"
                                       placeholder="Contoh: bi-shield-check, bi-pc-display, bi-flask"
                                       oninput="updateIconPreview(this.value)">
                            </div>
                            <div class="form-text">
                                Ketik nama class icon Bootstrap (<a href="https://icons.getbootstrap.com/" target="_blank">icons.getbootstrap.com</a>).
                            </div>
                            @error('icon')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Kategori --}}
                        <div class="col-md-5 mb-3">
                            <label for="kategori" class="form-label fw-semibold">Kategori</label>
                            <select id="kategori" name="kategori" class="form-select">
                                <option value="Fasilitas Kampus" {{ old('kategori') === 'Fasilitas Kampus' ? 'selected' : '' }}>Fasilitas Kampus</option>
                                <option value="Laboratorium & Studio" {{ old('kategori') === 'Laboratorium & Studio' ? 'selected' : '' }}>Laboratorium & Studio</option>
                            </select>
                        </div>
                    </div>

                    {{-- Nama Sarana --}}
                    <div class="mb-3">
                        <label for="nama" class="form-label fw-semibold">
                            Nama Laboratorium / Fasilitas <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               id="nama"
                               name="nama"
                               class="form-control @error('nama') is-invalid @enderror"
                               value="{{ old('nama') }}"
                               placeholder="Contoh: Laboratorium Komputer, Jaringan & AI">
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Deskripsi Singkat (Kartu Beranda) --}}
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label fw-semibold">Ringkasan Singkat (Tampil di Kartu Beranda)</label>
                        <textarea id="deskripsi"
                                  name="deskripsi"
                                  class="form-control @error('deskripsi') is-invalid @enderror"
                                  rows="3"
                                  placeholder="Tuliskan ringkasan singkat 1-2 kalimat yang tampil di kartu beranda...">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Detail Halaman Fasilitas / Laboratorium --}}
                    <div class="p-3 rounded-3 border bg-light bg-opacity-50 mb-3">
                        <h6 class="fw-bold text-success mb-3">
                            <i class="bi bi-file-earmark-richtext me-1"></i> Pengaturan Halaman Detail Laboratorium / Fasilitas
                        </h6>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small">
                                Upload Foto Ruangan / Gedung / Galeri <span class="badge bg-primary ms-1">Bisa Pilih Banyak Foto Sekaligus</span>
                            </label>
                            <div class="border border-2 border-dashed rounded-3 p-3 text-center bg-white" style="border-color: #cbd5e1 !important;">
                                <i class="bi bi-images text-primary fs-2 d-block mb-1"></i>
                                <div class="fw-semibold small text-dark mb-1">Pilih 1 atau Lebih Foto Sekaligus</div>
                                <div class="text-muted mb-2" style="font-size: 12px;">
                                    Foto pertama otomatis menjadi sampul utama, dan seluruh foto akan tampil di galeri halaman detail. Maksimal 20 MB per foto (JPG, PNG, WEBP).
                                </div>
                                <input type="file"
                                       id="multiFotoInput"
                                       name="foto[]"
                                       class="form-control form-control-sm mx-auto"
                                       style="max-width: 420px;"
                                       accept="image/*"
                                       multiple
                                       onchange="handleMultiFiles(this)">
                            </div>
                            <div id="multiPreviewGrid" class="row g-2 mt-2 d-none"></div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">Lokasi Gedung / Lantai</label>
                                <input type="text" name="lokasi" class="form-control" value="{{ old('lokasi', 'Kampus Terpadu Universitas Ibnu Sina, Batam') }}" placeholder="Contoh: Gedung B Lantai 2">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">Kapasitas Ruang</label>
                                <input type="text" name="kapasitas" class="form-control" value="{{ old('kapasitas', '40 Mahasiswa / Sesi Praktikum') }}" placeholder="Contoh: 40 Mahasiswa">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">Jam Operasional</label>
                                <input type="text" name="jam_operasional" class="form-control" value="{{ old('jam_operasional', 'Senin – Sabtu, 08.00 – 21.00 WIB') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">Kepala Lab / Penanggung Jawab</label>
                                <input type="text" name="penanggung_jawab" class="form-control" value="{{ old('penanggung_jawab', 'Unit Pengelola Laboratorium & Sarana UIS') }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Deskripsi Lengkap Halaman Detail</label>
                            <textarea name="konten_detail" rows="5" class="form-control tinymce-editor" placeholder="Tuliskan penjelasan lengkap mengenai fungsi laboratorium/fasilitas, kegiatan praktikum, riset, dan layanan yang tersedia...">{{ old('konten_detail') }}</textarea>
                        </div>

                        <div class="mb-0">
                            <label class="form-label fw-semibold small">Spesifikasi / Peralatan / Fasilitas Pendukung (1 Poin per Baris)</label>
                            <textarea name="spesifikasi" rows="4" class="form-control" placeholder="Ruangan ber-AC penuh&#10;Koneksi internet serat optik berkecepatan tinggi&#10;Perangkat komputer spesifikasi tinggi">{{ old('spesifikasi', "Ruangan ber-AC penuh dan pencahayaan standar akademik\nKoneksi internet serat optik berkecepatan tinggi (Wi-Fi Kampus)\nPerangkat multimedia dan proyektor interaktif\nSistem keamanan CCTV 24 jam & prosedur K3 laboratorium") }}</textarea>
                        </div>
                    </div>

                    <div class="row">
                        {{-- Urutan --}}
                        <div class="col-sm-4 mb-3">
                            <label for="urutan" class="form-label fw-semibold">Urutan Tampil</label>
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

                        {{-- Status --}}
                        <div class="col-sm-4 mb-3">
                            <label class="form-label fw-semibold">Status Tampil</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input"
                                       type="checkbox"
                                       role="switch"
                                       id="is_active"
                                       name="is_active"
                                       value="1"
                                       {{ old('is_active', 1) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Tampilkan di website</label>
                            </div>
                        </div>
                    </div>

                    {{-- Tombol --}}
                    <div class="d-flex gap-2 mt-2">
                        <a href="{{ route('sarana.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Simpan Sarana
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    {{-- Preview Card --}}
    <div class="col-lg-4 col-md-10 mt-4 mt-lg-0">
        <div class="card shadow-sm border-0" style="background:#ffffff;">
            <div class="card-header bg-transparent border-0 pt-3">
                <h6 class="fw-bold mb-0"><i class="bi bi-eye me-1 text-primary"></i> Preview Frontend</h6>
                <small class="text-muted">Begini tampilan di website</small>
            </div>
            <div class="card-body pt-2">
                <div class="p-3 rounded-3 border bg-white shadow-sm">
                    <div id="prev-icon-wrap" style="width:50px;height:50px;border-radius:12px;background:rgba(4,107,38,.12);display:flex;align-items:center;justify-content:center;margin-bottom:14px;">
                        <i id="prev-icon" class="bi bi-building" style="font-size:24px;color:#046B26;"></i>
                    </div>
                    <div id="prev-nama" class="fw-bold mb-1" style="font-size:15px;">Nama Sarana</div>
                    <div id="prev-deskripsi" class="text-muted small" style="line-height:1.6;">Deskripsi sarana akan tampil di sini.</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function updateIconPreview(val) {
    const cleanVal = val.trim();
    const box = document.getElementById('icon-preview-box');
    const prevIcon = document.getElementById('prev-icon');
    const cls = cleanVal || 'bi-building';
    box.innerHTML = '<i class="bi ' + cls + '"></i>';
    prevIcon.className = 'bi ' + cls;
    prevIcon.style.fontSize = '24px';
    prevIcon.style.color = '#046B26';
}

document.addEventListener('DOMContentLoaded', function () {
    updateIconPreview(document.getElementById('icon').value);

    // Live preview nama
    document.getElementById('nama').addEventListener('input', function () {
        document.getElementById('prev-nama').textContent = this.value || 'Nama Sarana';
    });
    // Live preview deskripsi
    document.getElementById('deskripsi').addEventListener('input', function () {
        document.getElementById('prev-deskripsi').textContent = this.value || 'Deskripsi sarana akan tampil di sini.';
    });
});

let selectedMultiFiles = new DataTransfer();
function handleMultiFiles(input) {
    if (input.files && input.files.length > 0) {
        Array.from(input.files).forEach(file => selectedMultiFiles.items.add(file));
        input.files = selectedMultiFiles.files;
    }
    renderMultiPreview();
}
function removeMultiFile(index) {
    const dt = new DataTransfer();
    Array.from(selectedMultiFiles.files).forEach((file, i) => {
        if (i !== index) dt.items.add(file);
    });
    selectedMultiFiles = dt;
    document.getElementById('multiFotoInput').files = selectedMultiFiles.files;
    renderMultiPreview();
}
function renderMultiPreview() {
    const grid = document.getElementById('multiPreviewGrid');
    grid.innerHTML = '';
    const files = Array.from(selectedMultiFiles.files);
    if (files.length === 0) {
        grid.classList.add('d-none');
        return;
    }
    grid.classList.remove('d-none');
    files.forEach((file, idx) => {
        const url = URL.createObjectURL(file);
        const col = document.createElement('div');
        col.className = 'col-6 col-sm-4 col-md-3';
        col.innerHTML = `
            <div class="position-relative border rounded-3 overflow-hidden bg-white shadow-sm">
                <img src="${url}" style="width:100%;height:95px;object-fit:cover;">
                <span class="badge ${idx === 0 ? 'bg-success' : 'bg-dark bg-opacity-75'} position-absolute top-0 start-0 m-1" style="font-size:10px;">
                    ${idx === 0 ? 'Sampul Utama' : 'Foto #' + (idx + 1)}
                </span>
                <button type="button" onclick="removeMultiFile(${idx})" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1 p-0 d-flex align-items-center justify-content-center rounded-circle" style="width:22px;height:22px;font-size:12px;" title="Batal pilih">
                    <i class="bi bi-x"></i>
                </button>
            </div>
        `;
        grid.appendChild(col);
    });
}
</script>
@endpush
