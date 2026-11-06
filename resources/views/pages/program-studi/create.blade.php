@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle d-flex flex-wrap align-items-center justify-content-between gap-2 mb-4">
    <div>
        <h1 class="mb-1">Tambah Program Studi Baru</h1>
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('program-studi.index') }}">Program Studi</a></li>
                <li class="breadcrumb-item active">Tambah Baru</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('program-studi.index') }}" class="btn btn-outline-secondary rounded-3 px-3">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
    </a>
</div>

<div class="row">
    <div class="col-12">
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

        <form action="{{ route('program-studi.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

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
                            <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" placeholder="Contoh: S1 Teknik Informatika" required>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-bold small">Jenjang Pendidikan <span class="text-danger">*</span></label>
                            <select name="jenjang" class="form-select" id="selectJenjang" required>
                                <option value="S1" {{ old('jenjang', $selectedFakultas === 'Program Pascasarjana' ? 'S2' : 'S1') === 'S1' ? 'selected' : '' }}>S1 (Sarjana)</option>
                                <option value="S2" {{ old('jenjang', $selectedFakultas === 'Program Pascasarjana' ? 'S2' : 'S1') === 'S2' ? 'selected' : '' }}>S2 (Pascasarjana)</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-bold small">Gelar Lulusan</label>
                            <input type="text" name="gelar" class="form-control" value="{{ old('gelar') }}" placeholder="Contoh: S.Kom., S.T., M.M.">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Fakultas / Unit Penyelenggara <span class="text-danger">*</span></label>
                            <select name="fakultas" class="form-select" required>
                                @foreach($fakultasList as $fak)
                                    <option value="{{ $fak }}" {{ old('fakultas', $selectedFakultas) === $fak ? 'selected' : '' }}>{{ $fak }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-bold small">Status Akreditasi</label>
                            <input type="text" name="akreditasi" class="form-control" value="{{ old('akreditasi', 'Baik Sekali') }}" placeholder="Contoh: Baik Sekali / Unggul">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-bold small">Icon Bootstrap</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-success"><i class="bi bi-mortarboard-fill" id="iconPreview"></i></span>
                                <input type="text" name="icon" id="iconInput" class="form-control" value="{{ old('icon', 'bi-mortarboard-fill') }}" placeholder="bi-mortarboard-fill">
                            </div>
                        </div>

                        <div class="col-md-8">
                            <label class="form-label fw-bold small">Link Website Resmi Prodi / Fakultas (Opsional)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-globe"></i></span>
                                <input type="text" name="link_website" class="form-control" value="{{ old('link_website') }}" placeholder="Contoh: https://fst.uis.ac.id">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label fw-bold small">Urutan Tampil</label>
                            <input type="number" name="urutan" class="form-control" value="{{ old('urutan', $nextUrutan) }}" min="1">
                        </div>

                        <div class="col-md-2 d-flex align-items-end">
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" name="is_active" id="isActive" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
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
                            <textarea name="deskripsi_singkat" rows="2" class="form-control" placeholder="Ringkasan singkat 1-2 kalimat tentang fokus keilmuan Program Studi...">{{ old('deskripsi_singkat') }}</textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold small">Profil Lengkap Program Studi</label>
                            <textarea name="deskripsi" rows="6" class="form-control" placeholder="Tuliskan penjelasan lengkap mengenai profil, keunggulan, dan fokus kurikulum Program Studi...">{{ old('deskripsi') }}</textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold small">Visi Program Studi</label>
                            <textarea name="visi" rows="2" class="form-control" placeholder="Tuliskan pernyataan Visi Program Studi...">{{ old('visi') }}</textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Misi Program Studi <span class="text-muted fw-normal">(Pisahkan dengan Enter / baris baru)</span></label>
                            <textarea name="misi" rows="5" class="form-control" placeholder="1 baris = 1 poin misi&#10;Menyelenggarakan pendidikan...&#10;Melaksanakan penelitian...">{{ old('misi') }}</textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Prospek Karir Lulusan <span class="text-muted fw-normal">(Pisahkan dengan Enter / baris baru)</span></label>
                            <textarea name="prospek_karir" rows="5" class="form-control" placeholder="1 baris = 1 profesi lulusan&#10;Software Engineer&#10;System Analyst&#10;IT Consultant">{{ old('prospek_karir') }}</textarea>
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
                    <label class="form-label fw-bold small d-block mb-2">
                        <i class="bi bi-cloud-arrow-up-fill text-success me-1"></i> Pilih Foto Kegiatan / Banner Prodi (Kapasitas Lapang Maks. 20 MB per Foto)
                    </label>
                    <div class="w-100 text-center p-4 p-md-5 rounded-4 position-relative"
                         style="border: 2px dashed #046B26; background: #f4faf6; cursor: pointer;"
                         onclick="document.getElementById('multiPhotoInput').click()">
                        <input type="file" name="foto[]" id="multiPhotoInput" class="d-none" accept="image/jpeg,image/png,image/webp" multiple onclick="event.stopPropagation()">
                        <div class="mx-auto mb-2 rounded-circle d-inline-flex align-items-center justify-content-center"
                             style="width: 60px; height: 60px; background: #e3f3e8; color: #046B26; font-size: 26px;">
                            <i class="bi bi-cloud-arrow-up-fill"></i>
                        </div>
                        <h6 class="fw-bold text-dark mb-1">Klik di Sini untuk Memilih Foto Dokumentasi / Banner Prodi</h6>
                        <p class="text-muted small mb-2">Bisa pilih lebih dari 1 gambar sekaligus. Foto pertama otomatis menjadi foto sampul utama.</p>
                        <span class="badge rounded-pill px-3 py-1.5" style="background: #046B26;">Kapasitas Lapang: Maksimal 20 MB / Foto (JPG, PNG, WEBP)</span>
                    </div>

                    <div id="photoPreviewGrid" class="row g-3 mt-3 d-none"></div>
                </div>

                <div class="card-footer bg-light py-3 px-4 d-flex justify-content-between align-items-center" style="border-radius: 0 0 16px 16px;">
                    <a href="{{ route('program-studi.index') }}" class="btn btn-outline-secondary rounded-3 px-3">Batal</a>
                    <button type="submit" class="btn btn-success fw-bold px-4 py-2 rounded-3" style="background: #046B26; border-color: #046B26;">
                        <i class="bi bi-save me-1"></i> Simpan Program Studi
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
                        <span class="badge ${idx === 0 ? 'bg-success' : 'bg-secondary'}" style="font-size: 10px;">
                            ${idx === 0 ? 'Foto Utama' : 'Foto #' + (idx + 1)}
                        </span>
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

