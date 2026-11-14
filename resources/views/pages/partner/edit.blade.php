@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
        <h1>Edit Mitra Kerjasama</h1>
        <a href="{{ route('partner.agreements.create', $partner) }}" class="btn btn-success btn-sm">
            <i class="bi bi-plus-lg me-1"></i>Tambah Perjanjian Baru
        </a>
    </div>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('partner.index') }}">Mitra Kerjasama</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>
</div>

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

<div class="row g-4">
    {{-- KOLOM KIRI: EDIT DATA MITRA KERJASAMA --}}
    <div class="col-lg-5">
        <div class="card shadow-sm h-100 mb-0">
            <div class="card-header py-3 bg-white border-bottom">
                <h5 class="mb-0 fw-semibold text-dark">
                    <i class="bi bi-building text-warning me-2"></i>1. Informasi Mitra
                </h5>
                <small class="text-muted">Perbarui data instansi atau perusahaan mitra.</small>
            </div>
            <div class="card-body pt-3">
                <form action="{{ route('partner.update', $partner->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="nama" class="form-label fw-semibold">Nama Mitra Kerjasama <span class="text-danger">*</span></label>
                        <input type="text" id="nama" name="nama"
                               class="form-control @error('nama') is-invalid @enderror"
                               value="{{ old('nama', $partner->nama) }}" required>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    @if ($partner->logo)
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Logo Saat Ini</label>
                            <div>
                                <img src="{{ asset('storage/' . $partner->logo) }}"
                                     alt="{{ $partner->nama }}"
                                     style="max-width:200px;max-height:110px;object-fit:contain;border-radius:8px;border:1px solid #dee2e6;padding:4px;background:#f8fafc">
                            </div>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label for="logo" class="form-label fw-semibold">
                            {{ $partner->logo ? 'Ganti Logo' : 'Upload Logo' }}
                            <span class="badge bg-secondary fw-normal ms-1" style="font-size:10px">Opsional</span>
                        </label>
                        <input type="file"
                               id="logo"
                               name="logo"
                               class="form-control @error('logo') is-invalid @enderror"
                               accept="image/jpg,image/jpeg,image/png,image/webp,image/svg+xml"
                               onchange="previewLogo(this)">
                        <div class="form-text">
                            <i class="bi bi-info-circle me-1"></i>
                            Kosongkan jika tidak ingin mengganti logo. Maks: 20 MB.
                        </div>
                        @error('logo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <div id="previewWrap" class="mt-3 d-none">
                            <p class="small text-muted mb-1">Preview logo baru:</p>
                            <img id="previewImg" src="" alt="Preview"
                                 style="max-width:200px;max-height:110px;object-fit:contain;border-radius:8px;border:2px solid #0d6efd;padding:4px">
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-sm-5">
                            <label for="urutan" class="form-label fw-semibold">Urutan Tampil</label>
                            <input type="number" id="urutan" name="urutan"
                                   class="form-control @error('urutan') is-invalid @enderror"
                                   value="{{ old('urutan', $partner->urutan) }}" min="0">
                            @error('urutan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-7 d-flex align-items-center" style="padding-top:28px">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="aktif" name="aktif" value="1"
                                       {{ old('aktif', $partner->aktif) ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="aktif">
                                    Aktifkan Mitra
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2 pt-2 border-top">
                        <a href="{{ route('partner.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-warning text-white fw-semibold">
                            <i class="bi bi-save me-1"></i> Simpan Perubahan Mitra
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- KOLOM KANAN: DAFTAR PERJANJIAN KERJASAMA MITRA INI --}}
    <div class="col-lg-7">
        <div class="card shadow-sm h-100 mb-0">
            <div class="card-header py-3 bg-white border-bottom d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0 fw-semibold text-dark">
                        <i class="bi bi-file-earmark-text text-success me-2"></i>2. Dokumen Perjanjian Kerjasama
                    </h5>
                    <small class="text-muted">Total {{ $partner->agreements->count() }} dokumen perjanjian terdaftar</small>
                </div>
                <a href="{{ route('partner.agreements.create', $partner) }}" class="btn btn-sm btn-success">
                    <i class="bi bi-plus-circle me-1"></i>Tambah Perjanjian
                </a>
            </div>
            <div class="card-body p-0">
                @if($partner->agreements->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 50px;">No</th>
                                    <th style="width: 80px;">Jenis</th>
                                    <th>Judul Kerjasama</th>
                                    <th>Nomor / Masa</th>
                                    <th style="width: 80px;" class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($partner->agreements as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <span class="badge rounded-pill text-bg-success">{{ $item->jenis }}</span>
                                        </td>
                                        <td>
                                            <div class="fw-semibold text-dark">{{ $item->judul }}</div>
                                            @if($item->deskripsi)
                                                <small class="text-muted">{{ Str::limit($item->deskripsi, 60) }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            <small class="d-block text-secondary">{{ $item->nomor ?: '—' }}</small>
                                            @if($item->tanggal_mulai)
                                                <small class="text-muted">{{ $item->tanggal_mulai->format('d/m/Y') }} {{ $item->tanggal_selesai ? ' - ' . $item->tanggal_selesai->format('d/m/Y') : '' }}</small>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <div class="d-flex justify-content-end gap-1">
                                                <a href="{{ route('partner.agreements.edit', [$partner, $item]) }}"
                                                   class="btn btn-sm btn-warning text-white" title="Edit">
                                                    <i class="bi bi-pencil-fill"></i>
                                                </a>
                                                <form action="{{ route('partner.agreements.destroy', [$partner, $item]) }}"
                                                      method="POST" onsubmit="return confirm('Hapus dokumen perjanjian ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                        <i class="bi bi-trash-fill"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-folder2-open text-success fs-1 d-block mb-2"></i>
                        <p class="mb-2">Belum ada dokumen perjanjian (MOU, MOA, IA) untuk mitra ini.</p>
                        <a href="{{ route('partner.agreements.create', $partner) }}" class="btn btn-sm btn-outline-success">
                            <i class="bi bi-plus-lg me-1"></i>Tambah Perjanjian Sekarang
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function previewLogo(input) {
        const wrap = document.getElementById('previewWrap');
        const img  = document.getElementById('previewImg');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                img.src = e.target.result;
                wrap.classList.remove('d-none');
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            wrap.classList.add('d-none');
        }
    }
</script>
@endpush
