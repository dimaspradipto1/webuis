@extends('layouts.dashboard.template')

@section('title', 'Pengaturan Hero & Background Humas')

@section('content')
<div class="pagetitle">
    <h1>Hero & Background Homepage Humas</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Layanan Humas</li>
            <li class="breadcrumb-item active">Hero Humas</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            {{-- Alert Notifikasi --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show rounded-3" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <strong>Terdapat kesalahan pengisian:</strong>
                    <ul class="mb-0 mt-1 small">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form action="{{ route('hero-humas.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="card shadow-sm border-0 rounded-4 mb-4">
                    <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                        <h5 class="card-title mb-0 fw-bold text-dark fs-6">
                            <i class="bi bi-image-fill text-success me-2"></i> Konten & Background Hero Humas
                        </h5>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $hero->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold text-dark small" for="is_active">Aktifkan Hero</label>
                        </div>
                    </div>

                    <div class="card-body pt-4">

                        {{-- Section 1: Background Image Upload & Preview --}}
                        <div class="mb-4 p-3 rounded-3" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                            <label class="form-label fw-bold text-dark d-flex align-items-center justify-content-between">
                                <span><i class="bi bi-card-image text-primary me-1"></i> Gambar Background Hero Homepage Humas</span>
                                <span class="badge bg-secondary" style="font-size: 11px;">Rekomendasi: 1920x800px (Maks 20 MB)</span>
                            </label>

                            <div class="row g-3 align-items-center">
                                <div class="col-md-5 text-center">
                                    <div class="position-relative overflow-hidden rounded-4 border shadow-sm" style="height: 180px; background: #032e12;">
                                        @php
                                            $bgUrl = $hero->background_image_url ?? asset('frontend/img/gedung-uis.jpg');
                                        @endphp
                                        <img src="{{ $bgUrl }}" 
                                             id="previewBgImg" 
                                             alt="Preview Background" 
                                             class="w-100 h-100" 
                                             style="object-fit: cover; opacity: 0.85;"
                                             onerror="this.onerror=null; this.src='{{ asset('frontend/img/gedung-uis.jpg') }}';">
                                        
                                        <div class="position-absolute bottom-0 start-0 end-0 p-2 text-white small" style="background: rgba(0,0,0,0.65);">
                                            <i class="bi bi-eye me-1"></i> Preview Background Aktif
                                        </div>
                                    </div>

                                    @if($hero->background_image)
                                        <div class="form-check mt-2 text-start">
                                            <input class="form-check-input" type="checkbox" name="hapus_background" value="1" id="hapus_background">
                                            <label class="form-check-label text-danger small fw-semibold" for="hapus_background">
                                                <i class="bi bi-trash me-1"></i> Kembalikan ke background tema default
                                            </label>
                                        </div>
                                    @endif
                                </div>

                                <div class="col-md-7">
                                    <div class="mb-3">
                                        <label for="background_image" class="form-label fw-semibold text-muted small">Pilih Gambar Background Baru</label>
                                        <input type="file" 
                                               id="background_image" 
                                               name="background_image" 
                                               class="form-control @error('background_image') is-invalid @enderror" 
                                               accept="image/*"
                                               onchange="previewImage(this)">
                                        <div class="form-text small" style="font-size: 11.5px;">
                                            Format yang didukung: JPG, PNG, WEBP, SVG. Gambar akan ditampilkan sebagai latar belakang di bagian atas menu Humas.
                                        </div>
                                        @error('background_image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Section 2: Teks Utama Hero --}}
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="judul" class="form-label fw-semibold">
                                    Judul Utama <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       id="judul" 
                                       name="judul" 
                                       class="form-control @error('judul') is-invalid @enderror" 
                                       value="{{ old('judul', $hero->judul) }}" 
                                       placeholder="Selamat Datang" 
                                       required>
                                @error('judul')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="badge_text" class="form-label fw-semibold">
                                    Teks Label / Badge
                                </label>
                                <input type="text" 
                                       id="badge_text" 
                                       name="badge_text" 
                                       class="form-control @error('badge_text') is-invalid @enderror" 
                                       value="{{ old('badge_text', $hero->badge_text) }}" 
                                       placeholder="Layanan">
                                @error('badge_text')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="subjudul" class="form-label fw-semibold">
                                    Subjudul / Keterangan Hero
                                </label>
                                <input type="text" 
                                       id="subjudul" 
                                       name="subjudul" 
                                       class="form-control @error('subjudul') is-invalid @enderror" 
                                       value="{{ old('subjudul', $hero->subjudul) }}" 
                                       placeholder="di Biro Hubungan Masyarakat dan Protokoler Universitas Ibnu Sina">
                                @error('subjudul')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Section 3: Pengaturan Tombol & Action Pills --}}
                        <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">
                            <i class="bi bi-tag-fill text-warning me-1"></i> Pengaturan Tombol Notifikasi & Pintasan (Action Pills)
                        </h6>

                        <div class="row g-3 mb-3">
                            {{-- Pill 1 --}}
                            <div class="col-md-6">
                                <label for="pill_text_1" class="form-label fw-semibold small">Teks Tombol 1 (Kiri)</label>
                                <input type="text" id="pill_text_1" name="pill_text_1" class="form-control" value="{{ old('pill_text_1', $hero->pill_text_1) }}" placeholder="Informasi Khusus PMB TA 2026/2027">
                            </div>
                            <div class="col-md-6">
                                <label for="pill_url_1" class="form-label fw-semibold small">Tautan / URL Tombol 1</label>
                                <input type="text" id="pill_url_1" name="pill_url_1" class="form-control" value="{{ old('pill_url_1', $hero->pill_url_1) }}" placeholder="Kosongkan untuk otomatis ke PMB">
                            </div>

                            {{-- Pill 2 --}}
                            <div class="col-md-6">
                                <label for="pill_text_2" class="form-label fw-semibold small">Teks Tombol 2 (Tengah)</label>
                                <input type="text" id="pill_text_2" name="pill_text_2" class="form-control" value="{{ old('pill_text_2', $hero->pill_text_2) }}" placeholder="Pengumuman Prestasi & Kejuaraan Kampus">
                            </div>
                            <div class="col-md-6">
                                <label for="pill_url_2" class="form-label fw-semibold small">Tautan / URL Tombol 2</label>
                                <input type="text" id="pill_url_2" name="pill_url_2" class="form-control" value="{{ old('pill_url_2', $hero->pill_url_2) }}" placeholder="Kosongkan untuk otomatis ke Prestasi">
                            </div>

                            {{-- Pill 3 --}}
                            <div class="col-md-6">
                                <label for="pill_text_3" class="form-label fw-semibold small">Teks Tombol 3 (Kanan / WhatsApp)</label>
                                <input type="text" id="pill_text_3" name="pill_text_3" class="form-control" value="{{ old('pill_text_3', $hero->pill_text_3) }}" placeholder="Live Chat Layanan Humas">
                            </div>
                            <div class="col-md-6">
                                <label for="pill_url_3" class="form-label fw-semibold small">Tautan / URL Tombol 3</label>
                                <input type="text" id="pill_url_3" name="pill_url_3" class="form-control" value="{{ old('pill_url_3', $hero->pill_url_3) }}" placeholder="Kosongkan untuk otomatis ke WhatsApp Utama">
                            </div>
                        </div>

                    </div>

                    <div class="card-footer bg-light py-3 border-top d-flex align-items-center justify-content-between">
                        <a href="{{ route('homepage.humas') }}" target="_blank" class="btn btn-outline-secondary rounded-pill px-4 fw-semibold">
                            <i class="bi bi-box-arrow-up-right me-1"></i> Lihat Halaman Humas
                        </a>
                        <button type="submit" class="btn btn-success rounded-pill px-5 fw-bold shadow-sm">
                            <i class="bi bi-save me-1"></i> Simpan Perubahan Hero
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</section>

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewBgImg').src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
