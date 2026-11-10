@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Edit Layanan Terkait</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('layanan-terkait.index') }}">Layanan Terkait</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-8 col-md-10">
        <div class="card shadow-sm border-0" style="border-radius: 12px;">
            <div class="card-header bg-white py-3" style="border-top: 3px solid #FED802; border-radius: 12px 12px 0 0;">
                <h5 class="mb-0 fw-bold" style="color: #2b2f32; font-size: 16px;">
                    <i class="bi bi-pencil-fill me-2" style="color: #FED802;"></i>Form Edit Kartu Layanan Digital
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

                <form action="{{ route('layanan-terkait.update', $layananTerkait->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Nama Layanan --}}
                    <div class="mb-3">
                        <label for="nama" class="form-label fw-bold text-dark">
                            Nama Layanan / Sistem <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               id="nama"
                               name="nama"
                               class="form-control @error('nama') is-invalid @enderror"
                               value="{{ old('nama', $layananTerkait->nama) }}"
                               placeholder="Contoh: SIAKAD UIS / SISTER / SINTA / EDLINK"
                               required>
                        <div class="form-text">Nama singkat sistem atau aplikasi yang ditampilkan dengan huruf tebal pada kartu.</div>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tautan / URL --}}
                    <div class="mb-3">
                        <label for="url" class="form-label fw-bold text-dark">
                            Tautan / URL Tujuan <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted"><i class="bi bi-link-45deg fs-5"></i></span>
                            <input type="text"
                                   id="url"
                                   name="url"
                                   class="form-control @error('url') is-invalid @enderror"
                                   value="{{ old('url', $layananTerkait->url) }}"
                                   placeholder="Contoh: https://siakad.uis.ac.id"
                                   required>
                        </div>
                        <div class="form-text">URL website tujuan yang akan dibuka ketika kartu diklik (membuka tab baru).</div>
                        @error('url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Deskripsi Singkat --}}
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label fw-bold text-dark">
                            Keterangan / Subtitle Singkat
                        </label>
                        <textarea id="deskripsi"
                                  name="deskripsi"
                                  class="form-control @error('deskripsi') is-invalid @enderror"
                                  rows="2"
                                  placeholder="Contoh: Sistem Informasi Akademik Terpadu Mahasiswa dan Dosen UIS">{{ old('deskripsi', $layananTerkait->deskripsi) }}</textarea>
                        <div class="form-text">Deskripsi singkat sistem (opsional, tampil pada tabel admin dan tooltip).</div>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Logo Upload & Current Logo --}}
                    <div class="mb-3">
                        <label for="logo" class="form-label fw-bold text-dark">
                            Ganti Logo / Icon Layanan
                        </label>

                        @if($layananTerkait->logo_url)
                            <div class="mb-2 p-3 rounded-3 d-inline-flex align-items-center gap-3" style="background: #046B26; border: 1.5px solid rgba(255,255,255,0.25); box-shadow: 0 4px 12px rgba(4, 107, 38, 0.25);">
                                <img src="{{ $layananTerkait->logo_url }}" alt="Logo Saat Ini" style="max-height: 50px; max-width: 80px; object-fit: contain;">
                                <div class="text-white small">
                                    <span class="text-warning fw-bold d-block">Logo Saat Ini Aktif</span>
                                    <span class="text-white-50" style="font-size: 11px;">Unggah file baru di bawah jika ingin mengganti</span>
                                </div>
                            </div>
                        @endif

                        <input type="file"
                               id="logo"
                               name="logo"
                               class="form-control @error('logo') is-invalid @enderror"
                               accept="image/png,image/jpeg,image/svg+xml,image/webp"
                               onchange="previewImage(this)">
                        <div class="form-text">
                            Format disarankan: <strong>PNG Transparan / SVG Putih / Monochrome</strong> (Rasio 1:1, Max 20 MB).
                        </div>
                        @error('logo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        {{-- Preview Box Baru --}}
                        <div id="previewContainer" class="mt-3 d-none">
                            <label class="form-label text-muted small d-block">Preview Logo Baru:</label>
                            <div class="p-2 rounded-3 d-inline-flex align-items-center justify-content-center" style="background: transparent; min-width: 60px; min-height: 60px; border: 1.5px dashed #046B26;">
                                <img id="previewImg" src="#" alt="Preview Logo Baru" style="max-height: 50px; max-width: 80px; object-fit: contain;">
                            </div>
                        </div>
                    </div>

                    {{-- Urutan & Status Aktif --}}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="urutan" class="form-label fw-bold text-dark">
                                Nomor Urutan
                            </label>
                            <input type="number"
                                   id="urutan"
                                   name="urutan"
                                   class="form-control @error('urutan') is-invalid @enderror"
                                   value="{{ old('urutan', $layananTerkait->urutan) }}"
                                   min="0">
                            <div class="form-text">Urutan posisi kartu dari kiri ke kanan.</div>
                            @error('urutan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-dark">Status Tampil</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input"
                                       type="checkbox"
                                       role="switch"
                                       id="is_active"
                                       name="is_active"
                                       value="1"
                                       {{ old('is_active', $layananTerkait->is_active ? '1' : '0') == '1' ? 'checked' : '' }}
                                       style="width: 2.5em; height: 1.3em; cursor: pointer;">
                                <label class="form-check-label ms-2 fw-semibold" for="is_active" style="cursor: pointer;">
                                    Aktif (Tampilkan di Beranda)
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                        <a href="{{ route('layanan-terkait.index') }}" class="btn btn-secondary px-4">
                            <i class="bi bi-arrow-left me-1"></i> Batal
                        </a>
                        <button type="submit" class="btn fw-semibold px-4 shadow-sm" style="background-color: #FED802; color: #ffffff; border: none; border-radius: 8px;">
                            <i class="bi bi-check-lg me-1"></i> Simpan Perubahan
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
    const container = document.getElementById('previewContainer');
    const preview = document.getElementById('previewImg');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            container.classList.remove('d-none');
        }
        reader.readAsDataURL(input.files[0]);
    } else {
        container.classList.add('d-none');
    }
}
</script>
@endpush
