@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle d-flex flex-wrap align-items-center justify-content-between gap-2 mb-4">
    <div>
        <h1 class="mb-1">Manajemen Pengumuman & Agenda</h1>
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item">Informasi</li>
                <li class="breadcrumb-item active">Pengumuman & Agenda</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex flex-wrap align-items-center gap-2">
        <a href="{{ route('homepage.pengumuman-agenda') }}" target="_blank" class="btn btn-outline-success btn-sm px-3">
            <i class="bi bi-box-arrow-up-right me-1"></i> Lihat di Website
        </a>
        <a href="{{ route('pengumuman-agenda.create', ['tipe' => 'pengumuman']) }}" class="btn btn-success btn-sm px-3">
            <i class="bi bi-megaphone-fill me-1"></i> + Tambah Pengumuman
        </a>
        <a href="{{ route('pengumuman-agenda.create', ['tipe' => 'agenda']) }}" class="btn btn-primary btn-sm px-3">
            <i class="bi bi-calendar-plus-fill me-1"></i> + Tambah Agenda
        </a>
    </div>
</div>

@php
    $currentTipe = $selectedTipe ?? request('tipe', '');
    $totalCount = $pengumumans->count() + $agendas->count();
@endphp

<!-- Tab Filter Kategori -->
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body py-3 px-4 d-flex flex-wrap align-items-center justify-content-between gap-3">
        <div class="d-flex flex-wrap align-items-center gap-2">
            <a href="{{ route('pengumuman-agenda.index') }}"
               class="btn btn-sm rounded-pill px-3 fw-semibold {{ empty($currentTipe) ? 'btn-primary' : 'btn-outline-secondary' }}">
                <i class="bi bi-grid-fill me-1"></i> Semua ({{ $totalCount }})
            </a>
            <a href="{{ route('pengumuman-agenda.index', ['tipe' => 'pengumuman']) }}"
               class="btn btn-sm rounded-pill px-3 fw-semibold {{ $currentTipe === 'pengumuman' ? 'btn-success' : 'btn-outline-secondary' }}">
                <i class="bi bi-megaphone-fill me-1"></i> Pengumuman ({{ $pengumumans->count() }})
            </a>
            <a href="{{ route('pengumuman-agenda.index', ['tipe' => 'agenda']) }}"
               class="btn btn-sm rounded-pill px-3 fw-semibold {{ $currentTipe === 'agenda' ? 'btn-warning text-dark' : 'btn-outline-secondary' }}">
                <i class="bi bi-calendar4-week me-1"></i> Agenda Akademik ({{ $agendas->count() }})
            </a>
        </div>
        <span class="text-muted small">
            Klik tombol <strong>"Kelola Detail"</strong> untuk mengedit isi lengkap, foto, atau lampiran PDF.
        </span>
    </div>
</div>

