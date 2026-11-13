@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Tambah Kartu Keunggulan Beranda</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('feature.index') }}">Kartu Keunggulan Beranda</a></li>
            <li class="breadcrumb-item active">Tambah</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-8 col-md-10">
        <div class="card shadow-sm">
            <div class="card-header py-3">
                <h5 class="mb-0 fw-semibold">
                    <i class="bi bi-plus-circle-fill me-2 text-success"></i>Form Tambah Kartu Keunggulan Beranda
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

                <form action="{{ route('feature.store') }}" method="POST">
                    @csrf

                    <div class="row g-3 mb-3">
                        {{-- Icon --}}
                        <div class="col-md-7">
                            <label for="icon" class="form-label fw-semibold">
                                Bootstrap Icon Class <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-success" id="icon-preview-box" style="font-size: 20px;">
                                    <i class="bi bi-layers"></i>
                                </span>
                                <input type="text"
                                       id="icon"
                                       name="icon"
                                       class="form-control @error('icon') is-invalid @enderror"
                                       value="{{ old('icon', 'bi-layers') }}"
                                       placeholder="Contoh: bi-layers, bi-house-door, bi-people, bi-award"
                                       oninput="updateIconPreview(this.value)">
                            </div>
                            <div class="d-flex flex-wrap gap-1 mt-2">
                                @foreach(['bi-layers' => 'Layers', 'bi-house-door' => 'Kampus', 'bi-people' => 'Kerjasama', 'bi-award' => 'Beasiswa', 'bi-mortarboard' => 'Akademik', 'bi-shield-check' => 'Mutu'] as $ic => $lbl)
                                    <button type="button" class="btn btn-sm btn-outline-secondary py-0 px-2" style="font-size: 11px;" onclick="selectQuickIcon('{{ $ic }}')">
                                        <i class="bi {{ $ic }} me-1"></i>{{ $lbl }}
                                    </button>
                                @endforeach
                            </div>
                            @error('icon')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Label Badge --}}
                        <div class="col-md-5">
                            <label for="badge" class="form-label fw-semibold">
                                Label Badge Status
                            </label>
                            <input type="text"
                                   id="badge"
                                   name="badge"
                                   class="form-control @error('badge') is-invalid @enderror"
                                   value="{{ old('badge', 'TERAKREDITASI') }}"
                                   placeholder="Contoh: TERAKREDITASI, MOU AKTIF">
                            <div class="form-text">Tampil pada kapsul bagian bawah kartu.</div>
                            @error('badge')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Judul (wajib) --}}
                    <div class="mb-3">
                        <label for="judul" class="form-label fw-semibold">
                            Judul Kartu <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               id="judul"
                               name="judul"
                               class="form-control @error('judul') is-invalid @enderror"
                               value="{{ old('judul') }}"
                               placeholder="Contoh: Program Studi">
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Deskripsi (wajib) --}}
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label fw-semibold">
                            Deskripsi Singkat <span class="text-danger">*</span>
                        </label>
                        <textarea id="deskripsi-feature"
                                  name="deskripsi"
                                  class="form-control @error('deskripsi') is-invalid @enderror"
                                  rows="3"
                                  placeholder="Contoh: Terakreditasi BAN-PT dengan kurikulum berbasis industri">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Urutan --}}
                    <div class="mb-4 col-sm-4">
                        <label for="urutan" class="form-label fw-semibold">
                            Urutan Tampil
                        </label>
                        <input type="number"
                               id="urutan"
                               name="urutan"
                               class="form-control @error('urutan') is-invalid @enderror"
                               value="{{ old('urutan', 1) }}"
                               min="0"
                               placeholder="1">
                        <div class="form-text">Urutan 1 tampil sebagai kartu hijau utama.</div>
                        @error('urutan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('feature.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-save me-1"></i> Simpan Kartu
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
    function updateIconPreview(val) {
        const previewBox = document.getElementById('icon-preview-box');
        const cleanVal = (val || '').trim();
        previewBox.innerHTML = cleanVal ? '<i class="bi ' + cleanVal + '"></i>' : '<i class="bi bi-layers"></i>';
    }
    function selectQuickIcon(ic) {
        const input = document.getElementById('icon');
        input.value = ic;
        updateIconPreview(ic);
    }
    document.addEventListener('DOMContentLoaded', function() {
        updateIconPreview(document.getElementById('icon').value);
    });
</script>
@endpush
