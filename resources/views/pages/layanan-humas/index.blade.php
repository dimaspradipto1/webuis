@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Layanan Humas</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Layanan Humas</li>
            <li class="breadcrumb-item active">Daftar Layanan</li>
        </ol>
    </nav>
</div>

<div class="alert alert-primary border-0 shadow-sm d-flex align-items-start gap-3 p-3 mb-4" style="background: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 100%); border-radius: 12px;">
    <div class="rounded-circle p-2 bg-white shadow-sm text-primary fs-4 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; flex-shrink: 0;">
        <i class="bi bi-grid-fill" style="color: #4f46e5;"></i>
    </div>
    <div>
        <h6 class="fw-bold mb-1" style="color: #312e81;">Pusat Akses Layanan Humas</h6>
        <p class="mb-0 text-muted small" style="line-height: 1.5;">
            Di bawah ini merupakan <strong>layanan utama</strong> yang tampil pada floating bar <strong>"Layanan"</strong> di Beranda Humas (<code>/humas</code>), termasuk akses langsung ke <strong>SIHUMAS (https://sihumas.uisbatam.com/)</strong>. Anda dapat mengelola tautan (Portal/Web/Form) atau mengunggah file panduan resmi untuk setiap layanan.
        </p>
    </div>
</div>

<div class="row g-3">
    @foreach($items as $item)
        <div class="col-lg-3 col-md-6 col-12">
            <div class="card h-100 shadow-sm border-0 position-relative" style="border-radius: 12px; transition: transform 0.2s ease, box-shadow 0.2s ease;">
                <div class="card-body p-3 d-flex flex-column justify-content-between">
                    <div>
                        {{-- Header Icon & Status --}}
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                 style="width: 46px; height: 46px; background-color: #e8f5e9; color: #046B26; font-size: 22px;">
                                <i class="bi {{ $item->icon ?: 'bi-grid' }}"></i>
                            </div>
                            <div class="d-flex align-items-center gap-1">
                                @if($item->is_active)
                                    <span class="badge bg-success-subtle text-success border border-success-subtle" style="font-size: 11px;">Aktif</span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary" style="font-size: 11px;">Nonaktif</span>
                                @endif
                                <span class="badge bg-light text-dark border" style="font-size: 11px;">#{{ $item->urutan }}</span>
                            </div>
                        </div>

                        {{-- Nama & Badge --}}
                        <h6 class="fw-bold text-dark mb-1" style="font-size: 15px;">{{ $item->nama }}</h6>
                        @if($item->badge_text)
                            <span class="badge bg-primary-subtle text-primary mb-2" style="font-size: 10.5px;">{{ $item->badge_text }}</span>
                        @endif

                        {{-- Deskripsi --}}
                        <p class="text-muted small mb-3" style="font-size: 12px; line-height: 1.4; min-height: 34px;">
                            {{ Str::limit($item->deskripsi ?: 'Tidak ada deskripsi.', 75) }}
                        </p>

                        {{-- Info Link / File Aktif --}}
                        <div class="bg-light rounded p-2 mb-3 small" style="font-size: 11.5px;">
                            <div class="text-muted mb-1 fw-semibold">Target Tautan:</div>
                            @if($item->file_path)
                                <span class="text-success text-truncate d-block fw-medium">
                                    <i class="bi bi-file-earmark-check me-1"></i> File: {{ basename($item->file_path) }}
                                </span>
                            @elseif($item->url)
                                <span class="text-primary text-truncate d-block fw-medium" title="{{ $item->url }}">
                                    <i class="bi bi-link-45deg me-1"></i> {{ Str::limit($item->url, 28) }}
                                </span>
                            @else
                                <span class="text-muted fst-italic">Default internal route</span>
                            @endif
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="pt-2 border-top d-flex gap-2">
                        @if($item->kode === 'unduhan')
                            <a href="{{ route('unduhan.index') }}" class="btn btn-sm btn-outline-success w-100 fw-semibold" style="font-size: 12px;">
                                <i class="bi bi-folder2-open me-1"></i> Modul File
                            </a>
                        @elseif($item->kode === 'desain-grafis')
                            <a href="{{ route('desain-grafis.index') }}" class="btn btn-sm btn-outline-success w-100 fw-semibold" style="font-size: 12px;">
                                <i class="bi bi-palette me-1"></i> Modul Desain
                            </a>
                        @elseif($item->kode === 'galeri-kegiatan')
                            <a href="{{ route('gallery.index', ['kategori' => 'humas']) }}" class="btn btn-sm btn-outline-success w-100 fw-semibold" style="font-size: 12px;">
                                <i class="bi bi-images me-1"></i> Modul Galeri
                            </a>
                        @endif

                        <a href="{{ route('layanan-humas.edit-item', $item->kode) }}" 
                           class="btn btn-sm fw-semibold w-100" 
                           style="background-color: #046B26; color: #fff; font-size: 12px; border-radius: 6px;">
                            <i class="bi bi-gear-fill me-1"></i> Kelola
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
