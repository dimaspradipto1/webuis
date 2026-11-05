@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle d-flex flex-wrap align-items-center justify-content-between gap-2 mb-4">
    <div>
        <h1 class="mb-1">Manajemen Program Studi & Detail Prodi</h1>
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Program Studi</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('homepage.program-studi') }}" target="_blank" class="btn btn-outline-success rounded-3 px-3">
            <i class="bi bi-box-arrow-up-right me-1"></i> Lihat Halaman Program Studi
        </a>
        <a href="{{ route('program-studi.create', ['fakultas' => $fakultas]) }}" class="btn btn-success rounded-3 px-3 shadow-sm" style="background: #046B26; border-color: #046B26;">
            <i class="bi bi-plus-circle-fill me-1"></i> Tambah Program Studi
        </a>
    </div>
</div>

{{-- Filter Tabs Berdasarkan Fakultas / Jenjang --}}
<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body p-3">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
            <div class="nav nav-pills gap-2">
                <a href="{{ route('program-studi.index') }}"
                   class="nav-link rounded-pill px-3 py-2 fw-semibold {{ empty($fakultas) ? 'active bg-success text-white' : 'bg-light text-dark' }}"
                   style="{{ empty($fakultas) ? 'background: #046B26 !important;' : '' }}">
                    <i class="bi bi-grid-fill me-1"></i> Semua Prodi
                    <span class="badge rounded-pill ms-1 {{ empty($fakultas) ? 'bg-white text-success' : 'bg-secondary text-white' }}">
                        {{ $allProdis->count() }}
                    </span>
                </a>

                @foreach($fakultasList as $fak)
                    @php
                        $countFak = $allProdis->where('fakultas', $fak)->count();
                        $isActiveTab = $fakultas === $fak;
                    @endphp
                    <a href="{{ route('program-studi.index', ['fakultas' => $fak]) }}"
                       class="nav-link rounded-pill px-3 py-2 fw-semibold {{ $isActiveTab ? 'active bg-success text-white' : 'bg-light text-dark' }}"
                       style="{{ $isActiveTab ? 'background: #046B26 !important;' : '' }}">
                        <i class="bi {{ $fak === 'Program Pascasarjana' ? 'bi-mortarboard-fill' : 'bi-building' }} me-1"></i>
                        {{ $fak }}
                        <span class="badge rounded-pill ms-1 {{ $isActiveTab ? 'bg-white text-success' : 'bg-secondary text-white' }}">
                            {{ $countFak }}
                        </span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- Daftar Program Studi Dikelompokkan per Fakultas --}}
@php
    $grouped = $prodis->groupBy('fakultas');
@endphp

