@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Edit Breadcrumb & Hero Banner</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('breadcrumb-setting.index') }}">Breadcrumb Halaman</a></li>
            <li class="breadcrumb-item active">Edit: {{ $breadcrumb->menu_name }}</li>
        </ol>
    </nav>
</div>

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

<div class="row">
    <!-- Kolom Kiri: Form Edit -->
    <div class="col-lg-7 col-xl-8">
        <div class="card shadow-sm border-0 rounded-4 mb-4">
            <div class="card-header bg-white py-3 px-4 border-bottom d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <span class="p-2 rounded-3 bg-success bg-opacity-10 text-success">
                        <i class="bi bi-pencil-square fs-5"></i>
                    </span>
                    <div>
                        <h5 class="mb-0 fw-bold text-dark">Formulir Pengaturan Breadcrumb</h5>
                        <small class="text-muted">Menu: <strong>{{ $breadcrumb->menu_name }}</strong> (Kategori: {{ $breadcrumb->kategori_menu }})</small>
                    </div>
                </div>
                <span class="badge bg-secondary bg-opacity-10 text-secondary border px-3 py-1 rounded-pill">
                    Key: /{{ $breadcrumb->page_key }}
                </span>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('breadcrumb-setting.update', $breadcrumb->id) }}" method="POST" enctype="multipart/form-data" id="formBreadcrumb">
                    @csrf
                    @method('PUT')

                    {{-- ═══════════════════════════════════════════════
                         BAGIAN 1: KONTEN HERO BANNER
                    ═══════════════════════════════════════════════ --}}
                    <div class="section-divider mb-3">
                        <span class="badge bg-success rounded-pill px-3 py-1"><i class="bi bi-card-heading me-1"></i> 1. Konten Teks Hero Banner</span>
                    </div>

                    <!-- Judul Hero Banner -->
                    <div class="mb-3">
                        <label for="judul" class="form-label fw-bold small text-dark">
                            Judul Utama Hero Banner <span class="text-danger">*</span>
                        </label>
                        <input type="text" id="judul" name="judul" 
                               class="form-control form-control-lg @error('judul') is-invalid @enderror"
                               value="{{ old('judul', $breadcrumb->judul) }}" 
                               required
                               placeholder="Contoh: Tentang &lt;em&gt;UIS&lt;/em&gt;"
                               oninput="updateLivePreview()">
                        <div class="form-text small">
                            <i class="bi bi-info-circle me-1"></i> Gunakan tag <code>&lt;em&gt;Kata&lt;/em&gt;</code> untuk memberikan warna aksen kuning emas pada kata tertentu.
                        </div>
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Subjudul / Slogan Deskripsi -->
                    <div class="mb-3">
                        <label for="subjudul" class="form-label fw-bold small text-dark">
                            Subjudul / Slogan Penjelas (Opsional)
                        </label>
                        <textarea id="subjudul" name="subjudul" rows="2"
                                  class="form-control @error('subjudul') is-invalid @enderror"
                                  placeholder="Deskripsi singkat yang tampil tepat di bawah judul banner..."
                                  oninput="updateLivePreview()">{{ old('subjudul', $breadcrumb->subjudul) }}</textarea>
                        @error('subjudul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Badge / Label Atas (Eyebrow) -->
                    <div class="mb-4">
                        <label for="badge_text" class="form-label fw-bold small text-dark">
                            Label Kategori Kecil / Badge Atas (Opsional)
                        </label>
                        <input type="text" id="badge_text" name="badge_text"
                               class="form-control @error('badge_text') is-invalid @enderror"
                               value="{{ old('badge_text', $breadcrumb->badge_text) }}"
                               placeholder="Contoh: Profil Universitas / Kabar Terkini"
                               oninput="updateLivePreview()">
                        @error('badge_text')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- ═══════════════════════════════════════════════
                         BAGIAN 2: JEJAK BREADCRUMB (NAVIGASI)
                    ═══════════════════════════════════════════════ --}}
                    <div class="section-divider mb-3">
                        <span class="badge bg-primary rounded-pill px-3 py-1"><i class="bi bi-signpost-split me-1"></i> 2. Susunan Jejak Breadcrumb (Navigasi)</span>
                    </div>

                    <div class="row g-3 mb-3">
                        <!-- Breadcrumb Item 1 (Home) -->
                        <div class="col-md-6">
                            <label for="breadcrumb_item_1" class="form-label fw-bold small text-dark">
                                Item 1 (Beranda) <span class="text-danger">*</span>
                            </label>
                            <input type="text" id="breadcrumb_item_1" name="breadcrumb_item_1"
                                   class="form-control @error('breadcrumb_item_1') is-invalid @enderror"
                                   value="{{ old('breadcrumb_item_1', $breadcrumb->breadcrumb_item_1 ?: 'Beranda') }}"
                                   required
                                   oninput="updateLivePreview()">
                            @error('breadcrumb_item_1')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="breadcrumb_url_1" class="form-label fw-bold small text-dark">
                                Link URL Item 1
                            </label>
                            <input type="text" id="breadcrumb_url_1" name="breadcrumb_url_1"
                                   class="form-control @error('breadcrumb_url_1') is-invalid @enderror"
                                   value="{{ old('breadcrumb_url_1', $breadcrumb->breadcrumb_url_1 ?: '/') }}">
                            @error('breadcrumb_url_1')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <!-- Breadcrumb Item 2 (Parent Menu, opsional) -->
                        <div class="col-md-6">
                            <label for="breadcrumb_item_2" class="form-label fw-bold small text-dark">
                                Item 2 (Kategori Induk / Parent) <span class="badge bg-secondary fw-normal">Opsional</span>
                            </label>
                            <input type="text" id="breadcrumb_item_2" name="breadcrumb_item_2"
                                   class="form-control @error('breadcrumb_item_2') is-invalid @enderror"
                                   value="{{ old('breadcrumb_item_2', $breadcrumb->breadcrumb_item_2) }}"
                                   placeholder="Contoh: Profil / Akademik / Humas"
                                   oninput="updateLivePreview()">
                            @error('breadcrumb_item_2')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="breadcrumb_url_2" class="form-label fw-bold small text-dark">
                                Link URL Item 2 (Opsional)
                            </label>
                            <input type="text" id="breadcrumb_url_2" name="breadcrumb_url_2"
                                   class="form-control @error('breadcrumb_url_2') is-invalid @enderror"
                                   value="{{ old('breadcrumb_url_2', $breadcrumb->breadcrumb_url_2) }}"
                                   placeholder="Contoh: /tentang atau /program-studi">
                            @error('breadcrumb_url_2')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Breadcrumb Active (Current Page) -->
                    <div class="mb-4">
                        <label for="breadcrumb_active" class="form-label fw-bold small text-dark">
                            Teks Halaman Aktif (Active Item) <span class="text-danger">*</span>
                        </label>
                        <input type="text" id="breadcrumb_active" name="breadcrumb_active"
                               class="form-control @error('breadcrumb_active') is-invalid @enderror"
                               value="{{ old('breadcrumb_active', $breadcrumb->breadcrumb_active) }}"
                               required
                               placeholder="Contoh: Tentang Universitas / Visi & Misi"
                               oninput="updateLivePreview()">
                        <div class="form-text small">Teks ini akan tampil tebal dengan warna kuning emas sebagai posisi halaman saat ini.</div>
                        @error('breadcrumb_active')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- ═══════════════════════════════════════════════
                         BAGIAN 3: GAMBAR BACKGROUND BANNER
                    ═══════════════════════════════════════════════ --}}
                    <div class="section-divider mb-3">
                        <span class="badge bg-warning text-dark rounded-pill px-3 py-1"><i class="bi bi-image me-1"></i> 3. Gambar Latar Belakang (Background Banner)</span>
                    </div>

                    <div class="mb-3">
                        <label for="background_image" class="form-label fw-bold small text-dark">
                            Unggah Gambar Background Banner
                        </label>
                        <input type="file" id="background_image" name="background_image"
                               class="form-control @error('background_image') is-invalid @enderror"
                               accept="image/png,image/jpeg,image/jpg,image/webp"
                               onchange="previewUploadedImage(this)">
                        <div class="form-text small">
                            Format: JPG, PNG, atau WebP. Rekomendasi resolusi lebar minimal 1920x400 px. Maks: 5 MB.
                        </div>
                        @error('background_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        @if($breadcrumb->background_image)
                            <div class="mt-3 p-3 bg-light rounded-3 border d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-2">
                                    <img src="{{ $breadcrumb->bg_image_url }}" alt="Current Background" class="rounded-2 border" style="width: 80px; height: 46px; object-fit: cover;">
                                    <div>
                                        <div class="small fw-bold text-dark">Background Banner Aktif</div>
                                        <div class="text-muted" style="font-size: 11px;">{{ basename($breadcrumb->background_image) }}</div>
                                    </div>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="remove_background_image" id="remove_background_image" value="1">
                                    <label class="form-check-label text-danger small fw-semibold" for="remove_background_image">
                                        Hapus gambar (gunakan warna standar)
                                    </label>
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- Status Switch --}}
                    <div class="p-3 bg-light rounded-3 border mb-4">
                        <div class="form-check form-switch mb-0">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                                   {{ old('is_active', $breadcrumb->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold text-dark" for="is_active">
                                Aktifkan Hero Banner & Breadcrumb
                            </label>
                            <div class="text-muted small">Jika dinonaktifkan, bagian hero banner pada halaman ini tidak akan ditampilkan di website frontend.</div>
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 pt-2 border-top">
                        <a href="{{ route('breadcrumb-setting.index') }}" class="btn btn-secondary px-4 rounded-pill">
                            <i class="bi bi-arrow-left me-1"></i> Batal
                        </a>
                        <div class="d-flex align-items-center gap-2">
                            <button type="submit" class="btn btn-success px-4 rounded-pill fw-bold shadow-sm">
                                <i class="bi bi-save me-1"></i> Simpan Pengaturan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Kolom Kanan: Pratinjau Langsung (Live Preview) -->
    <div class="col-lg-5 col-xl-4">
        <div class="card shadow-sm border-0 rounded-4 sticky-top" style="top: 85px;">
            <div class="card-header bg-white py-3 px-4 border-bottom d-flex align-items-center justify-content-between">
                <span class="fw-bold text-dark small"><i class="bi bi-eye-fill text-primary me-1"></i> Pratinjau Tampilan Frontend</span>
                <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2.5 py-1" style="font-size: 11px;">Real-Time</span>
            </div>
            <div class="card-body p-4">
                {{-- Mock Browser Box --}}
                <div class="rounded-4 overflow-hidden border shadow-sm" style="border-color: #cbd5e1 !important;">
                    <div class="px-3 py-2 bg-dark d-flex align-items-center gap-1.5" style="border-bottom: 1px solid rgba(255,255,255,0.1);">
                        <span class="rounded-circle d-inline-block" style="width: 9px; height: 9px; background: #ef4444;"></span>
                        <span class="rounded-circle d-inline-block" style="width: 9px; height: 9px; background: #f59e0b;"></span>
                        <span class="rounded-circle d-inline-block" style="width: 9px; height: 9px; background: #10b981;"></span>
                        <span class="text-white-50 ms-2 font-monospace" style="font-size: 10px;">webuis.test/{{ $breadcrumb->page_key }}</span>
                    </div>

                    {{-- Hero Banner Preview Container --}}
                    <div id="pvHeroBox" style="background: {{ $breadcrumb->bg_image_url ? "linear-gradient(135deg, rgba(4, 107, 38, 0.88) 0%, rgba(2, 56, 20, 0.94) 100%), url('{$breadcrumb->bg_image_url}') center/cover no-repeat" : "#046b26" }}; border-bottom: 3px solid #fed802; padding: 22px 18px; color: #fff; transition: all 0.3s ease;">
                        
                        {{-- Badge Preview --}}
                        <div id="pvBadge" class="badge px-2.5 py-0.5 rounded-pill mb-2 {{ empty($breadcrumb->badge_text) ? 'd-none' : '' }}" 
                             style="background: rgba(4, 107, 38, 0.45); color: #fed802; border: 1px solid rgba(254, 216, 2, 0.4); font-size: 10px;">
                            <i class="bi bi-bookmark-star-fill me-1"></i> <span id="pvBadgeText">{{ $breadcrumb->badge_text }}</span>
                        </div>

                        {{-- Judul Preview --}}
                        <h4 id="pvTitle" class="fw-bold mb-1" style="font-size: 18px; color: #fff; line-height: 1.3;">
                            {!! $breadcrumb->judul !!}
                        </h4>

                        {{-- Subjudul Preview --}}
                        <p id="pvSubtitle" class="text-white-50 mb-2 {{ empty($breadcrumb->subjudul) ? 'd-none' : '' }}" style="font-size: 11.5px; line-height: 1.45;">
                            {{ $breadcrumb->subjudul }}
                        </p>

                        {{-- Breadcrumb Custom Preview --}}
                        <div class="breadcrumb-custom" style="font-size: 11px !important;">
                            <span class="text-white" style="font-size: 11px;"><i class="bi bi-house-door-fill me-1"></i><span id="pvItem1">{{ $breadcrumb->breadcrumb_item_1 }}</span></span>
                            
                            <span id="pvSep2" class="{{ empty($breadcrumb->breadcrumb_item_2) ? 'd-none' : '' }}">/</span>
                            <span id="pvItem2" class="text-white-50 {{ empty($breadcrumb->breadcrumb_item_2) ? 'd-none' : '' }}" style="font-size: 11px;">
                                {{ $breadcrumb->breadcrumb_item_2 }}
                            </span>

                            <span>/</span>
                            <span id="pvActive" class="active fw-bold" style="color: #fed802 !important; font-size: 11px;">
                                {{ $breadcrumb->breadcrumb_active }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Action Reset Default --}}
                <div class="mt-4 pt-3 border-top">
                    <form action="{{ route('breadcrumb-setting.reset', $breadcrumb->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengembalikan teks dan background breadcrumb menu ini ke standar awal?');">
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary btn-sm w-100 rounded-pill">
                            <i class="bi bi-arrow-counterclockwise me-1"></i> Reset ke Standar Awal UIS
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function updateLivePreview() {
        // Judul
        const judulVal = document.getElementById('judul').value;
        document.getElementById('pvTitle').innerHTML = judulVal || 'Judul Banner';

        // Subjudul
        const subjudulVal = document.getElementById('subjudul').value;
        const pvSubtitle = document.getElementById('pvSubtitle');
        if (subjudulVal.trim() !== '') {
            pvSubtitle.innerText = subjudulVal;
            pvSubtitle.classList.remove('d-none');
        } else {
            pvSubtitle.classList.add('d-none');
        }

        // Badge
        const badgeVal = document.getElementById('badge_text').value;
        const pvBadge = document.getElementById('pvBadge');
        const pvBadgeText = document.getElementById('pvBadgeText');
        if (badgeVal.trim() !== '') {
            pvBadgeText.innerText = badgeVal;
            pvBadge.classList.remove('d-none');
        } else {
            pvBadge.classList.add('d-none');
        }

        // Breadcrumb 1
        const item1Val = document.getElementById('breadcrumb_item_1').value;
        document.getElementById('pvItem1').innerText = item1Val || 'Beranda';

        // Breadcrumb 2
        const item2Val = document.getElementById('breadcrumb_item_2').value;
        const pvItem2 = document.getElementById('pvItem2');
        const pvSep2 = document.getElementById('pvSep2');
        if (item2Val.trim() !== '') {
            pvItem2.innerText = item2Val;
            pvItem2.classList.remove('d-none');
            pvSep2.classList.remove('d-none');
        } else {
            pvItem2.classList.add('d-none');
            pvSep2.classList.add('d-none');
        }

        // Active
        const activeVal = document.getElementById('breadcrumb_active').value;
        document.getElementById('pvActive').innerText = activeVal || 'Halaman Aktif';
    }

    function previewUploadedImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const pvHeroBox = document.getElementById('pvHeroBox');
                pvHeroBox.style.background = `linear-gradient(135deg, rgba(4, 107, 38, 0.88) 0%, rgba(2, 56, 20, 0.94) 100%), url('${e.target.result}') center/cover no-repeat`;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
