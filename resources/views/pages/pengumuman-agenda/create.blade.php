@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
    <div>
        <h1>Tambah {{ ($defaultTipe ?? 'pengumuman') === 'agenda' ? 'Agenda Akademik' : 'Pengumuman Resmi' }}</h1>
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('pengumuman-agenda.index') }}">Pengumuman & Agenda</a></li>
                <li class="breadcrumb-item active">Tambah Baru</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('pengumuman-agenda.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
    </a>
</div>

<div class="row">
    <div class="col-lg-9 col-md-11">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-plus-circle-fill me-2 text-success"></i>Form Tambah Pengumuman / Agenda & Halaman Detail
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

                <form action="{{ route('pengumuman-agenda.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Jenis Informasi <span class="text-danger">*</span></label>
                            <select name="tipe" class="form-select" required>
                                <option value="pengumuman" {{ old('tipe', $defaultTipe ?? 'pengumuman') === 'pengumuman' ? 'selected' : '' }}>
                                    Pengumuman Resmi
                                </option>
                                <option value="agenda" {{ old('tipe', $defaultTipe ?? '') === 'agenda' ? 'selected' : '' }}>
                                    Agenda Akademik / Kampus
                                </option>
                            </select>
                        </div>

                        <div class="col-md-5">
                            <label class="form-label fw-semibold">Tanggal / Rentang Waktu <span class="text-danger">*</span></label>
                            <input type="text"
                                   name="waktu"
                                   class="form-control @error('waktu') is-invalid @enderror"
                                   value="{{ old('waktu') }}"
                                   required
                                   placeholder="Contoh: 15 Agustus 2026 atau 20 - 31 Juli 2026">
                            @error('waktu')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Urutan Tampil</label>
                            <input type="number" name="urutan" class="form-control" value="{{ old('urutan', $nextUrutan ?? 1) }}" min="0">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Judul Pengumuman / Agenda <span class="text-danger">*</span></label>
                        <input type="text"
                               name="judul"
                               class="form-control @error('judul') is-invalid @enderror"
                               value="{{ old('judul') }}"
                               required
                               placeholder="Contoh: Pengumuman Pengisian KRS dan Validasi KRS Tahun Akademik 2026/2027 Gasal">
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Lokasi / Unit Penerbit (Opsional)</label>
                            <input type="text"
                                   name="lokasi"
                                   class="form-control"
                                   value="{{ old('lokasi', 'Bagian Akademik & Portal SIAKAD UIS') }}"
                                   placeholder="Contoh: Auditorium Kampus UIS / Portal SIAKAD">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Tautan Eksternal / Link Pendaftaran (Opsional)</label>
                            <input type="text"
                                   name="url"
                                   class="form-control"
                                   value="{{ old('url') }}"
                                   placeholder="https://... (kosongkan jika tidak ada)">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Isi Lengkap Halaman Detail Pengumuman / Agenda</label>
                        <textarea name="konten"
                                  rows="7"
                                  class="form-control tinymce-editor"
                                  placeholder="Tuliskan rincian lengkap pengumuman atau jadwal kegiatan agenda di sini...">{{ old('konten') }}</textarea>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-7">
                            <label class="form-label fw-semibold small">
                                Upload Foto / Poster / Galeri <span class="badge bg-primary ms-1">Bisa Pilih Banyak Foto</span>
                            </label>
                            <div class="border border-2 border-dashed rounded-3 p-3 text-center bg-light bg-opacity-50" style="border-color: #cbd5e1 !important;">
                                <i class="bi bi-images text-primary fs-3 d-block mb-1"></i>
                                <div class="small fw-semibold text-dark mb-1">Pilih 1 atau Lebih Foto / Poster</div>
                                <div class="text-muted mb-2" style="font-size: 11.5px;">Maksimal 20 MB per foto (JPG, PNG, WEBP).</div>
                                <input type="file"
                                       id="paMultiFotoInput"
                                       name="foto[]"
                                       class="form-control form-control-sm mx-auto"
                                       accept="image/*"
                                       multiple
                                       onchange="handlePaMultiFiles(this)">
                            </div>
                            <div id="paMultiPreviewGrid" class="row g-2 mt-2 d-none"></div>
                        </div>

                        <div class="col-md-5">
                            <label class="form-label fw-semibold small">
                                File Lampiran Resmi / Surat Edaran (PDF / Dokumen)
                            </label>
                            <div class="border border-2 border-dashed rounded-3 p-3 text-center bg-light bg-opacity-50 h-100 d-flex flex-column justify-content-center" style="border-color: #cbd5e1 !important;">
                                <i class="bi bi-file-earmark-pdf text-danger fs-3 d-block mb-1"></i>
                                <div class="small fw-semibold text-dark mb-1">Upload Dokumen Lampiran (Opsional)</div>
                                <div class="text-muted mb-2" style="font-size: 11.5px;">Format PDF, DOC, DOCX, XLS, ZIP (Maks. 100 MB).</div>
                                <input type="file"
                                       name="file_lampiran"
                                       class="form-control form-control-sm"
                                       accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.zip,.rar,.jpg,.jpeg,.png">
                            </div>
                        </div>
                    </div>

                    <div class="form-check form-switch mb-4">
                        <input class="form-check-input" type="checkbox" name="is_active" id="isActiveSwitch" value="1" {{ old('is_active', 1) ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold" for="isActiveSwitch">Tampilkan (Aktif) di Website</label>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('pengumuman-agenda.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-success px-4">
                            <i class="bi bi-save me-1"></i> Simpan Data
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
    let paSelectedFiles = new DataTransfer();
    function handlePaMultiFiles(input) {
        if (input.files && input.files.length > 0) {
            Array.from(input.files).forEach(file => paSelectedFiles.items.add(file));
            input.files = paSelectedFiles.files;
        }
        renderPaMultiPreview();
    }
    function removePaMultiFile(index) {
        const dt = new DataTransfer();
        Array.from(paSelectedFiles.files).forEach((file, i) => {
            if (i !== index) dt.items.add(file);
        });
        paSelectedFiles = dt;
        document.getElementById('paMultiFotoInput').files = paSelectedFiles.files;
        renderPaMultiPreview();
    }
    function renderPaMultiPreview() {
        const grid = document.getElementById('paMultiPreviewGrid');
        grid.innerHTML = '';
        const files = Array.from(paSelectedFiles.files);
        if (files.length === 0) {
            grid.classList.add('d-none');
            return;
        }
        grid.classList.remove('d-none');
        files.forEach((file, idx) => {
            const url = URL.createObjectURL(file);
            const col = document.createElement('div');
            col.className = 'col-6 col-sm-4';
            col.innerHTML = `
                <div class="position-relative border rounded-3 overflow-hidden bg-white shadow-sm">
                    <img src="${url}" style="width:100%;height:85px;object-fit:cover;">
                    <span class="badge ${idx === 0 ? 'bg-success' : 'bg-dark'} position-absolute top-0 start-0 m-1" style="font-size:9.5px;">
                        ${idx === 0 ? 'Sampul' : '#' + (idx + 1)}
                    </span>
                    <button type="button" onclick="removePaMultiFile(${idx})" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1 p-0 d-flex align-items-center justify-content-center rounded-circle" style="width:20px;height:20px;font-size:11px;">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
            `;
            grid.appendChild(col);
        });
    }
</script>
@endpush

