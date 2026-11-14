@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Pengaturan Program Beasiswa</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Kemahasiswaan</li>
            <li class="breadcrumb-item active">Program Beasiswa</li>
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

<form action="{{ route('beasiswa.admin.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row g-4">
        {{-- KOLOM KIRI: HERO & STATUS --}}
        <div class="col-lg-6">
            <div class="card shadow-sm h-100">
                <div class="card-header py-3 bg-white border-bottom">
                    <h5 class="mb-0 fw-semibold text-dark">
                        <i class="bi bi-megaphone text-success me-2"></i>Informasi Hero & Status Beasiswa
                    </h5>
                    <small class="text-muted">Teks pembuka dan badge status di bagian paling atas halaman beasiswa.</small>
                </div>
                <div class="card-body pt-3">
                    <div class="mb-3">
                        <label for="hero_badge" class="form-label fw-semibold">Teks Badge Status</label>
                        <input type="text" id="hero_badge" name="hero_badge"
                               class="form-control @error('hero_badge') is-invalid @enderror"
                               value="{{ old('hero_badge', $beasiswa->hero_badge) }}"
                               placeholder="Contoh: PENDAFTARAN BEASISWA T.A. 2026/2027 TELAH DIBUKA">
                        @error('hero_badge')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="hero_judul" class="form-label fw-semibold">Judul Utama Hero <span class="text-danger">*</span></label>
                        <input type="text" id="hero_judul" name="hero_judul"
                               class="form-control @error('hero_judul') is-invalid @enderror"
                               value="{{ old('hero_judul', $beasiswa->hero_judul) }}" required
                               placeholder="Contoh: Raih Impian & Masa Depan Bersama Program Beasiswa Universitas Ibnu Sina">
                        @error('hero_judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="hero_deskripsi" class="form-label fw-semibold">Deskripsi Singkat Hero</label>
                        <textarea id="hero_deskripsi" name="hero_deskripsi" rows="4"
                                  class="form-control @error('hero_deskripsi') is-invalid @enderror"
                                  placeholder="Tuliskan gambaran umum beasiswa yang ditawarkan...">{{ old('hero_deskripsi', $beasiswa->hero_deskripsi) }}</textarea>
                        @error('hero_deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="link_daftar" class="form-label fw-semibold">
                            Tautan Khusus Pendaftaran Beasiswa
                            <span class="badge bg-secondary fw-normal ms-1" style="font-size:10px">Opsional</span>
                        </label>
                        <input type="text" id="link_daftar" name="link_daftar"
                               class="form-control @error('link_daftar') is-invalid @enderror"
                               value="{{ old('link_daftar', $beasiswa->link_daftar) }}"
                               placeholder="Kosongkan untuk otomatis menggunakan tautan PMB utama">
                        <div class="form-text">Bila dikosongkan, tombol 'Daftar' akan otomatis mengarah ke portal PMB yang aktif.</div>
                        @error('link_daftar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-check form-switch mt-4">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                               {{ old('is_active', $beasiswa->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold" for="is_active">
                            Aktifkan Status Buka Beasiswa
                        </label>
                    </div>
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: GAMBAR & TENTANG --}}
        <div class="col-lg-6">
            <div class="card shadow-sm h-100">
                <div class="card-header py-3 bg-white border-bottom">
                    <h5 class="mb-0 fw-semibold text-dark">
                        <i class="bi bi-image text-success me-2"></i>Gambar & Ulasan Tentang Beasiswa
                    </h5>
                    <small class="text-muted">Foto gedung / mahasiswa serta uraian komitmen pendidikan.</small>
                </div>
                <div class="card-body pt-3">
                    <div class="mb-3">
                        <label for="tentang_judul" class="form-label fw-semibold">Judul Bagian Tentang Beasiswa</label>
                        <input type="text" id="tentang_judul" name="tentang_judul"
                               class="form-control @error('tentang_judul') is-invalid @enderror"
                               value="{{ old('tentang_judul', $beasiswa->tentang_judul) }}"
                               placeholder="Contoh: Membuka Akses Pendidikan Tinggi Unggul Tanpa Kendala Biaya">
                        @error('tentang_judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tentang_deskripsi" class="form-label fw-semibold">Deskripsi Lengkap Tentang Beasiswa</label>
                        <textarea id="tentang_deskripsi" name="tentang_deskripsi" rows="6"
                                  class="form-control @error('tentang_deskripsi') is-invalid @enderror"
                                  placeholder="Jelaskan visi misi dan komitmen pemberian beasiswa UIS...">{{ old('tentang_deskripsi', $beasiswa->tentang_deskripsi) }}</textarea>
                        @error('tentang_deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="gambar" class="form-label fw-semibold">
                            Foto Showcase Beasiswa
                            <span class="badge bg-secondary fw-normal ms-1" style="font-size:10px">Opsional</span>
                        </label>
                        <input type="file" id="gambar" name="gambar"
                               class="form-control @error('gambar') is-invalid @enderror"
                               accept="image/jpg,image/jpeg,image/png,image/webp"
                               onchange="previewImgFile(this)">
                        <div class="form-text">Format: JPG, PNG, WebP. Maks: 10 MB. Kosongkan jika ingin memakai foto default gedung UIS.</div>
                        @error('gambar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        @if($beasiswa->gambar)
                            <div class="mt-3">
                                <p class="small text-muted mb-1">Foto saat ini:</p>
                                <img src="{{ asset('storage/' . $beasiswa->gambar) }}" alt="Preview"
                                     style="max-width:240px;max-height:130px;object-fit:cover;border-radius:10px;border:1px solid #dee2e6">
                            </div>
                        @endif

                        <div id="previewWrap" class="mt-3 d-none">
                            <p class="small text-muted mb-1">Preview foto baru:</p>
                            <img id="previewImg" src="" alt="Preview"
                                 style="max-width:240px;max-height:130px;object-fit:cover;border-radius:10px;border:2px solid #046B26">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- TOMBOL AKSI BAWAH --}}
        <div class="col-12">
            <div class="card shadow-sm border-0 bg-white p-3">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <a href="{{ route('homepage.beasiswa') }}" target="_blank" class="btn btn-outline-success">
                        <i class="bi bi-box-arrow-up-right me-1"></i> Lihat Halaman Beasiswa Frontend
                    </a>
                    <button type="submit" class="btn btn-success px-4 py-2 fw-semibold">
                        <i class="bi bi-save me-1"></i> Simpan Pengaturan Program Beasiswa
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
    function previewImgFile(input) {
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
