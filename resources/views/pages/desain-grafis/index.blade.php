@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Desain Grafis Humas</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Layanan Humas</li>
            <li class="breadcrumb-item active">Desain Grafis Humas</li>
        </ol>
    </nav>
</div>

<!-- Nav Tabs for Template Management vs Page Content Settings -->
<ul class="nav nav-tabs nav-tabs-bordered mb-3" id="desainGrafisTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active fw-bold" id="templates-tab" data-bs-toggle="tab" data-bs-target="#tab-templates" type="button" role="tab">
            <i class="bi bi-grid-3x3-gap-fill me-1 text-success"></i> Daftar Templat Desain
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link fw-bold" id="settings-tab" data-bs-toggle="tab" data-bs-target="#tab-settings" type="button" role="tab">
            <i class="bi bi-sliders me-1 text-primary"></i> Pengaturan Konten, Hero & Panduan Infografis
        </button>
    </li>
</ul>

<div class="tab-content" id="desainGrafisTabContent">
    
    <!-- ══════════════════════════════════════════════════════
         TAB 1: DAFTAR TEMPLAT DESAIN (DATATABLE)
    ══════════════════════════════════════════════════════ -->
    <div class="tab-pane fade show active" id="tab-templates" role="tabpanel">
        <div class="card shadow-sm">
            <div class="card-header d-flex align-items-center justify-content-between py-3">
                <h5 class="mb-0 fw-semibold">
                    <i class="bi bi-palette me-2 text-success"></i>Daftar Templat Desain Grafis Humas
                </h5>
                <a href="{{ route('desain-grafis.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Templat
                </a>
            </div>
            <div class="card-body pt-3">
                <div class="alert alert-info alert-dismissible fade show mb-3" role="alert">
                    <i class="bi bi-info-circle-fill me-2"></i>
                    <strong>Info Templat:</strong> Kelola tautan templat Canva & banner siap pakai untuk LED Auditorium, Ruang Sidang, Rapat Dekanat, dan Spanduk Outdoor.
                    Semua templat yang aktif otomatis tampil di halaman portal publik <a href="{{ route('homepage.desain-grafis') }}" target="_blank" class="fw-bold text-decoration-underline">/desain-grafis</a>.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <div class="table-responsive">
                    {{ $dataTable->table([
                        'class' => 'table table-striped table-bordered align-middle',
                        'style' => 'width:100%',
                    ]) }}
                </div>
            </div>
        </div>
    </div>


    <!-- ══════════════════════════════════════════════════════
         TAB 2: PENGATURAN KONTEN HALAMAN & UPLOAD GAMBAR PANDUAN
    ══════════════════════════════════════════════════════ -->
    <div class="tab-pane fade" id="tab-settings" role="tabpanel">
        <div class="card shadow-sm">
            <div class="card-header py-3">
                <h5 class="mb-0 fw-semibold">
                    <i class="bi bi-pencil-square me-2 text-primary"></i>Pengaturan Konten Hero, Bar Pelacakan, 4 Metrik & Infografis Panduan
                </h5>
            </div>
            <div class="card-body pt-4">

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <strong>Periksa kembali data yang dimasukkan:</strong>
                        <ul class="mb-0 mt-1 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('desain-grafis.update-setting') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- SECTION A: HERO BANNER -->
                    <div class="p-3 mb-4 rounded-3 border bg-light">
                        <h6 class="fw-bold text-success mb-3">
                            <i class="bi bi-card-heading me-1"></i> 1. Konten Hero Banner (Atas)
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="hero_title" class="form-label fw-semibold">Judul Baris 1 <span class="text-danger">*</span></label>
                                <input type="text" id="hero_title" name="hero_title" class="form-control"
                                       value="{{ old('hero_title', $setting->hero_title ?? 'Desain Mudah,') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="hero_highlight" class="form-label fw-semibold">Judul Highlight Kuning <span class="text-danger">*</span></label>
                                <input type="text" id="hero_highlight" name="hero_highlight" class="form-control"
                                       value="{{ old('hero_highlight', $setting->hero_highlight ?? 'Siap Digunakan !') }}" required>
                            </div>
                            <div class="col-12">
                                <label for="hero_subtitle" class="form-label fw-semibold">Subjudul / Deskripsi Hero</label>
                                <textarea id="hero_subtitle" name="hero_subtitle" rows="2" class="form-control">{{ old('hero_subtitle', $setting->hero_subtitle ?? 'Kami menyediakan template desain resmi untuk keperluan presentasi LED, ruang sidang, agenda rapat, dan spanduk acara di lingkungan Universitas Ibnu Sina.') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- SECTION B: KOTAK PESAN DESAIN -->
                    <div class="p-3 mb-4 rounded-3 border bg-light">
                        <h6 class="fw-bold text-warning mb-3">
                            <i class="bi bi-box-seam me-1"></i> 2. Kotak "Pesan Desain Disini" (Sebelah Kanan Hero)
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="order_box_title" class="form-label fw-semibold">Judul Header Kotak <span class="text-danger">*</span></label>
                                <input type="text" id="order_box_title" name="order_box_title" class="form-control"
                                       value="{{ old('order_box_title', $setting->order_box_title ?? 'Pesan desain disini') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="order_box_btn_text" class="form-label fw-semibold">Teks Tombol <span class="text-danger">*</span></label>
                                <input type="text" id="order_box_btn_text" name="order_box_btn_text" class="form-control"
                                       value="{{ old('order_box_btn_text', $setting->order_box_btn_text ?? 'Pesan Sekarang') }}" required>
                            </div>
                            <div class="col-12">
                                <label for="order_box_text" class="form-label fw-semibold">Deskripsi Pesan Khusus</label>
                                <textarea id="order_box_text" name="order_box_text" rows="2" class="form-control">{{ old('order_box_text', $setting->order_box_text ?? 'Butuh desain yang belum tersedia dalam template? Sampaikan kebutuhan acara Anda, dan tim Humas & Promosi UIS siap membantu mewujudkannya.') }}</textarea>
                            </div>
                            <div class="col-12">
                                <label for="order_box_wa_url" class="form-label fw-semibold">Custom WhatsApp URL / Link Form (Opsional)</label>
                                <input type="url" id="order_box_wa_url" name="order_box_wa_url" class="form-control"
                                       value="{{ old('order_box_wa_url', $setting->order_box_wa_url) }}"
                                       placeholder="https://wa.me/628... (Kosongkan jika menggunakan nomor WA kontak bawaan)">
                            </div>
                        </div>
                    </div>

                    <!-- SECTION C: BAR PELACAKAN & 4 METRIK STATS -->
                    <div class="p-3 mb-4 rounded-3 border bg-light">
                        <h6 class="fw-bold text-success mb-3">
                            <i class="bi bi-graph-up-arrow me-1"></i> 3. Bar Pelacakan & 4 Metrik Statistik
                        </h6>
                        <div class="row g-3 mb-3">
                            <div class="col-12">
                                <label for="track_bar_text" class="form-label fw-semibold">Teks Bar Pelacakan <span class="text-danger">*</span></label>
                                <input type="text" id="track_bar_text" name="track_bar_text" class="form-control"
                                       value="{{ old('track_bar_text', $setting->track_bar_text ?? 'Lacak progress pesanan desain kamu disini!') }}" required>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-3 col-6">
                                <label for="stat_total" class="form-label fw-semibold">Total Project</label>
                                <input type="number" id="stat_total" name="stat_total" class="form-control fw-bold" min="0"
                                       value="{{ old('stat_total', $setting->stat_total ?? 82) }}" required>
                            </div>
                            <div class="col-md-3 col-6">
                                <label for="stat_selesai" class="form-label fw-semibold text-success">Selesai</label>
                                <input type="number" id="stat_selesai" name="stat_selesai" class="form-control fw-bold text-success" min="0"
                                       value="{{ old('stat_selesai', $setting->stat_selesai ?? 74) }}" required>
                            </div>
                            <div class="col-md-3 col-6">
                                <label for="stat_dikerjakan" class="form-label fw-semibold text-warning">Dikerjakan</label>
                                <input type="number" id="stat_dikerjakan" name="stat_dikerjakan" class="form-control fw-bold text-warning" min="0"
                                       value="{{ old('stat_dikerjakan', $setting->stat_dikerjakan ?? 2) }}" required>
                            </div>
                            <div class="col-md-3 col-6">
                                <label for="stat_menunggu" class="form-label fw-semibold text-primary">Menunggu</label>
                                <input type="number" id="stat_menunggu" name="stat_menunggu" class="form-control fw-bold text-primary" min="0"
                                       value="{{ old('stat_menunggu', $setting->stat_menunggu ?? 5) }}" required>
                            </div>
                        </div>
                    </div>

                    <!-- SECTION D: UPLOAD GAMBAR INFOGRAFIS PANDUAN -->
                    <div class="p-3 mb-4 rounded-3 border bg-light">
                        <h6 class="fw-bold text-primary mb-3">
                            <i class="bi bi-file-image me-1"></i> 4. Bagian Infografis Panduan Desain (Upload File Gambar)
                        </h6>
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="guide_image" class="form-label fw-semibold">Upload File Gambar Panduan <span class="text-muted">(JPG, PNG, WEBP, SVG Maks 20 MB)</span></label>
                                <input type="file" id="guide_image" name="guide_image" class="form-control"
                                       accept="image/jpeg,image/png,image/webp,image/svg+xml">
                                <div class="form-text">Unggah file gambar lengkap infografis langkah penggunaan templat desain. Gambar ini akan tampil penuh dan rapi di bagian bawah halaman publik.</div>
                            </div>
                            
                            @if (!empty($setting->guide_image))
                            <div class="col-12 mt-3">
                                <div class="p-3 bg-white rounded-3 border shadow-sm">
                                    <div class="fw-bold text-dark mb-2">
                                        <i class="bi bi-check-circle-fill text-success me-1"></i> Gambar Panduan Saat Ini yang Tampil:
                                    </div>
                                    <div class="text-center p-3 bg-light rounded-3 border">
                                        <img src="{{ asset('storage/' . $setting->guide_image) }}" alt="Preview Panduan" class="img-fluid rounded-3 shadow-sm" style="max-height: 280px;">
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Tombol Simpan Setting -->
                    <div class="d-flex align-items-center gap-2 pt-2 border-top">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-save me-1"></i> Simpan Semua Perubahan Konten
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
    @if(app()->environment('production'))
        {!! str_replace('http:', 'https:', $dataTable->scripts()) !!}
    @else
        {!! $dataTable->scripts() !!}
    @endif

    <script>
        function confirmDeleteDesainGrafis(e, btn) {
            if (e) e.preventDefault();
            const form = btn.closest('form');
            const itemName = btn.getAttribute('data-name') || 'templat desain ini';

            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: 'Apakah Anda yakin ingin menghapus "' + itemName + '"? Data yang dihapus tidak dapat dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="bi bi-trash-fill me-1"></i> Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-4 shadow-lg border-0',
                    confirmButton: 'px-4 py-2 rounded-3 fw-semibold',
                    cancelButton: 'px-4 py-2 rounded-3 fw-semibold'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    </script>
@endpush
