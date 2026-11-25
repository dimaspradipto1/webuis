@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle d-flex flex-wrap align-items-center justify-content-between gap-2 mb-4">
    <div>
        <h1 class="mb-1">Kelola Sertifikat Akreditasi</h1>
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item">Informasi</li>
                <li class="breadcrumb-item active">Sertifikat Akreditasi</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('homepage.akreditasi') }}" target="_blank" class="btn btn-outline-success rounded-3 px-3">
            <i class="bi bi-box-arrow-up-right me-1"></i> Pratinjau di Web
        </a>
        <a href="{{ route('akreditasi.create') }}" class="btn btn-success rounded-3 px-3 shadow-sm" style="background: #046B26; border-color: #046B26;">
            <i class="bi bi-plus-circle-fill me-1"></i> Tambah Sertifikat
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4 rounded-3 border-0 shadow-sm" role="alert">
        <i class="bi bi-check-circle-fill me-2 fs-5"></i>
        <div>{{ session('success') }}</div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

{{-- Ringkasan Statistik --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 p-3" style="border-left: 4px solid #046B26 !important;">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small fw-semibold">Total Sertifikat</div>
                    <div class="fs-4 fw-bold text-dark mt-1">{{ $totalCount }}</div>
                </div>
                <div class="rounded-circle p-2 d-flex align-items-center justify-content-center" style="background: rgba(4, 107, 38, 0.1); width: 44px; height: 44px;">
                    <i class="bi bi-award-fill fs-5" style="color: #046B26;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 p-3" style="border-left: 4px solid #fed802 !important;">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small fw-semibold">Universitas / Institusi</div>
                    <div class="fs-4 fw-bold text-dark mt-1">{{ $univCount }}</div>
                </div>
                <div class="rounded-circle p-2 d-flex align-items-center justify-content-center" style="background: rgba(254, 216, 2, 0.2); width: 44px; height: 44px;">
                    <i class="bi bi-building fs-5 text-warning"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 p-3" style="border-left: 4px solid #0d6efd !important;">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small fw-semibold">Tingkat Fakultas</div>
                    <div class="fs-4 fw-bold text-dark mt-1">{{ $fakultasCount }}</div>
                </div>
                <div class="rounded-circle p-2 d-flex align-items-center justify-content-center" style="background: rgba(13, 110, 253, 0.1); width: 44px; height: 44px;">
                    <i class="bi bi-mortarboard-fill fs-5 text-primary"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 p-3" style="border-left: 4px solid #198754 !important;">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small fw-semibold">Program Studi</div>
                    <div class="fs-4 fw-bold text-dark mt-1">{{ $prodiCount }}</div>
                </div>
                <div class="rounded-circle p-2 d-flex align-items-center justify-content-center" style="background: rgba(25, 135, 84, 0.1); width: 44px; height: 44px;">
                    <i class="bi bi-journal-check fs-5 text-success"></i>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Filter & Pencarian --}}
