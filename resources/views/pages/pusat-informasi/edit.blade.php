@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Edit Kartu Informasi Humas</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Beranda Humas</li>
            <li class="breadcrumb-item"><a href="{{ route('pusat-informasi.index') }}">Hubungi Kami & Pusat Informasi</a></li>
            <li class="breadcrumb-item active">Edit Kartu</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-8 col-md-12">
        <div class="card shadow-sm border-0 mb-4" style="border-radius: 12px;">
            <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between" style="border-top: 3px solid #f59e0b; border-radius: 12px 12px 0 0;">
                <h5 class="mb-0 fw-bold" style="color: #2b2f32; font-size: 16px;">
                    <i class="bi bi-pencil-fill me-2" style="color: #f59e0b;"></i>Edit Kartu: {{ $pusatInformasi->judul ?: 'Kartu #' . $pusatInformasi->id }}
                </h5>
                <a href="{{ route('pusat-informasi.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>
            <div class="card-body pt-3 pb-4">
                <form action="{{ route('pusat-informasi.update', $pusatInformasi->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- 1. Nama / Judul Kartu --}}
                    <div class="mb-3">
                        <label for="judul" class="form-label fw-bold text-dark" style="font-size: 13.5px;">
                            Nama / Judul Kartu <span class="text-muted fw-normal">(Sebagai penanda referensi di Admin)</span>
                        </label>
                        <input type="text"
                               id="judul"
                               name="judul"
                               class="form-control @error('judul') is-invalid @enderror"
                               value="{{ old('judul', $pusatInformasi->judul) }}"
                               placeholder="Contoh: Formulir PPID, Siaran Pers, Booklet Profil UIS, dsb">
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- 2. Pilihan Sumber Background Image --}}
                    <div class="card border border-light-subtle bg-light p-3 mb-3" style="border-radius: 10px;">
                        <label class="form-label fw-bold text-dark mb-2" style="font-size: 14px;">
                            <i class="bi bi-image me-1 text-primary"></i> Background Kartu
                        </label>
                        <p class="text-muted small mb-3">
                            Pilih salah satu: Anda dapat mengunggah file gambar baru <strong>ATAU</strong> menempelkan link Google Drive / URL Gambar.
                        </p>

                        {{-- Current background indicator --}}
                        @if($pusatInformasi->gambar || $pusatInformasi->link_drive)
                            <div class="alert alert-white border shadow-sm p-2 mb-3 d-flex align-items-center gap-3" style="border-radius: 8px;">
                                @if($pusatInformasi->image_url)
                                    <div class="rounded overflow-hidden flex-shrink-0" 
                                         style="width: 60px; height: 42px; background: url('{{ $pusatInformasi->image_url }}') center/cover no-repeat; border: 1px solid #e2e8f0;"></div>
                                @endif
                                <div class="small">
                                    <strong>Background Aktif Saat Ini:</strong>
                                    @if($pusatInformasi->gambar)
                                        <span class="badge bg-success ms-1"><i class="bi bi-upload me-1"></i> File Upload</span>
                                    @elseif($pusatInformasi->link_drive)
                                        <span class="badge bg-primary ms-1"><i class="bi bi-google me-1"></i> Google Drive</span>
                                    @endif
                                </div>
                            </div>
                        @endif

                        {{-- Opsi A: Upload File --}}
                        <div class="mb-3">
                            <label for="gambar" class="form-label fw-semibold text-dark small">
                                Opsi 1: Upload File Gambar Baru
                            </label>
                            <input type="file"
                                   id="gambar"
                                   name="gambar"
                                   class="form-control @error('gambar') is-invalid @enderror"
                                   accept="image/*">
                            <div class="form-text text-muted small">
                                Kosongkan jika tidak ingin mengubah file gambar yang sudah ada. Maks 20 MB.
                            </div>
                            @error('gambar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="text-center my-1 text-muted fw-bold small">
                            <span>— ATAU —</span>
                        </div>

                        {{-- Opsi B: Link Google Drive --}}
                        <div class="mb-2">
                            <label for="link_drive" class="form-label fw-semibold text-dark small">
                                Opsi 2: Link Google Drive / URL Gambar
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="bi bi-google text-primary"></i></span>
                                <input type="text"
                                       id="link_drive"
                                       name="link_drive"
                                       class="form-control @error('link_drive') is-invalid @enderror"
                                       value="{{ old('link_drive', $pusatInformasi->link_drive) }}"
                                       placeholder="https://drive.google.com/file/d/1ABCXYZ.../view?usp=sharing">
                            </div>
                            <div class="form-text text-muted small mt-1">
                                <i class="bi bi-info-circle me-1 text-info"></i>
                                Tempel link sharing Google Drive dengan akses publik ("Anyone with the link").
                            </div>
                            @error('link_drive')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- 3. Pengaturan Tombol & Link Tujuan --}}
                    <div class="card border border-warning-subtle bg-warning bg-opacity-10 p-3 mb-3" style="border-radius: 10px;">
                        <label class="form-label fw-bold text-dark mb-2" style="font-size: 14px;">
                            <i class="bi bi-cursor-fill me-1 text-warning"></i> Tombol Aksi & Link Tujuan
                        </label>
                        <p class="text-muted small mb-3">
                            Pada tampilan frontend, kartu ini hanya akan menampilkan background dan <strong>tombol ini</strong>. Pengunjung yang menekan tombol akan diarahkan ke link di bawah.
                        </p>

                        <div class="row g-3">
                            <div class="col-md-5 col-12">
                                <label for="button_text" class="form-label fw-semibold text-dark small">
                                    Teks Tombol <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       id="button_text"
                                       name="button_text"
                                       class="form-control @error('button_text') is-invalid @enderror"
                                       value="{{ old('button_text', $pusatInformasi->button_text ?? 'Lihat') }}"
                                       placeholder="Contoh: Lihat / Akses / Buka / Baca"
                                       required>
                                @error('button_text')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-7 col-12">
                                <label for="button_url" class="form-label fw-semibold text-dark small">
                                    Link Tujuan Tombol (URL)
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="bi bi-link-45deg"></i></span>
                                    <input type="text"
                                           id="button_url"
                                           name="button_url"
                                           class="form-control @error('button_url') is-invalid @enderror"
                                           value="{{ old('button_url', $pusatInformasi->button_url) }}"
                                           placeholder="https://example.com/dokumen atau /berita">
                                </div>
                                <div class="form-text text-muted small">Tautan website, dokumen, WhatsApp, form, atau drive.</div>
                                @error('button_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-check mt-3">
                            <input class="form-check-input" type="checkbox" name="target_blank" id="target_blank" value="1" {{ old('target_blank', $pusatInformasi->target_blank) ? 'checked' : '' }}>
                            <label class="form-check-label text-dark small fw-semibold" for="target_blank">
                                Buka link di tab browser baru (target="_blank")
                            </label>
                        </div>
                    </div>

                    {{-- 4. Urutan & Status Aktif --}}
                    <div class="row g-3 mb-4">
                        <div class="col-md-6 col-12">
                            <label for="urutan" class="form-label fw-bold text-dark small">
                                Nomor Urutan Tampilan
                            </label>
                            <input type="number"
                                   id="urutan"
                                   name="urutan"
                                   class="form-control @error('urutan') is-invalid @enderror"
                                   value="{{ old('urutan', $pusatInformasi->urutan) }}"
                                   min="0">
                            <div class="form-text text-muted small">Semakin kecil angkanya, semakin di depan posisinya.</div>
                            @error('urutan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 col-12 d-flex align-items-center pt-md-3">
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" role="switch" name="is_active" id="is_active" value="1" {{ old('is_active', $pusatInformasi->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label text-dark fw-semibold" for="is_active">
                                    Status Aktif (Tampilkan di Frontend)
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Submit Button --}}
                    <div class="d-flex justify-content-end gap-2 pt-2 border-top">
                        <a href="{{ route('pusat-informasi.index') }}" class="btn btn-secondary px-3">Batal</a>
                        <button type="submit" class="btn fw-semibold px-4" style="background-color: #046B26; color: #ffffff;">
                            <i class="bi bi-save me-1"></i> Perbarui Kartu
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Live Card Preview Side Box --}}
    <div class="col-lg-4 col-md-12">
        <div class="card shadow-sm border-0 sticky-top" style="top: 90px; border-radius: 12px;">
            <div class="card-header bg-white py-3" style="border-top: 3px solid #6366f1; border-radius: 12px 12px 0 0;">
                <h6 class="mb-0 fw-bold text-dark">
                    <i class="bi bi-eye-fill me-1 text-primary"></i> Live Preview Kartu
                </h6>
                <small class="text-muted">Simulasi tampilan kartu di halaman Humas</small>
            </div>
            <div class="card-body p-4 text-center bg-light" style="border-radius: 0 0 12px 12px;">
                <div id="card-preview-box" 
                     class="mx-auto rounded-4 shadow-sm overflow-hidden d-flex flex-column justify-content-end p-3 position-relative"
                     style="width: 100%; max-width: 240px; height: 260px; background: {{ $pusatInformasi->image_url ? "url('" . e($pusatInformasi->image_url) . "') center/cover no-repeat" : '#e2e8f0' }}; border: 1px solid rgba(0,0,0,0.1); transition: all 0.3s ease;">
                    
                    {{-- Overlay --}}
                    <div class="position-absolute top-0 bottom-0 start-0 end-0" 
                         style="background: linear-gradient(180deg, rgba(0,0,0,0) 45%, rgba(0,0,0,0.65) 100%); pointer-events: none;"></div>

                    {{-- Button --}}
                    <div class="position-relative" style="z-index: 2;">
                        <span id="preview-btn-label" class="d-inline-block px-4 py-2 fw-bold text-dark rounded-pill shadow"
                              style="background: #ffd600; font-size: 13px;">
                            {{ $pusatInformasi->button_text ?? 'Lihat' }}
                        </span>
                    </div>
                </div>

                <div class="mt-3">
                    <span id="preview-card-title" class="fw-bold text-dark d-block">{{ $pusatInformasi->judul ?: 'Judul Kartu' }}</span>
                    <small id="preview-url-indicator" class="text-muted d-block text-truncate" style="max-width: 220px; margin: 0 auto;">
                        {{ $pusatInformasi->button_url ?: 'Link belum diatur' }}
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const fileInput = document.getElementById('gambar');
        const driveInput = document.getElementById('link_drive');
        const btnTextInput = document.getElementById('button_text');
        const btnUrlInput = document.getElementById('button_url');
        const titleInput = document.getElementById('judul');

        const previewBox = document.getElementById('card-preview-box');
        const previewBtn = document.getElementById('preview-btn-label');
        const previewTitle = document.getElementById('preview-card-title');
        const previewUrl = document.getElementById('preview-url-indicator');

        const initialImageUrl = "{{ $pusatInformasi->image_url ?? '' }}";

        // Update button text
        if (btnTextInput && previewBtn) {
            btnTextInput.addEventListener('input', function () {
                previewBtn.textContent = this.value.trim() ? this.value : 'Lihat';
            });
        }

        // Update title
        if (titleInput && previewTitle) {
            titleInput.addEventListener('input', function () {
                previewTitle.textContent = this.value.trim() ? this.value : 'Judul Kartu';
            });
        }

        // Update URL preview
        if (btnUrlInput && previewUrl) {
            btnUrlInput.addEventListener('input', function () {
                previewUrl.textContent = this.value.trim() ? this.value : 'Link belum diatur';
            });
        }

        // Convert drive link
        function formatDriveUrl(url) {
            if (!url) return '';
            const match = url.match(/(?:drive\.google\.com\/(?:file\/d\/|open\?id=)|id=)([a-zA-Z0-9_-]{25,})/i);
            if (match && match[1]) {
                return 'https://lh3.googleusercontent.com/d/' + match[1];
            }
            return url;
        }

        // Update preview from drive input
        if (driveInput) {
            driveInput.addEventListener('input', function () {
                const url = this.value.trim();
                if (url) {
                    const cdnUrl = formatDriveUrl(url);
                    previewBox.style.backgroundImage = "url('" + cdnUrl + "')";
                    previewBox.style.backgroundSize = "cover";
                    previewBox.style.backgroundPosition = "center";
                } else if (fileInput.files.length) {
                    // fall back to uploaded file
                } else if (initialImageUrl) {
                    previewBox.style.backgroundImage = "url('" + initialImageUrl + "')";
                } else {
                    previewBox.style.backgroundImage = "none";
                }
            });
        }

        // Update preview from file input
        if (fileInput) {
            fileInput.addEventListener('change', function () {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        previewBox.style.backgroundImage = "url('" + e.target.result + "')";
                        previewBox.style.backgroundSize = "cover";
                        previewBox.style.backgroundPosition = "center";
                    };
                    reader.readAsDataURL(this.files[0]);
                } else {
                    const driveUrl = driveInput ? driveInput.value.trim() : '';
                    if (driveUrl) {
                        const cdnUrl = formatDriveUrl(driveUrl);
                        previewBox.style.backgroundImage = "url('" + cdnUrl + "')";
                        previewBox.style.backgroundSize = "cover";
                        previewBox.style.backgroundPosition = "center";
                    } else if (initialImageUrl) {
                        previewBox.style.backgroundImage = "url('" + initialImageUrl + "')";
                    } else {
                        previewBox.style.backgroundImage = "none";
                    }
                }
            });
        }
    });
</script>
@endpush
