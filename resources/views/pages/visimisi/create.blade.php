@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Upload Gambar Visi & Misi</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('visimisi.index') }}">Visi & Misi</a></li>
            <li class="breadcrumb-item active">Upload Baru</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-8 col-md-12">
        <div class="card shadow-sm border-0 mb-4" style="border-radius: 12px;">
            <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between" style="border-top: 3px solid #046B26; border-radius: 12px 12px 0 0;">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background-color: #e8f5e9; color: #046B26;">
                        <i class="bi bi-cloud-arrow-up-fill fs-5"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold" style="color: #2b2f32; font-size: 16px;">Form Upload Gambar Visi Misi</h5>
                        <small class="text-muted">Tambahkan gambar yang akan ditampilkan dalam 3 kolom full-width di frontend</small>
                    </div>
                </div>
                <a href="{{ route('visimisi.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>
            <div class="card-body pt-4">

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <strong>Periksa kembali inputan Anda:</strong>
                        <ul class="mb-0 mt-1 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('visimisi.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Upload File Gambar --}}
                    <div class="mb-4">
                        <label for="gambar" class="form-label fw-bold text-dark small">
                            File Gambar Visi / Misi <span class="text-danger">*</span>
                        </label>
                        <input type="file"
                               id="gambar"
                               name="gambar"
                               class="form-control @error('gambar') is-invalid @enderror"
                               accept="image/png,image/jpeg,image/jpg,image/webp,image/svg+xml"
                               required
                               onchange="previewImage(this)">
                        <div class="form-text text-muted small">
                            Format: JPG, PNG, WEBP, atau SVG. Ukuran maksimal 5 MB. Gunakan gambar dengan resolusi tinggi agar teks infografis jelas saat tampil full width.
                        </div>
                        @error('gambar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        {{-- Preview Box --}}
                        <div id="preview-wrapper" class="mt-3 p-3 bg-light border rounded text-center d-none" style="border-radius: 8px;">
                            <small class="fw-bold text-muted d-block mb-2">Pratinjau Gambar Terpilih:</small>
                            <img id="image-preview" src="#" alt="Preview" class="img-fluid rounded shadow-sm" style="max-height: 280px; width: 100%; object-fit: contain;">
                        </div>
                    </div>

                    {{-- Judul / Label Gambar --}}
                    <div class="row g-3 mb-3">
                        <div class="col-md-8 col-12">
                            <label for="judul" class="form-label fw-bold text-dark small">
                                Judul / Nama Bagian <small class="text-muted fw-normal">(Opsional)</small>
                            </label>
                            <input type="text"
                                   id="judul"
                                   name="judul"
                                   class="form-control @error('judul') is-invalid @enderror"
                                   value="{{ old('judul') }}"
                                   placeholder="Contoh: Visi Universitas, Misi Fakultas, atau Sasaran Strategis">
                            <div class="form-text text-muted small">Akan dijadikan judul kartu atau keterangan gambar.</div>
                            @error('judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 col-12">
                            <label for="urutan" class="form-label fw-bold text-dark small">
                                Urutan Tampil <span class="text-danger">*</span>
                            </label>
                            <input type="number"
                                   id="urutan"
                                   name="urutan"
                                   class="form-control @error('urutan') is-invalid @enderror"
                                   value="{{ old('urutan', $nextUrutan ?? 1) }}"
                                   min="1"
                                   required>
                            <div class="form-text text-muted small">Urutan susunan dalam 3 kolom.</div>
                            @error('urutan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Keterangan Singkat --}}
                    <div class="mb-3">
                        <label for="keterangan" class="form-label fw-bold text-dark small">
                            Keterangan / Alt Text <small class="text-muted fw-normal">(Opsional)</small>
                        </label>
                        <textarea id="keterangan"
                                  name="keterangan"
                                  rows="3"
                                  class="form-control @error('keterangan') is-invalid @enderror"
                                  placeholder="Catatan ringkas mengenai isi poster atau infografis ini">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Status Aktif --}}
                    <div class="mb-4 p-3 bg-light rounded-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label text-dark fw-semibold small" for="is_active">
                                Status Aktif (Tampilkan di Halaman Visi & Misi Frontend)
                            </label>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-2 border-top">
                        <a href="{{ route('visimisi.index') }}" class="btn btn-secondary px-3">Batal</a>
                        <button type="submit" class="btn fw-semibold px-4" style="background-color: #046B26; color: #ffffff;">
                            <i class="bi bi-floppy-fill me-1"></i> Simpan & Upload Gambar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Info Card di Sebelah Kanan --}}
    <div class="col-lg-4 col-md-12">
        <div class="card shadow-sm border-0 mb-4" style="border-radius: 12px;">
            <div class="card-header bg-white py-3" style="border-top: 3px solid #046B26; border-radius: 12px 12px 0 0;">
                <h6 class="mb-0 fw-bold text-dark">
                    <i class="bi bi-layout-three-columns me-1 text-success"></i> Tata Letak Frontend
                </h6>
            </div>
            <div class="card-body p-3">
                <p class="small text-muted mb-3" style="line-height: 1.6;">
                    Di halaman publik <strong>/visi-misi</strong>, setiap gambar yang diupload akan otomatis dibagi ke dalam <strong>3 Kolom (Grid 3 Col)</strong>:
                </p>
                <div class="p-2 bg-light rounded border mb-3">
                    <div class="row g-2 text-center small fw-semibold text-muted">
                        <div class="col-4"><div class="p-2 bg-white border rounded text-success">Kolom 1</div></div>
                        <div class="col-4"><div class="p-2 bg-white border rounded text-success">Kolom 2</div></div>
                        <div class="col-4"><div class="p-2 bg-white border rounded text-success">Kolom 3</div></div>
                    </div>
                </div>
                <ul class="small text-muted ps-3 mb-0" style="line-height: 1.6;">
                    <li>Gambar tampil <strong>Full Width (100%)</strong> di dalam kolomnya masing-masing.</li>
                    <li>Pengunjung dapat mengklik gambar untuk membuka ukuran penuh (popup lightbox).</li>
                    <li>Anda dapat mengunggah 3 gambar utama (misal: <em>Visi</em>, <em>Misi</em>, dan <em>Tujuan</em>) atau lebih sesuai kebutuhan.</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function previewImage(input) {
        const previewWrapper = document.getElementById('preview-wrapper');
        const previewImg = document.getElementById('image-preview');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                previewWrapper.classList.remove('d-none');
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            previewImg.src = '#';
            previewWrapper.classList.add('d-none');
        }
    }
</script>
@endpush
