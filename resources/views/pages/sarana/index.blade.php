@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle d-flex flex-wrap align-items-center justify-content-between gap-2 mb-4">
    <div>
        <h1 class="mb-1">Laboratorium & Fasilitas Kampus</h1>
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Laboratorium & Fasilitas</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex align-items-center gap-2">
        <a href="{{ route('homepage.fasilitas') }}" target="_blank" class="btn btn-outline-success btn-sm px-3">
            <i class="bi bi-box-arrow-up-right me-1"></i> Lihat Halaman Website
        </a>
        <a href="{{ route('sarana.create') }}" class="btn btn-primary btn-sm px-3">
            <i class="bi bi-plus-lg me-1"></i> Tambah Lab / Fasilitas Baru
        </a>
    </div>
</div>

@php
    $allItems = $allSaranas ?? collect();
    $filteredItems = $saranas ?? $allItems;
    $currentKat = $selectedKategori ?? request('kategori', '');
    $labCount = $allItems->where('kategori', 'Laboratorium & Studio')->count();
    $fasilitasCount = $allItems->where('kategori', 'Fasilitas Kampus')->count();
@endphp

<!-- Tab Filter Kategori yang Jelas & Mudah Dipakai -->
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body py-3 px-4 d-flex flex-wrap align-items-center justify-content-between gap-3">
        <div class="d-flex flex-wrap align-items-center gap-2">
            <a href="{{ route('sarana.index') }}"
               class="btn btn-sm rounded-pill px-3 fw-semibold {{ empty($currentKat) ? 'btn-primary' : 'btn-outline-secondary' }}">
                <i class="bi bi-grid-fill me-1"></i> Semua ({{ $allItems->count() }})
            </a>
            <a href="{{ route('sarana.index', ['kategori' => 'Laboratorium & Studio']) }}"
               class="btn btn-sm rounded-pill px-3 fw-semibold {{ $currentKat === 'Laboratorium & Studio' ? 'btn-primary' : 'btn-outline-secondary' }}">
                <i class="bi bi-cpu-fill me-1"></i> Data Laboratorium ({{ $labCount }})
            </a>
            <a href="{{ route('sarana.index', ['kategori' => 'Fasilitas Kampus']) }}"
               class="btn btn-sm rounded-pill px-3 fw-semibold {{ $currentKat === 'Fasilitas Kampus' ? 'btn-primary' : 'btn-outline-secondary' }}">
                <i class="bi bi-building-fill me-1"></i> Data Fasilitas Kampus ({{ $fasilitasCount }})
            </a>
        </div>
        <span class="text-muted small">
            Klik tombol <strong>"Kelola Detail & Foto"</strong> pada masing-masing kartu di bawah untuk mengubah isi halaman detailnya.
        </span>
    </div>
</div>

