@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Sunting Program Studi</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('layanan.index') }}">Program Studi</a></li>
            <li class="breadcrumb-item active">Sunting</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-8 col-md-10">
        <div class="card shadow-sm">
            <div class="card-header py-3">
                <h5 class="mb-0 fw-semibold">
                    <i class="bi bi-pencil-square me-2 text-warning"></i>Form Sunting Program Studi
                </h5>
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

                <form action="{{ route('layanan.update', $layanan->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-3 mb-3">
                        <div class="col-sm-4">
                            <label for="icon" class="form-label fw-semibold">Icon <span class="text-danger">*</span></label>
                            <input type="text" id="icon" name="icon"
                                   class="form-control @error('icon') is-invalid @enderror"
                                   value="{{ old('icon', $layanan->icon) }}"
                                   placeholder="bi-mortarboard-fill">
                            <div class="form-text">Nama class <a href="https://icons.getbootstrap.com/" target="_blank">Bootstrap Icons</a>.</div>
                            @error('icon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-8">
                            <label for="judul" class="form-label fw-semibold">Nama Program Studi <span class="text-danger">*</span></label>
                            <input type="text" id="judul" name="judul"
                                   class="form-control @error('judul') is-invalid @enderror"
                                   value="{{ old('judul', $layanan->judul) }}">
                            @error('judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="link" class="form-label fw-semibold">
                            <i class="bi bi-link-45deg text-primary me-1"></i>Link / URL Website Program Studi
                            <span class="badge bg-secondary fw-normal ms-1" style="font-size:10px">Opsional</span>
                        </label>
                        <input type="url" id="link" name="link"
                               class="form-control @error('link') is-invalid @enderror"
                               value="{{ old('link', $layanan->link) }}"
                               placeholder="Contoh: https://kesmas.uis.ac.id atau https://...">
                        <div class="form-text">Jika diisi, klik pada menu dropdown Program Studi di navbar akan langsung membuka tautan ini. Jika dikosongkan, akan membuka halaman detail prodi di website UIS.</div>
                        @error('link')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="dasar_hukum" class="form-label fw-semibold">
                            SK / Akreditasi
                            <span class="badge bg-secondary fw-normal ms-1" style="font-size:10px">Opsional</span>
                        </label>
                        <input type="text" id="dasar_hukum" name="dasar_hukum"
                               class="form-control @error('dasar_hukum') is-invalid @enderror"
                               value="{{ old('dasar_hukum', $layanan->dasar_hukum) }}"
                               placeholder="Contoh: SK LAM-PTKes & Kemendikbudristek / Unggul / B">
                        @error('dasar_hukum')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label fw-semibold">Deskripsi Singkat <span class="text-danger">*</span></label>
                        <textarea id="deskripsi" name="deskripsi" rows="3"
                                  class="form-control @error('deskripsi') is-invalid @enderror">{{ old('deskripsi', $layanan->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <label class="form-label fw-semibold mb-0">
                                <i class="bi bi-list-check text-primary me-1"></i>Kompetensi / Poin Keunggulan
                                <span class="badge bg-secondary fw-normal ms-1" style="font-size:10px">Opsional</span>
                            </label>
                            <button type="button" class="btn btn-sm btn-outline-primary" id="btn-add-rincian">
                                <i class="bi bi-plus-circle-fill me-1"></i> Tambah Poin
                            </button>
                        </div>

                        <div id="rincian-container" class="d-flex flex-column gap-2">
                            @php
                                $rawRincian = $layanan->rincian ? array_filter(array_map('trim', explode("\n", $layanan->rincian))) : [];
                                $rincianList = old('rincian_list', count($rawRincian) > 0 ? $rawRincian : ['']);
                            @endphp

                            @foreach($rincianList as $index => $itemVal)
                                <div class="input-group rincian-item shadow-sm">
                                    <span class="input-group-text bg-light text-primary fw-bold rincian-num" style="min-width:42px; justify-content:center;">
                                        {{ $loop->iteration }}
                                    </span>
                                    <input type="text" name="rincian_list[]"
                                           class="form-control"
                                           value="{{ $itemVal }}"
                                           placeholder="Contoh: Kurikulum terakreditasi berbasis riset terapan...">
                                    <button type="button" class="btn btn-outline-danger btn-remove-rincian" title="Hapus poin ini">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                        <div class="form-text mt-2">
                            <i class="bi bi-info-circle me-1"></i>Setiap field merupakan 1 poin keunggulan prodi. Klik <strong>+ Tambah Poin</strong> untuk menambah field baru.
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-sm-4">
                            <label for="urutan" class="form-label fw-semibold">Urutan Tampil</label>
                            <input type="number" id="urutan" name="urutan"
                                   class="form-control @error('urutan') is-invalid @enderror"
                                   value="{{ old('urutan', $layanan->urutan) }}" min="0">
                            <div class="form-text">Urutan posisi di menu dropdown navbar.</div>
                            @error('urutan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-8 d-flex align-items-center" style="padding-top:28px">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="aktif" name="aktif" value="1"
                                       {{ old('aktif', $layanan->aktif) ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="aktif">
                                    Aktifkan Program Studi (tampil di navbar & beranda)
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('layanan.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-warning text-dark fw-bold">
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
    const container = document.getElementById('rincian-container');
    const btnAdd = document.getElementById('btn-add-rincian');

    function updateRincianNumbers() {
        const items = container.querySelectorAll('.rincian-item');
        items.forEach((item, index) => {
            const numBadge = item.querySelector('.rincian-num');
            if (numBadge) {
                numBadge.textContent = index + 1;
            }
        });
    }

    if (btnAdd) {
        btnAdd.addEventListener('click', function () {
            const total = container.querySelectorAll('.rincian-item').length + 1;
            const newRow = document.createElement('div');
            newRow.className = 'input-group rincian-item shadow-sm';
            newRow.innerHTML = `
                <span class="input-group-text bg-light text-primary fw-bold rincian-num" style="min-width:42px; justify-content:center;">
                    ${total}
                </span>
                <input type="text" name="rincian_list[]" class="form-control" placeholder="Masukkan poin keunggulan / kompetensi...">
                <button type="button" class="btn btn-outline-danger btn-remove-rincian" title="Hapus poin ini">
                    <i class="bi bi-trash-fill"></i>
                </button>
            `;
            container.appendChild(newRow);
            const input = newRow.querySelector('input');
            if (input) input.focus();
        });
    }

    container.addEventListener('click', function (e) {
        const removeBtn = e.target.closest('.btn-remove-rincian');
        if (removeBtn) {
            const row = removeBtn.closest('.rincian-item');
            if (row) {
                row.remove();
                updateRincianNumbers();
            }
        }
    });
});
</script>
@endpush