@forelse($grouped as $namaFakultas => $items)
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-white py-3 px-4 d-flex align-items-center justify-content-between flex-wrap gap-2" style="border-top: 3px solid #046B26; border-radius: 16px 16px 0 0;">
            <div class="d-flex align-items-center gap-2">
                <span class="badge rounded-pill px-3 py-1.5 text-white" style="background: #046B26;">
                    {{ $namaFakultas === 'Program Pascasarjana' ? 'S2 Pascasarjana' : 'S1 Sarjana' }}
                </span>
                <h5 class="mb-0 fw-bold text-dark">{{ $namaFakultas }}</h5>
                <span class="text-muted small">({{ $items->count() }} Program Studi)</span>
            </div>
            <a href="{{ route('program-studi.create', ['fakultas' => $namaFakultas]) }}" class="btn btn-sm btn-outline-success rounded-pill px-3">
                <i class="bi bi-plus-lg me-1"></i> Tambah Prodi di {{ $namaFakultas }}
            </a>
        </div>

        <div class="card-body p-4">
            <div class="row g-3">
                @foreach($items as $prodi)
                    @php
                        $photoCount = count($prodi->all_photos);
                    @endphp
                    <div class="col-xl-6 col-12">
                        <div class="border rounded-4 p-3 h-100 d-flex flex-column justify-content-between bg-white shadow-xs">
                            <div>
                                <div class="d-flex align-items-start justify-content-between gap-3 mb-2">
                                    <div class="d-flex align-items-center gap-3">
                                        @if($prodi->foto_url)
                                            <img src="{{ $prodi->foto_url }}" alt="{{ $prodi->nama }}" class="rounded-3 border" style="width: 56px; height: 56px; object-fit: cover; flex-shrink: 0;">
                                        @else
                                            <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 56px; height: 56px; background: #eaf5ee; color: #046B26; font-size: 24px; flex-shrink: 0;">
                                                <i class="bi {{ $prodi->icon ?: 'bi-mortarboard-fill' }}"></i>
                                            </div>
                                        @endif

                                        <div>
                                            <div class="d-flex flex-wrap align-items-center gap-1 mb-1">
                                                <span class="badge bg-success-subtle text-success fw-bold" style="font-size: 11px;">{{ $prodi->jenjang }}</span>
                                                @if($prodi->gelar)
                                                    <span class="badge bg-light text-dark border" style="font-size: 11px;">Gelar: {{ $prodi->gelar }}</span>
                                                @endif
                                                @if($prodi->akreditasi)
                                                    <span class="badge bg-warning-subtle text-dark fw-semibold" style="font-size: 11px;">
                                                        <i class="bi bi-patch-check-fill text-warning me-1"></i>{{ $prodi->akreditasi }}
                                                    </span>
                                                @endif
                                                @if($photoCount > 0)
                                                    <span class="badge bg-info-subtle text-info-emphasis" style="font-size: 11px;">
                                                        <i class="bi bi-images me-1"></i>{{ $photoCount }} Foto
                                                    </span>
                                                @endif
                                            </div>
                                            <h6 class="fw-bold text-dark mb-0" style="font-size: 16px;">{{ $prodi->nama }}</h6>
                                        </div>
                                    </div>

                                    @if($prodi->is_active)
                                        <span class="badge rounded-pill bg-success-subtle text-success">Aktif</span>
                                    @else
                                        <span class="badge rounded-pill bg-secondary-subtle text-secondary">Nonaktif</span>
                                    @endif
                                </div>

                                <p class="text-muted small mb-3" style="line-height: 1.6;">
                                    {{ Str::limit($prodi->deskripsi_singkat ?: strip_tags($prodi->deskripsi), 140) }}
                                </p>
                            </div>

                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 pt-2 border-top">
                                <div class="small text-muted">
                                    Urutan: <strong>#{{ $prodi->urutan }}</strong>
                                    @if($prodi->link_website)
                                        • <a href="{{ $prodi->link_website }}" target="_blank" class="text-success text-decoration-none"><i class="bi bi-globe me-1"></i>Website</a>
                                    @endif
                                </div>

                                <div class="d-flex align-items-center gap-2">
                                    <a href="{{ route('homepage.program-studi.detail', $prodi->slug) }}" target="_blank" class="btn btn-sm btn-outline-secondary rounded-3" title="Lihat Detail di Frontend">
                                        <i class="bi bi-eye me-1"></i> Lihat Detail
                                    </a>
                                    <a href="{{ route('program-studi.edit', $prodi->id) }}" class="btn btn-sm btn-primary rounded-3" style="background: #046B26; border-color: #046B26;">
                                        <i class="bi bi-pencil-square me-1"></i> Edit Prodi
                                    </a>
                                    <form action="{{ route('program-studi.destroy', $prodi->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus Program Studi {{ addslashes($prodi->nama) }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-3" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@empty
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body text-center py-5">
            <i class="bi bi-journal-bookmark fs-1 text-muted mb-2 d-block"></i>
            <h5 class="fw-bold">Belum Ada Data Program Studi</h5>
            <p class="text-muted small mb-3">Silakan tambahkan data Program Studi baru untuk ditampilkan di halaman depan.</p>
            <a href="{{ route('program-studi.create') }}" class="btn btn-success rounded-3 px-4" style="background: #046B26;">
                <i class="bi bi-plus-circle me-1"></i> Tambah Program Studi
            </a>
        </div>
    </div>
@endforelse
@endsection

