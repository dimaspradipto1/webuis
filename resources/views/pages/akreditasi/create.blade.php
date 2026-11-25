@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle mb-4">
    <h1 class="mb-1">Tambah Sertifikat Akreditasi</h1>
    <nav>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('akreditasi.index') }}">Sertifikat Akreditasi</a></li>
            <li class="breadcrumb-item active">Tambah Baru</li>
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

<form action="{{ route('akreditasi.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h5 class="fw-bold text-dark border-bottom pb-3 mb-4 d-flex align-items-center gap-2">
                    <i class="bi bi-patch-check-fill text-success"></i> Informasi Sertifikat Akreditasi
                </h5>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="tingkat" class="form-label fw-semibold small text-dark">Tingkat Akreditasi <span class="text-danger">*</span></label>
                        <select id="tingkat" name="tingkat" class="form-select @error('tingkat') is-invalid @enderror" required onchange="handleTingkatChange(this.value)">
                            <option value="prodi" {{ old('tingkat') === 'prodi' ? 'selected' : '' }}>Program Studi</option>
                            <option value="fakultas" {{ old('tingkat') === 'fakultas' ? 'selected' : '' }}>Fakultas</option>
                            <option value="universitas" {{ old('tingkat') === 'universitas' ? 'selected' : '' }}>Universitas (Institusi)</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="kategori_label" class="form-label fw-semibold small text-dark">Kategori / Fakultas Induk <span class="text-danger">*</span></label>
                        <input type="text" id="kategori_label" name="kategori_label" class="form-control @error('kategori_label') is-invalid @enderror" list="fakultasList" value="{{ old('kategori_label', 'Fakultas Sains dan Teknologi') }}" placeholder="Contoh: Fakultas Sains dan Teknologi" required>
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
                        <input type="text" id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" placeholder="Contoh: S1 Teknik Informatika" required>
                    </div>
                    <div class="col-md-4">
                        <label for="jenjang" class="form-label fw-semibold small text-dark">Jenjang Pendidikan</label>
                        <select id="jenjang" name="jenjang" class="form-select @error('jenjang') is-invalid @enderror">
                            <option value="S1" {{ old('jenjang') === 'S1' ? 'selected' : '' }}>S1 (Sarjana)</option>
                            <option value="S2" {{ old('jenjang') === 'S2' ? 'selected' : '' }}>S2 (Magister)</option>
                            <option value="D3" {{ old('jenjang') === 'D3' ? 'selected' : '' }}>D3 (Diploma)</option>
                            <option value="Institusi" {{ old('jenjang') === 'Institusi' ? 'selected' : '' }}>Institusi</option>
                            <option value="Fakultas" {{ old('jenjang') === 'Fakultas' ? 'selected' : '' }}>Fakultas</option>
                        </select>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="lembaga" class="form-label fw-semibold small text-dark">Lembaga Akreditasi <span class="text-danger">*</span></label>
                        <input type="text" id="lembaga" name="lembaga" class="form-control @error('lembaga') is-invalid @enderror" list="lembagaList" value="{{ old('lembaga', 'BAN-PT') }}" placeholder="Contoh: BAN-PT / LAM-INFOKOM" required>
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
                                <option value="{{ $p }}" {{ old('peringkat', 'Baik Sekali') === $p ? 'selected' : '' }}>{{ $p }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-5">
                        <label for="nomor_sk" class="form-label fw-semibold small text-dark">Nomor SK Akreditasi</label>
                        <input type="text" id="nomor_sk" name="nomor_sk" class="form-control @error('nomor_sk') is-invalid @enderror" value="{{ old('nomor_sk') }}" placeholder="Contoh: 123/SK/BAN-PT/Ak/PT/2023">
                    </div>
                    <div class="col-md-3">
                        <label for="tahun_sk" class="form-label fw-semibold small text-dark">Tahun SK</label>
                        <input type="text" id="tahun_sk" name="tahun_sk" class="form-control @error('tahun_sk') is-invalid @enderror" value="{{ old('tahun_sk', date('Y')) }}" placeholder="2023">
                    </div>
                    <div class="col-md-4">
                        <label for="masa_berlaku" class="form-label fw-semibold small text-dark">Masa Berlaku</label>
                        <input type="text" id="masa_berlaku" name="masa_berlaku" class="form-control @error('masa_berlaku') is-invalid @enderror" value="{{ old('masa_berlaku') }}" placeholder="Contoh: 2023 - 2028 atau 15 Des 2028">
                    </div>
                </div>

                <div class="p-3 rounded-3 bg-light border">
                    <h6 class="fw-bold text-dark mb-2">
                        <i class="bi bi-file-earmark-pdf-fill text-danger me-1"></i> Upload File Sertifikat Resmi (PDF / Foto)
                    </h6>
                    <input type="file" id="file_sertifikat" name="file_sertifikat" class="form-control @error('file_sertifikat') is-invalid @enderror" accept=".pdf,image/*">
                    <div class="form-text small text-muted mt-1">Format: PDF, JPG, PNG, WEBP. Maksimal ukuran file 20 MB.</div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">Pengaturan Publikasi</h6>

                <div class="mb-3">
                    <label for="urutan" class="form-label fw-semibold small text-dark">Urutan Tampilan</label>
                    <input type="number" id="urutan" name="urutan" class="form-control" value="{{ old('urutan', 0) }}" min="0">
                    <div class="form-text small">Nomor urut terkecil tampil paling atas.</div>
                </div>

                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold small text-dark" for="is_active">Status Aktif & Tampil di Web</label>
                </div>

                <hr class="my-3">

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-success py-2.5 rounded-3 fw-bold shadow-sm" style="background: #046B26; border-color: #046B26;">
                        <i class="bi bi-save me-1"></i> Simpan Data Sertifikat
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
