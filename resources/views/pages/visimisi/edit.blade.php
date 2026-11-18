@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Edit Gambar Visi & Misi</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Profil</li>
            <li class="breadcrumb-item"><a href="{{ route('visimisi.index') }}">Visi & Misi</a></li>
            <li class="breadcrumb-item active">Edit Gambar</li>
        </ol>
    </nav>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8 col-md-10 col-12">
        <div class="card shadow-sm border-0 mb-4" style="border-radius: 12px;">
            <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between" style="border-top: 3px solid #046B26; border-radius: 12px 12px 0 0;">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; background-color: #e8f5e9; color: #046B26;">
                        <i class="bi bi-pencil-square fs-5"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold" style="color: #2b2f32; font-size: 16px;">Edit Gambar Visi Misi</h5>
                        <small class="text-muted">Perbarui file gambar atau urutan tampil</small>
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
                        <strong>Periksa kembali data Anda:</strong>
                        <ul class="mb-0 mt-1 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('visimisi.update', $visiMisi->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Upload File Gambar Baru --}}
                    <div class="mb-4">
                        <label for="gambar" class="form-label fw-bold text-dark">
                            Ganti File Gambar <small class="text-muted fw-normal">(Biarkan kosong jika tetap menggunakan gambar saat ini)</small>
                        </label>
                        <div class="p-3 border rounded-3 bg-light text-center" style="border-style: dashed !important; border-width: 2px !important; border-color: #046B26 !important;">
                            <input type="file"
                                   id="gambar"
                                   name="gambar"
                                   class="form-control form-control-lg @error('gambar') is-invalid @enderror"
                                   accept="image/png,image/jpeg,image/jpg,image/webp,image/svg+xml"
                                   onchange="previewImage(this)">
                            <div class="form-text text-muted small mt-2">
                                Format: JPG, PNG, WEBP, atau SVG (Maksimal 5 MB).
                            </div>
                        </div>
                        @error('gambar')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror

                        {{-- Current Image vs Preview --}}
                        <div class="row g-3 mt-2">
                            @if($visiMisi->gambar_url)
                                <div class="col-md-6 col-12" id="current-image-wrapper">
                                    <div class="p-3 bg-white border rounded text-center shadow-sm" style="border-radius: 10px;">
                                        <span class="badge bg-secondary mb-2">Gambar Saat Ini</span>
                                        <a href="{{ $visiMisi->gambar_url }}" target="_blank">
                                            <img src="{{ $visiMisi->gambar_url }}" alt="Current" class="img-fluid rounded shadow-sm d-block mx-auto" style="max-height: 200px; width: 100%; object-fit: contain;">
                                        </a>
                                    </div>
                                </div>
                            @endif

                            <div class="col-md-6 col-12 d-none" id="preview-wrapper">
                                <div class="p-3 bg-white border rounded text-center shadow-sm" style="border-radius: 10px;">
                                    <span class="badge bg-success mb-2">Pratinjau Gambar Baru</span>
                                    <img id="image-preview" src="#" alt="Preview" class="img-fluid rounded shadow-sm d-block mx-auto" style="max-height: 200px; width: 100%; object-fit: contain;">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Judul & Urutan --}}
                    <div class="row g-3 mb-3">
                        <div class="col-md-8 col-12">
                            <label for="judul" class="form-label fw-semibold text-dark small">
                                Judul / Label Gambar <small class="text-muted">(Opsional)</small>
                            </label>
                            <input type="text"
                                   id="judul"
                                   name="judul"
                                   class="form-control @error('judul') is-invalid @enderror"
                                   value="{{ old('judul', $visiMisi->judul) }}"
                                   placeholder="Contoh: Visi UIS, Misi Fakultas, Sasaran Strategis">
                            <div class="form-text text-muted small">Label kecil di bawah gambar (bisa dikosongkan).</div>
                            @error('judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 col-12">
                            <label for="urutan" class="form-label fw-semibold text-dark small">
                                Urutan Tampil <span class="text-danger">*</span>
                            </label>
                            <input type="number"
                                   id="urutan"
                                   name="urutan"
                                   class="form-control @error('urutan') is-invalid @enderror"
                                   value="{{ old('urutan', $visiMisi->urutan) }}"
                                   min="1"
                                   required>
                            @error('urutan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Status Aktif --}}
                    <div class="mb-4 p-3 bg-light rounded-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" name="is_active" id="is_active" value="1" {{ old('is_active', $visiMisi->is_active ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label text-dark fw-semibold small" for="is_active">
                                Status Aktif (Tampilkan di Halaman Visi & Misi Frontend)
                            </label>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-2 border-top">
                        <a href="{{ route('visimisi.index') }}" class="btn btn-secondary px-3">Batal</a>
                        <button type="submit" class="btn fw-semibold px-4" style="background-color: #046B26; color: #ffffff;">
                            <i class="bi bi-floppy-fill me-1"></i> Simpan Perubahan
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
