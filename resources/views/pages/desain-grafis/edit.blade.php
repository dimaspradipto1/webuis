@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Edit Templat Desain Grafis</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('desain-grafis.index') }}">Desain Grafis Humas</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-8 col-md-10">
        <div class="card shadow-sm">
            <div class="card-header py-3">
                <h5 class="mb-0 fw-semibold">
                    <i class="bi bi-pencil-square me-2 text-warning"></i>Form Edit Templat Desain Grafis
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

                <form action="{{ route('desain-grafis.update', $desainGrafis->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Judul Templat -->
                    <div class="mb-3">
                        <label for="judul" class="form-label fw-semibold">Judul Templat <span class="text-danger">*</span></label>
                        <input type="text" id="judul" name="judul"
                               class="form-control @error('judul') is-invalid @enderror"
                               value="{{ old('judul', $desainGrafis->judul) }}"
                               placeholder="Contoh: LED Tengah Audit #1" required>
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Kategori Ruangan -->
                    <div class="mb-3">
                        <label for="kategori" class="form-label fw-semibold">Kategori Lokasi / Ruangan <span class="text-danger">*</span></label>
                        <select id="kategori" name="kategori" class="form-select @error('kategori') is-invalid @enderror" required>
                            <option value="audit" {{ old('kategori', $desainGrafis->kategori) == 'audit' ? 'selected' : '' }}>🏛️ Auditorium lt. 4 Rektorat</option>
                            <option value="sidang" {{ old('kategori', $desainGrafis->kategori) == 'sidang' ? 'selected' : '' }}>📺 Ruang Sidang lt. 2 Rektorat</option>
                            <option value="dekanat" {{ old('kategori', $desainGrafis->kategori) == 'dekanat' ? 'selected' : '' }}>🏢 Ruang Rapat Dekanat</option>
                            <option value="spanduk" {{ old('kategori', $desainGrafis->kategori) == 'spanduk' ? 'selected' : '' }}>🚩 Banner & Spanduk Outdoor</option>
                        </select>
                        @error('kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Badge Format / Dimensi -->
                    <div class="mb-3">
                        <label for="badge_teks" class="form-label fw-semibold">Label Dimensi / Badge</label>
                        <input type="text" id="badge_teks" name="badge_teks"
                               class="form-control @error('badge_teks') is-invalid @enderror"
                               value="{{ old('badge_teks', $desainGrafis->badge_teks) }}"
                               placeholder="Contoh: Landscape (704 x 320 px) atau 16:9 (1920 x 1080 px)">
                        <div class="form-text">Teks badge kecil yang muncul di sudut kartu preview.</div>
                        @error('badge_teks')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Canva URL -->
                    <div class="mb-3">
                        <label for="canva_url" class="form-label fw-semibold">Tautan Canva (Link Template)</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-link-45deg"></i></span>
                            <input type="url" id="canva_url" name="canva_url"
                                   class="form-control @error('canva_url') is-invalid @enderror"
                                   value="{{ old('canva_url', $desainGrafis->canva_url) }}"
                                   placeholder="https://www.canva.com/design/...">
                        </div>
                        <div class="form-text">Tautan langsung untuk user mengedit / memakai templat ini di Canva.</div>
                        @error('canva_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Warna Gradient Preview -->
                    <div class="mb-3">
                        <label for="warna_gradient" class="form-label fw-semibold">Warna / Tema Card Preview</label>
                        <select id="warna_gradient" name="warna_gradient" class="form-select @error('warna_gradient') is-invalid @enderror">
                            <option value="linear-gradient(135deg, #0b6828 0%, #15803d 100%)" {{ old('warna_gradient', $desainGrafis->warna_gradient) == 'linear-gradient(135deg, #0b6828 0%, #15803d 100%)' ? 'selected' : '' }}>🟢 Hijau & Emas UIS</option>
                            <option value="linear-gradient(135deg, #044b1c 0%, #066d2a 100%)" {{ old('warna_gradient', $desainGrafis->warna_gradient) == 'linear-gradient(135deg, #044b1c 0%, #066d2a 100%)' ? 'selected' : '' }}>🌲 Hijau Gelap Modern</option>
                            <option value="linear-gradient(135deg, #166534 0%, #22c55e 100%)" {{ old('warna_gradient', $desainGrafis->warna_gradient) == 'linear-gradient(135deg, #166534 0%, #22c55e 100%)' ? 'selected' : '' }}>🍃 Hijau Fresh Seminar</option>
                            <option value="linear-gradient(135deg, #ca8a04 0%, #eab308 100%)" {{ old('warna_gradient', $desainGrafis->warna_gradient) == 'linear-gradient(135deg, #ca8a04 0%, #eab308 100%)' ? 'selected' : '' }}>🟡 Kuning Emas Elegan</option>
                            <option value="linear-gradient(135deg, #065f46 0%, #059669 100%)" {{ old('warna_gradient', $desainGrafis->warna_gradient) == 'linear-gradient(135deg, #065f46 0%, #059669 100%)' ? 'selected' : '' }}>❇️ Emerald Modern</option>
                            <option value="linear-gradient(135deg, #1e3a8a 0%, #0284c7 100%)" {{ old('warna_gradient', $desainGrafis->warna_gradient) == 'linear-gradient(135deg, #1e3a8a 0%, #0284c7 100%)' ? 'selected' : '' }}>🔵 Biru Formal Dekanat</option>
                        </select>
                        @error('warna_gradient')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Upload Gambar Thumbnail (Opsional) -->
                    <div class="mb-3">
                        <label for="gambar_preview" class="form-label fw-semibold">Ganti Gambar Thumbnail (Opsional)</label>
                        @if ($desainGrafis->gambar_preview)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $desainGrafis->gambar_preview) }}" alt="Preview Saat Ini" class="rounded border shadow-sm" style="height: 60px;">
                                <span class="text-muted small ms-2">Gambar thumbnail saat ini</span>
                            </div>
                        @endif
                        <input type="file" id="gambar_preview" name="gambar_preview"
                               class="form-control @error('gambar_preview') is-invalid @enderror"
                               accept="image/jpeg,image/png,image/webp,image/svg+xml">
                        <div class="form-text">Biarkan kosong jika tidak ingin mengubah thumbnail. Maks 20 MB.</div>
                        @error('gambar_preview')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Deskripsi / Catatan Tema -->
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label fw-semibold">Keterangan / Tema Desain</label>
                        <input type="text" id="deskripsi" name="deskripsi"
                               class="form-control @error('deskripsi') is-invalid @enderror"
                               value="{{ old('deskripsi', $desainGrafis->deskripsi) }}"
                               placeholder="Contoh: Tema Hijau & Emas Formal">
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Spesifikasi / Catatan Ukuran Ruangan -->
                    <div class="mb-3">
                        <label for="spesifikasi" class="form-label fw-semibold">Spesifikasi Ukuran Ruangan (Opsional)</label>
                        <input type="text" id="spesifikasi" name="spesifikasi"
                               class="form-control @error('spesifikasi') is-invalid @enderror"
                               value="{{ old('spesifikasi', $desainGrafis->spesifikasi) }}"
                               placeholder="Contoh: Format 704 x 320 px / Landscape">
                        @error('spesifikasi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Urutan & Status Aktif -->
                    <div class="row mb-4">
                        <div class="col-sm-6">
                            <label for="urutan" class="form-label fw-semibold">Urutan Tampil</label>
                            <input type="number" id="urutan" name="urutan" min="0"
                                   class="form-control @error('urutan') is-invalid @enderror"
                                   value="{{ old('urutan', $desainGrafis->urutan) }}">
                            @error('urutan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-6 d-flex align-items-end">
                            <div class="form-check form-switch mt-3">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                                       {{ old('is_active', $desainGrafis->is_active ? '1' : '0') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="is_active">Aktif & Tampilkan di Portal</label>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="d-flex align-items-center gap-2 pt-2 border-top">
                        <button type="submit" class="btn btn-warning px-4 text-white fw-semibold">
                            <i class="bi bi-save me-1"></i> Perbarui Templat
                        </button>
                        <a href="{{ route('desain-grafis.index') }}" class="btn btn-secondary px-4">
                            Batal
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection
