@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
    <div>
        <h1 class="mb-1">Edit Program Studi: {{ $programStudi->nama }}</h1>
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('program-studi.index') }}">Program Studi</a></li>
                <li class="breadcrumb-item active">{{ $programStudi->nama }}</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('homepage.program-studi.detail', $programStudi->slug) }}" target="_blank" class="btn btn-outline-success rounded-3 px-3">
            <i class="bi bi-box-arrow-up-right me-1"></i> Lihat Halaman Detail
        </a>
        <a href="{{ route('program-studi.index') }}" class="btn btn-outline-secondary rounded-3 px-3">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>

{{-- Quick Switcher Antar Prodi --}}
<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body py-2.5 px-3">
        <div class="d-flex align-items-center gap-2 overflow-auto py-1">
            <span class="small fw-bold text-muted text-nowrap me-1"><i class="bi bi-arrow-left-right me-1"></i>Pilih Prodi:</span>
            @foreach($allProdis as $item)
                <a href="{{ route('program-studi.edit', $item->id) }}"
                   class="btn btn-sm rounded-pill text-nowrap {{ $item->id === $programStudi->id ? 'btn-success text-white fw-bold' : 'btn-light text-dark border' }}"
                   style="{{ $item->id === $programStudi->id ? 'background: #046B26; border-color: #046B26;' : '' }}">
                    {{ $item->nama }}
                </a>
            @endforeach
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 col-xl-10">
        @if ($errors->any())
            <div class="alert alert-danger rounded-3">
                <strong class="d-block mb-1"><i class="bi bi-exclamation-triangle-fill me-1"></i> Periksa kembali inputan Anda:</strong>
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('program-studi.update', $programStudi->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- 1. Informasi Utama Program Studi --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 px-4" style="border-top: 3px solid #046B26; border-radius: 16px 16px 0 0;">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="bi bi-mortarboard-fill text-success me-2"></i>Informasi Utama Program Studi
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Nama Program Studi <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control" value="{{ old('nama', $programStudi->nama) }}" required>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-bold small">Jenjang Pendidikan <span class="text-danger">*</span></label>
                            <select name="jenjang" class="form-select" required>
                                <option value="S1" {{ old('jenjang', $programStudi->jenjang) === 'S1' ? 'selected' : '' }}>S1 (Sarjana)</option>
                                <option value="S2" {{ old('jenjang', $programStudi->jenjang) === 'S2' ? 'selected' : '' }}>S2 (Pascasarjana)</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-bold small">Gelar Lulusan</label>
                            <input type="text" name="gelar" class="form-control" value="{{ old('gelar', $programStudi->gelar) }}" placeholder="Contoh: S.Kom., S.T., M.M.">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Fakultas / Unit Penyelenggara <span class="text-danger">*</span></label>
                            <select name="fakultas" class="form-select" required>
                                @foreach($fakultasList as $fak)
                                    <option value="{{ $fak }}" {{ old('fakultas', $programStudi->fakultas) === $fak ? 'selected' : '' }}>{{ $fak }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-bold small">Status Akreditasi</label>
                            <input type="text" name="akreditasi" class="form-control" value="{{ old('akreditasi', $programStudi->akreditasi) }}" placeholder="Contoh: Baik Sekali / Unggul">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-bold small">Icon Bootstrap</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-success"><i class="bi {{ $programStudi->icon ?: 'bi-mortarboard-fill' }}" id="iconPreview"></i></span>
                                <input type="text" name="icon" id="iconInput" class="form-control" value="{{ old('icon', $programStudi->icon ?: 'bi-mortarboard-fill') }}">
                            </div>
                        </div>

                        <div class="col-md-8">
                            <label class="form-label fw-bold small">Link Website Resmi Prodi / Fakultas (Opsional)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-globe"></i></span>
                                <input type="text" name="link_website" class="form-control" value="{{ old('link_website', $programStudi->link_website) }}" placeholder="Contoh: https://fst.uis.ac.id">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label fw-bold small">Urutan Tampil</label>
                            <input type="number" name="urutan" class="form-control" value="{{ old('urutan', $programStudi->urutan) }}" min="1">
                        </div>

                        <div class="col-md-2 d-flex align-items-end">
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" name="is_active" id="isActive" value="1" {{ old('is_active', $programStudi->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold small" for="isActive">Aktif</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 2. Konten Detail Program Studi --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 px-4" style="border-top: 3px solid #046B26; border-radius: 16px 16px 0 0;">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="bi bi-file-earmark-richtext text-success me-2"></i>Profil, Visi Misi & Prospek Karir Prodi
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-bold small">Ringkasan / Deskripsi Singkat</label>
                            <textarea name="deskripsi_singkat" rows="2" class="form-control">{{ old('deskripsi_singkat', $programStudi->deskripsi_singkat) }}</textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold small">Profil Lengkap Program Studi</label>
                            <textarea name="deskripsi" rows="6" class="form-control">{{ old('deskripsi', $programStudi->deskripsi) }}</textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold small">Visi Program Studi</label>
                            <textarea name="visi" rows="2" class="form-control">{{ old('visi', $programStudi->visi) }}</textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Misi Program Studi <span class="text-muted fw-normal">(1 baris = 1 poin misi)</span></label>
                            <textarea name="misi" rows="5" class="form-control">{{ old('misi', $programStudi->misi) }}</textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Prospek Karir Lulusan <span class="text-muted fw-normal">(1 baris = 1 profesi lulusan)</span></label>
                            <textarea name="prospek_karir" rows="5" class="form-control">{{ old('prospek_karir', $programStudi->prospek_karir) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 3. Multi-Upload Foto / Dokumentasi Prodi --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 px-4" style="border-top: 3px solid #046B26; border-radius: 16px 16px 0 0;">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="bi bi-images text-success me-2"></i>Foto Banner & Galeri Dokumentasi Prodi (Bisa Banyak Foto)
                    </h5>
                </div>
                <div class="card-body p-4">
                    @php
                        $existingPhotos = $programStudi->all_photos;
                    @endphp

                    @if(count($existingPhotos) > 0)
                        <div class="mb-4">
                            <label class="form-label fw-bold small d-block mb-2">Foto Saat Ini ({{ count($existingPhotos) }} Foto)</label>
                            <div class="row g-3">
                                @foreach($existingPhotos as $idx => $photoPath)
                                    @php
                                        $photoUrl = str_starts_with($photoPath, 'http') ? $photoPath : (str_starts_with($photoPath, 'assets/') ? asset($photoPath) : asset('storage/' . $photoPath));
                                    @endphp
                                    <div class="col-6 col-md-3">
                                        <div class="border rounded-3 p-2 bg-light h-100 d-flex flex-column justify-content-between">
                                            <img src="{{ $photoUrl }}" alt="Foto Prodi" class="w-100 rounded-2 mb-2" style="height: 115px; object-fit: cover;">
                                            <div class="d-flex flex-column gap-1">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="main_photo" id="main_photo_{{ $idx }}" value="{{ $photoPath }}" {{ $idx === 0 ? 'checked' : '' }}>
                                                    <label class="form-check-label small fw-semibold" for="main_photo_{{ $idx }}">Jadikan Sampul</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="delete_photos[]" id="del_photo_{{ $idx }}" value="{{ $photoPath }}">
                                                    <label class="form-check-label small text-danger" for="del_photo_{{ $idx }}">Hapus Foto Ini</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <label class="form-label fw-bold small">Tambah Foto Baru (Bisa pilih lebih dari 1 foto sekaligus)</label>
                    <input type="file" name="foto[]" id="multiPhotoInput" class="form-control" accept="image/jpeg,image/png,image/webp" multiple>
                    <div class="form-text">Maksimal 20 MB per foto (JPG, PNG, WEBP).</div>

                    <div id="photoPreviewGrid" class="row g-3 mt-2 d-none"></div>
                </div>

                <div class="card-footer bg-light py-3 px-4 d-flex justify-content-between align-items-center" style="border-radius: 0 0 16px 16px;">
                    <a href="{{ route('program-studi.index') }}" class="btn btn-outline-secondary rounded-3 px-3">Batal</a>
                    <button type="submit" class="btn btn-success fw-bold px-4 py-2 rounded-3" style="background: #046B26; border-color: #046B26;">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const iconInput = document.getElementById('iconInput');
    const iconPreview = document.getElementById('iconPreview');
    if (iconInput && iconPreview) {
        iconInput.addEventListener('input', function () {
            iconPreview.className = 'bi ' + (this.value.trim() || 'bi-mortarboard-fill');
        });
    }

    const fileInput = document.getElementById('multiPhotoInput');
    const previewGrid = document.getElementById('photoPreviewGrid');
    let selectedFiles = new DataTransfer();

    if (fileInput && previewGrid) {
        fileInput.addEventListener('change', function () {
            Array.from(this.files).forEach(file => selectedFiles.items.add(file));
            this.files = selectedFiles.files;
            renderPreviews();
        });
    }

    function renderPreviews() {
        previewGrid.innerHTML = '';
        if (selectedFiles.files.length === 0) {
            previewGrid.classList.add('d-none');
            return;
        }
        previewGrid.classList.remove('d-none');

        Array.from(selectedFiles.files).forEach((file, idx) => {
            const url = URL.createObjectURL(file);
            const col = document.createElement('div');
            col.className = 'col-6 col-md-3';
            col.innerHTML = `
                <div class="border rounded-3 p-2 position-relative bg-white shadow-xs">
                    <img src="${url}" class="w-100 rounded-2" style="height: 110px; object-fit: cover;">
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <span class="badge bg-success" style="font-size: 10px;">Foto Baru #${idx + 1}</span>
                        <button type="button" class="btn btn-sm btn-outline-danger py-0 px-1" data-remove-idx="${idx}">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                </div>
            `;
            previewGrid.appendChild(col);
        });

        previewGrid.querySelectorAll('[data-remove-idx]').forEach(btn => {
            btn.addEventListener('click', function () {
                const rmIdx = parseInt(this.getAttribute('data-remove-idx'), 10);
                const nextDt = new DataTransfer();
                Array.from(selectedFiles.files).forEach((f, i) => {
                    if (i !== rmIdx) nextDt.items.add(f);
                });
                selectedFiles = nextDt;
                fileInput.files = selectedFiles.files;
                renderPreviews();
            });
        });
    }
});
</script>
@endpush

