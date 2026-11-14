@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Tentang UIS</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Profil</li>
            <li class="breadcrumb-item active">Tentang UIS</li>
        </ol>
    </nav>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-1"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row">
    <div class="col-lg-10">
        <div class="card shadow-sm">
            <div class="card-header py-3 d-flex flex-wrap align-items-center justify-content-between gap-2">
                <h5 class="mb-0 fw-semibold">
                    <i class="bi bi-pencil-square me-2 text-primary"></i>Form Sunting Profil Tentang UIS
                </h5>
                <a href="{{ route('homepage.tentang') }}" target="_blank" class="btn btn-sm btn-outline-success">
                    <i class="bi bi-box-arrow-up-right me-1"></i> Lihat Halaman
                </a>
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

                <form action="{{ route('about.update', $about->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- SECTION 1: PROFIL UNIVERSITAS & VIDEO -->
                    <div class="border-bottom pb-4 mb-4">
                        <h6 class="fw-bold text-primary mb-3"><i class="bi bi-building me-2"></i>1. Profil Universitas & Video Profil</h6>
                        
                        <div class="mb-3">
                            <label for="judul_profil" class="form-label fw-semibold">Judul Profil Universitas</label>
                            <input type="text" id="judul_profil" name="judul_profil" class="form-control @error('judul_profil') is-invalid @enderror" value="{{ old('judul_profil', $about->judul_profil) }}" placeholder="Contoh: Kampusnya Profesional Muda — Universitas Ibnu Sina">
                            @error('judul_profil')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="deskripsi_profil_1" class="form-label fw-semibold">Deskripsi Profil Universitas</label>
                            <textarea id="deskripsi_profil_1" name="deskripsi_profil_1" rows="6" class="form-control tinymce-editor @error('deskripsi_profil_1') is-invalid @enderror" placeholder="Tuliskan deskripsi profil resmi Universitas Ibnu Sina">{{ old('deskripsi_profil_1', $about->deskripsi_profil_1) }}</textarea>
                            @error('deskripsi_profil_1')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text text-muted">Deskripsi profil universitas dalam satu narasi utuh yang ditampilkan di beranda dan halaman tentang.</div>
                        </div>

                        <!-- VIDEO PROFIL SECTION -->
                        <div class="card bg-light border-0 p-3 rounded-3 mt-3">
                            <h6 class="fw-bold text-dark mb-3">
                                <i class="bi bi-camera-video-fill me-2 text-danger"></i>Video Profil Universitas
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-7">
                                    <label for="video_url" class="form-label fw-semibold small">Link Video (YouTube / External URL)</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white"><i class="bi bi-link-45deg"></i></span>
                                        <input type="text" id="video_url" name="video_url" class="form-control @error('video_url') is-invalid @enderror" value="{{ old('video_url', $about->video_url) }}" placeholder="Tempel link (Salin) atau kode sematan (Sematkan) dari YouTube">
                                    </div>
                                    @error('video_url')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text small text-muted">
                                        <i class="bi bi-info-circle me-1 text-success"></i>Bisa pakai link <strong>Salin</strong> (<code>https://youtu.be/...</code>) maupun kode <strong>Sematkan</strong> (<code>&lt;iframe...&gt;</code>). Sistem otomatis merapikannya.
                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <label for="video_file" class="form-label fw-semibold small">Atau Upload File Video (MP4 / WebM)</label>
                                    <input type="file" id="video_file" name="video_file" class="form-control @error('video_file') is-invalid @enderror" accept="video/mp4,video/webm,video/ogg">
                                    @error('video_file')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text small">Maksimal 50 MB (format MP4/WebM).</div>
                                </div>
                            </div>

                            @if($about->hasVideo())
                                <div class="mt-3 pt-3 border-top">
                                    <div class="fw-semibold small text-muted mb-2"><i class="bi bi-play-circle-fill me-1 text-success"></i>Video Profil Saat Ini:</div>
                                    <div class="row align-items-center">
                                        <div class="col-md-6">
                                            @if($about->video_file)
                                                <video controls class="w-100 rounded-3 shadow-sm" style="max-height: 220px; background: #000;">
                                                    <source src="{{ asset('storage/' . $about->video_file) }}">
                                                    Browser Anda tidak mendukung tag video.
                                                </video>
                                                <div class="form-check mt-2">
                                                    <input class="form-check-input" type="checkbox" name="delete_video_file" id="delete_video_file" value="1">
                                                    <label class="form-check-label text-danger small" for="delete_video_file">
                                                        Hapus file video yang diunggah
                                                    </label>
                                                </div>
                                            @elseif($about->youtube_embed_url)
                                                <div class="ratio ratio-16x9 rounded-3 overflow-hidden shadow-sm" style="max-height: 240px;">
                                                    <iframe 
                                                        src="{{ $about->youtube_embed_url }}" 
                                                        title="Video Profil UIS" 
                                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                                        referrerpolicy="strict-origin-when-cross-origin" 
                                                        allowfullscreen>
                                                    </iframe>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-md-6 mt-2 mt-md-0">
                                            @if($about->video_url)
                                                <p class="mb-1 small"><strong>Link Aktif:</strong> <a href="{{ $about->video_url }}" target="_blank" rel="noopener" class="text-primary">{{ $about->video_url }}</a></p>
                                            @endif
                                            @if($about->video_file)
                                                <p class="mb-0 small"><strong>File Aktif:</strong> <span class="badge bg-secondary">{{ basename($about->video_file) }}</span></p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- SECTION 2: VISI & MISI -->
                    <div class="border-bottom pb-3 mb-4">
                        <h6 class="fw-bold text-primary mb-3"><i class="bi bi-eye me-2"></i>2. Visi & Misi</h6>

                        <div class="row mb-3">
                            <div class="col-md-8">
                                <label for="visi_judul" class="form-label fw-semibold">Judul Kartu Visi</label>
                                <input type="text" id="visi_judul" name="visi_judul" class="form-control" value="{{ old('visi_judul', $about->visi_judul) }}" placeholder="Visi Kami">
                            </div>
                            <div class="col-md-4">
                                <label for="visi_icon" class="form-label fw-semibold">Icon Visi <small class="text-muted">(Bootstrap Icon Class)</small></label>
                                <input type="text" id="visi_icon" name="visi_icon" class="form-control" value="{{ old('visi_icon', $about->visi_icon) }}" placeholder="bi-eye">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="visi" class="form-label fw-semibold">Deskripsi Visi</label>
                            <textarea id="visi" name="visi" rows="3" class="form-control @error('visi') is-invalid @enderror" placeholder="Pernyataan Visi Perusahaan">{{ old('visi', $about->visi) }}</textarea>
                            @error('visi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-8">
                                <label for="misi_judul" class="form-label fw-semibold">Judul Kartu Misi</label>
                                <input type="text" id="misi_judul" name="misi_judul" class="form-control" value="{{ old('misi_judul', $about->misi_judul) }}" placeholder="Misi Kami">
                            </div>
                            <div class="col-md-4">
                                <label for="misi_icon" class="form-label fw-semibold">Icon Misi <small class="text-muted">(Bootstrap Icon Class)</small></label>
                                <input type="text" id="misi_icon" name="misi_icon" class="form-control" value="{{ old('misi_icon', $about->misi_icon) }}" placeholder="bi-rocket-takeoff">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="misi" class="form-label fw-semibold">Poin-Poin Misi <small class="text-muted">(Gunakan tombol Enter untuk memisahkan setiap poin misi)</small></label>
                            <textarea id="misi" name="misi" rows="5" class="form-control @error('misi') is-invalid @enderror" placeholder="Contoh:&#10;Menyediakan produk berkualitas tinggi.&#10;Memberikan layanan terbaik.">{{ old('misi', $about->misi) }}</textarea>
                            @error('misi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- SECTION 3: NILAI UTAMA KAMI -->
                    <div class="border-bottom pb-3 mb-4">
                        <h6 class="fw-bold text-primary mb-3"><i class="bi bi-award me-2"></i>3. Nilai Utama Kami (Values)</h6>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="judul_nilai" class="form-label fw-semibold">Judul Section Nilai</label>
                                <input type="text" id="judul_nilai" name="judul_nilai" class="form-control" value="{{ old('judul_nilai', $about->judul_nilai) }}" placeholder="Contoh: Prinsip Kerja yang Kami Pegang Teguh">
                            </div>
                            <div class="col-md-6">
                                <label for="deskripsi_nilai" class="form-label fw-semibold">Deskripsi Section Nilai</label>
                                <input type="text" id="deskripsi_nilai" name="deskripsi_nilai" class="form-control" value="{{ old('deskripsi_nilai', $about->deskripsi_nilai) }}" placeholder="Contoh: Kualitas dan kepercayaan bukanlah sebuah kebetulan...">
                            </div>
                        </div>

                        <div class="row g-3">
                            <!-- Card 1 -->
                            <div class="col-md-6">
                                <div class="p-3 border rounded bg-light">
                                    <div class="fw-bold text-secondary mb-2"><i class="bi bi-1-circle-fill"></i> Nilai 1</div>
                                    <div class="mb-2">
                                        <label class="form-label small">Judul</label>
                                        <input type="text" name="nilai_1_judul" class="form-control form-control-sm" value="{{ old('nilai_1_judul', $about->nilai_1_judul) }}" placeholder="Kualitas Bersertifikasi">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label small">Deskripsi</label>
                                        <textarea name="nilai_1_deskripsi" rows="2" class="form-control form-control-sm" placeholder="Deskripsi nilai 1">{{ old('nilai_1_deskripsi', $about->nilai_1_deskripsi) }}</textarea>
                                    </div>
                                    <div>
                                        <label class="form-label small">Icon (Bootstrap Icon Class)</label>
                                        <input type="text" name="nilai_1_icon" class="form-control form-control-sm" value="{{ old('nilai_1_icon', $about->nilai_1_icon) }}" placeholder="bi-shield-fill-check">
                                    </div>
                                </div>
                            </div>

                            <!-- Card 2 -->
                            <div class="col-md-6">
                                <div class="p-3 border rounded bg-light">
                                    <div class="fw-bold text-secondary mb-2"><i class="bi bi-2-circle-fill"></i> Nilai 2</div>
                                    <div class="mb-2">
                                        <label class="form-label small">Judul</label>
                                        <input type="text" name="nilai_2_judul" class="form-control form-control-sm" value="{{ old('nilai_2_judul', $about->nilai_2_judul) }}" placeholder="Keanekaragaman Motif">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label small">Deskripsi</label>
                                        <textarea name="nilai_2_deskripsi" rows="2" class="form-control form-control-sm" placeholder="Deskripsi nilai 2">{{ old('nilai_2_deskripsi', $about->nilai_2_deskripsi) }}</textarea>
                                    </div>
                                    <div>
                                        <label class="form-label small">Icon (Bootstrap Icon Class)</label>
                                        <input type="text" name="nilai_2_icon" class="form-control form-control-sm" value="{{ old('nilai_2_icon', $about->nilai_2_icon) }}" placeholder="bi-palette-fill">
                                    </div>
                                </div>
                            </div>

                            <!-- Card 3 -->
                            <div class="col-md-6">
                                <div class="p-3 border rounded bg-light">
                                    <div class="fw-bold text-secondary mb-2"><i class="bi bi-3-circle-fill"></i> Nilai 3</div>
                                    <div class="mb-2">
                                        <label class="form-label small">Judul</label>
                                        <input type="text" name="nilai_3_judul" class="form-control form-control-sm" value="{{ old('nilai_3_judul', $about->nilai_3_judul) }}" placeholder="Fokus pada Pelanggan">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label small">Deskripsi</label>
                                        <textarea name="nilai_3_deskripsi" rows="2" class="form-control form-control-sm" placeholder="Deskripsi nilai 3">{{ old('nilai_3_deskripsi', $about->nilai_3_deskripsi) }}</textarea>
                                    </div>
                                    <div>
                                        <label class="form-label small">Icon (Bootstrap Icon Class)</label>
                                        <input type="text" name="nilai_3_icon" class="form-control form-control-sm" value="{{ old('nilai_3_icon', $about->nilai_3_icon) }}" placeholder="bi-people-fill">
                                    </div>
                                </div>
                            </div>

                            <!-- Card 4 -->
                            <div class="col-md-6">
                                <div class="p-3 border rounded bg-light">
                                    <div class="fw-bold text-secondary mb-2"><i class="bi bi-4-circle-fill"></i> Nilai 4</div>
                                    <div class="mb-2">
                                        <label class="form-label small">Judul</label>
                                        <input type="text" name="nilai_4_judul" class="form-control form-control-sm" value="{{ old('nilai_4_judul', $about->nilai_4_judul) }}" placeholder="Distribusi Aman">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label small">Deskripsi</label>
                                        <textarea name="nilai_4_deskripsi" rows="2" class="form-control form-control-sm" placeholder="Deskripsi nilai 4">{{ old('nilai_4_deskripsi', $about->nilai_4_deskripsi) }}</textarea>
                                    </div>
                                    <div>
                                        <label class="form-label small">Icon (Bootstrap Icon Class)</label>
                                        <input type="text" name="nilai_4_icon" class="form-control form-control-sm" value="{{ old('nilai_4_icon', $about->nilai_4_icon) }}" placeholder="bi-truck-flatbed">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Buttons --}}
                    <div class="d-flex gap-2">
                        <a href="{{ route('about.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-counterclockwise me-1"></i> Batalkan Perubahan
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Simpan Perubahan
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
        const videoInput = document.getElementById('video_url');
        if (videoInput) {
            function cleanInput() {
                let val = videoInput.value.trim();
                // Jika user mem-paste seluruh tag <iframe>
                const match = val.match(/<iframe.*?src=["']([^"']+)["']/i);
                if (match && match[1]) {
                    videoInput.value = match[1];
                }
            }
            videoInput.addEventListener('input', cleanInput);
            videoInput.addEventListener('paste', function () {
                setTimeout(cleanInput, 50);
            });
        }
    });
</script>
@endpush
