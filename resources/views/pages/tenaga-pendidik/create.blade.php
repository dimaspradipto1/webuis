@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Tambah Tenaga Pendidik</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('tenaga-pendidik.index') }}">Tenaga Pendidik</a></li>
            <li class="breadcrumb-item active">Tambah</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-8 col-md-10">
        <div class="card shadow-sm">
            <div class="card-header py-3">
                <h5 class="mb-0 fw-semibold">
                    <i class="bi bi-person-plus-fill me-2 text-primary"></i>Form Tambah Card Tenaga Pendidik
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

                <form action="{{ route('tenaga-pendidik.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Nama / Kelompok Dosen --}}
                    <div class="mb-3">
                        <label for="nama" class="form-label fw-semibold">
                            Nama / Kelompok Bidang Dosen <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               id="nama"
                               name="nama"
                               class="form-control @error('nama') is-invalid @enderror"
                               value="{{ old('nama') }}"
                               placeholder="Contoh: Dosen Bidang K3 / Dosen Higiene Industri">
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Spesialisasi / Bidang --}}
                    <div class="mb-3">
                        <label for="bidang" class="form-label fw-semibold">
                            Spesialisasi / Keahlian
                        </label>
                        <input type="text"
                               id="bidang"
                               name="bidang"
                               class="form-control @error('bidang') is-invalid @enderror"
                               value="{{ old('bidang') }}"
                               placeholder="Contoh: Spesialis Ergonomi & SMK3 / Toksikologi & Bahaya Fisik">
                        @error('bidang')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Keterangan / Pengalaman / Publikasi --}}
                    <div class="mb-3">
                        <label for="keterangan" class="form-label fw-semibold">Deskripsi / Keterangan Singkat</label>
                        <textarea id="keterangan"
                                  name="keterangan"
                                  class="form-control @error('keterangan') is-invalid @enderror"
                                  rows="3"
                                  placeholder="Contoh: Ahli K3 Umum & Auditor ISO 45001 Kemnaker RI.">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Hubungkan ke Prodi & Custom Tombol --}}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="layanan_id" class="form-label fw-semibold">
                                Hubungkan ke Program Studi
                            </label>
                            <select name="layanan_id" id="layanan_id" class="form-select @error('layanan_id') is-invalid @enderror">
                                <option value="">-- Tanpa Filter Prodi (Semua Dosen) --</option>
                                @foreach($prodis as $prodi)
                                    <option value="{{ $prodi->id }}" {{ old('layanan_id') == $prodi->id ? 'selected' : '' }}>
                                        {{ $prodi->judul }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-text">Tombol di card akan otomatis membuka halaman dosen untuk prodi ini.</div>
                            @error('layanan_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="tombol_teks" class="form-label fw-semibold">Teks Tombol Arahkan</label>
                            <input type="text"
                                   id="tombol_teks"
                                   name="tombol_teks"
                                   class="form-control @error('tombol_teks') is-invalid @enderror"
                                   value="{{ old('tombol_teks', 'Lihat Dosen Prodi') }}"
                                   placeholder="Contoh: Lihat Dosen K3">
                            @error('tombol_teks')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Custom Link (Opsional) --}}
                    <div class="mb-3">
                        <label for="link" class="form-label fw-semibold">Custom URL Link <span class="text-muted small fw-normal">(Opsional)</span></label>
                        <input type="text"
                               id="link"
                               name="link"
                               class="form-control @error('link') is-invalid @enderror"
                               value="{{ old('link') }}"
                               placeholder="Biarkan kosong jika ingin menggunakan link prodi otomatis di atas">
                        @error('link')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Foto Profil / Icon Avatar --}}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="foto" class="form-label fw-semibold">Upload Foto <span class="text-muted small fw-normal">(Opsional)</span></label>
                            <input type="file"
                                   id="foto"
                                   name="foto"
                                   class="form-control @error('foto') is-invalid @enderror"
                                   accept="image/*">
                            <div class="form-text">Jika diisi, foto ini akan menggantikan icon default. Format: JPG, PNG, WEBP (Maks. 20 MB).</div>
                            @error('foto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="icon" class="form-label fw-semibold">Icon Avatar Default</label>
                            <input type="text"
                                   id="icon"
                                   name="icon"
                                   class="form-control @error('icon') is-invalid @enderror"
                                   value="{{ old('icon', 'bi-person-fill') }}"
                                   placeholder="bi-person-fill">
                            @error('icon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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
                                   max="255">
                            <div class="form-text">Angka lebih kecil tampil lebih dulu.</div>
                            @error('urutan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Status Aktif --}}
                        <div class="col-sm-8 mb-3 d-flex align-items-center pt-sm-4">
                            <div class="form-check form-switch">
                                <input type="hidden" name="is_active" value="0">
                                <input class="form-check-input"
                                       type="checkbox"
                                       role="switch"
                                       id="is_active"
                                       name="is_active"
                                       value="1"
                                       {{ old('is_active', '1') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold ms-2" for="is_active">
                                    Aktifkan (Tampilkan di Beranda)
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="d-flex gap-2 justify-content-end pt-3 border-top mt-2">
                        <a href="{{ route('tenaga-pendidik.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Simpan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
