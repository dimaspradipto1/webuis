@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Edit Media Sosial</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('social-media.index', ['kategori' => $socialMedia->kategori ?? 'universitas']) }}">Media Sosial {{ ($socialMedia->kategori ?? '') === 'humas' ? 'Humas' : 'Universitas' }}</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-8 col-md-10">
        <div class="card shadow-sm border-0" style="border-radius: 12px;">
            <div class="card-header bg-white py-3" style="border-top: 3px solid #046B26; border-radius: 12px 12px 0 0;">
                <h5 class="mb-0 fw-bold" style="color: #2b2f32; font-size: 16px;">
                    <i class="bi bi-pencil-square me-2" style="color: #046B26;"></i>Edit Data Media Sosial
                </h5>
            </div>
            <div class="card-body pt-4">

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <strong>Periksa kembali data yang diinput:</strong>
                        <ul class="mb-0 mt-1 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('social-media.update', $socialMedia->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Kategori Media Sosial --}}
                    <div class="mb-3">
                        <label for="kategori" class="form-label fw-bold text-dark">
                            Kategori Penempatan <span class="text-danger">*</span>
                        </label>
                        <select name="kategori" id="kategori" class="form-select @error('kategori') is-invalid @enderror" required>
                            <option value="universitas" {{ old('kategori', $socialMedia->kategori ?? 'universitas') === 'universitas' ? 'selected' : '' }}>
                                🏛️ Media Sosial Universitas (Tampil di Beranda Utama UIS)
                            </option>
                            <option value="humas" {{ old('kategori', $socialMedia->kategori) === 'humas' ? 'selected' : '' }}>
                                📢 Media Sosial Humas (Tampil di Beranda Humas & Smartphone Video Mockup)
                            </option>
                        </select>
                        <div class="form-text">Pilih apakah platform ini milik Universitas atau Humas.</div>
                        @error('kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Nama Platform --}}
                    <div class="mb-3">
                        <label for="nama" class="form-label fw-bold text-dark">
                            Nama Media Sosial / Platform <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               id="nama"
                               name="nama"
                               class="form-control @error('nama') is-invalid @enderror"
                               value="{{ old('nama', $socialMedia->nama) }}"
                               placeholder="Contoh: TikTok / Facebook / Instagram / WhatsApp / YouTube"
                               required>
                        <div class="form-text">Nama media sosial yang akan tampil saat di-hover / tooltip.</div>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Upload / Ganti Logo PNG & Live Preview --}}
                    <div class="mb-4">
                        <label for="logo" class="form-label fw-bold text-dark">
                            Upload / Ganti Logo (Format PNG)
                        </label>
                        
                        <input type="file"
                               id="logo"
                               name="logo"
                               class="form-control @error('logo') is-invalid @enderror"
                               accept="image/png,image/webp,image/svg+xml">
                        <div class="form-text mt-1">
                            Format file yang didukung: <strong>PNG (disarankan transparan)</strong>, WebP, SVG. Maks 20 MB.
                        </div>
                        @error('logo')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror

                        {{-- Area Preview Logo --}}
                        <div class="mt-3 p-3 bg-light rounded-3 border">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="small fw-bold text-muted text-uppercase" style="letter-spacing: 0.5px;">
                                    <i class="bi bi-eye me-1 text-success"></i> Preview Logo
                                </span>
                                <span id="preview-badge" class="badge {{ $socialMedia->logo_url ? 'bg-success' : 'bg-secondary' }}" style="font-size: 11px;">
                                    {{ $socialMedia->logo_url ? 'Logo Saat Ini' : 'Belum Ada Logo' }}
                                </span>
                            </div>
                            
                            <div class="d-flex align-items-center gap-3">
                                {{-- Box Preview Logo Langsung (Tanpa Background Hijau) --}}
                                <div id="preview-container" class="d-flex align-items-center justify-content-center rounded-3 border bg-white p-1"
                                     style="width: 58px; height: 58px; flex-shrink: 0; box-shadow: 0 1px 4px rgba(0,0,0,0.06);">
                                    @if($socialMedia->logo_url)
                                        <img id="preview-img" src="{{ $socialMedia->logo_url }}" alt="{{ $socialMedia->nama }}"
                                             style="max-width: 48px; max-height: 48px; object-fit: contain; border-radius: 6px;">
                                        <div id="preview-placeholder" class="d-none text-muted text-center" style="font-size: 11px; line-height: 1.2;">
                                            <i class="bi bi-image d-block fs-5 mb-1 text-secondary"></i>Preview
                                        </div>
                                    @else
                                        <img id="preview-img" src="" alt="Preview Logo" class="d-none"
                                             style="max-width: 48px; max-height: 48px; object-fit: contain; border-radius: 6px;">
                                        <div id="preview-placeholder" class="text-muted text-center" style="font-size: 11px; line-height: 1.2;">
                                            <i class="bi bi-image d-block fs-5 mb-1 text-secondary"></i>Preview
                                        </div>
                                    @endif
                                </div>

                                {{-- Keterangan Preview --}}
                                <div class="small text-muted flex-grow-1" id="preview-note">
                                    @if($socialMedia->logo_url)
                                        Menampilkan logo PNG yang tersimpan saat ini. Bila Anda memilih file baru, tampilan di kotak ini akan berganti secara otomatis.
                                    @else
                                        Belum ada logo PNG yang diunggah. Silakan pilih file gambar PNG di atas untuk menampilkan logo di website.
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- URL Tujuan --}}
                    <div class="mb-3">
                        <label for="url" class="form-label fw-bold text-dark">
                            Link / URL Akun Media Sosial <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted"><i class="bi bi-link-45deg fs-5"></i></span>
                            <input type="text"
                                   id="url"
                                   name="url"
                                   class="form-control @error('url') is-invalid @enderror"
                                   value="{{ old('url', $socialMedia->url) }}"
                                   placeholder="Contoh: https://tiktok.com/@universitasibnusina atau https://instagram.com/uis_official"
                                   required>
                        </div>
                        <div class="form-text">Tautan utama ke profil akun media sosial (akan membuka di tab baru).</div>
                        @error('url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Username / Handle Akun --}}
                    <div class="mb-4">
                        <label for="handle" class="form-label fw-bold text-dark">
                            Username / Handle Akun
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted">@</span>
                            <input type="text"
                                   id="handle"
                                   name="handle"
                                   class="form-control @error('handle') is-invalid @enderror"
                                   value="{{ old('handle', ltrim($socialMedia->handle ?? '', '@')) }}"
                                   placeholder="universitasibnusina atau humas_uis">
                        </div>
                        <div class="form-text">Teks handle akun yang tampil di bawah layar card smartphone (contoh: @universitasibnusina).</div>
                        @error('handle')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- SEKSI VIDEO TERBARU DARI LINK MEDIA SOSIAL --}}
                    <div class="p-3 mb-4 rounded-3 border" style="background: #fbfcfe; border-left: 4px solid #FED802 !important;">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <h6 class="fw-bold text-dark mb-0">
                                <i class="bi bi-camera-reels text-warning me-2"></i>Link Video Sosial Media
                            </h6>
                            <span class="badge bg-warning text-dark px-2 py-1" style="font-size: 11px;">
                                <i class="bi bi-lightning-fill me-1"></i>Video Layar Card
                            </span>
                        </div>
                        <div class="small text-muted mb-3">
                            Masukkan link video media sosial terbaru (TikTok, Instagram Reels, YouTube Shorts/Video, Facebook) untuk ditampilkan di card smartphone pada Beranda Humas.
                        </div>

                        {{-- Link Video / Postingan Media Sosial --}}
                        <div class="mb-3">
                            <label for="video_url" class="form-label fw-bold text-dark">
                                Link / URL Video Media Sosial <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-white text-danger fw-bold"><i class="bi bi-play-circle-fill fs-5"></i></span>
                                <input type="text"
                                       id="video_url"
                                       name="video_url"
                                       class="form-control @error('video_url') is-invalid @enderror"
                                       value="{{ old('video_url', $socialMedia->video_url) }}"
                                       placeholder="Contoh: https://www.tiktok.com/@universitasibnusina/video/... atau https://instagram.com/reel/... atau https://youtu.be/...">
                            </div>
                            <div class="form-text">
                                Cukup tempelkan (paste) tautan video dari TikTok, Instagram Reels, YouTube, atau MP4. Sistem otomatis membaca dan menampilkan preview video.
                            </div>
                            @error('video_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Judul / Caption Video --}}
                        <div class="mb-3">
                            <label for="video_judul" class="form-label fw-bold text-dark">
                                Judul / Keterangan Video Terbaru (Opsional)
                            </label>
                            <input type="text"
                                   id="video_judul"
                                   name="video_judul"
                                   class="form-control @error('video_judul') is-invalid @enderror"
                                   value="{{ old('video_judul', $socialMedia->video_judul) }}"
                                   placeholder="Contoh: Highlight Dies Natalis & Prestasi Mahasiswa UIS 2026">
                            <div class="form-text">Judul atau deskripsi singkat yang muncul pada overlay layar card smartphone.</div>
                            @error('video_judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Area Live Preview Video dari Link --}}
                        <div class="p-3 bg-white rounded-3 border mb-3">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="small fw-bold text-muted text-uppercase" style="letter-spacing: 0.5px;">
                                    <i class="bi bi-display me-1 text-primary"></i> Preview Video Layar Card
                                </span>
                                <span id="preview-video-badge" class="badge {{ $socialMedia->video_embed_url ? 'bg-success' : 'bg-secondary' }}" style="font-size: 11px;">
                                    {{ $socialMedia->video_embed_url ? 'Video Terhubung' : ($socialMedia->video_url ? 'Link Terpasang' : 'Belum Ada Link Video') }}
                                </span>
                            </div>

                            <div id="preview-video-box"
                                 class="position-relative rounded-3 overflow-hidden border bg-dark d-flex align-items-center justify-content-center"
                                 style="max-width: 300px; height: 340px; margin: 0 auto; box-shadow: 0 4px 14px rgba(0,0,0,0.2);">
                                @if(!empty($socialMedia->video_embed_url))
                                    @if(preg_match('/\.(mp4|webm|ogg)$/i', $socialMedia->video_embed_url))
                                        <video src="{{ $socialMedia->video_embed_url }}" controls playsinline class="w-100 h-100" style="object-fit: cover;"></video>
                                    @else
                                        <iframe src="{{ $socialMedia->video_embed_url }}"
                                                class="w-100 h-100"
                                                style="border: none;"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                allowfullscreen>
                                        </iframe>
                                    @endif
                                @elseif(!empty($socialMedia->video_url))
                                    <div class="text-white text-center p-3">
                                        <i class="bi bi-play-circle text-warning fs-1 mb-2 d-block"></i>
                                        <div class="small fw-semibold text-truncate px-2">{{ $socialMedia->video_url }}</div>
                                        <span class="badge bg-warning text-dark mt-2" style="font-size: 11px;">Link Media Sosial</span>
                                    </div>
                                @else
                                    <div class="text-white text-center p-3">
                                        <i class="bi bi-play-btn text-warning fs-1 mb-2 d-block"></i>
                                        <span class="small opacity-75">Masukkan link video di atas untuk melihat preview</span>
                                    </div>
                                @endif
                            </div>
                            <div class="small text-muted text-center mt-2" id="preview-video-note">
                                @if(!empty($socialMedia->video_embed_url))
                                    Video dari tautan media sosial siap ditampilkan pada card smartphone.
                                @else
                                    Tempelkan tautan video TikTok, Reels, atau YouTube pada input di atas.
                                @endif
                            </div>
                        </div>

                        {{-- Opsi Tambahan: Upload Thumbnail Kustom (Opsional) --}}
                        <div class="accordion accordion-flush" id="accordionThumbnail">
                            <div class="accordion-item bg-transparent">
                                <h2 class="accordion-header" id="headingThumb">
                                    <button class="accordion-button collapsed px-0 py-2 bg-transparent text-secondary small fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThumb">
                                        <i class="bi bi-image me-1"></i> Opsional: Upload Gambar Thumbnail Poster Manual
                                    </button>
                                </h2>
                                <div id="collapseThumb" class="accordion-collapse collapse" data-bs-parent="#accordionThumbnail">
                                    <div class="accordion-body px-0 pt-2 pb-0">
                                        <input type="file"
                                               id="thumbnail_video"
                                               name="thumbnail_video"
                                               class="form-control form-control-sm @error('thumbnail_video') is-invalid @enderror"
                                               accept="image/jpeg,image/png,image/webp">
                                        <div class="form-text">Gunakan opsi ini hanya jika ingin mengganti poster video bawaan dengan file gambar sendiri.</div>
                                        @if($socialMedia->thumbnail_video_url && !$socialMedia->isVideoFile())
                                            <div class="mt-2 small text-success">
                                                <i class="bi bi-check-circle me-1"></i>Thumbnail custom tersimpan: <a href="{{ $socialMedia->thumbnail_video_url }}" target="_blank">Lihat Gambar</a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- Urutan Tampil --}}
                    <div class="mb-3">
                        <label for="urutan" class="form-label fw-bold text-dark">
                            Urutan Tampil (Posisi Kiri ke Kanan)
                        </label>
                        <input type="number"
                               id="urutan"
                               name="urutan"
                               class="form-control @error('urutan') is-invalid @enderror"
                               value="{{ old('urutan', $socialMedia->urutan) }}"
                               min="0"
                               style="max-width: 140px;">
                        <div class="form-text">Urutan posisi ikon dari kiri ke kanan (angka terkecil tampil lebih awal).</div>
                        @error('urutan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Status Aktif --}}
                    <div class="mb-4">
                        <div class="form-check form-switch fs-5">
                            <input class="form-check-input"
                                   type="checkbox"
                                   role="switch"
                                   id="is_active"
                                   name="is_active"
                                   value="1"
                                   {{ old('is_active', $socialMedia->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label fs-6 fw-bold text-dark ms-2" for="is_active">
                                Aktifkan Media Sosial (Tampil di Frontend)
                            </label>
                        </div>
                        <div class="form-text ms-1">Jika dinonaktifkan, logo tidak akan muncul di beranda.</div>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                        <a href="{{ route('social-media.index', ['kategori' => old('kategori', $socialMedia->kategori ?? 'universitas')]) }}" class="btn btn-outline-secondary px-4">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                        <button type="submit" class="btn fw-semibold shadow-sm px-4" style="background-color: #046B26; color: #ffffff; border: none;">
                            <i class="bi bi-save me-1"></i> Perbarui Media Sosial
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
    document.addEventListener('DOMContentLoaded', function () {
        // Preview Logo
        const logoInput = document.getElementById('logo');
        const previewImg = document.getElementById('preview-img');
        const placeholder = document.getElementById('preview-placeholder');
        const previewBadge = document.getElementById('preview-badge');
        const previewNote = document.getElementById('preview-note');

        if (logoInput) {
            logoInput.addEventListener('change', function () {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        previewImg.src = e.target.result;
                        previewImg.classList.remove('d-none');
                        if (placeholder) placeholder.classList.add('d-none');
                        if (previewBadge) {
                            previewBadge.className = 'badge bg-warning text-dark';
                            previewBadge.textContent = 'Preview File Baru';
                        }
                        if (previewNote) {
                            previewNote.innerHTML = '<span class="text-success fw-bold"><i class="bi bi-check-circle-fill me-1"></i>File terpilih: ' + file.name + '</span> (' + (file.size / 1024).toFixed(1) + ' KB)';
                        }
                    };
                    reader.readAsDataURL(file);
                }
            });
        }

        // Live Preview Realtime dari Link Video Sosial Media
        const videoUrlInput = document.getElementById('video_url');
        const previewVideoBox = document.getElementById('preview-video-box');
        const previewVideoBadge = document.getElementById('preview-video-badge');
        const previewVideoNote = document.getElementById('preview-video-note');

        function updateVideoPreviewFromUrl(url) {
            if (!previewVideoBox) return;

            if (!url || !url.trim()) {
                previewVideoBox.innerHTML = `
                    <div class="text-white text-center p-3">
                        <i class="bi bi-play-btn text-warning fs-1 mb-2 d-block"></i>
                        <span class="small opacity-75">Masukkan link video di atas untuk melihat preview</span>
                    </div>`;
                if (previewVideoBadge) {
                    previewVideoBadge.className = 'badge bg-secondary';
                    previewVideoBadge.textContent = 'Belum Ada Link Video';
                }
                if (previewVideoNote) previewVideoNote.textContent = 'Tempelkan tautan video TikTok, Reels, atau YouTube pada input di atas.';
                return;
            }

            url = url.trim();
            let embedUrl = null;
            let platform = 'Video';

            // Iframe src check
            const iframeMatch = url.match(/src=["']([^"']+)["']/i);
            if (iframeMatch) {
                embedUrl = iframeMatch[1];
                platform = 'Embed Video';
            }

            // YouTube
            const ytMatch = url.match(/(?:youtube\.com\/(?:watch\?v=|shorts\/|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/i);
            if (ytMatch) {
                embedUrl = 'https://www.youtube.com/embed/' + ytMatch[1] + '?rel=0';
                platform = 'YouTube';
            }

            // TikTok (video, photo, or numeric ID)
            if (url.toLowerCase().includes('tiktok.com')) {
                const ttMatch = url.match(/(?:\/(?:video|photo|embed\/v2|embed|v|player\/v1)\/)?(\d{15,25})/i);
                if (ttMatch) {
                    embedUrl = 'https://www.tiktok.com/player/v1/' + ttMatch[1];
                    platform = 'TikTok';
                }
            }

            // Instagram
            const igMatch = url.match(/instagram\.com\/(?:reel|p)\/([a-zA-Z0-9_-]+)/i);
            if (igMatch) {
                embedUrl = 'https://www.instagram.com/reel/' + igMatch[1] + '/embed/';
                platform = 'Instagram';
            }

            // Facebook
            if (url.toLowerCase().includes('facebook.com') || url.toLowerCase().includes('fb.watch')) {
                const isFbVideo = url.toLowerCase().includes('watch') || url.toLowerCase().includes('reel') || url.toLowerCase().includes('/videos/');
                if (isFbVideo) {
                    embedUrl = 'https://www.facebook.com/plugins/video.php?href=' + encodeURIComponent(url) + '&show_text=false&autoplay=true&mute=1&width=500';
                    platform = 'Facebook Video';
                } else {
                    embedUrl = 'https://www.facebook.com/plugins/post.php?href=' + encodeURIComponent(url) + '&show_text=false&width=500';
                    platform = 'Facebook Post';
                }
            }

            // MP4 direct file
            if (url.match(/\.(mp4|webm|ogg)$/i)) {
                previewVideoBox.innerHTML = `<video src="${url}" controls playsinline class="w-100 h-100" style="object-fit: cover;"></video>`;
                if (previewVideoBadge) {
                    previewVideoBadge.className = 'badge bg-success';
                    previewVideoBadge.innerHTML = '<i class="bi bi-check-circle-fill me-1"></i>File Video Langsung';
                }
                if (previewVideoNote) previewVideoNote.innerHTML = '<span class="text-success fw-bold">Link video MP4 terdeteksi</span>';
                return;
            }

            if (embedUrl) {
                previewVideoBox.innerHTML = `
                    <iframe src="${embedUrl}" 
                            class="w-100 h-100" 
                            style="border: none;" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen>
                    </iframe>`;
                if (previewVideoBadge) {
                    previewVideoBadge.className = 'badge bg-success';
                    previewVideoBadge.innerHTML = `<i class="bi bi-check-circle-fill me-1"></i>${platform} Terhubung`;
                }
                if (previewVideoNote) previewVideoNote.innerHTML = `<span class="text-success fw-bold"><i class="bi bi-check2-circle me-1"></i>Preview video ${platform} aktif.</span>`;
            } else {
                previewVideoBox.innerHTML = `
                    <div class="text-white text-center p-3">
                        <i class="bi bi-play-circle text-warning fs-1 mb-2 d-block"></i>
                        <div class="small fw-semibold text-truncate px-2" style="max-width: 280px;">${url}</div>
                        <span class="badge bg-warning text-dark mt-2" style="font-size: 11px;">Link Media Sosial</span>
                    </div>`;
                if (previewVideoBadge) {
                    previewVideoBadge.className = 'badge bg-info text-dark';
                    previewVideoBadge.textContent = 'Link Terpasang';
                }
                if (previewVideoNote) previewVideoNote.textContent = 'Link postingan media sosial akan terbuka saat pengunjung mengklik card di website.';
            }
        }

        if (videoUrlInput) {
            videoUrlInput.addEventListener('input', function () {
                updateVideoPreviewFromUrl(this.value);
            });
            videoUrlInput.addEventListener('change', function () {
                updateVideoPreviewFromUrl(this.value);
            });
        }
    });
</script>
@endpush