<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body p-3">
        <form method="GET" action="{{ route('akreditasi.index') }}" class="row g-2 align-items-center">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-light border-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="q" value="{{ $search }}" class="form-control bg-light border-0" placeholder="Cari nama prodi, nomor SK, lembaga...">
                </div>
            </div>
            <div class="col-md-3">
                <select name="tingkat" class="form-select bg-light border-0" onchange="this.form.submit()">
                    <option value="semua" {{ $tingkatFilter === 'semua' || empty($tingkatFilter) ? 'selected' : '' }}>Semua Tingkat (Univ, Fak, Prodi)</option>
                    <option value="universitas" {{ $tingkatFilter === 'universitas' ? 'selected' : '' }}>Universitas (Institusi)</option>
                    <option value="fakultas" {{ $tingkatFilter === 'fakultas' ? 'selected' : '' }}>Fakultas</option>
                    <option value="prodi" {{ $tingkatFilter === 'prodi' ? 'selected' : '' }}>Program Studi</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="kategori" class="form-select bg-light border-0" onchange="this.form.submit()">
                    <option value="semua" {{ $kategoriFilter === 'semua' || empty($kategoriFilter) ? 'selected' : '' }}>Semua Fakultas/Kategori</option>
                    @foreach($kategoriList as $kat)
                        <option value="{{ $kat }}" {{ $kategoriFilter === $kat ? 'selected' : '' }}>{{ $kat }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary rounded-3 w-100" style="background: #046B26; border-color: #046B26;">Filter</button>
                @if($search || ($tingkatFilter && $tingkatFilter !== 'semua') || ($kategoriFilter && $kategoriFilter !== 'semua'))
                    <a href="{{ route('akreditasi.index') }}" class="btn btn-outline-secondary rounded-3" title="Reset Filter"><i class="bi bi-arrow-counterclockwise"></i></a>
                @endif
            </div>
        </form>
    </div>
</div>

{{-- Tabel Data Sertifikat --}}
<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="card-header bg-white py-3 px-4 d-flex align-items-center justify-content-between border-bottom">
        <h5 class="mb-0 fw-bold text-dark d-flex align-items-center gap-2">
            <i class="bi bi-patch-check-fill text-success fs-5"></i>
            Daftar Sertifikat Akreditasi
        </h5>
        <span class="badge bg-light text-muted px-3 py-1.5 rounded-pill fw-semibold">
            Menampilkan {{ $items->total() }} Data
        </span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-muted small text-uppercase">
                    <tr>
                        <th class="ps-4" style="width: 50px;">No</th>
                        <th>Nama Entitas / Prodi</th>
                        <th>Tingkat & Kategori</th>
                        <th>Lembaga</th>
                        <th>Peringkat</th>
                        <th>Nomor SK & Masa Berlaku</th>
                        <th class="text-center">Sertifikat</th>
                        <th class="text-center">Status</th>
                        <th class="text-end pe-4" style="width: 140px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $index => $item)
                        <tr>
                            <td class="ps-4 text-muted fw-semibold">{{ $items->firstItem() + $index }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $item->nama }}</div>
                                @if($item->jenjang && $item->jenjang !== 'Institusi' && $item->jenjang !== 'Fakultas')
                                    <span class="badge bg-light text-primary border rounded-pill px-2 py-0.5 small mt-0.5">Jenjang {{ $item->jenjang }}</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $badgeTingkat = match($item->tingkat) {
                                        'universitas' => 'bg-warning text-dark',
                                        'fakultas' => 'bg-info text-dark',
                                        default => 'bg-light text-secondary border'
                                    };
                                @endphp
                                <span class="badge {{ $badgeTingkat }} rounded-pill px-2.5 py-1 fw-bold small text-capitalize mb-1 d-inline-block">
                                    {{ $item->tingkat }}
                                </span>
                                <div class="small text-muted text-truncate" style="max-width: 180px;">{{ $item->kategori_label }}</div>
                            </td>
                            <td>
                                <span class="badge bg-dark-subtle text-dark rounded-pill px-2.5 py-1 fw-semibold small">
                                    {{ $item->lembaga }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $item->badge_class }} rounded-pill px-3 py-1 fw-bold small">
                                    {{ $item->peringkat }}
                                </span>
                            </td>
                            <td>
                                <div class="small fw-semibold text-dark">{{ $item->nomor_sk ?: '-' }}</div>
                                <div class="small text-muted"><i class="bi bi-clock me-1"></i>{{ $item->masa_berlaku ?: ($item->tahun_sk ? 'Tahun ' . $item->tahun_sk : '-') }}</div>
                            </td>
                            <td class="text-center">
                                @if($item->file_sertifikat)
                                    <a href="{{ $item->file_url }}" target="_blank" class="btn btn-sm btn-outline-success rounded-pill px-2.5 py-1" title="Lihat / Unduh Dokumen">
                                        <i class="bi bi-file-earmark-pdf-fill me-1 text-danger"></i> Unduh
                                    </a>
                                @else
                                    <span class="badge bg-secondary-subtle text-muted rounded-pill px-2 py-1 small">Belum Upload</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($item->is_active)
                                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2.5 py-1 small">
                                        <i class="bi bi-check-circle me-1"></i>Aktif
                                    </span>
                                @else
                                    <span class="badge bg-secondary-subtle text-muted rounded-pill px-2.5 py-1 small">Nonaktif</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <div class="btn-group gap-1">
                                    <a href="{{ route('akreditasi.edit', $item->id) }}" class="btn btn-sm btn-outline-primary rounded-2 px-2" title="Edit Akreditasi">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('akreditasi.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data sertifikat akreditasi ini?')" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-2 px-2" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-5 text-muted">
                                <i class="bi bi-folder-x fs-1 d-block mb-2 text-secondary"></i>
                                Tidak ada data sertifikat akreditasi yang sesuai kriteria pencarian.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($items->hasPages())
        <div class="card-footer bg-white py-3 px-4 border-top">
            {{ $items->links() }}
        </div>
    @endif
</div>
@endsection
