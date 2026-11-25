@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Edit Item Tri Dharma</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('tridharma.index') }}">Tri Dharma</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-8 col-md-10">
        <div class="card shadow-sm">
            <div class="card-header py-3">
                <h5 class="mb-0 fw-semibold">
                    <i class="bi bi-pencil-square me-2 text-warning"></i>Form Edit Tri Dharma
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

                <form action="{{ route('tridharma.update', $tridharma->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Icon & Warna --}}
                    <div class="row">
                        <div class="col-md-7 mb-3">
                            <label for="icon" class="form-label fw-semibold">
                                Bootstrap Icon Class <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light" id="icon-preview-box" style="font-size:22px;color:{{ old('warna', $tridharma->warna ?? '#046B26') }};min-width:52px;justify-content:center;">
                                    <i id="preview-icon-el" class="bi {{ old('icon', $tridharma->icon) }}"></i>
                                </span>
                                <input type="text"
                                       id="icon"
                                       name="icon"
                                       class="form-control @error('icon') is-invalid @enderror"
                                       value="{{ old('icon', $tridharma->icon) }}"
                                       placeholder="Contoh: bi-journal-check, bi-globe-americas"
                                       oninput="updatePreview()">
                            </div>
                            <div class="form-text">
                                Lihat daftar icon di <a href="https://icons.getbootstrap.com/" target="_blank">icons.getbootstrap.com</a>.
                            </div>
                            @error('icon')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-5 mb-3">
                            <label for="warna" class="form-label fw-semibold">Warna Icon</label>
                            <div class="d-flex align-items-center gap-2">
                                <input type="color"
                                       id="warna_picker"
                                       class="form-control form-control-color"
                                       value="{{ old('warna', Str::startsWith($tridharma->warna ?? '', '#') ? $tridharma->warna : '#046B26') }}"
                                       title="Pilih Warna"
                                       onchange="document.getElementById('warna').value = this.value; updatePreview();">
                                <input type="text"
                                       id="warna"
                                       name="warna"
                                       class="form-control @error('warna') is-invalid @enderror"
                                       value="{{ old('warna', $tridharma->warna ?? '#046B26') }}"
                                       placeholder="#046B26"
                                       oninput="updateColorFromInput(this.value)">
                            </div>
                            @error('warna')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Judul --}}
                    <div class="mb-3">
                        <label for="judul" class="form-label fw-semibold">
                            Judul Riset / Pengabdian <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               id="judul"
                               name="judul"
                               class="form-control @error('judul') is-invalid @enderror"
                               value="{{ old('judul', $tridharma->judul) }}"
                               placeholder="Contoh: Riset Terapan / Publikasi SINTA">
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Deskripsi --}}
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label fw-semibold">Deskripsi Singkat</label>
                        <textarea id="deskripsi"
                                  name="deskripsi"
                                  class="form-control @error('deskripsi') is-invalid @enderror"
                                  rows="3"
                                  placeholder="Contoh: Fokus riset ergonomi industri maritim dan sanitasi pesisir...">{{ old('deskripsi', $tridharma->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        {{-- Urutan --}}
                        <div class="col-sm-4 mb-3">
                            <label for="urutan" class="form-label fw-semibold">Urutan Tampil</label>
                            <input type="number"
                                   id="urutan"
                                   name="urutan"
                                   class="form-control @error('urutan') is-invalid @enderror"
                                   value="{{ old('urutan', $tridharma->urutan) }}"
                                   min="0"
                                   max="255">
                            <div class="form-text">Angka lebih kecil tampil lebih dulu.</div>
                            @error('urutan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Status Aktif --}}
                        <div class="col-sm-8 mb-3 d-flex align-items-center pt-sm-4">
                            <div class="form-check form-switch">
                                <input type="hidden" name="is_active" value="0">
                                <input class="form-check-input"
                                       type="checkbox"
                                       role="switch"
                                       id="is_active"
                                       name="is_active"
                                       value="1"
                                       {{ old('is_active', $tridharma->is_active ? '1' : '0') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold ms-2" for="is_active">
                                    Aktifkan (Tampilkan di Beranda)
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="d-flex gap-2 justify-content-end pt-3 border-top mt-2">
                        <a href="{{ route('tridharma.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-warning text-dark fw-bold">
                            <i class="bi bi-check-lg me-1"></i> Perbarui
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
function updatePreview() {
    const iconVal = document.getElementById('icon').value.trim();
    const colorVal = document.getElementById('warna').value.trim() || '#046B26';
    const iconEl = document.getElementById('preview-icon-el');
    const boxEl = document.getElementById('icon-preview-box');

    iconEl.className = 'bi ' + (iconVal || 'bi-journal-check');
    boxEl.style.color = colorVal;
}

function updateColorFromInput(val) {
    if (/^#[0-9A-F]{6}$/i.test(val)) {
        document.getElementById('warna_picker').value = val;
    }
    updatePreview();
}
</script>
@endpush
