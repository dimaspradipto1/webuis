@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Pengaturan Breadcrumb & Hero Banner Halaman</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Pengaturan & Administrator</li>
            <li class="breadcrumb-item active">Breadcrumb Halaman</li>
        </ol>
    </nav>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- Header Banner & Statistik Singkat --}}
<div class="card shadow-sm border-0 rounded-4 mb-4" style="background: linear-gradient(135deg, #046b26 0%, #034b1a 100%); color: #fff;">
    <div class="card-body p-4 d-flex flex-wrap align-items-center justify-content-between gap-3">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge rounded-pill px-3 py-1 fw-bold text-dark" style="background: #fed802;">
                    <i class="bi bi-signpost-2-fill me-1"></i> Modul Manajemen Navigasi
                </span>
                <span class="badge bg-white bg-opacity-25 rounded-pill px-3 py-1 text-white">
                    {{ $totalItems }} Menu Frontend Terdaftar
                </span>
            </div>
            <h4 class="fw-bold mb-1 text-white">Kelola Breadcrumb & Hero Banner Semua Halaman</h4>
            <p class="mb-0 text-white-50 small" style="max-width: 650px;">
                Sesuaikan teks judul hero, slogan/subjudul, hierarki jejak navigasi (breadcrumb), serta gambar latar belakang banner untuk setiap menu di website frontend.
            </p>
        </div>
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <form action="{{ route('breadcrumb-setting.reset-all') }}" method="POST" onsubmit="return confirm('Muat ulang dan pastikan seluruh 30 menu breadcrumb terisi penuh?')">
                @csrf
                <button type="submit" class="btn btn-outline-light btn-sm px-3 py-2 rounded-3 fw-bold shadow-sm">
                    <i class="bi bi-arrow-repeat me-1"></i> Sinkronkan 30 Menu
                </button>
            </form>
            <a href="{{ route('homepage') }}" target="_blank" class="btn btn-warning btn-sm px-3 py-2 rounded-3 fw-bold shadow-sm" style="background: #fed802; color: #111;">
                <i class="bi bi-box-arrow-up-right me-1"></i> Lihat Frontend
            </a>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0 rounded-4">
    <div class="card-header bg-white py-3 px-4 border-bottom">
        <div class="d-flex flex-column flex-xl-row align-items-xl-center justify-content-between gap-3">
            {{-- Filter Kategori Tabs (Pill Buttons) --}}
            <div class="d-flex flex-wrap align-items-center gap-2">
                <a href="{{ route('breadcrumb-setting.index', ['kategori' => 'all', 'q' => $search]) }}" 
                   class="btn btn-sm rounded-pill px-3 py-1.5 fw-semibold d-inline-flex align-items-center gap-1 transition-all"
                   style="{{ empty($kategori) || $kategori === 'all' 
                       ? 'background-color: #046b26; border: 1.5px solid #046b26; color: #ffffff !important; box-shadow: 0 2px 6px rgba(4,107,38,0.25);' 
                       : 'background-color: #f8fafc; border: 1.5px solid #e2e8f0; color: #475569;' }}">
                    Semua <span class="badge rounded-pill ms-1" style="{{ empty($kategori) || $kategori === 'all' ? 'background: rgba(255,255,255,0.25); color: #fff;' : 'background: #e2e8f0; color: #475569;' }}">{{ $totalItems }}</span>
                </a>
                @foreach($categories as $cat)
                    @php $isActiveCat = ($kategori === $cat); @endphp
                    <a href="{{ route('breadcrumb-setting.index', ['kategori' => $cat, 'q' => $search]) }}" 
                       class="btn btn-sm rounded-pill px-3 py-1.5 fw-semibold transition-all"
                       style="{{ $isActiveCat 
                           ? 'background-color: #046b26; border: 1.5px solid #046b26; color: #ffffff !important; box-shadow: 0 2px 6px rgba(4,107,38,0.25);' 
                           : 'background-color: #f8fafc; border: 1.5px solid #e2e8f0; color: #475569;' }}">
                        {{ $cat }}
                    </a>
                @endforeach
            </div>

            {{-- Form Pencarian Elegan & Rapi --}}
            <div class="d-flex align-items-center gap-2 flex-shrink-0 ms-xl-auto">
                <form action="{{ route('breadcrumb-setting.index') }}" method="GET" class="d-flex align-items-center gap-2 m-0">
                    @if(!empty($kategori))
                        <input type="hidden" name="kategori" value="{{ $kategori }}">
                    @endif
                    <div class="position-relative" style="width: 250px;">
                        <input type="text" name="q" value="{{ $search }}" 
                               class="form-control form-control-sm rounded-pill ps-3 pe-5 py-1.5" 
                               placeholder="Cari menu / judul..." 
                               style="border: 1.5px solid #cbd5e1; font-size: 13px;">
                        <button class="btn btn-sm btn-success rounded-circle position-absolute end-0 top-50 translate-middle-y me-1 d-flex align-items-center justify-content-center" 
                                type="submit" 
                                style="width: 26px; height: 26px; padding: 0; background: #046b26; border: none;" 
                                title="Cari">
                            <i class="bi bi-search" style="font-size: 11px;"></i>
                        </button>
                    </div>
                    @if(!empty($search))
                        <a href="{{ route('breadcrumb-setting.index', ['kategori' => $kategori]) }}" 
                           class="btn btn-sm btn-outline-danger rounded-circle d-flex align-items-center justify-content-center" 
                           style="width: 28px; height: 28px; padding: 0;"
                           title="Reset Pencarian">
                            <i class="bi bi-x-lg" style="font-size: 11px;"></i>
                        </a>
                    @endif
                </form>
            </div>
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size: 13.5px;">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4" style="width: 50px;">No</th>
                        <th style="min-width: 200px;">Menu / Halaman</th>
                        <th style="min-width: 260px;">Judul & Subjudul Banner</th>
                        <th style="min-width: 260px;">Jejak Breadcrumb Frontend</th>
                        <th style="min-width: 140px;">Background</th>
                        <th style="width: 100px;">Status</th>
                        <th class="text-center pe-4" style="width: 120px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($breadcrumbs as $index => $item)
                        <tr>
                            <td class="ps-4 text-muted fw-bold">{{ $loop->iteration }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $item->menu_name }}</div>
                                <div class="d-flex align-items-center gap-1 mt-1">
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary border rounded-pill px-2 py-0" style="font-size: 11px;">
                                        /{{ $item->page_key }}
                                    </span>
                                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2 py-0" style="font-size: 11px;">
                                        {{ $item->kategori_menu }}
                                    </span>
                                </div>
                            </td>
                            <td>
                                @if(!empty($item->badge_text))
                                    <div class="badge px-2 py-0.5 rounded-pill mb-1" style="background:#eaf6ec; color:#046b26; font-size:10.5px; border:1px solid #c7e6ce;">
                                        <i class="bi bi-bookmark-star-fill me-1"></i>{{ $item->badge_text }}
                                    </div>
                                @endif
                                <div class="fw-semibold text-dark" style="line-height: 1.3;">
                                    {!! $item->judul !!}
                                </div>
                                @if(!empty($item->subjudul))
                                    <div class="text-muted small mt-1 text-truncate" style="max-width: 280px;" title="{{ $item->subjudul }}">
                                        {{ $item->subjudul }}
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="d-inline-flex align-items-center flex-wrap gap-1 p-2 rounded-3 border bg-light bg-opacity-50" style="font-size: 12px;">
                                    <span class="text-secondary"><i class="bi bi-house-door-fill me-1"></i>{{ $item->breadcrumb_item_1 }}</span>
                                    @if(!empty($item->breadcrumb_item_2))
                                        <span class="text-muted">/</span>
                                        <span class="text-secondary">{{ $item->breadcrumb_item_2 }}</span>
                                    @endif
                                    <span class="text-muted">/</span>
                                    <span class="fw-bold text-success">{{ $item->breadcrumb_active }}</span>
                                </div>
                            </td>
                            <td>
                                @if($item->bg_image_url)
                                    <div class="position-relative d-inline-block rounded-3 overflow-hidden border shadow-sm" style="width: 76px; height: 42px;">
                                        <img src="{{ $item->bg_image_url }}" alt="Banner" style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                    <div class="text-success small fw-semibold" style="font-size: 10.5px;">Custom Banner</div>
                                @else
                                    <div class="d-inline-flex align-items-center gap-1 rounded-2 px-2 py-1" style="background: #eaf6ec; color: #046b26; font-size: 11px;">
                                        <span class="rounded-circle" style="width: 8px; height: 8px; background: #046b26; display: inline-block;"></span>
                                        Warna Standar UIS
                                    </div>
                                @endif
                            </td>
                            <td>
                                @if($item->is_active)
                                    <span class="badge bg-success rounded-pill px-2 py-1"><i class="bi bi-check-circle me-1"></i>Aktif</span>
                                @else
                                    <span class="badge bg-secondary rounded-pill px-2 py-1"><i class="bi bi-dash-circle me-1"></i>Sembunyi</span>
                                @endif
                            </td>
                            <td class="text-center pe-4">
                                <div class="d-flex align-items-center justify-content-center gap-1">
                                    <a href="{{ route('breadcrumb-setting.edit', $item->id) }}" 
                                       class="btn btn-sm btn-primary rounded-circle d-inline-flex align-items-center justify-content-center shadow-sm" 
                                       style="width: 34px; height: 34px;" 
                                       title="Edit Breadcrumb & Hero Banner" 
                                       data-bs-toggle="tooltip">
                                        <i class="bi bi-pencil-square fs-6"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                Tidak ada data breadcrumb ditemukan untuk kriteria pencarian ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