<div class="row g-4">
    @if(empty($currentTipe) || $currentTipe === 'pengumuman')
    <!-- ═══════════════════════════════════════════════
         1. DAFTAR PENGUMUMAN
    ═══════════════════════════════════════════════ -->
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white d-flex align-items-center justify-content-between py-3">
                <h5 class="mb-0 fw-bold text-dark">
                    <i class="bi bi-megaphone-fill me-2 text-success"></i>Daftar Pengumuman Resmi ({{ $pengumumans->count() }})
                </h5>
                <a href="{{ route('pengumuman-agenda.create', ['tipe' => 'pengumuman']) }}" class="btn btn-success btn-sm">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Pengumuman
                </a>
            </div>
            <div class="card-body pt-3">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" style="width: 55px;">No</th>
                                <th>Judul & Ringkasan Pengumuman</th>
                                <th style="width: 170px;">Tanggal</th>
                                <th class="text-center" style="width: 120px;">Media / Lampiran</th>
                                <th class="text-center" style="width: 80px;">Urutan</th>
                                <th class="text-center" style="width: 95px;">Status</th>
                                <th class="text-center" style="width: 185px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pengumumans as $idx => $item)
                                <tr>
                                    <td class="text-center">{{ $idx + 1 }}</td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $item->judul }}</div>
                                        @if(!empty($item->konten))
                                            <div class="text-muted small mt-1">
                                                {{ \Illuminate\Support\Str::limit(strip_tags($item->konten), 95) }}
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border px-2 py-1">
                                            <i class="bi bi-calendar3 me-1 text-success"></i>{{ $item->waktu }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $photoCount = is_array($item->galeri) ? count($item->galeri) : (!empty($item->foto) ? 1 : 0);
                                        @endphp
                                        @if($photoCount > 0)
                                            <span class="badge bg-info text-dark me-1"><i class="bi bi-images me-1"></i>{{ $photoCount }} Foto</span>
                                        @endif
                                        @if(!empty($item->file_lampiran))
                                            <span class="badge bg-danger"><i class="bi bi-file-earmark-pdf me-1"></i>Lampiran</span>
                                        @endif
                                        @if($photoCount === 0 && empty($item->file_lampiran))
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center"><span class="badge bg-secondary">#{{ $item->urutan }}</span></td>
                                    <td class="text-center">
                                        @if($item->is_active)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            <a href="{{ route('pengumuman-agenda.edit', $item->id) }}"
                                               class="btn btn-sm btn-primary fw-semibold"
                                               title="Kelola Detail Pengumuman">
                                                <i class="bi bi-pencil-square me-1"></i> Detail
                                            </a>
                                            <a href="{{ route('homepage.pengumuman-agenda.detail', $item->slug ?: $item->id) }}"
                                               target="_blank"
                                               class="btn btn-sm btn-outline-success"
                                               title="Lihat Halaman Detail di Website">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <form action="{{ route('pengumuman-agenda.destroy', $item->id) }}"
                                                  method="POST"
                                                  class="m-0"
                                                  onsubmit="return confirm('Yakin ingin menghapus pengumuman ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">Belum ada data pengumuman.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if(empty($currentTipe) || $currentTipe === 'agenda')
    <!-- ═══════════════════════════════════════════════
         2. DAFTAR AGENDA
    ═══════════════════════════════════════════════ -->
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white d-flex align-items-center justify-content-between py-3">
                <h5 class="mb-0 fw-bold text-dark">
                    <i class="bi bi-calendar4-week me-2 text-warning"></i>Daftar Agenda Akademik / Kampus ({{ $agendas->count() }})
                </h5>
                <a href="{{ route('pengumuman-agenda.create', ['tipe' => 'agenda']) }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Agenda
                </a>
            </div>
            <div class="card-body pt-3">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" style="width: 55px;">No</th>
                                <th style="width: 220px;">Rentang Tanggal / Waktu</th>
                                <th>Judul & Rincian Kegiatan Agenda</th>
                                <th class="text-center" style="width: 120px;">Media / Lampiran</th>
                                <th class="text-center" style="width: 80px;">Urutan</th>
                                <th class="text-center" style="width: 95px;">Status</th>
                                <th class="text-center" style="width: 185px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($agendas as $idx => $item)
                                <tr>
                                    <td class="text-center">{{ $idx + 1 }}</td>
                                    <td class="fw-bold text-dark">
                                        <i class="bi bi-calendar-range text-primary me-1"></i>{{ $item->waktu }}
                                    </td>
                                    <td>
                                        <span class="px-3 py-1 rounded-2 fw-bold d-inline-block mb-1" style="background: #f4d348; color: #1a202c; font-size: 13.5px;">
                                            {{ $item->judul }}
                                        </span>
                                        @if(!empty($item->konten))
                                            <div class="text-muted small">
                                                {{ \Illuminate\Support\Str::limit(strip_tags($item->konten), 90) }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $photoCount = is_array($item->galeri) ? count($item->galeri) : (!empty($item->foto) ? 1 : 0);
                                        @endphp
                                        @if($photoCount > 0)
                                            <span class="badge bg-info text-dark me-1"><i class="bi bi-images me-1"></i>{{ $photoCount }} Foto</span>
                                        @endif
                                        @if(!empty($item->file_lampiran))
                                            <span class="badge bg-danger"><i class="bi bi-file-earmark-pdf me-1"></i>Lampiran</span>
                                        @endif
                                        @if($photoCount === 0 && empty($item->file_lampiran))
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center"><span class="badge bg-secondary">#{{ $item->urutan }}</span></td>
                                    <td class="text-center">
                                        @if($item->is_active)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            <a href="{{ route('pengumuman-agenda.edit', $item->id) }}"
                                               class="btn btn-sm btn-primary fw-semibold"
                                               title="Kelola Detail Agenda">
                                                <i class="bi bi-pencil-square me-1"></i> Detail
                                            </a>
                                            <a href="{{ route('homepage.pengumuman-agenda.detail', $item->slug ?: $item->id) }}"
                                               target="_blank"
                                               class="btn btn-sm btn-outline-success"
                                               title="Lihat Halaman Detail di Website">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <form action="{{ route('pengumuman-agenda.destroy', $item->id) }}"
                                                  method="POST"
                                                  class="m-0"
                                                  onsubmit="return confirm('Yakin ingin menghapus agenda ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">Belum ada data agenda.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
