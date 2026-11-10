@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Edit Prestasi Mahasiswa</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('prestasi.index') }}">Prestasi Mahasiswa</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-12 col-xl-9">

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <strong>Terdapat kesalahan pengisian:</strong>
                <ul class="mb-0 mt-1 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-semibold text-dark">
                    <i class="bi bi-pencil-square text-warning me-2"></i>Edit Data Prestasi Mahasiswa
                </h5>
            </div>
            <div class="card-body pt-4">
                <form action="{{ route('prestasi.update', $prestasi->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <!-- Judul Prestasi -->
                        <div class="col-md-12">
                            <label for="judul_prestasi" class="form-label fw-semibold">
                                Judul Prestasi / Nama Kejuaraan <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   id="judul_prestasi"
                                   name="judul_prestasi"
                                   class="form-control @error('judul_prestasi') is-invalid @enderror"
                                   value="{{ old('judul_prestasi', $prestasi->judul_prestasi) }}"
                                   required>
                            @error('judul_prestasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Nama Mahasiswa -->
                        <div class="col-md-7">
                            <label for="nama_mahasiswa" class="form-label fw-semibold">
                                Nama Mahasiswa / Tim <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   id="nama_mahasiswa"
                                   name="nama_mahasiswa"
                                   class="form-control @error('nama_mahasiswa') is-invalid @enderror"
                                   value="{{ old('nama_mahasiswa', $prestasi->nama_mahasiswa) }}"
                                   required>
                            @error('nama_mahasiswa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- NIM -->
                        <div class="col-md-5">
                            <label for="nim" class="form-label fw-semibold">
                                NIM Mahasiswa <span class="badge bg-secondary fw-normal ms-1" style="font-size:9px">Opsional</span>
                            </label>
                            <input type="text"
                                   id="nim"
                                   name="nim"
                                   class="form-control @error('nim') is-invalid @enderror"
                                   value="{{ old('nim', $prestasi->nim) }}">
                            @error('nim')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Program Studi -->
                        <div class="col-md-6">
                            <label for="prodi" class="form-label fw-semibold">
                                Program Studi <span class="badge bg-secondary fw-normal ms-1" style="font-size:9px">Opsional</span>
                            </label>
                            <select id="prodi" name="prodi" class="form-select @error('prodi') is-invalid @enderror">
                                <option value="">-- Pilih Program Studi --</option>
                                <optgroup label="Fakultas Teknik">
                                    <option value="S1 Teknik Informatika" {{ old('prodi', $prestasi->prodi) === 'S1 Teknik Informatika' ? 'selected' : '' }}>S1 Teknik Informatika</option>
                                    <option value="S1 Sistem Informasi" {{ old('prodi', $prestasi->prodi) === 'S1 Sistem Informasi' ? 'selected' : '' }}>S1 Sistem Informasi</option>
                                    <option value="S1 Teknik Industri" {{ old('prodi', $prestasi->prodi) === 'S1 Teknik Industri' ? 'selected' : '' }}>S1 Teknik Industri</option>
                                    <option value="S1 Teknik Logistik" {{ old('prodi', $prestasi->prodi) === 'S1 Teknik Logistik' ? 'selected' : '' }}>S1 Teknik Logistik</option>
                                    <option value="S1 Teknik Perkapalan" {{ old('prodi', $prestasi->prodi) === 'S1 Teknik Perkapalan' ? 'selected' : '' }}>S1 Teknik Perkapalan</option>
                                </optgroup>
                                <optgroup label="Fakultas Ekonomi dan Bisnis">
                                    <option value="S2 Magister Manajemen" {{ old('prodi', $prestasi->prodi) === 'S2 Magister Manajemen' ? 'selected' : '' }}>S2 Magister Manajemen</option>
                                    <option value="S1 Manajemen" {{ old('prodi', $prestasi->prodi) === 'S1 Manajemen' ? 'selected' : '' }}>S1 Manajemen</option>
                                    <option value="S1 Akuntansi" {{ old('prodi', $prestasi->prodi) === 'S1 Akuntansi' ? 'selected' : '' }}>S1 Akuntansi</option>
                                    <option value="D3 Akuntansi" {{ old('prodi', $prestasi->prodi) === 'D3 Akuntansi' ? 'selected' : '' }}>D3 Akuntansi</option>
                                </optgroup>
                                <optgroup label="Fakultas Ilmu Kesehatan">
                                    <option value="S2 Kesehatan Masyarakat" {{ old('prodi', $prestasi->prodi) === 'S2 Kesehatan Masyarakat' ? 'selected' : '' }}>S2 Kesehatan Masyarakat</option>
                                    <option value="S1 Kesehatan dan Keselamatan Kerja" {{ old('prodi', $prestasi->prodi) === 'S1 Kesehatan dan Keselamatan Kerja' ? 'selected' : '' }}>S1 Kesehatan dan Keselamatan Kerja (K3)</option>
                                    <option value="S1 Kesehatan Lingkungan" {{ old('prodi', $prestasi->prodi) === 'S1 Kesehatan Lingkungan' ? 'selected' : '' }}>S1 Kesehatan Lingkungan</option>
                                </optgroup>
                                <option value="Universitas Ibnu Sina" {{ old('prodi', $prestasi->prodi) === 'Universitas Ibnu Sina' ? 'selected' : '' }}>Universitas Ibnu Sina (Umum)</option>
                            </select>
                            @error('prodi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tingkat Kejuaraan -->
                        <div class="col-md-6">
                            <label for="tingkat" class="form-label fw-semibold">
                                Tingkat Kejuaraan <span class="text-danger">*</span>
                            </label>
                            <select id="tingkat" name="tingkat" class="form-select @error('tingkat') is-invalid @enderror" required>
                                <option value="Nasional" {{ old('tingkat', $prestasi->tingkat) === 'Nasional' ? 'selected' : '' }}>Nasional</option>
                                <option value="Internasional" {{ old('tingkat', $prestasi->tingkat) === 'Internasional' ? 'selected' : '' }}>Internasional</option>
                                <option value="Provinsi / Wilayah" {{ old('tingkat', $prestasi->tingkat) === 'Provinsi / Wilayah' ? 'selected' : '' }}>Provinsi / Wilayah</option>
                                <option value="Universitas" {{ old('tingkat', $prestasi->tingkat) === 'Universitas' ? 'selected' : '' }}>Universitas / Lokal</option>
                            </select>
                            @error('tingkat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Peringkat / Capaian -->
                        <div class="col-md-6">
                            <label for="peringkat" class="form-label fw-semibold">
                                Peringkat / Capaian <span class="badge bg-secondary fw-normal ms-1" style="font-size:9px">Opsional</span>
                            </label>
                            <input type="text"
                                   id="peringkat"
                                   name="peringkat"
                                   class="form-control @error('peringkat') is-invalid @enderror"
                                   value="{{ old('peringkat', $prestasi->peringkat) }}"
                                   placeholder="Contoh: Juara 1 / Medali Emas / Best Paper">
                            @error('peringkat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tahun -->
                        <div class="col-md-6">
                            <label for="tahun" class="form-label fw-semibold">
                                Tahun Prestasi <span class="badge bg-secondary fw-normal ms-1" style="font-size:9px">Opsional</span>
                            </label>
                            <input type="text"
                                   id="tahun"
                                   name="tahun"
                                   class="form-control @error('tahun') is-invalid @enderror"
                                   value="{{ old('tahun', $prestasi->tahun) }}"
                                   placeholder="Contoh: 2026">
                            @error('tahun')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Penyelenggara -->
                        <div class="col-md-12">
                            <label for="penyelenggara" class="form-label fw-semibold">
                                Lembaga / Penyelenggara <span class="badge bg-secondary fw-normal ms-1" style="font-size:9px">Opsional</span>
                            </label>
                            <input type="text"
                                   id="penyelenggara"
                                   name="penyelenggara"
                                   class="form-control @error('penyelenggara') is-invalid @enderror"
                                   value="{{ old('penyelenggara', $prestasi->penyelenggara) }}">
                            @error('penyelenggara')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Foto Dokumentasi / Mahasiswa -->
                        <div class="col-md-12">
                            <label for="foto" class="form-label fw-semibold">
                                Foto Dokumentasi / Mahasiswa / Sertifikat
                            </label>
                            @if($prestasi->foto)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $prestasi->foto) }}" alt="Foto Lama" class="img-thumbnail rounded-3 shadow-sm" style="max-height: 150px;">
                                </div>
                            @endif
                            <input type="file"
                                   id="foto"
                                   name="foto"
                                   class="form-control @error('foto') is-invalid @enderror"
                                   accept="image/*"
                                   onchange="previewFoto(event)">
                            <div class="form-text">Pilih foto baru jika ingin mengganti foto sebelumnya. (Maks 20 MB).</div>
                            @error('foto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <!-- Image Preview Baru -->
                            <div class="mt-3" id="foto-preview-box" style="display:none;">
                                <img id="foto-preview" src="#" alt="Preview Foto Baru" class="img-thumbnail rounded-3 shadow-sm" style="max-height: 200px;">
                            </div>
                        </div>

                        <!-- Deskripsi / Ulasan Singkat -->
                        <div class="col-md-12">
                            <label for="deskripsi" class="form-label fw-semibold">
                                Deskripsi / Catatan Prestasi (TinyMCE)
                            </label>
                            <textarea id="deskripsi"
                                      name="deskripsi"
                                      class="form-control tinymce-editor @error('deskripsi') is-invalid @enderror"
                                      rows="5">{{ old('deskripsi', $prestasi->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status & Urutan -->
                        <div class="col-md-6">
                            <label for="urutan" class="form-label fw-semibold">Urutan Tampil</label>
                            <input type="number"
                                   id="urutan"
                                   name="urutan"
                                   class="form-control @error('urutan') is-invalid @enderror"
                                   value="{{ old('urutan', $prestasi->urutan) }}"
                                   min="0">
                            @error('urutan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 d-flex align-items-center" style="padding-top: 28px;">
                            <div class="form-check form-switch">
                                <input class="form-check-input"
                                       type="checkbox"
                                       id="is_active"
                                       name="is_active"
                                       value="1"
                                       {{ old('is_active', $prestasi->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="is_active">
                                    Tampilkan di Website (Aktif)
                                </label>
                            </div>
                        </div>

                        <div class="col-12 mt-4 pt-3 border-top d-flex justify-content-between">
                            <a href="{{ route('prestasi.index') }}" class="btn btn-outline-secondary px-4">
                                <i class="bi bi-arrow-left me-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary px-4 fw-bold" style="background: #046B26; border-color: #046B26;">
                                <i class="bi bi-check2-circle me-1"></i> Perbarui Data Prestasi
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
function previewFoto(event) {
    const input = event.target;
    const previewBox = document.getElementById('foto-preview-box');
    const previewImg = document.getElementById('foto-preview');

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
            previewImg.src = e.target.result;
            previewBox.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        previewBox.style.display = 'none';
    }
}
</script>
@endpush