<!-- Grid Kartu Masing-Masing Laboratorium & Fasilitas -->
<div class="row g-3 mb-4">
    @forelse($filteredItems as $item)
        @php
            $isLab = ($item->kategori === 'Laboratorium & Studio');
        @endphp
        <div class="col-md-6 col-xl-4">
            <div class="card h-100 shadow-sm border-0" style="border-radius: 14px; overflow: hidden;">
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <div>
                        <!-- Baris Atas: Ikon, Kategori, Status -->
                        <div class="d-flex align-items-start justify-content-between gap-2 mb-3">
                            <div class="d-flex align-items-center gap-3">
                                @if(!empty($item->foto))
                                    <img src="{{ asset('storage/' . $item->foto) }}"
                                         alt="{{ $item->nama }}"
                                         class="rounded-3 border"
                                         style="width: 52px; height: 52px; object-fit: cover;">
                                @else
                                    <div class="rounded-3 d-flex align-items-center justify-content-center"
                                         style="width: 52px; height: 52px; background: {{ $isLab ? '#eff6ff' : '#f0fdf4' }}; color: {{ $isLab ? '#2563eb' : '#16a34a' }}; font-size: 24px;">
                                        <i class="bi {{ $item->icon ?: 'bi-building' }}"></i>
                                    </div>
                                @endif
                                <div>
                                    <span class="badge {{ $isLab ? 'bg-primary' : 'bg-success' }} mb-1" style="font-size: 11px;">
                                        <i class="bi {{ $isLab ? 'bi-cpu' : 'bi-building' }} me-1"></i>{{ $item->kategori ?: 'Fasilitas Kampus' }}
                                    </span>
                                    <div class="text-muted" style="font-size: 11.5px;">
                                        Urutan Tampil: <strong>#{{ $item->urutan }}</strong>
                                    </div>
                                </div>
                            </div>

                            @if($item->is_active)
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">
                                    <i class="bi bi-check-circle-fill me-1"></i>Aktif
                                </span>
                            @else
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1">
                                    <i class="bi bi-x-circle-fill me-1"></i>Nonaktif
                                </span>
                            @endif
                        </div>

                        <!-- Nama Lengkap Laboratorium / Fasilitas -->
                        <h5 class="fw-bold text-dark mb-2" style="font-size: 16.5px; line-height: 1.4;">
                            {{ $item->nama }}
                        </h5>

                        <!-- Deskripsi Singkat -->
                        <p class="text-muted small mb-3" style="line-height: 1.55;">
                            {{ \Illuminate\Support\Str::limit($item->deskripsi ?: 'Belum ada deskripsi singkat.', 110) }}
                        </p>

                        <!-- Info Ringkas (Lokasi & Kapasitas) -->
                        <div class="bg-light rounded-3 p-2 px-3 mb-3 border" style="font-size: 12px;">
                            <div class="d-flex align-items-center text-secondary mb-1">
                                <i class="bi bi-geo-alt-fill text-danger me-2"></i>
                                <span class="text-truncate">{{ $item->lokasi ?: 'Lokasi belum diatur' }}</span>
                            </div>
                            <div class="d-flex align-items-center text-secondary">
                                <i class="bi bi-people-fill text-success me-2"></i>
                                <span class="text-truncate">{{ $item->kapasitas ?: 'Kapasitas belum diatur' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Aksi yang Jelas -->
                    <div class="d-flex align-items-center gap-2 pt-2 border-top">
                        <a href="{{ route('sarana.edit', $item->id) }}" class="btn btn-primary btn-sm flex-grow-1 fw-semibold">
                            <i class="bi bi-pencil-square me-1"></i> Kelola Detail & Foto
                        </a>
                        <a href="{{ route('homepage.fasilitas.detail', $item->slug ?: $item->id) }}"
                           target="_blank"
                           class="btn btn-outline-secondary btn-sm"
                           title="Lihat Halaman Detail di Website">
                            <i class="bi bi-eye"></i>
                        </a>
                        <form action="{{ route('sarana.destroy', $item->id) }}"
                              method="POST"
                              class="m-0"
                              onsubmit="return confirm('Yakin ingin menghapus {{ addslashes($item->nama) }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm" title="Hapus">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center py-5 text-muted">
                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                    Belum ada data pada kategori ini.
                </div>
            </div>
        </div>
    @endforelse
</div>

<!-- Tabel Ringkasan & Pencarian -->
<div class="card shadow-sm border-0">
    <div class="card-header bg-white d-flex align-items-center justify-content-between py-3">
        <h6 class="mb-0 fw-bold text-secondary">
            <i class="bi bi-table me-2 text-primary"></i>Tabel Ringkasan & Pencarian Cepat
        </h6>
    </div>
    <div class="card-body pt-3">
        <div class="table-responsive">
            {{ $dataTable->table([
                'class' => 'table table-striped table-bordered align-middle',
                'style' => 'width:100%',
            ]) }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
    @if(app()->environment('production'))
        {!! str_replace('http:', 'https:', $dataTable->scripts()) !!}
    @else
        {!! $dataTable->scripts() !!}
    @endif
@endpush
