@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Tambah Organisasi Mahasiswa</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('organisasi-mahasiswa.index') }}">Organisasi Mahasiswa</a></li>
            <li class="breadcrumb-item active">Tambah</li>
        </ol>
    </nav>
</div>

<div class="card shadow-sm">
    <div class="card-header py-3">
        <h5 class="mb-0 fw-semibold text-dark">
            <i class="bi bi-people-fill me-2 text-primary"></i>Formulir Tambah Organisasi Mahasiswa
        </h5>
    </div>
    <div class="card-body pt-4">
        <form action="{{ route('organisasi-mahasiswa.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row g-3">
                {{-- Section 1: Data Pokok Organisasi --}}
                <div class="col-12">
                    <h6 class="fw-bold text-dark border-bottom pb-2 mb-2">
                        <i class="bi bi-info-circle-fill me-1 text-primary"></i>1. Identitas Organisasi
                    </h6>
                </div>

                <div class="col-md-8">
                    <label for="nama_organisasi" class="form-label fw-semibold text-dark">Nama Lengkap Organisasi <span class="text-danger">*</span></label>
                    <input type="text" name="nama_organisasi" id="nama_organisasi" class="form-control @error('nama_organisasi') is-invalid @enderror" placeholder="Contoh: Badan Eksekutif Mahasiswa (BEM) / HIMA Informatika" value="{{ old('nama_organisasi') }}" required>
                    @error('nama_organisasi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="singkatan" class="form-label fw-semibold text-dark">Singkatan / Akronim</label>
                    <input type="text" name="singkatan" id="singkatan" class="form-control @error('singkatan') is-invalid @enderror" placeholder="Contoh: BEM UIS / HMTI" value="{{ old('singkatan') }}">
                    @error('singkatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="kategori" class="form-label fw-semibold text-dark">Kategori Lembaga <span class="text-danger">*</span></label>
                    <select name="kategori" id="kategori" class="form-select @error('kategori') is-invalid @enderror" required>
                        <option value="BEM / DPM" {{ old('kategori') == 'BEM / DPM' ? 'selected' : '' }}>BEM / DPM Fakultas</option>
                        <option value="Himpunan Mahasiswa (HIMA)" {{ old('kategori', 'Himpunan Mahasiswa (HIMA)') == 'Himpunan Mahasiswa (HIMA)' ? 'selected' : '' }}>Himpunan Mahasiswa Program Studi (HIMA)</option>
                        <option value="Unit Kegiatan Mahasiswa (UKM)" {{ old('kategori') == 'Unit Kegiatan Mahasiswa (UKM)' ? 'selected' : '' }}>Unit Kegiatan Mahasiswa (UKM)</option>
                        <option value="Komunitas Minat Bakat" {{ old('kategori') == 'Komunitas Minat Bakat' ? 'selected' : '' }}>Komunitas Minat & Bakat</option>
                    </select>
                    @error('kategori')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="periode" class="form-label fw-semibold text-dark">Periode Kepengurusan</label>
                    <input type="text" name="periode" id="periode" class="form-control @error('periode') is-invalid @enderror" placeholder="Contoh: 2025/2026" value="{{ old('periode', '2025/2026') }}">
                    @error('periode')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Section 2: Logo & Foto Kegiatan --}}
                <div class="col-12 mt-4">
                    <h6 class="fw-bold text-dark border-bottom pb-2 mb-2">
                        <i class="bi bi-image-fill me-1 text-warning"></i>2. Logo & Foto Kegiatan
                    </h6>
                </div>

                <div class="col-md-6">
                    <label for="logo" class="form-label fw-semibold text-dark">Logo Organisasi</label>
                    <input type="file" name="logo" id="logo" class="form-control @error('logo') is-invalid @enderror" accept="image/*">
                    <small class="text-muted">Format: JPG, PNG, WEBP, SVG (Maks. 20 MB). Disarankan berlatar transparan.</small>
                    @error('logo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="foto_kegiatan" class="form-label fw-semibold text-dark">Foto Dokumentasi / Banner Kegiatan</label>
                    <input type="file" name="foto_kegiatan" id="foto_kegiatan" class="form-control @error('foto_kegiatan') is-invalid @enderror" accept="image/*">
                    <small class="text-muted">Format: JPG, PNG, WEBP (Maks. 20 MB). Foto bersama pengurus / kegiatan unggulan.</small>
                    @error('foto_kegiatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Section 3: Profil & Deskripsi (TinyMCE) --}}
                <div class="col-12 mt-4">
                    <h6 class="fw-bold text-dark border-bottom pb-2 mb-2">
                        <i class="bi bi-card-text me-1 text-success"></i>3. Deskripsi & Profil Organisasi
                    </h6>
                </div>

                <div class="col-12">
                    <label for="deskripsi" class="form-label fw-semibold text-dark">Profil & Deskripsi Lengkap</label>
                    <textarea name="deskripsi" id="deskripsi" rows="6" class="form-control tinymce-editor @error('deskripsi') is-invalid @enderror" placeholder="Tuliskan latar belakang, tujuan, dan program kerja utama organisasi...">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="visi" class="form-label fw-semibold text-dark">Visi Organisasi</label>
                    <textarea name="visi" id="visi" rows="3" class="form-control @error('visi') is-invalid @enderror" placeholder="Tuliskan visi organisasi...">{{ old('visi') }}</textarea>
                    @error('visi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="misi" class="form-label fw-semibold text-dark">Misi Organisasi</label>
                    <textarea name="misi" id="misi" rows="3" class="form-control @error('misi') is-invalid @enderror" placeholder="Tuliskan butir-butir misi organisasi...">{{ old('misi') }}</textarea>
                    @error('misi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Section 4: Susunan Pengurus & Kontak --}}
                <div class="col-12 mt-4">
                    <h6 class="fw-bold text-dark border-bottom pb-2 mb-2">
                        <i class="bi bi-person-badge-fill me-1 text-info"></i>4. Struktur Pengurus & Tautan
                    </h6>
                </div>

                <div class="col-md-4">
                    <label for="nama_ketua" class="form-label fw-semibold text-dark">Nama Ketua Organisasi</label>
                    <input type="text" name="nama_ketua" id="nama_ketua" class="form-control @error('nama_ketua') is-invalid @enderror" placeholder="Nama Ketua" value="{{ old('nama_ketua') }}">
                    @error('nama_ketua')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="nama_wakil" class="form-label fw-semibold text-dark">Nama Wakil Ketua</label>
                    <input type="text" name="nama_wakil" id="nama_wakil" class="form-control @error('nama_wakil') is-invalid @enderror" placeholder="Nama Wakil" value="{{ old('nama_wakil') }}">
                    @error('nama_wakil')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="pembina" class="form-label fw-semibold text-dark">Dosen Pembina Organisasi</label>
                    <input type="text" name="pembina" id="pembina" class="form-control @error('pembina') is-invalid @enderror" placeholder="Nama Dosen Pembina" value="{{ old('pembina') }}">
                    @error('pembina')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="instagram" class="form-label fw-semibold text-dark"><i class="bi bi-instagram text-danger me-1"></i> Akun Instagram</label>
                    <input type="url" name="instagram" id="instagram" class="form-control @error('instagram') is-invalid @enderror" placeholder="https://instagram.com/..." value="{{ old('instagram') }}">
                    @error('instagram')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="email" class="form-label fw-semibold text-dark"><i class="bi bi-envelope text-primary me-1"></i> Email Organisasi</label>
                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="organisasi@uis.ac.id" value="{{ old('email') }}">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="link_pendaftaran" class="form-label fw-semibold text-dark"><i class="bi bi-box-arrow-up-right text-success me-1"></i> Link Pendaftaran / Oprec</label>
                    <input type="url" name="link_pendaftaran" id="link_pendaftaran" class="form-control @error('link_pendaftaran') is-invalid @enderror" placeholder="https://bit.ly/..." value="{{ old('link_pendaftaran') }}">
                    @error('link_pendaftaran')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="urutan" class="form-label fw-semibold text-dark">Urutan Tampil</label>
                    <input type="number" name="urutan" id="urutan" class="form-control @error('urutan') is-invalid @enderror" placeholder="0" value="{{ old('urutan', 0) }}" min="0">
                    @error('urutan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Status Aktif --}}
                <div class="col-md-6 d-flex align-items-center mt-md-4 pt-md-3">
                    <div class="form-check form-switch p-2 bg-light rounded-3 border w-100 d-flex align-items-center gap-3">
                        <input class="form-check-input ms-0" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }} style="cursor: pointer;">
                        <label class="form-check-label fw-semibold text-dark" for="is_active" style="cursor: pointer;">
                            Tampilkan di Website Frontend
                        </label>
                    </div>
                </div>
            </div>

            <div class="mt-4 pt-3 border-top d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-save me-1"></i> Simpan Organisasi
                </button>
                <a href="{{ route('organisasi-mahasiswa.index') }}" class="btn btn-secondary px-4">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
