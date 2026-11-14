@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Tambah Mitra Kerjasama</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('partner.index') }}">Mitra Kerjasama</a></li>
            <li class="breadcrumb-item active">Tambah</li>
        </ol>
    </nav>
</div>

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

<form action="{{ route('partner.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="row g-4">
        {{-- KOLOM KIRI: DATA MITRA KERJASAMA --}}
        <div class="col-lg-5">
            <div class="card shadow-sm h-100 mb-0">
                <div class="card-header py-3 bg-white border-bottom">
                    <h5 class="mb-0 fw-semibold text-dark">
                        <i class="bi bi-building text-success me-2"></i>1. Tambah Mitra Kerjasama
                    </h5>
                    <small class="text-muted">Informasi identitas instansi atau perusahaan mitra.</small>
                </div>
                <div class="card-body pt-3 d-flex flex-column justify-content-between">
                    <div>
                        <div class="mb-3">
                            <label for="nama" class="form-label fw-semibold">Nama Mitra Kerjasama <span class="text-danger">*</span></label>
                            <input type="text" id="nama" name="nama"
                                   class="form-control @error('nama') is-invalid @enderror"
                                   value="{{ old('nama') }}" required
                                   placeholder="Contoh: PT Hutama Karya (Persero)">
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="logo" class="form-label fw-semibold">
                                Logo Mitra
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
                                Format: JPG, PNG, WebP, SVG. Maksimal 20 MB.
                            </div>
                            @error('logo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <div id="previewWrap" class="mt-3 d-none">
                                <p class="small text-muted mb-1">Preview Logo:</p>
                                <img id="previewImg" src="" alt="Preview"
                                     style="max-width:200px;max-height:110px;object-fit:contain;border-radius:8px;border:1px solid #dee2e6;padding:4px;background:#f8fafc">
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-sm-5">
                                <label for="urutan" class="form-label fw-semibold">Urutan Tampil</label>
                                <input type="number" id="urutan" name="urutan"
                                       class="form-control @error('urutan') is-invalid @enderror"
                                       value="{{ old('urutan', 0) }}" min="0">
                                @error('urutan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-sm-7 d-flex align-items-center" style="padding-top:28px">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="aktif" name="aktif" value="1"
                                           {{ old('aktif', true) ? 'checked' : '' }}>
                                    <label class="form-check-label fw-semibold" for="aktif">
                                        Aktifkan Mitra
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-light border small text-muted mb-0 mt-3">
                        <i class="bi bi-lightbulb text-warning me-1"></i>
                        Data mitra akan menjadi induk bagi dokumen perjanjian (MOU, MOA, IA).
                    </div>
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: TAMBAH PERJANJIAN KERJASAMA --}}
        <div class="col-lg-7">
            <div class="card shadow-sm h-100 mb-0">
                <div class="card-header py-3 bg-white border-bottom d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0 fw-semibold text-dark">
                            <i class="bi bi-file-earmark-text text-success me-2"></i>2. Tambah Perjanjian Kerjasama
                        </h5>
                        <small class="text-muted">Sertakan dokumen perjanjian (MOU / MOA / IA) untuk mitra ini.</small>
                    </div>
                    <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">
                        Langsung Terhubung
                    </span>
                </div>
                <div class="card-body pt-3">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="perjanjian_jenis" class="form-label fw-semibold">Jenis Kerjasama <span class="text-danger">*</span></label>
                            <select id="perjanjian_jenis" name="perjanjian_jenis" class="form-select @error('perjanjian_jenis') is-invalid @enderror">
                                @foreach(\App\Models\PartnerAgreement::TYPES as $type)
                                    <option value="{{ $type }}" {{ old('perjanjian_jenis', 'MOU') === $type ? 'selected' : '' }}>{{ $type }}</option>
                                @endforeach
                            </select>
                            @error('perjanjian_jenis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-8">
                            <label for="perjanjian_nomor" class="form-label fw-semibold">Nomor Dokumen / Perjanjian</label>
                            <input id="perjanjian_nomor" name="perjanjian_nomor"
                                   class="form-control @error('perjanjian_nomor') is-invalid @enderror"
                                   value="{{ old('perjanjian_nomor') }}" maxlength="255"
                                   placeholder="Contoh: 042/MOU/UIS-HK/2026">
                            @error('perjanjian_nomor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="perjanjian_judul" class="form-label fw-semibold">Judul Kerjasama / Program</label>
                            <textarea id="perjanjian_judul" name="perjanjian_judul" rows="3"
                                      class="form-control @error('perjanjian_judul') is-invalid @enderror"
                                      placeholder="Contoh: Nota Kesepahaman tentang Penyelenggaraan Pendidikan, Riset, Pengabdian Kepada Masyarakat dan Magang Industri">{{ old('perjanjian_judul') }}</textarea>
                            <div class="form-text">
                                <i class="bi bi-info-circle me-1"></i>Textarea otomatis aman untuk judul panjang. Kosongkan jika hanya ingin menyimpan mitra saja.
                            </div>
                            @error('perjanjian_judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="perjanjian_tanggal_mulai" class="form-label fw-semibold">Tanggal Mulai</label>
                            <input type="date" id="perjanjian_tanggal_mulai" name="perjanjian_tanggal_mulai"
                                   class="form-control @error('perjanjian_tanggal_mulai') is-invalid @enderror"
                                   value="{{ old('perjanjian_tanggal_mulai') }}">
                            @error('perjanjian_tanggal_mulai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="perjanjian_tanggal_selesai" class="form-label fw-semibold">Tanggal Selesai</label>
                            <input type="date" id="perjanjian_tanggal_selesai" name="perjanjian_tanggal_selesai"
                                   class="form-control @error('perjanjian_tanggal_selesai') is-invalid @enderror"
                                   value="{{ old('perjanjian_tanggal_selesai') }}">
                            @error('perjanjian_tanggal_selesai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="perjanjian_deskripsi" class="form-label fw-semibold">Ruang Lingkup / Keterangan Kerjasama</label>
                            <textarea id="perjanjian_deskripsi" name="perjanjian_deskripsi" rows="3"
                                      class="form-control @error('perjanjian_deskripsi') is-invalid @enderror"
                                      placeholder="Jelaskan bidang atau ruang lingkup kerjasama yang dijalankan...">{{ old('perjanjian_deskripsi') }}</textarea>
                            @error('perjanjian_deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <div class="form-check form-switch mt-1">
                                <input class="form-check-input" type="checkbox" id="perjanjian_aktif" name="perjanjian_aktif" value="1"
                                       {{ old('perjanjian_aktif', true) ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="perjanjian_aktif">
                                    Publikasikan Perjanjian di Daftar Tabel Kerjasama
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- TOMBOL AKSI BAWAH --}}
        <div class="col-12">
            <div class="card shadow-sm border-0 bg-white p-3">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <a href="{{ route('partner.index') }}" class="btn btn-secondary px-3">
                        <i class="bi bi-arrow-left me-1"></i> Batal / Kembali
                    </a>
                    <button type="submit" class="btn btn-success px-4 py-2 fw-semibold">
                        <i class="bi bi-check-circle-fill me-1"></i> Simpan Data Mitra & Perjanjian
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
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
