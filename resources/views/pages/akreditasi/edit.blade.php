@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle mb-4">
    <h1 class="mb-1">Edit Dokumen Akreditasi</h1>
    <nav>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('akreditasi.index') }}">Akreditasi</a></li>
            <li class="breadcrumb-item active">Edit Dokumen</li>
        </ol>
    </nav>
</div>

@if (isset($errors) && $errors->any())
    <div class="alert alert-danger alert-dismissible fade show rounded-3 border-0 shadow-sm" role="alert">
        <div class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-2"></i>Periksa kesalahan berikut:</div>
        <ul class="mb-0 ps-3">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<form action="{{ route('akreditasi.update', $akreditasi->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h5 class="fw-bold text-dark border-bottom pb-3 mb-4 d-flex align-items-center gap-2">
                    <i class="bi bi-pencil-square text-success"></i> Edit Informasi Akreditasi: {{ $akreditasi->nama }}
                </h5>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="tingkat" class="form-label fw-semibold small text-dark">Tingkat Akreditasi <span class="text-danger">*</span></label>
                        <select id="tingkat" name="tingkat" class="form-select @error('tingkat') is-invalid @enderror" required onchange="handleTingkatChange(this.value)">
                            <option value="prodi" {{ old('tingkat', $akreditasi->tingkat) === 'prodi' ? 'selected' : '' }}>Program Studi</option>
                            <option value="fakultas" {{ old('tingkat', $akreditasi->tingkat) === 'fakultas' ? 'selected' : '' }}>Fakultas</option>
                            <option value="universitas" {{ old('tingkat', $akreditasi->tingkat) === 'universitas' ? 'selected' : '' }}>Universitas (Institusi)</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="kategori_label" class="form-label fw-semibold small text-dark">Kategori / Fakultas Induk <span class="text-danger">*</span></label>
                        <input type="text" id="kategori_label" name="kategori_label" class="form-control @error('kategori_label') is-invalid @enderror" list="fakultasList" value="{{ old('kategori_label', $akreditasi->kategori_label) }}" placeholder="Contoh: Fakultas Sains dan Teknologi" required>
                        <datalist id="fakultasList">
                            @foreach($fakultasOptions as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </datalist>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-8">
                        <label for="nama" class="form-label fw-semibold small text-dark">Nama Program Studi / Entitas <span class="text-danger">*</span></label>
                        <input type="text" id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $akreditasi->nama) }}" placeholder="Contoh: S1 Teknik Informatika" required>
                    </div>
                    <div class="col-md-4">
                        <label for="jenjang" class="form-label fw-semibold small text-dark">Jenjang Pendidikan</label>
                        <select id="jenjang" name="jenjang" class="form-select @error('jenjang') is-invalid @enderror">
                            <option value="S1" {{ old('jenjang', $akreditasi->jenjang) === 'S1' ? 'selected' : '' }}>S1 (Sarjana)</option>
                            <option value="S2" {{ old('jenjang', $akreditasi->jenjang) === 'S2' ? 'selected' : '' }}>S2 (Magister)</option>
                            <option value="D3" {{ old('jenjang', $akreditasi->jenjang) === 'D3' ? 'selected' : '' }}>D3 (Diploma)</option>
                            <option value="Institusi" {{ old('jenjang', $akreditasi->jenjang) === 'Institusi' ? 'selected' : '' }}>Institusi</option>
                            <option value="Fakultas" {{ old('jenjang', $akreditasi->jenjang) === 'Fakultas' ? 'selected' : '' }}>Fakultas</option>
                        </select>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="lembaga" class="form-label fw-semibold small text-dark">Lembaga Akreditasi <span class="text-danger">*</span></label>
                        <input type="text" id="lembaga" name="lembaga" class="form-control @error('lembaga') is-invalid @enderror" list="lembagaList" value="{{ old('lembaga', $akreditasi->lembaga) }}" placeholder="Contoh: BAN-PT / LAM-INFOKOM" required>
                        <datalist id="lembagaList">
                            @foreach($lembagaOptions as $lembaga)
                                <option value="{{ $lembaga }}"></option>
                            @endforeach
                        </datalist>
                    </div>

                    <div class="col-md-6">
                        <label for="peringkat" class="form-label fw-semibold small text-dark">Peringkat Akreditasi <span class="text-danger">*</span></label>
                        <select id="peringkat" name="peringkat" class="form-select @error('peringkat') is-invalid @enderror" required>
                            @foreach($peringkatOptions as $p)
                                <option value="{{ $p }}" {{ old('peringkat', $akreditasi->peringkat) === $p ? 'selected' : '' }}>{{ $p }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-5">
                        <label for="nomor_sk" class="form-label fw-semibold small text-dark">Nomor SK Akreditasi</label>
                        <input type="text" id="nomor_sk" name="nomor_sk" class="form-control @error('nomor_sk') is-invalid @enderror" value="{{ old('nomor_sk', $akreditasi->nomor_sk) }}" placeholder="Contoh: 123/SK/BAN-PT/Ak/PT/2023">
                    </div>
                    <div class="col-md-3">
                        <label for="tahun_sk" class="form-label fw-semibold small text-dark">Tahun SK</label>
                        <input type="text" id="tahun_sk" name="tahun_sk" class="form-control @error('tahun_sk') is-invalid @enderror" value="{{ old('tahun_sk', $akreditasi->tahun_sk) }}" placeholder="2023">
                    </div>
                    <div class="col-md-4">
                        <label for="masa_berlaku" class="form-label fw-semibold small text-dark">Masa Berlaku</label>
                        <input type="text" id="masa_berlaku" name="masa_berlaku" class="form-control @error('masa_berlaku') is-invalid @enderror" value="{{ old('masa_berlaku', $akreditasi->masa_berlaku) }}" placeholder="Contoh: 2023 - 2028 atau 15 Des 2028">
                    </div>
                </div>

                <div class="p-3.5 rounded-4 bg-light border mb-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <label for="link_gdrive" class="form-label fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                            <i class="bi bi-google text-primary fs-5"></i> Link Dokumen Google Drive <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2 py-0.5 small">Direkomendasikan</span>
                        </label>
                        @if($akreditasi->link_gdrive)
                            <a href="{{ $akreditasi->link_gdrive }}" target="_blank" class="btn btn-sm btn-outline-success rounded-pill px-3 py-0.5 small">
                                <i class="bi bi-box-arrow-up-right me-1"></i> Buka Tautan Drive
                            </a>
                        @endif
                    </div>
                    <p class="text-muted small mb-2">
                        Tautan file atau folder dokumen sertifikat di Google Drive. Pastikan izin sharing diatur ke <strong>"Siapa saja yang memiliki link (Anyone with the link)"</strong>.
                    </p>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 text-success"><i class="bi bi-link-45deg fs-5"></i></span>
                        <input type="url" id="link_gdrive" name="link_gdrive" class="form-control border-start-0 ps-0 @error('link_gdrive') is-invalid @enderror" value="{{ old('link_gdrive', $akreditasi->link_gdrive) }}" placeholder="https://drive.google.com/file/d/.../view?usp=sharing">
                    </div>
                    @error('link_gdrive')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="p-3 rounded-3 bg-white border">
                    <h6 class="fw-bold text-secondary mb-1 small d-flex align-items-center gap-2">
                        <i class="bi bi-file-earmark-arrow-up text-secondary"></i> Opsi Alternatif: Upload Berkas Fisik (Opsional)
                    </h6>

                    @if($akreditasi->file_sertifikat)
                        <div class="d-flex align-items-center justify-content-between p-2 mb-2 bg-light rounded border">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-file-earmark-check-fill text-success fs-5"></i>
                                <span class="small fw-semibold text-truncate" style="max-width: 280px;">{{ basename($akreditasi->file_sertifikat) }}</span>
                            </div>
                            <a href="{{ $akreditasi->file_url }}" target="_blank" class="btn btn-sm btn-outline-secondary px-3 rounded-pill">
                                <i class="bi bi-box-arrow-up-right me-1"></i> Lihat Berkas Fisik
                            </a>
                        </div>
                    @endif

                    <label for="file_sertifikat" class="form-label fw-semibold small text-dark mt-1">Upload / Ganti Berkas Fisik Baru</label>
                    <input type="file" id="file_sertifikat" name="file_sertifikat" class="form-control @error('file_sertifikat') is-invalid @enderror" accept=".pdf,image/*">
                    <div class="form-text small text-muted mt-1">Format: PDF, JPG, PNG, WEBP. Maksimal ukuran file 20 MB. Biarkan kosong jika tidak ingin mengubah.</div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">Pengaturan Publikasi</h6>

                <div class="mb-3">
                    <label for="urutan" class="form-label fw-semibold small text-dark">Urutan Tampilan</label>
                    <input type="number" id="urutan" name="urutan" class="form-control" value="{{ old('urutan', $akreditasi->urutan) }}" min="0">
                    <div class="form-text small">Nomor urut terkecil tampil paling atas.</div>
                </div>

                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1" {{ old('is_active', $akreditasi->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold small text-dark" for="is_active">Status Aktif & Tampil di Web</label>
                </div>

                <hr class="my-3">

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-success py-2.5 rounded-3 fw-bold shadow-sm" style="background: #046B26; border-color: #046B26;">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                    </button>
                    <a href="{{ route('akreditasi.index') }}" class="btn btn-outline-secondary py-2 rounded-3">
                        Batal
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
function handleTingkatChange(val) {
    const jenjangSelect = document.getElementById('jenjang');
    const kategoriInput = document.getElementById('kategori_label');
    if (val === 'universitas') {
        jenjangSelect.value = 'Institusi';
        kategoriInput.value = 'Institusi';
    } else if (val === 'fakultas') {
        jenjangSelect.value = 'Fakultas';
    } else if (val === 'prodi') {
        if (jenjangSelect.value === 'Institusi' || jenjangSelect.value === 'Fakultas') {
            jenjangSelect.value = 'S1';
        }
    }
}
</script>
@endsection
